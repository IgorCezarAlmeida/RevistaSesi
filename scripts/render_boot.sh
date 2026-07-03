#!/bin/sh
set -e

cd /var/www/html

echo "[boot] Validando/Inicializando schema core no TiDB..."
php scripts/tidb_init_core.php || echo "[boot] Aviso: nao foi possivel inicializar schema automaticamente."

echo "[boot] Iniciando Apache..."
exec apache2-foreground

