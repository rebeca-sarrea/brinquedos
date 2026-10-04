<?php
$mensagem = pegarMensagem();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($tituloPagina ?? 'Gestão de Brinquedos') ?> – Gestão de Brinquedos</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<header class="topo">
    <div class="container">
        <h1>Gestão de Brinquedos</h1>
        <nav>
            <a href="index.php">Listar</a>
            <a href="cadastrar.php">Cadastrar brinquedo</a>
        </nav>
    </div>
</header>

<main class="container">
    <?php if ($mensagem): ?>
        <div class="alerta alerta-<?= e($mensagem['tipo']) ?>"><?= e($mensagem['texto']) ?></div>
    <?php endif; ?>
