<?php

declare(strict_types=1);

namespace App\Config;

use Doctrine\ORM\EntityManager;

final class Database
{
    public static function getEntityManager(): EntityManager
    {
        return Conexao::getEntityManager();
    }
}
