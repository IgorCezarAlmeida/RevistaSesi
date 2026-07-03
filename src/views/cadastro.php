<?php

declare(strict_types=1);

$title = 'Cadastro';
require __DIR__ . '/_header.php';
?>
<div class="card">
  <h3>Criar conta</h3>
  <?php if (!empty($error)): ?><div class="alert"><?= htmlspecialchars($error) ?></div><?php endif; ?>

  <form method="POST" action="/index.php?action=cadastro">
    <label>Nome</label>
    <input type="text" name="nome" required>

    <label>Email</label>
    <input type="email" name="email" required>

    <label>Senha</label>
    <input type="password" name="senha" required>

    <button type="submit">Cadastrar</button>
  </form>
</div>
<?php require __DIR__ . '/_footer.php';
