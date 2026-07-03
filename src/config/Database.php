<?php

declare(strict_types=1);

namespace App\Config;

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

final class Database
{
    private static ?EntityManager $entityManager = null;

    public static function getEntityManager(): EntityManager
    {
        if (self::$entityManager instanceof EntityManager) {
            return self::$entityManager;
        }

        $config = ORMSetup::createAttributeMetadataConfiguration(
            paths: [dirname(__DIR__) . '/model'],
            isDevMode: true
        );

        $connection = [
            'driver'        => 'pdo_mysql',
            'host'          => Config::dbHost(),
            'port'          => Config::dbPort(),
            'dbname'        => Config::dbName(),
            'user'          => Config::dbUser(),
            'password'      => Config::dbPass(),
            'charset'       => 'utf8mb4',
            'driverOptions' => [
                \PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
                \PDO::MYSQL_ATTR_SSL_CA               => '',
            ],
        ];

        $dbalConnection = DriverManager::getConnection($connection, $config);
        self::$entityManager = new EntityManager($dbalConnection, $config);
        return self::$entityManager;
    }
}


