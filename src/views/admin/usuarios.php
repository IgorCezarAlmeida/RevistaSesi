<?php

declare(strict_types=1);

$title = 'Admin — Usuários';
require dirname(__DIR__) . '/_header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
  <h4 class="fw-bold mb-0"><i class="bi bi-people me-2 text-primary"></i>Usuários Cadastrados</h4>
  <a href="/index.php?action=admin/dashboard" class="btn btn-outline-secondary btn-sm">
    <i class="bi bi-arrow-left me-1"></i>Voltar
  </a>
</div>

<?php if (empty($usuarios)): ?>
  <div class="alert alert-info"><i class="bi bi-info-circle me-2"></i>Nenhum usuário encontrado.</div>
<?php else: ?>
<div class="card shadow-sm border-0">
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th>#</th>
          <th>Nome</th>
          <th>E-mail</th>
          <th>Tipo</th>
          <th>Data cadastro</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($usuarios as $usuario): ?>
        <tr>
          <td class="text-muted small"><?= $usuario->getId() ?></td>
          <td>
            <div class="d-flex align-items-center gap-2">
              <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center flex-shrink-0"
                   style="width:32px;height:32px;font-size:.85rem;">
                <?= strtoupper(substr($usuario->getNome(), 0, 1)) ?>
              </div>
              <span class="fw-semibold"><?= htmlspecialchars($usuario->getNome()) ?></span>
            </div>
          </td>
          <td class="text-muted"><?= htmlspecialchars($usuario->getEmail()) ?></td>
          <td>
            <?php if ($usuario->isAdmin()): ?>
              <span class="badge bg-danger"><i class="bi bi-shield-lock me-1"></i>Admin</span>
            <?php else: ?>
              <span class="badge bg-secondary"><i class="bi bi-person me-1"></i>Usuário</span>
            <?php endif; ?>
          </td>
          <td class="text-muted small"><?= $usuario->getCreatedAt()->format('d/m/Y') ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?php endif; ?>

<?php require dirname(__DIR__) . '/_footer.php';
