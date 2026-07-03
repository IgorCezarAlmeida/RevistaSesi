<?php

declare(strict_types=1);

$title = 'Dashboard Admin';
require __DIR__ . '/_header.php';
?>
<div class="card">
  <h3>Painel administrativo</h3>
  <p>Total de usuarios: <?= count($usuarios) ?></p>
  <p>Total de artigos: <?= count($artigos) ?></p>
  <p>Total de categorias: <?= count($categorias) ?></p>

  <p>
    <a href="/index.php?action=admin/usuarios">Gerenciar usuarios</a> |
    <a href="/index.php?action=admin/artigos">Gerenciar artigos</a> |
    <a href="/index.php?action=admin/categorias">Gerenciar categorias</a>
  </p>
</div>
<?php require __DIR__ . '/_footer.php';
