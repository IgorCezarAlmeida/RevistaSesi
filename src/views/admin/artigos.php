<?php

declare(strict_types=1);

$title = 'Admin - Artigos';
require dirname(__DIR__) . '/_header.php';
?>
<div class="card">
  <h3>Artigos publicados</h3>
  <?php foreach ($artigos as $artigo): ?>
    <p>
      #<?= $artigo->getId() ?> -
      <a href="/artigo.php?id=<?= $artigo->getId() ?>"><?= htmlspecialchars($artigo->getTitulo()) ?></a>
      (<?= htmlspecialchars($artigo->getAutor()->getNome()) ?>)
    </p>
  <?php endforeach; ?>
</div>
<?php require dirname(__DIR__) . '/_footer.php';
