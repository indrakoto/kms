<?php

namespace App\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TableauEmbedService
{
    public static function generateToken(?string $viewUrl = null, ?string $subject = null): string
    {
        $payload = [
            'iss' => env('TABLEAU_CLIENT_ID'),
            'exp' => now()->addMinutes(5)->timestamp,
            'jti' => uniqid(),
            'aud' => env('TABLEAU_AUDIENCE', 'tableau'),
            'sub' => $subject ?? env('TABLEAU_SUBJECT'),
            'scp' => ['tableau:views:embed'],
        ];

        if ($viewUrl) {
            $payload['resource'] = [
                'viewUrl' => $viewUrl,
            ];
        }

        return JWT::encode($payload, env('TABLEAU_SECRET_VALUE'), 'HS256');
    }

    public static function generateJwt(): string
    {
        $clientId = config('services.tableau.client_id');
        $secretId = config('services.tableau.secret_id');
        $secretValue = config('services.tableau.secret_value');
        $subject = config('services.tableau.subject');
        $audience = config('services.tableau.audience');

        $payload = [
            'iss' => $clientId,
            'exp' => Carbon::now()->addMinutes(5)->timestamp,
            'jti' => (string) Str::uuid(),
            'aud' => $audience,
            'sub' => $subject,
            'scp' => [
                'tableau:views:embed',
                'tableau:views:embed_authoring',
                'tableau:insights:embed'
            ],
            //'https://tableau.com/oda' => true,
        ];

        $headers = [
            'kid' => $secretId,
            'iss' => $clientId,
        ];

        return JWT::encode($payload, $secretValue, 'HS256', null, $headers);
    }

    public static function getEmbedConfig(string $tableauUrl): array
    {
        return [
            'url' => $tableauUrl,
            'token' => self::generateJwt()
        ];
    }

}
