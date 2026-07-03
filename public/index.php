<?php

declare(strict_types=1);

use App\Controller\AdminController;
use App\Controller\ArtigoController;
use App\Controller\CategoriaController;
use App\Controller\ComentarioController;
use App\Controller\LoginController;
use App\Controller\UsuarioController;
use App\DAO\ArtigoDAO;
use App\DAO\CategoriaDAO;
use App\DAO\ComentarioDAO;
use App\DAO\CurtidaDAO;
use App\DAO\UsuarioDAO;
use App\Helpers\Session;

$entityManager = require dirname(__DIR__) . '/src/config/bootstrap.php';

Session::start();

$usuarioDAO = new UsuarioDAO($entityManager);
$categoriaDAO = new CategoriaDAO($entityManager);
$artigoDAO = new ArtigoDAO($entityManager);
$comentarioDAO = new ComentarioDAO($entityManager);
$curtidaDAO = new CurtidaDAO($entityManager);

$loginController = new LoginController($usuarioDAO);
$usuarioController = new UsuarioController($usuarioDAO);
$categoriaController = new CategoriaController($categoriaDAO);
$artigoController = new ArtigoController($artigoDAO, $categoriaDAO, $comentarioDAO, $curtidaDAO, $usuarioDAO);
$comentarioController = new ComentarioController($comentarioDAO, $artigoDAO, $usuarioDAO);
$adminController = new AdminController($usuarioDAO, $artigoDAO, $categoriaDAO);

$action = $_GET['action'] ?? 'home';
$method = $_SERVER['REQUEST_METHOD'];

switch ($action) {
    case 'home':
        $artigoController->home();
        break;

    case 'login':
        $method === 'POST' ? $loginController->login($_POST) : $loginController->showLogin();
        break;

    case 'logout':
        $loginController->logout();
        break;

    case 'cadastro':
        $method === 'POST' ? $usuarioController->cadastro($_POST) : $usuarioController->showCadastro();
        break;

    case 'perfil':
        $usuarioController->perfil();
        break;

    case 'artigo/show':
        $artigoController->show((int) ($_GET['id'] ?? 0));
        break;

    case 'artigo/criar':
        $method === 'POST'
            ? $artigoController->create($_POST, $_FILES)
            : $artigoController->createForm();
        break;

    case 'artigo/editar':
        $id = (int) ($_GET['id'] ?? 0);
        $method === 'POST'
            ? $artigoController->update($id, $_POST, $_FILES)
            : $artigoController->editForm($id);
        break;

    case 'artigo/remover':
        $artigoController->delete((int) ($_GET['id'] ?? 0));
        break;

    case 'artigo/curtir':
        $artigoController->toggleLike((int) ($_GET['id'] ?? 0));
        break;

    case 'pesquisar':
        $artigoController->search((string) ($_GET['q'] ?? ''));
        break;

    case 'comentario/adicionar':
        $comentarioController->add($_POST);
        break;

    case 'comentario/remover':
        $comentarioController->delete((int) ($_GET['id'] ?? 0), (int) ($_GET['artigo_id'] ?? 0));
        break;

    case 'categorias':
        $categoriaController->index();
        break;

    case 'admin/dashboard':
        $adminController->dashboard();
        break;

    case 'admin/usuarios':
        $adminController->usuarios();
        break;

    case 'admin/artigos':
        $adminController->artigos();
        break;

    case 'admin/categorias':
        if ($method === 'POST') {
            $categoriaController->create($_POST);
        }
        $adminController->categorias();
        break;

    case 'upload':
        $file = basename((string) ($_GET['file'] ?? ''));
        $path = dirname(__DIR__) . '/uploads/' . $file;
        if ($file === '' || !is_file($path)) {
            http_response_code(404);
            exit;
        }

        header('Content-Type: ' . (mime_content_type($path) ?: 'application/octet-stream'));
        readfile($path);
        exit;

    default:
        $artigoController->home();
}


