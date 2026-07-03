<?php

declare(strict_types=1);

$q = isset($_GET['q']) ? urlencode((string) $_GET['q']) : '';
header('Location: /index.php?action=pesquisar&q=' . $q);
exit;
