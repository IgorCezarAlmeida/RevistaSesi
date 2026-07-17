<?php

declare(strict_types=1);

$title = 'Criar Artigo';
require __DIR__ . '/_header.php';
?>

<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="card shadow-sm border-0">
      <div class="card-body p-4">
        <h4 class="fw-bold mb-1"><i class="bi bi-plus-circle me-2 text-primary"></i>Novo Artigo</h4>
        <p class="text-muted small mb-4">Preencha os campos abaixo para publicar</p>

        <form method="POST" action="/index.php?action=artigo/criar" enctype="multipart/form-data">
          <div class="mb-3">
            <label class="form-label fw-semibold">Título <span class="text-danger">*</span></label>
            <input type="text" name="titulo" class="form-control" placeholder="Título do artigo" required>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Resumo <span class="text-danger">*</span></label>
            <textarea name="resumo" class="form-control" rows="2" placeholder="Breve descrição do artigo..." required></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Conteúdo <span class="text-danger">*</span></label>
            <textarea name="conteudo" class="form-control" rows="12" placeholder="Escreva o conteúdo completo aqui..." required></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Categoria <span class="text-danger">*</span></label>
            <select name="categoria_id" class="form-select" required>
              <option value="" disabled selected>Selecione uma categoria</option>
              <?php foreach ($categorias as $categoria): ?>
                <option value="<?= $categoria->getId() ?>"><?= htmlspecialchars($categoria->getNome()) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-4">
            <label class="form-label fw-semibold">Imagem de capa <span class="text-muted fw-normal">(opcional)</span></label>
            <input type="file" name="imagem" class="form-control" accept="image/*">
            <div class="form-text">JPG, PNG, WEBP — máx. 5 MB</div>
          </div>
          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary px-4">
              <i class="bi bi-send me-1"></i>Publicar artigo
            </button>
            <a href="/index.php" class="btn btn-outline-secondary">Cancelar</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php require __DIR__ . '/_footer.php';
