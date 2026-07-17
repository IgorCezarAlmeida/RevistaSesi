<?php

declare(strict_types=1);

use App\Helpers\Session;

$title = $title ?? 'Revista SESI';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($title) ?> — Revista SESI</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold fs-4" href="/index.php">
      <i class="bi bi-journal-richtext me-2"></i>Revista SESI
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navMain">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="/index.php"><i class="bi bi-house me-1"></i>Home</a></li>
        <li class="nav-item"><a class="nav-link" href="/index.php?action=categorias"><i class="bi bi-tags me-1"></i>Categorias</a></li>
        <li class="nav-item"><a class="nav-link" href="/index.php?action=pesquisar"><i class="bi bi-search me-1"></i>Pesquisar</a></li>
      </ul>
      <ul class="navbar-nav ms-auto align-items-lg-center">
        <?php if (Session::get('user_id')): ?>
          <li class="nav-item">
            <a class="nav-link" href="/index.php?action=artigo/criar"><i class="bi bi-plus-circle me-1"></i>Novo Artigo</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
              <i class="bi bi-person-circle me-1"></i><?= htmlspecialchars((string) Session::get('user_name', 'Conta')) ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="/index.php?action=perfil"><i class="bi bi-person me-2"></i>Meu Perfil</a></li>
              <?php if (Session::get('is_admin')): ?>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="/index.php?action=admin/dashboard"><i class="bi bi-shield-lock me-2"></i>Painel Admin</a></li>
              <?php endif; ?>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="/index.php?action=logout"><i class="bi bi-box-arrow-right me-2"></i>Sair</a></li>
            </ul>
          </li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="/login.php"><i class="bi bi-box-arrow-in-right me-1"></i>Login</a></li>
          <li class="nav-item"><a class="btn btn-outline-light ms-2" href="/cadastro.php">Cadastre-se</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<main class="container py-4">

