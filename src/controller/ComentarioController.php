<?php

declare(strict_types=1);

namespace App\Controller;

use App\DAO\ArtigoDAO;
use App\DAO\ComentarioDAO;
use App\DAO\UsuarioDAO;
use App\Helpers\Session;
use App\Middleware\Auth;
use App\Model\Comentario;

final class ComentarioController
{
    public function __construct(
        private readonly ComentarioDAO $comentarioDAO,
        private readonly ArtigoDAO $artigoDAO,
        private readonly UsuarioDAO $usuarioDAO
    ) {}

    public function add(array $data): void
    {
        Auth::requireLogin();
        $artigoId = (int) ($data['artigo_id'] ?? 0);
        $conteudo = trim((string) ($data['conteudo'] ?? ''));

        $artigo = $this->artigoDAO->findById($artigoId);
        $usuario = $this->usuarioDAO->findById((int) Session::get('user_id'));

        if (!$artigo || !$usuario || $conteudo === '') {
            Session::flash('error', 'Comentario invalido.');
            header('Location: /artigo.php?id=' . $artigoId);
            exit;
        }

        $comentario = new Comentario();
        $comentario->setArtigo($artigo);
        $comentario->setUsuario($usuario);
        $comentario->setConteudo($conteudo);

        $this->comentarioDAO->save($comentario);
        header('Location: /artigo.php?id=' . $artigoId);
        exit;
    }

    public function delete(int $id, int $artigoId): void
    {
        Auth::requireLogin();
        $comentario = $this->comentarioDAO->findById($id);
        if (!$comentario) {
            header('Location: /artigo.php?id=' . $artigoId);
            exit;
        }

        $userId = (int) Session::get('user_id');
        $isAdmin = (bool) Session::get('is_admin');
        if (!$isAdmin && $comentario->getUsuario()->getId() !== $userId) {
            Session::flash('error', 'Voce nao pode remover este comentario.');
            header('Location: /artigo.php?id=' . $artigoId);
            exit;
        }

        $this->comentarioDAO->delete($comentario);
        header('Location: /artigo.php?id=' . $artigoId);
        exit;
    }
}
