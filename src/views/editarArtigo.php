<?php

declare(strict_types=1);

$title = 'Editar Artigo';
require __DIR__ . '/_header.php';
?>

<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="card shadow-sm border-0">
      <div class="card-body p-4">
        <h4 class="fw-bold mb-1"><i class="bi bi-pencil-square me-2 text-primary"></i>Editar Artigo</h4>
        <p class="text-muted small mb-4">Altere os campos desejados e salve</p>

        <form method="POST" action="/index.php?action=artigo/editar&id=<?= $artigo->getId() ?>" enctype="multipart/form-data">
          <div class="mb-3">
            <label class="form-label fw-semibold">Título <span class="text-danger">*</span></label>
            <input type="text" name="titulo" class="form-control" value="<?= htmlspecialchars($artigo->getTitulo()) ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Resumo <span class="text-danger">*</span></label>
            <textarea name="resumo" class="form-control" rows="2" required><?= htmlspecialchars($artigo->getResumo()) ?></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Conteúdo <span class="text-danger">*</span></label>
            <textarea name="conteudo" class="form-control" rows="12" required><?= htmlspecialchars($artigo->getConteudo()) ?></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Categoria <span class="text-danger">*</span></label>
            <select name="categoria_id" class="form-select" required>
              <?php foreach ($categorias as $categoria): ?>
                <option value="<?= $categoria->getId() ?>" <?= $artigo->getCategoria()->getId() === $categoria->getId() ? 'selected' : '' ?>>
                  <?= htmlspecialchars($categoria->getNome()) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-4">
            <label class="form-label fw-semibold">Nova imagem de capa <span class="text-muted fw-normal">(opcional)</span></label>
            <?php if ($artigo->getImagemCapa()): ?>
              <div class="mb-2">
                <img src="/index.php?action=upload&file=<?= urlencode($artigo->getImagemCapa()) ?>"
                     class="img-thumbnail" style="max-height:120px;" alt="Capa atual">
                <small class="text-muted d-block mt-1">Capa atual — envie outra para substituir</small>
              </div>
            <?php endif; ?>
            <input type="file" name="imagem" class="form-control" accept="image/*">
          </div>
          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary px-4">
              <i class="bi bi-floppy me-1"></i>Salvar alterações
            </button>
            <a href="/artigo.php?id=<?= $artigo->getId() ?>" class="btn btn-outline-secondary">Cancelar</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php require __DIR__ . '/_footer.php';
