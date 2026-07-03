<?php

declare(strict_types=1);

$title = 'Pesquisar';
require __DIR__ . '/_header.php';
?>
<div class="card">
  <h3>Pesquisar artigos</h3>
  <form method="GET" action="/index.php">
    <input type="hidden" name="action" value="pesquisar">
    <input type="text" name="q" value="<?= htmlspecialchars($termo ?? '') ?>" placeholder="Digite um termo">
    <button type="submit">Buscar</button>
  </form>
</div>

<?php if (!empty($termo)): ?>
  <div class="card">
    <h4>Resultados para: "<?= htmlspecialchars($termo) ?>"</h4>
    <?php if (empty($artigos)): ?>
      <p>Nenhum artigo encontrado.</p>
    <?php endif; ?>

    <?php foreach ($artigos as $artigo): ?>
      <p>
        <a href="/artigo.php?id=<?= $artigo->getId() ?>"><?= htmlspecialchars($artigo->getTitulo()) ?></a>
        - <?= htmlspecialchars($artigo->getResumo()) ?>
      </p>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<?php require __DIR__ . '/_footer.php';
