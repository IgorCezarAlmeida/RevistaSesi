<?php

declare(strict_types=1);

$title = 'Perfil';
require __DIR__ . '/_header.php';
?>
<div class="card">
  <h3>Meu perfil</h3>
  <?php if (!$usuario): ?>
    <div class="alert">Usuario nao encontrado.</div>
  <?php else: ?>
    <p><strong>Nome:</strong> <?= htmlspecialchars($usuario->getNome()) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($usuario->getEmail()) ?></p>
    <p><strong>Tipo:</strong> <?= $usuario->isAdmin() ? 'Administrador' : 'Usuario' ?></p>
  <?php endif; ?>
</div>
<?php require __DIR__ . '/_footer.php';
