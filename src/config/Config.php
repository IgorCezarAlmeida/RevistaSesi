<?php

declare(strict_types=1);

namespace App\Config;

final class Config
{
    public const APP_NAME = 'ProjetoArtigos';
    public const BASE_URL = '/index.php';

    public static function dbSslCa(): ?string
    {
        $candidates = [
            getenv('DB_SSL_CA') ?: null,
            getenv('SSL_CERT_FILE') ?: null,
            getenv('CURL_CA_BUNDLE') ?: null,
            ini_get('openssl.cafile') ?: null,
            ini_get('curl.cainfo') ?: null,
        ];

        if (function_exists('openssl_get_cert_locations')) {
            $locations = openssl_get_cert_locations();
            $candidates[] = $locations['default_cert_file'] ?? null;
        }

        foreach ($candidates as $candidate) {
            if (is_string($candidate) && $candidate !== '' && is_file($candidate)) {
                return $candidate;
            }
        }

        return null;
    }

    // Lê de variáveis de ambiente (Render) com fallback para TiDB Cloud
    public static function dbHost(): string
    {
        return (string) (getenv('DB_HOST') ?: 'gateway01.us-east-1.prod.aws.tidbcloud.com');
    }

    public static function dbPort(): string
    {
        return (string) (getenv('DB_PORT') ?: '4000');
    }

    public static function dbName(): string
    {
        return (string) (getenv('DB_NAME') ?: 'revistaSesi');
    }

    public static function dbUser(): string
    {
        return (string) (getenv('DB_USER') ?: '2pxmsaj29iFCsGe.root');
    }

    public static function dbPass(): string
    {
        return (string) (getenv('DB_PASS') ?: 'QRCcMQV5m7Y8e7HR');
    }

    public static function baseUrl(string $path = ''): string
    {
        $suffix = ltrim($path, '/');
        return self::BASE_URL . ($suffix !== '' ? '?action=' . $suffix : '');
    }
}


