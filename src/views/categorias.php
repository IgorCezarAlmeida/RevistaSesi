<?php

declare(strict_types=1);

$title = 'Categorias';
require __DIR__ . '/_header.php';
?>
<div class="card">
  <h3>Categorias</h3>
  <?php foreach ($categorias as $categoria): ?>
    <p><?= htmlspecialchars($categoria->getNome()) ?></p>
  <?php endforeach; ?>
</div>
<?php require __DIR__ . '/_footer.php';
