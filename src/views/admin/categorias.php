<?php

declare(strict_types=1);

use App\Helpers\Session;

$title = 'Admin - Categorias';
require dirname(__DIR__) . '/_header.php';
?>

<?php if ($msg = Session::flash('error')): ?><div class="alert"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
<?php if ($msg = Session::flash('success')): ?><div class="success"><?= htmlspecialchars($msg) ?></div><?php endif; ?>

<div class="card">
  <h3>Nova categoria</h3>
  <form method="POST" action="/index.php?action=admin/categorias">
    <input type="text" name="nome" placeholder="Nome da categoria" required>
    <button type="submit">Salvar</button>
  </form>
</div>

<div class="card">
  <h3>Categorias cadastradas</h3>
  <?php foreach ($categorias as $categoria): ?>
    <p>#<?= $categoria->getId() ?> - <?= htmlspecialchars($categoria->getNome()) ?></p>
  <?php endforeach; ?>
</div>

<?php require dirname(__DIR__) . '/_footer.php';
