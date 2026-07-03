<?php

declare(strict_types=1);

$title = 'Inicio';
require __DIR__ . '/_header.php';
?>

<?php if (!empty($error)): ?><div class="alert"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<?php if (!empty($success)): ?><div class="success"><?= htmlspecialchars($success) ?></div><?php endif; ?>

<div class="card">
  <h3>Artigos recentes</h3>
  <form method="GET" action="/index.php">
    <input type="hidden" name="action" value="pesquisar">
    <input type="text" name="q" placeholder="Busque por titulo ou resumo">
  </form>
</div>

<?php foreach ($artigos as $artigo): ?>
  <div class="card">
    <h3><?= htmlspecialchars($artigo->getTitulo()) ?></h3>
    <p><?= htmlspecialchars($artigo->getResumo()) ?></p>
    <small>
      Autor: <?= htmlspecialchars($artigo->getAutor()->getNome()) ?> |
      Categoria: <?= htmlspecialchars($artigo->getCategoria()->getNome()) ?> |
      Curtidas: <?= $artigo->getQtdCurtidas() ?>
    </small>
    <p><a href="/artigo.php?id=<?= $artigo->getId() ?>">Ler artigo</a></p>
  </div>
<?php endforeach; ?>

<?php require __DIR__ . '/_footer.php';
