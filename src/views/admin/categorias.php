<?php

declare(strict_types=1);

use App\Helpers\Session;

$title = 'Admin — Categorias';
require dirname(__DIR__) . '/_header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
  <h4 class="fw-bold mb-0"><i class="bi bi-tags me-2 text-warning"></i>Gerenciar Categorias</h4>
  <a href="/index.php?action=admin/dashboard" class="btn btn-outline-secondary btn-sm">
    <i class="bi bi-arrow-left me-1"></i>Voltar
  </a>
</div>

<?php if ($msg = Session::flash('error')): ?>
  <div class="alert alert-danger"><i class="bi bi-exclamation-triangle me-2"></i><?= htmlspecialchars($msg) ?></div>
<?php endif; ?>
<?php if ($msg = Session::flash('success')): ?>
  <div class="alert alert-success"><i class="bi bi-check-circle me-2"></i><?= htmlspecialchars($msg) ?></div>
<?php endif; ?>

<div class="row g-4">
  <!-- Form nova categoria -->
  <div class="col-md-4">
    <div class="card shadow-sm border-0">
      <div class="card-body p-4">
        <h6 class="fw-bold mb-3"><i class="bi bi-plus-circle me-2 text-primary"></i>Nova Categoria</h6>
        <form method="POST" action="/index.php?action=admin/categorias">
          <div class="mb-3">
            <input type="text" name="nome" class="form-control" placeholder="Nome da categoria" required>
          </div>
          <button type="submit" class="btn btn-primary w-100">
            <i class="bi bi-floppy me-1"></i>Salvar
          </button>
        </form>
      </div>
    </div>
  </div>

  <!-- Lista de categorias -->
  <div class="col-md-8">
    <div class="card shadow-sm border-0">
      <div class="card-body p-0">
        <?php if (empty($categorias)): ?>
          <div class="p-4"><div class="alert alert-info mb-0">Nenhuma categoria cadastrada.</div></div>
        <?php else: ?>
          <ul class="list-group list-group-flush">
            <?php foreach ($categorias as $categoria): ?>
              <li class="list-group-item d-flex justify-content-between align-items-center px-4 py-3">
                <div class="d-flex align-items-center gap-2">
                  <i class="bi bi-folder2-open text-warning"></i>
                  <span class="fw-semibold"><?= htmlspecialchars($categoria->getNome()) ?></span>
                </div>
                <span class="badge bg-light text-muted border">#<?= $categoria->getId() ?></span>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<?php require dirname(__DIR__) . '/_footer.php';
