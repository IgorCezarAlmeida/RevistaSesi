<?php

declare(strict_types=1);

$title = 'Cadastro';
require __DIR__ . '/_header.php';
?>

<div class="row justify-content-center">
  <div class="col-md-5 col-lg-4">
    <div class="card shadow-sm border-0 mt-3">
      <div class="card-body p-4">
        <div class="text-center mb-4">
          <i class="bi bi-person-plus text-primary" style="font-size:3rem;"></i>
          <h4 class="fw-bold mt-2">Criar conta</h4>
          <p class="text-muted small">Junte-se à Revista SESI</p>
        </div>

        <?php if (!empty($error)): ?>
          <div class="alert alert-danger"><i class="bi bi-exclamation-triangle me-2"></i><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="/index.php?action=cadastro">
          <div class="mb-3">
            <label class="form-label fw-semibold">Nome completo</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-person"></i></span>
              <input type="text" name="nome" class="form-control" placeholder="Seu nome" required autofocus>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">E-mail</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-envelope"></i></span>
              <input type="email" name="email" class="form-control" placeholder="seu@email.com" required>
            </div>
          </div>
          <div class="mb-4">
            <label class="form-label fw-semibold">Senha</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-lock"></i></span>
              <input type="password" name="senha" class="form-control" placeholder="Mínimo 6 caracteres" required minlength="6">
            </div>
          </div>
          <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
            <i class="bi bi-person-check me-2"></i>Cadastrar
          </button>
        </form>

        <hr>
        <p class="text-center text-muted small mb-0">
          Já tem conta? <a href="/login.php" class="text-primary fw-semibold">Fazer login</a>
        </p>
      </div>
    </div>
  </div>
</div>

<?php require __DIR__ . '/_footer.php';
