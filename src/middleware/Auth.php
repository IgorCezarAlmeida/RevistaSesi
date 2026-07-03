<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Helpers\Session;

final class Auth
{
    public static function requireLogin(): void
    {
        if (!Session::get('user_id')) {
            Session::flash('error', 'Voce precisa fazer login.');
            header('Location: /login.php');
            exit;
        }
    }
}
