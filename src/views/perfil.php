<?php

declare(strict_types=1);

$title = 'Meu Perfil';
require __DIR__ . '/_header.php';
?>

<div class="row justify-content-center">
  <div class="col-md-6 col-lg-5">
    <div class="card shadow-sm border-0">
      <div class="card-body p-4 text-center">
        <?php if (!$usuario): ?>
          <div class="alert alert-danger"><i class="bi bi-exclamation-triangle me-2"></i>Usuário não encontrado.</div>
        <?php else: ?>
          <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-3"
               style="width:80px;height:80px;font-size:2.5rem;">
            <?= strtoupper(substr($usuario->getNome(), 0, 1)) ?>
          </div>
          <h4 class="fw-bold"><?= htmlspecialchars($usuario->getNome()) ?></h4>
          <p class="text-muted"><?= htmlspecialchars($usuario->getEmail()) ?></p>
          <span class="badge <?= $usuario->isAdmin() ? 'bg-danger' : 'bg-primary' ?> px-3 py-2">
            <i class="bi <?= $usuario->isAdmin() ? 'bi-shield-lock' : 'bi-person' ?> me-1"></i>
            <?= $usuario->isAdmin() ? 'Administrador' : 'Usuário' ?>
          </span>
          <?php if ($usuario->isAdmin()): ?>
            <div class="mt-4">
              <a href="/index.php?action=admin/dashboard" class="btn btn-outline-danger">
                <i class="bi bi-shield-lock me-1"></i>Acessar Painel Admin
              </a>
            </div>
          <?php endif; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<?php require __DIR__ . '/_footer.php';
