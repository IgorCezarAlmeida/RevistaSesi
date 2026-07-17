<?php

declare(strict_types=1);

$title = 'Início';
require __DIR__ . '/_header.php';
?>

<?php if (!empty($error)): ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="bi bi-exclamation-triangle me-2"></i><?= htmlspecialchars($error) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
<?php endif; ?>
<?php if (!empty($success)): ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle me-2"></i><?= htmlspecialchars($success) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
<?php endif; ?>

<!-- Hero -->
<div class="p-5 mb-4 bg-primary text-white rounded-3 shadow-sm">
  <div class="container-fluid">
    <h1 class="display-5 fw-bold"><i class="bi bi-journal-richtext me-2"></i>Revista SESI</h1>
    <p class="col-md-8 fs-5">Explore artigos sobre tecnologia, educação, ciência e muito mais.</p>
    <form method="GET" action="/index.php" class="d-flex gap-2">
      <input type="hidden" name="action" value="pesquisar">
      <input class="form-control form-control-lg" type="text" name="q" placeholder="Buscar artigos...">
      <button class="btn btn-light btn-lg px-4" type="submit"><i class="bi bi-search"></i></button>
    </form>
  </div>
</div>

<!-- Artigos -->
<h4 class="fw-bold mb-3"><i class="bi bi-clock-history me-2 text-primary"></i>Artigos Recentes</h4>
<?php if (empty($artigos)): ?>
  <div class="alert alert-info"><i class="bi bi-info-circle me-2"></i>Nenhum artigo publicado ainda.</div>
<?php else: ?>
<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
  <?php foreach ($artigos as $artigo): ?>
  <div class="col">
    <div class="card h-100 shadow-sm border-0">
      <?php if ($artigo->getImagemCapa()): ?>
        <img src="/index.php?action=upload&file=<?= urlencode($artigo->getImagemCapa()) ?>"
             class="card-img-top" alt="Capa" style="height:180px;object-fit:cover;">
      <?php else: ?>
        <div class="bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" style="height:180px;">
          <i class="bi bi-file-earmark-text text-primary" style="font-size:3rem;"></i>
        </div>
      <?php endif; ?>
      <div class="card-body d-flex flex-column">
        <span class="badge bg-primary mb-2"><?= htmlspecialchars($artigo->getCategoria()->getNome()) ?></span>
        <h5 class="card-title fw-bold"><?= htmlspecialchars($artigo->getTitulo()) ?></h5>
        <p class="card-text text-muted small flex-grow-1"><?= htmlspecialchars(mb_strimwidth($artigo->getResumo(), 0, 120, '...')) ?></p>
        <div class="d-flex justify-content-between align-items-center mt-3">
          <small class="text-muted"><i class="bi bi-person me-1"></i><?= htmlspecialchars($artigo->getAutor()->getNome()) ?></small>
          <small class="text-muted"><i class="bi bi-heart me-1"></i><?= $artigo->getQtdCurtidas() ?></small>
        </div>
      </div>
      <div class="card-footer bg-transparent border-0 pb-3">
        <a href="/artigo.php?id=<?= $artigo->getId() ?>" class="btn btn-primary w-100">
          <i class="bi bi-book me-1"></i>Ler artigo
        </a>
      </div>
    </div>
  </div>
  <?php endforeach; ?>
</div>
<?php endif; ?>

<?php require __DIR__ . '/_footer.php';
