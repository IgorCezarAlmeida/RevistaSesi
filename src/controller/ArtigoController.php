<?php

declare(strict_types=1);

namespace App\Controller;

use App\DAO\ArtigoDAO;
use App\DAO\CategoriaDAO;
use App\DAO\ComentarioDAO;
use App\DAO\CurtidaDAO;
use App\DAO\UsuarioDAO;
use App\Helpers\Session;
use App\Helpers\Upload;
use App\Middleware\Auth;
use App\Model\Artigo;

final class ArtigoController
{
    public function __construct(
        private readonly ArtigoDAO $artigoDAO,
        private readonly CategoriaDAO $categoriaDAO,
        private readonly ComentarioDAO $comentarioDAO,
        private readonly CurtidaDAO $curtidaDAO,
        private readonly UsuarioDAO $usuarioDAO
    ) {}

    public function home(): void
    {
        $artigos = $this->artigoDAO->latest();
        $error = Session::flash('error');
        $success = Session::flash('success');
        require dirname(__DIR__) . '/views/home.php';
    }

    public function show(int $id): void
    {
        $artigo = $this->artigoDAO->findById($id);
        if (!$artigo) {
            Session::flash('error', 'Artigo nao encontrado.');
            header('Location: /index.php');
            exit;
        }

        $comentarios = $this->comentarioDAO->findByArtigo($id);
        $canEdit = Session::get('is_admin', false) || Session::get('user_id') === $artigo->getAutor()->getId();
        require dirname(__DIR__) . '/views/artigo.php';
    }

    public function createForm(): void
    {
        Auth::requireLogin();
        $categorias = $this->categoriaDAO->findAll();
        require dirname(__DIR__) . '/views/criarArtigo.php';
    }

    public function create(array $data, array $files): void
    {
        Auth::requireLogin();

        $titulo = trim((string) ($data['titulo'] ?? ''));
        $resumo = trim((string) ($data['resumo'] ?? ''));
        $conteudo = trim((string) ($data['conteudo'] ?? ''));
        $categoria = $this->categoriaDAO->findById((int) ($data['categoria_id'] ?? 0));
        $autor = $this->usuarioDAO->findById((int) Session::get('user_id'));

        if (!$categoria || !$autor || $titulo === '' || $resumo === '' || $conteudo === '') {
            Session::flash('error', 'Dados do artigo invalidos.');
            header('Location: /index.php?action=artigo/criar');
            exit;
        }

        $artigo = new Artigo();
        $artigo->setTitulo($titulo);
        $artigo->setResumo($resumo);
        $artigo->setConteudo($conteudo);
        $artigo->setCategoria($categoria);
        $artigo->setAutor($autor);

        $upload = Upload::image($files['imagem'] ?? [], dirname(__DIR__, 2) . '/uploads');
        $artigo->setImagemCapa($upload);

        $this->artigoDAO->save($artigo);
        Session::flash('success', 'Artigo criado com sucesso.');
        header('Location: /index.php');
        exit;
    }

    public function editForm(int $id): void
    {
        Auth::requireLogin();
        $artigo = $this->artigoDAO->findById($id);
        if (!$artigo) {
            header('Location: /index.php');
            exit;
        }

        $this->authorizeOwner($artigo);
        $categorias = $this->categoriaDAO->findAll();
        require dirname(__DIR__) . '/views/editarArtigo.php';
    }

    public function update(int $id, array $data, array $files): void
    {
        Auth::requireLogin();
        $artigo = $this->artigoDAO->findById($id);
        if (!$artigo) {
            header('Location: /index.php');
            exit;
        }

        $this->authorizeOwner($artigo);

        $categoria = $this->categoriaDAO->findById((int) ($data['categoria_id'] ?? 0));
        if ($categoria) {
            $artigo->setCategoria($categoria);
        }

        $artigo->setTitulo(trim((string) ($data['titulo'] ?? $artigo->getTitulo())));
        $artigo->setResumo(trim((string) ($data['resumo'] ?? $artigo->getResumo())));
        $artigo->setConteudo(trim((string) ($data['conteudo'] ?? $artigo->getConteudo())));

        $upload = Upload::image($files['imagem'] ?? [], dirname(__DIR__, 2) . '/uploads');
        if ($upload) {
            $artigo->setImagemCapa($upload);
        }

        $artigo->touch();
        $this->artigoDAO->save($artigo);

        Session::flash('success', 'Artigo atualizado.');
        header('Location: /artigo.php?id=' . $id);
        exit;
    }

    public function delete(int $id): void
    {
        Auth::requireLogin();
        $artigo = $this->artigoDAO->findById($id);
        if (!$artigo) {
            header('Location: /index.php');
            exit;
        }

        $this->authorizeOwner($artigo);
        $this->artigoDAO->delete($artigo);

        Session::flash('success', 'Artigo removido.');
        header('Location: /index.php');
        exit;
    }

    public function search(string $term): void
    {
        $termo = trim($term);
        $artigos = $termo !== '' ? $this->artigoDAO->search($termo) : [];
        require dirname(__DIR__) . '/views/pesquisar.php';
    }

    public function toggleLike(int $id): void
    {
        Auth::requireLogin();
        $artigo = $this->artigoDAO->findById($id);
        $usuario = $this->usuarioDAO->findById((int) Session::get('user_id'));
        if ($artigo && $usuario) {
            $this->curtidaDAO->toggle($usuario, $artigo);
        }

        header('Location: /artigo.php?id=' . $id);
        exit;
    }

    private function authorizeOwner(Artigo $artigo): void
    {
        $isAdmin = (bool) Session::get('is_admin');
        $userId = (int) Session::get('user_id');

        if (!$isAdmin && $artigo->getAutor()->getId() !== $userId) {
            Session::flash('error', 'Voce nao pode alterar este artigo.');
            header('Location: /index.php');
            exit;
        }
    }
}
