<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Throwable;
use Illuminate\Support\Str;

class TelegramErrorNotifier
{
    public static function send(Throwable $e): void
    {
        if (!app()->isProduction() || config('app.debug')) {
            return;
        }
        
        $token = env('TELEGRAM_BOT_TOKEN');
        $chatId = env('TELEGRAM_CHAT_ID');

        if (empty($token) || empty($chatId)) {
            Log::warning('Telegram credentials not set!');
            return;
        }

        $snippet = self::getCodeSnippet($e->getFile(), $e->getLine());
        
        // Format pesan dengan Markdown yang valid
        $message = self::formatMarkdownMessage(
            $e->getMessage(),
            $e->getFile(),
            $e->getLine(),
            $snippet
        );

        try {
            Http::post("https://api.telegram.org/bot{$token}/sendMessage", [
                'chat_id' => $chatId,
                'text' => $message,
                'parse_mode' => 'MarkdownV2', // Gunakan MarkdownV2 yang lebih modern
                'disable_web_page_preview' => true
            ]);
        } catch (\Exception $e) {
            Log::error('Telegram notification failed: ' . $e->getMessage());
        }
    }
    
    protected static function getCodeSnippet(string $filePath, int $errorLine, int $padding = 3): string
    {
        if (!file_exists($filePath)) {
            return 'Code snippet not available\.'; // Escape titik untuk Markdown
        }

        $lines = file($filePath);
        $start = max($errorLine - $padding - 1, 0);
        $end = min($errorLine + $padding - 1, count($lines) - 1);

        $snippetLines = [];
        for ($i = $start; $i <= $end; $i++) {
            $lineNumber = $i + 1;
            $prefix = ($lineNumber === $errorLine) ? '>> ' : '   ';
            $snippetLines[] = $prefix . $lineNumber . ': ' . trim($lines[$i]);
        }

        return "```php\n" . implode("\n", $snippetLines) . "\n```";
    }

    protected static function formatMarkdownMessage(
        string $errorMessage,
        string $file,
        int $line,
        string $snippet
    ): string {
        // Escape karakter khusus MarkdownV2
        /*$escapeMarkdown = fn ($text) => str_replace(
            ['_', '*', '[', ']', '(', ')', '~', '`', '>', '#', '+', '-', '=', '|', '{', '}', '.', '!'],
            ['\_', '\*', '\[', '\]', '\(', '\)', '\~', '\`', '\>', '\#', '\+', '\-', '\=', '\|', '\{', '\}', '\.', '\!'],
            $text
        );*/
        $escapeMarkdown = fn ($text) => preg_replace(
            '/([_*\[\]()~`>#+\-=|{}.!])/', 
            '\\\\$1', 
            $text
        );

        return "🚨 *KMS\-MIGAS Error Notification* 🚨\n" .
               "*Message:* `" . $escapeMarkdown($errorMessage) . "`\n" .
               "*File:* `" . $escapeMarkdown($file) . "`\n" .
               "*Line:* `" . $line . "`\n\n" .
               "*Code snippet:*\n" . $snippet;
    }
}