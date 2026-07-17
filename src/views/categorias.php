<?php

declare(strict_types=1);

$title = 'Categorias';
require __DIR__ . '/_header.php';
?>

<h4 class="fw-bold mb-4"><i class="bi bi-tags me-2 text-primary"></i>Categorias</h4>
<div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 g-3">
  <?php foreach ($categorias as $categoria): ?>
  <div class="col">
    <a href="/index.php?action=pesquisar&q=<?= urlencode($categoria->getNome()) ?>"
       class="text-decoration-none">
      <div class="card border-0 shadow-sm text-center py-3 h-100 category-card">
        <div class="card-body">
          <i class="bi bi-folder2-open text-primary mb-2" style="font-size:2rem;"></i>
          <h6 class="fw-semibold mb-0"><?= htmlspecialchars($categoria->getNome()) ?></h6>
        </div>
      </div>
    </a>
  </div>
  <?php endforeach; ?>
</div>

<?php require __DIR__ . '/_footer.php';
