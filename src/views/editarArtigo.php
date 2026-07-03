<?php

declare(strict_types=1);

$title = 'Editar Artigo';
require __DIR__ . '/_header.php';
?>
<div class="card">
  <h3>Editar artigo</h3>
  <form method="POST" action="/index.php?action=artigo/editar&id=<?= $artigo->getId() ?>" enctype="multipart/form-data">
    <label>Titulo</label>
    <input type="text" name="titulo" value="<?= htmlspecialchars($artigo->getTitulo()) ?>" required>

    <label>Resumo</label>
    <input type="text" name="resumo" value="<?= htmlspecialchars($artigo->getResumo()) ?>" required>

    <label>Conteudo</label>
    <textarea name="conteudo" rows="10" required><?= htmlspecialchars($artigo->getConteudo()) ?></textarea>

    <label>Categoria</label>
    <select name="categoria_id" required>
      <?php foreach ($categorias as $categoria): ?>
        <option value="<?= $categoria->getId() ?>" <?= $artigo->getCategoria()->getId() === $categoria->getId() ? 'selected' : '' ?>>
          <?= htmlspecialchars($categoria->getNome()) ?>
        </option>
      <?php endforeach; ?>
    </select>

    <label>Nova imagem de capa (opcional)</label>
    <input type="file" name="imagem" accept="image/*">

    <button type="submit">Salvar alteracoes</button>
  </form>
</div>
<?php require __DIR__ . '/_footer.php';
