<?php

declare(strict_types=1);

namespace App\Controller;

use App\DAO\ArtigoDAO;
use App\DAO\CategoriaDAO;
use App\DAO\UsuarioDAO;
use App\Middleware\Admin;

final class AdminController
{
    public function __construct(
        private readonly UsuarioDAO $usuarioDAO,
        private readonly ArtigoDAO $artigoDAO,
        private readonly CategoriaDAO $categoriaDAO
    ) {}

    public function dashboard(): void
    {
        Admin::requireAdmin();
        $usuarios = $this->usuarioDAO->findAll();
        $artigos = $this->artigoDAO->latest(200);
        $categorias = $this->categoriaDAO->findAll();
        require dirname(__DIR__) . '/views/dashboard.php';
    }

    public function usuarios(): void
    {
        Admin::requireAdmin();
        $usuarios = $this->usuarioDAO->findAll();
        require dirname(__DIR__) . '/views/admin/usuarios.php';
    }

    public function artigos(): void
    {
        Admin::requireAdmin();
        $artigos = $this->artigoDAO->latest(200);
        require dirname(__DIR__) . '/views/admin/artigos.php';
    }

    public function categorias(): void
    {
        Admin::requireAdmin();
        $categorias = $this->categoriaDAO->findAll();
        require dirname(__DIR__) . '/views/admin/categorias.php';
    }
}
