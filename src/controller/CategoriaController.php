<?php

declare(strict_types=1);

namespace App\Controller;

use App\DAO\CategoriaDAO;
use App\Helpers\Session;
use App\Middleware\Admin;
use App\Model\Categoria;

final class CategoriaController
{
    public function __construct(private readonly CategoriaDAO $categoriaDAO) {}

    public function index(): void
    {
        $categorias = $this->categoriaDAO->findAll();
        require dirname(__DIR__) . '/views/categorias.php';
    }

    public function create(array $data): void
    {
        Admin::requireAdmin();
        $nome = trim((string) ($data['nome'] ?? ''));
        if ($nome === '') {
            Session::flash('error', 'Informe o nome da categoria.');
            header('Location: /index.php?action=admin/categorias');
            exit;
        }

        $categoria = new Categoria();
        $categoria->setNome($nome);
        $this->categoriaDAO->save($categoria);

        Session::flash('success', 'Categoria criada com sucesso.');
        header('Location: /index.php?action=admin/categorias');
        exit;
    }
}
