<?php

declare(strict_types=1);

use App\Helpers\Session;

$title = $title ?? 'ProjetoArtigos';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($title) ?></title>
  <link rel="stylesheet" href="/assets/css/style.css">
  <script defer src="/assets/js/app.js"></script>
</head>
<body>
<header>
  <h2><a href="/index.php" style="text-decoration:none;color:inherit;">ProjetoArtigos</a></h2>
  <nav>
    <a href="/index.php">Home</a>
    <a href="/index.php?action=categorias">Categorias</a>
    <a href="/pesquisar.php">Pesquisar</a>
    <?php if (Session::get('user_id')): ?>
      <a href="/index.php?action=perfil">Perfil</a>
      <a href="/index.php?action=artigo/criar">Novo Artigo</a>
      <?php if (Session::get('is_admin')): ?>
        <a href="/index.php?action=admin/dashboard">Admin</a>
      <?php endif; ?>
      <a href="/index.php?action=logout">Sair</a>
    <?php else: ?>
      <a href="/login.php">Login</a>
      <a href="/cadastro.php">Cadastro</a>
    <?php endif; ?>
  </nav>
</header>
<main>

