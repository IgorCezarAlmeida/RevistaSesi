<?php

declare(strict_types=1);

namespace App\DAO;

use App\Config\Database;
use Doctrine\ORM\EntityManager;

final class Connection
{
    public static function getEntityManager(): EntityManager
    {
        return Database::getEntityManager();
    }
}
