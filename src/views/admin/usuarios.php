<?php

declare(strict_types=1);

$title = 'Admin - Usuarios';
require dirname(__DIR__) . '/_header.php';
?>
<div class="card">
  <h3>Usuarios cadastrados</h3>
  <?php foreach ($usuarios as $usuario): ?>
    <p>
      #<?= $usuario->getId() ?> - <?= htmlspecialchars($usuario->getNome()) ?>
      (<?= htmlspecialchars($usuario->getEmail()) ?>)
      <?= $usuario->isAdmin() ? '[ADMIN]' : '' ?>
    </p>
  <?php endforeach; ?>
</div>
<?php require dirname(__DIR__) . '/_footer.php';
