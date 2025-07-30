<?php

namespace App\Helpers;

use Throwable;
use Illuminate\Support\Facades\Http;

class TelegramErrorHandler
{
    protected bool $hasReported = false;

    /**
     * Kirim notifikasi error ke Telegram dengan snippet kode.
     *
     * @param Throwable $exception
     * @return void
     */
    public function report(Throwable $exception): void
    {
        if ($this->hasReported) {
            return; // Mencegah laporan duplikat
        }

        $this->hasReported = true;

        $telegramToken = env('TELEGRAM_BOT_TOKEN');
        $chatId = env('TELEGRAM_CHAT_ID');

        if (empty($telegramToken) || empty($chatId)) {
            return;
        }

        $file = $exception->getFile();
        $line = $exception->getLine();

        // Ambil snippet kode error
        $snippet = $this->getCodeSnippet($file, $line);

        $message = "🚨 *APLIKASI ERROR* 🚨\n\n"
            . "*Pesan:* " . $exception->getMessage() . "\n"
            . "*File:* " . $file . "\n"
            . "*Baris:* " . $line . "\n\n"
            . "*Code snippet:*\n" . $snippet;

        $url = "https://api.telegram.org/bot{$telegramToken}/sendMessage";

        try {
            Http::post($url, [
                'chat_id' => $chatId,
                'text' => $message,
                'parse_mode' => 'Markdown',
            ]);
        } catch (\Exception $e) {
            // Hindari exception loop jika gagal kirim pesan Telegram
        }
    }

    /**
     * Mendapatkan potongan kode sumber di sekitar baris error.
     *
     * @param string $filePath Path lengkap file sumber
     * @param int $errorLine Baris error
     * @param int $padding Jumlah baris sebelum dan sesudah baris error
     * @return string Potongan kode dengan format markdown
     */
    public function getCodeSnippet(string $filePath, int $errorLine, int $padding = 3): string
    {
        if (!file_exists($filePath)) {
            return '_Code snippet not available._';
        }

        $lines = file($filePath);
        $start = max($errorLine - $padding - 1, 0);
        $end = min($errorLine + $padding - 1, count($lines) - 1);

        $snippetLines = [];
        for ($i = $start; $i <= $end; $i++) {
            $lineNumber = $i + 1;
            $prefix = ($lineNumber === $errorLine) ? '>> ' : '   ';
            $lineContent = rtrim($lines[$i], "\r\n"); // hapus newline kanan
            $snippetLines[] = $prefix . $lineNumber . ': ' . $lineContent;
        }

        // Bungkus dengan triple backticks Markdown untuk blok kode
        return "```php\n" . implode("\n", $snippetLines) . "\n```";
    }
}
