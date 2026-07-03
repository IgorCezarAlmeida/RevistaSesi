<?php

declare(strict_types=1);

use App\Config\Database;

require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

return Database::getEntityManager();

