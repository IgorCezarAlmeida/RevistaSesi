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

## TiDB (Render)

Se aparecer erro como `Table 'revistasesi.artigos' doesn't exist`, a conexao com TiDB esta OK,
mas o schema ainda nao foi criado nesse banco.

Opcao 1 (completa): importar `database/banco.sql` no TiDB.

Opcao 2 (rapida para o app funcionar):

```powershell
cd "C:\Users\igorc\OneDrive\Área de Trabalho\Projetos_Tarefas\Revista SESI\ProjetoArtigos"
composer db:init-core
composer db:check
```

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


