<?php

declare(strict_types=1);

$title = 'Admin — Artigos';
require dirname(__DIR__) . '/_header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
  <h4 class="fw-bold mb-0"><i class="bi bi-newspaper me-2 text-success"></i>Artigos Publicados</h4>
  <a href="/index.php?action=admin/dashboard" class="btn btn-outline-secondary btn-sm">
    <i class="bi bi-arrow-left me-1"></i>Voltar
  </a>
</div>

<?php if (empty($artigos)): ?>
  <div class="alert alert-info"><i class="bi bi-info-circle me-2"></i>Nenhum artigo publicado.</div>
<?php else: ?>
<div class="card shadow-sm border-0">
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th>#</th>
          <th>Título</th>
          <th>Autor</th>
          <th>Categoria</th>
          <th>Data</th>
          <th class="text-end">Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($artigos as $artigo): ?>
        <tr>
          <td class="text-muted small"><?= $artigo->getId() ?></td>
          <td class="fw-semibold"><?= htmlspecialchars($artigo->getTitulo()) ?></td>
          <td><?= htmlspecialchars($artigo->getAutor()->getNome()) ?></td>
          <td><span class="badge bg-primary"><?= htmlspecialchars($artigo->getCategoria()->getNome()) ?></span></td>
          <td class="text-muted small"><?= $artigo->getCreatedAt()->format('d/m/Y') ?></td>
          <td class="text-end">
            <a href="/artigo.php?id=<?= $artigo->getId() ?>" class="btn btn-sm btn-outline-primary me-1">
              <i class="bi bi-eye"></i>
            </a>
            <a href="/index.php?action=artigo/editar&id=<?= $artigo->getId() ?>" class="btn btn-sm btn-outline-secondary me-1">
              <i class="bi bi-pencil"></i>
            </a>
            <a href="/index.php?action=artigo/remover&id=<?= $artigo->getId() ?>"
               class="btn btn-sm btn-outline-danger"
               onclick="return confirm('Remover artigo?')">
              <i class="bi bi-trash"></i>
            </a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?php endif; ?>

<?php require dirname(__DIR__) . '/_footer.php';
