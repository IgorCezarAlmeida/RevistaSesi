<?php

declare(strict_types=1);

use App\Helpers\Session;

$title = $artigo->getTitulo();
require __DIR__ . '/_header.php';
?>
<div class="card">
  <h2><?= htmlspecialchars($artigo->getTitulo()) ?></h2>
  <p><em><?= htmlspecialchars($artigo->getResumo()) ?></em></p>
  <?php if ($artigo->getImagemCapa()): ?>
    <p><img src="/index.php?action=upload&file=<?= urlencode($artigo->getImagemCapa()) ?>" alt="Capa" style="max-width:100%;height:auto;"></p>
  <?php endif; ?>
  <p><?= nl2br(htmlspecialchars($artigo->getConteudo())) ?></p>
  <small>Categoria: <?= htmlspecialchars($artigo->getCategoria()->getNome()) ?> | Autor: <?= htmlspecialchars($artigo->getAutor()->getNome()) ?></small>

  <form method="POST" action="/index.php?action=artigo/curtir&id=<?= $artigo->getId() ?>">
    <button type="submit">Curtir (<?= $artigo->getQtdCurtidas() ?>)</button>
  </form>

  <?php if ($canEdit): ?>
    <p>
      <a href="/index.php?action=artigo/editar&id=<?= $artigo->getId() ?>">Editar</a> |
      <a href="/index.php?action=artigo/remover&id=<?= $artigo->getId() ?>" data-confirm="Deseja remover este artigo?">Remover</a>
    </p>
  <?php endif; ?>
</div>

<div class="card">
  <h3>Comentarios</h3>
  <?php foreach ($comentarios as $comentario): ?>
    <p>
      <strong><?= htmlspecialchars($comentario->getUsuario()->getNome()) ?>:</strong>
      <?= htmlspecialchars($comentario->getConteudo()) ?>
      <?php if (Session::get('is_admin') || Session::get('user_id') === $comentario->getUsuario()->getId()): ?>
        - <a href="/index.php?action=comentario/remover&id=<?= $comentario->getId() ?>&artigo_id=<?= $artigo->getId() ?>">remover</a>
      <?php endif; ?>
    </p>
  <?php endforeach; ?>

  <?php if (Session::get('user_id')): ?>
    <form method="POST" action="/index.php?action=comentario/adicionar">
      <input type="hidden" name="artigo_id" value="<?= $artigo->getId() ?>">
      <textarea name="conteudo" rows="3" required></textarea>
      <button type="submit">Comentar</button>
    </form>
  <?php else: ?>
    <p>Faca login para comentar.</p>
  <?php endif; ?>
</div>

<?php require __DIR__ . '/_footer.php';

