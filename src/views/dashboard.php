<?php

declare(strict_types=1);

$title = 'Dashboard Admin';
require dirname(__DIR__) . '/_header.php';
?>

<div class="d-flex align-items-center gap-2 mb-4">
  <i class="bi bi-shield-lock text-danger fs-3"></i>
  <div>
    <h4 class="fw-bold mb-0">Painel Administrativo</h4>
    <small class="text-muted">Visão geral do sistema</small>
  </div>
</div>

<!-- Estatísticas -->
<div class="row g-3 mb-4">
  <div class="col-sm-6 col-lg-3">
    <div class="card border-0 shadow-sm text-center py-3 h-100">
      <div class="card-body">
        <i class="bi bi-people text-primary mb-2" style="font-size:2rem;"></i>
        <h2 class="fw-bold"><?= count($usuarios) ?></h2>
        <p class="text-muted mb-0">Usuários</p>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-lg-3">
    <div class="card border-0 shadow-sm text-center py-3 h-100">
      <div class="card-body">
        <i class="bi bi-file-earmark-text text-success mb-2" style="font-size:2rem;"></i>
        <h2 class="fw-bold"><?= count($artigos) ?></h2>
        <p class="text-muted mb-0">Artigos</p>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-lg-3">
    <div class="card border-0 shadow-sm text-center py-3 h-100">
      <div class="card-body">
        <i class="bi bi-tags text-warning mb-2" style="font-size:2rem;"></i>
        <h2 class="fw-bold"><?= count($categorias) ?></h2>
        <p class="text-muted mb-0">Categorias</p>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-lg-3">
    <div class="card border-0 shadow-sm text-center py-3 h-100">
      <div class="card-body">
        <i class="bi bi-gear text-danger mb-2" style="font-size:2rem;"></i>
        <h2 class="fw-bold">Admin</h2>
        <p class="text-muted mb-0">Nível de acesso</p>
      </div>
    </div>
  </div>
</div>

<!-- Ações rápidas -->
<div class="row g-3">
  <div class="col-md-4">
    <a href="/index.php?action=admin/usuarios" class="card border-0 shadow-sm text-decoration-none text-dark h-100">
      <div class="card-body d-flex align-items-center gap-3 p-4">
        <i class="bi bi-people-fill text-primary" style="font-size:2rem;"></i>
        <div>
          <h6 class="fw-bold mb-0">Gerenciar Usuários</h6>
          <small class="text-muted">Ver e remover usuários</small>
        </div>
        <i class="bi bi-chevron-right ms-auto text-muted"></i>
      </div>
    </a>
  </div>
  <div class="col-md-4">
    <a href="/index.php?action=admin/artigos" class="card border-0 shadow-sm text-decoration-none text-dark h-100">
      <div class="card-body d-flex align-items-center gap-3 p-4">
        <i class="bi bi-newspaper text-success" style="font-size:2rem;"></i>
        <div>
          <h6 class="fw-bold mb-0">Gerenciar Artigos</h6>
          <small class="text-muted">Todos os artigos publicados</small>
        </div>
        <i class="bi bi-chevron-right ms-auto text-muted"></i>
      </div>
    </a>
  </div>
  <div class="col-md-4">
    <a href="/index.php?action=admin/categorias" class="card border-0 shadow-sm text-decoration-none text-dark h-100">
      <div class="card-body d-flex align-items-center gap-3 p-4">
        <i class="bi bi-tags-fill text-warning" style="font-size:2rem;"></i>
        <div>
          <h6 class="fw-bold mb-0">Gerenciar Categorias</h6>
          <small class="text-muted">Adicionar e remover categorias</small>
        </div>
        <i class="bi bi-chevron-right ms-auto text-muted"></i>
      </div>
    </a>
  </div>
</div>

<?php require dirname(__DIR__) . '/_footer.php';
