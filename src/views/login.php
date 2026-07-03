<?php

declare(strict_types=1);

$title = 'Login';
require __DIR__ . '/_header.php';
?>
<div class="card">
  <h3>Entrar</h3>
  <?php if (!empty($error)): ?><div class="alert"><?= htmlspecialchars($error) ?></div><?php endif; ?>
  <?php if (!empty($success)): ?><div class="success"><?= htmlspecialchars($success) ?></div><?php endif; ?>

  <form method="POST" action="/index.php?action=login">
    <label>Email</label>
    <input type="email" name="email" required>

    <label>Senha</label>
    <input type="password" name="senha" required>

    <button type="submit">Entrar</button>
  </form>
</div>
<?php require __DIR__ . '/_footer.php';
