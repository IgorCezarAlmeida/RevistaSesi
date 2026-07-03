<?php

declare(strict_types=1);

namespace App\Controller;

use App\DAO\UsuarioDAO;
use App\Helpers\Session;

final class LoginController
{
    public function __construct(private readonly UsuarioDAO $usuarioDAO) {}

    public function showLogin(): void
    {
        $error = Session::flash('error');
        $success = Session::flash('success');
        require dirname(__DIR__) . '/views/login.php';
    }

    public function login(array $data): void
    {
        $email = trim((string) ($data['email'] ?? ''));
        $senha = (string) ($data['senha'] ?? '');

        $usuario = $this->usuarioDAO->findByEmail($email);
        if (!$usuario || !password_verify($senha, $usuario->getSenha())) {
            Session::flash('error', 'Credenciais invalidas.');
            header('Location: /login.php');
            exit;
        }

        Session::set('user_id', $usuario->getId());
        Session::set('user_nome', $usuario->getNome());
        Session::set('is_admin', $usuario->isAdmin());

        header('Location: /index.php');
        exit;
    }

    public function logout(): void
    {
        Session::destroy();
        header('Location: /index.php');
        exit;
    }
}
