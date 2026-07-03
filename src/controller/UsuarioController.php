<?php

declare(strict_types=1);

namespace App\Controller;

use App\DAO\UsuarioDAO;
use App\Helpers\Session;
use App\Helpers\Validator;
use App\Middleware\Auth;
use App\Model\Usuario;

final class UsuarioController
{
    public function __construct(private readonly UsuarioDAO $usuarioDAO) {}

    public function showCadastro(): void
    {
        $error = Session::flash('error');
        require dirname(__DIR__) . '/views/cadastro.php';
    }

    public function cadastro(array $data): void
    {
        $errors = Validator::required($data, ['nome', 'email', 'senha']);
        if (!Validator::email((string) ($data['email'] ?? null))) {
            $errors[] = 'Email invalido.';
        }

        if ($this->usuarioDAO->findByEmail((string) ($data['email'] ?? ''))) {
            $errors[] = 'Email ja cadastrado.';
        }

        if ($errors !== []) {
            Session::flash('error', implode(' ', $errors));
            header('Location: /cadastro.php');
            exit;
        }

        $usuario = new Usuario();
        $usuario->setNome(trim((string) $data['nome']));
        $usuario->setEmail(trim((string) $data['email']));
        $usuario->setSenha(password_hash((string) $data['senha'], PASSWORD_DEFAULT));
        $usuario->setIsAdmin(false);

        $this->usuarioDAO->save($usuario);

        Session::flash('success', 'Cadastro realizado. Faca login.');
        header('Location: /login.php');
        exit;
    }

    public function perfil(): void
    {
        Auth::requireLogin();
        $usuario = $this->usuarioDAO->findById((int) Session::get('user_id'));
        require dirname(__DIR__) . '/views/perfil.php';
    }
}
