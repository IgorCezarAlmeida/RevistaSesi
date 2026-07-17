<?php

declare(strict_types=1);

namespace App\Config;

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use PDO;

final class Conexao
{
    private static ?EntityManager $entityManager = null;

    private static function env(string $key): ?string
    {
        $value = $_ENV[$key] ?? getenv($key);
        if ($value === false || $value === null || $value === '') {
            return null;
        }

        return (string) $value;
    }

    private static function dbDriver(): string
    {
        return self::env('DB_DRIVER') ?? 'pdo_mysql';
    }

    private static function dbHost(): string
    {
        return self::env('DB_HOST') ?? Config::dbHost();
    }

    private static function dbPort(): string
    {
        return self::env('DB_PORT') ?? Config::dbPort();
    }

    private static function dbName(): string
    {
        return self::env('DB_NAME') ?? Config::dbName();
    }

    private static function dbUser(): string
    {
        return self::env('DB_USER') ?? Config::dbUser();
    }

    private static function dbPassword(): string
    {
        return self::env('DB_PASSWORD')
            ?? self::env('DB_PASS')
            ?? Config::dbPass();
    }

    private static function validateEnvVars(): void
    {
        $required = [
            'DB_HOST' => self::dbHost(),
            'DB_PORT' => self::dbPort(),
            'DB_NAME' => self::dbName(),
            'DB_USER' => self::dbUser(),
            'DB_PASSWORD/DB_PASS' => self::dbPassword(),
        ];

        $missing = [];
        foreach ($required as $label => $value) {
            if ($value === '') {
                $missing[] = $label;
            }
        }

        if ($missing !== []) {
            throw new \RuntimeException(
                'Variaveis de ambiente obrigatorias nao configuradas: ' . implode(', ', $missing)
            );
        }
    }

    public static function getEntityManager(): EntityManager
    {
        if (self::$entityManager instanceof EntityManager) {
            return self::$entityManager;
        }

        self::validateEnvVars();

        $config = ORMSetup::createAttributeMetadataConfiguration(
            paths: [dirname(__DIR__) . '/model'],
            isDevMode: false
        );

        $connectionParams = [
            'driver' => self::dbDriver(),
            'host' => self::dbHost(),
            'port' => self::dbPort(),
            'dbname' => self::dbName(),
            'user' => self::dbUser(),
            'password' => self::dbPassword(),
            'charset' => 'utf8mb4',
            'driverOptions' => [
                PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
            ],
        ];

        $connection = DriverManager::getConnection($connectionParams, $config);
        self::$entityManager = new EntityManager($connection, $config);

        return self::$entityManager;
    }
}
