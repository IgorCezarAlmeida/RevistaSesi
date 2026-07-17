<?php

declare(strict_types=1);

$title = 'Pesquisar';
require __DIR__ . '/_header.php';
?>

<div class="row justify-content-center mb-4">
  <div class="col-lg-7">
    <h4 class="fw-bold mb-3"><i class="bi bi-search me-2 text-primary"></i>Pesquisar Artigos</h4>
    <form method="GET" action="/index.php" class="d-flex gap-2">
      <input type="hidden" name="action" value="pesquisar">
      <input type="text" name="q" class="form-control form-control-lg"
             value="<?= htmlspecialchars($termo ?? '') ?>" placeholder="Digite título, resumo ou conteúdo..." autofocus>
      <button type="submit" class="btn btn-primary btn-lg px-4"><i class="bi bi-search"></i></button>
    </form>
  </div>
</div>

<?php if (!empty($termo)): ?>
  <h5 class="fw-semibold mb-3">
    Resultados para: <span class="text-primary">"<?= htmlspecialchars($termo) ?>"</span>
    <span class="badge bg-secondary ms-2"><?= count($artigos) ?></span>
  </h5>
  <?php if (empty($artigos)): ?>
    <div class="alert alert-warning"><i class="bi bi-exclamation-circle me-2"></i>Nenhum artigo encontrado para esse termo.</div>
  <?php else: ?>
    <div class="row row-cols-1 row-cols-md-2 g-4">
      <?php foreach ($artigos as $artigo): ?>
      <div class="col">
        <div class="card h-100 shadow-sm border-0">
          <div class="card-body">
            <span class="badge bg-primary mb-2"><?= htmlspecialchars($artigo->getCategoria()->getNome()) ?></span>
            <h5 class="card-title fw-bold">
              <a href="/artigo.php?id=<?= $artigo->getId() ?>" class="text-decoration-none text-dark">
                <?= htmlspecialchars($artigo->getTitulo()) ?>
              </a>
            </h5>
            <p class="card-text text-muted small"><?= htmlspecialchars(mb_strimwidth($artigo->getResumo(), 0, 150, '...')) ?></p>
          </div>
          <div class="card-footer bg-transparent border-0 d-flex justify-content-between align-items-center">
            <small class="text-muted"><i class="bi bi-person me-1"></i><?= htmlspecialchars($artigo->getAutor()->getNome()) ?></small>
            <a href="/artigo.php?id=<?= $artigo->getId() ?>" class="btn btn-sm btn-primary">
              <i class="bi bi-book me-1"></i>Ler
            </a>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
<?php endif; ?>

<?php require __DIR__ . '/_footer.php';
