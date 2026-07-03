<?php

declare(strict_types=1);

$title = 'Criar Artigo';
require __DIR__ . '/_header.php';
?>
<div class="card">
  <h3>Novo artigo</h3>
  <form method="POST" action="/index.php?action=artigo/criar" enctype="multipart/form-data">
    <label>Titulo</label>
    <input type="text" name="titulo" required>

    <label>Resumo</label>
    <input type="text" name="resumo" required>

    <label>Conteudo</label>
    <textarea name="conteudo" rows="10" required></textarea>

    <label>Categoria</label>
    <select name="categoria_id" required>
      <?php foreach ($categorias as $categoria): ?>
        <option value="<?= $categoria->getId() ?>"><?= htmlspecialchars($categoria->getNome()) ?></option>
      <?php endforeach; ?>
    </select>

    <label>Imagem de capa (opcional)</label>
    <input type="file" name="imagem" accept="image/*">

    <button type="submit">Publicar</button>
  </form>
</div>
<?php require __DIR__ . '/_footer.php';
