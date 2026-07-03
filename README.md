# ProjetoArtigos

Sistema simples de artigos com arquitetura MVC em PHP, persistencia com Doctrine ORM e renderizacao por views PHP.

## Requisitos

- PHP 8.2+
- Composer
- MySQL 8+

## Setup rapido

```powershell
cd "C:\Users\igorc\OneDrive\Área de Trabalho\Projetos_Tarefas\Revista SESI\ProjetoArtigos"
composer install
```

Crie o banco e importe `database/banco.sql`.

## Rodar localmente

```powershell
cd "C:\Users\igorc\OneDrive\Área de Trabalho\Projetos_Tarefas\Revista SESI\ProjetoArtigos"
php -S localhost:8000 -t public
```

Abra:

- `http://localhost:8000/index.php`

## Smoke test

```powershell
cd "C:\Users\igorc\OneDrive\Área de Trabalho\Projetos_Tarefas\Revista SESI\ProjetoArtigos"
php scripts/smoke.php
```

## Credenciais de administrador (seed SQL)

- Email: `admin@site.com`
- Senha: `123456`

## Estrutura

- `public/`: pontos de entrada HTTP
- `src/controller/`: regras de fluxo
- `src/model/`: entidades Doctrine
- `src/dao/`: acesso a dados
- `src/views/`: frontend (views PHP)
- `src/middleware/`: auth/admin
- `src/helpers/`: utilitarios


