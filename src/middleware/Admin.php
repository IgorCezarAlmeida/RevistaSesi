<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Helpers\Session;

final class Admin
{
    public static function requireAdmin(): void
    {
        if (!Session::get('is_admin', false)) {
            Session::flash('error', 'Acesso restrito a administradores.');
            header('Location: /index.php');
            exit;
        }
    }
}
