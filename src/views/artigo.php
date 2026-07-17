<?php

declare(strict_types=1);

use App\Helpers\Session;

$title = $artigo->getTitulo();
require __DIR__ . '/_header.php';
?>

<div class="row g-4">
  <!-- Conteúdo principal -->
  <div class="col-lg-8">
    <article class="card shadow-sm border-0">
      <?php if ($artigo->getImagemCapa()): ?>
        <img src="/index.php?action=upload&file=<?= urlencode($artigo->getImagemCapa()) ?>"
             class="card-img-top" alt="Capa" style="max-height:380px;object-fit:cover;">
      <?php endif; ?>
      <div class="card-body p-4">
        <span class="badge bg-primary mb-2"><?= htmlspecialchars($artigo->getCategoria()->getNome()) ?></span>
        <h1 class="fw-bold h3"><?= htmlspecialchars($artigo->getTitulo()) ?></h1>
        <p class="text-muted fst-italic"><?= htmlspecialchars($artigo->getResumo()) ?></p>
        <div class="d-flex align-items-center gap-3 text-muted small mb-4">
          <span><i class="bi bi-person me-1"></i><?= htmlspecialchars($artigo->getAutor()->getNome()) ?></span>
          <span><i class="bi bi-calendar me-1"></i><?= $artigo->getCreatedAt()->format('d/m/Y') ?></span>
          <span><i class="bi bi-heart-fill text-danger me-1"></i><?= $artigo->getQtdCurtidas() ?> curtidas</span>
        </div>
        <hr>
        <div class="article-content lh-lg">
          <?= nl2br(htmlspecialchars($artigo->getConteudo())) ?>
        </div>
        <hr>

        <!-- Ações -->
        <div class="d-flex flex-wrap gap-2">
          <form method="POST" action="/index.php?action=artigo/curtir&id=<?= $artigo->getId() ?>">
            <button type="submit" class="btn btn-outline-danger">
              <i class="bi bi-heart me-1"></i>Curtir (<?= $artigo->getQtdCurtidas() ?>)
            </button>
          </form>
          <?php if ($canEdit): ?>
            <a href="/index.php?action=artigo/editar&id=<?= $artigo->getId() ?>" class="btn btn-outline-secondary">
              <i class="bi bi-pencil me-1"></i>Editar
            </a>
            <a href="/index.php?action=artigo/remover&id=<?= $artigo->getId() ?>"
               class="btn btn-outline-danger"
               onclick="return confirm('Deseja remover este artigo?')">
              <i class="bi bi-trash me-1"></i>Remover
            </a>
          <?php endif; ?>
          <a href="/index.php" class="btn btn-link text-muted ms-auto">
            <i class="bi bi-arrow-left me-1"></i>Voltar
          </a>
        </div>
      </div>
    </article>

    <!-- Comentários -->
    <div class="card shadow-sm border-0 mt-4">
      <div class="card-body p-4">
        <h5 class="fw-bold mb-3"><i class="bi bi-chat-dots me-2 text-primary"></i>Comentários (<?= count($comentarios) ?>)</h5>

        <?php if (empty($comentarios)): ?>
          <p class="text-muted">Nenhum comentário ainda. Seja o primeiro!</p>
        <?php endif; ?>

        <?php foreach ($comentarios as $comentario): ?>
          <div class="d-flex gap-3 mb-3">
            <div class="flex-shrink-0">
              <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width:40px;height:40px;">
                <?= strtoupper(substr($comentario->getUsuario()->getNome(), 0, 1)) ?>
              </div>
            </div>
            <div class="flex-grow-1">
              <div class="bg-light rounded p-3">
                <strong class="small"><?= htmlspecialchars($comentario->getUsuario()->getNome()) ?></strong>
                <span class="text-muted small ms-2"><?= $comentario->getCreatedAt()->format('d/m/Y H:i') ?></span>
                <p class="mb-0 mt-1"><?= htmlspecialchars($comentario->getConteudo()) ?></p>
              </div>
              <?php if (Session::get('is_admin') || Session::get('user_id') === $comentario->getUsuario()->getId()): ?>
                <a href="/index.php?action=comentario/remover&id=<?= $comentario->getId() ?>&artigo_id=<?= $artigo->getId() ?>"
                   class="text-danger small"
                   onclick="return confirm('Remover comentário?')">
                  <i class="bi bi-trash"></i> remover
                </a>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>

        <hr>
        <?php if (Session::get('user_id')): ?>
          <form method="POST" action="/index.php?action=comentario/adicionar">
            <input type="hidden" name="artigo_id" value="<?= $artigo->getId() ?>">
            <label class="form-label fw-semibold">Deixe um comentário</label>
            <textarea name="conteudo" class="form-control mb-2" rows="3" placeholder="Escreva aqui..." required></textarea>
            <button type="submit" class="btn btn-primary">
              <i class="bi bi-send me-1"></i>Comentar
            </button>
          </form>
        <?php else: ?>
          <div class="alert alert-info mb-0">
            <i class="bi bi-info-circle me-2"></i>
            <a href="/login.php" class="fw-semibold">Faça login</a> para comentar.
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- Sidebar -->
  <div class="col-lg-4">
    <div class="card shadow-sm border-0">
      <div class="card-body">
        <h6 class="fw-bold"><i class="bi bi-person me-2 text-primary"></i>Sobre o autor</h6>
        <div class="d-flex align-items-center gap-3 mt-2">
          <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center flex-shrink-0" style="width:50px;height:50px;font-size:1.3rem;">
            <?= strtoupper(substr($artigo->getAutor()->getNome(), 0, 1)) ?>
          </div>
          <div>
            <div class="fw-semibold"><?= htmlspecialchars($artigo->getAutor()->getNome()) ?></div>
            <small class="text-muted">Autor</small>
          </div>
        </div>
      </div>
    </div>

    <div class="card shadow-sm border-0 mt-3">
      <div class="card-body">
        <h6 class="fw-bold"><i class="bi bi-info-circle me-2 text-primary"></i>Detalhes</h6>
        <ul class="list-unstyled small text-muted mb-0 mt-2">
          <li class="mb-1"><i class="bi bi-tags me-2"></i><?= htmlspecialchars($artigo->getCategoria()->getNome()) ?></li>
          <li class="mb-1"><i class="bi bi-calendar me-2"></i>Publicado em <?= $artigo->getCreatedAt()->format('d/m/Y') ?></li>
          <li class="mb-1"><i class="bi bi-heart-fill text-danger me-2"></i><?= $artigo->getQtdCurtidas() ?> curtidas</li>
          <li><i class="bi bi-chat-dots me-2"></i><?= count($comentarios) ?> comentários</li>
        </ul>
      </div>
    </div>
  </div>
</div>

<?php require __DIR__ . '/_footer.php';

