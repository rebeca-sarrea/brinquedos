<?php

require_once __DIR__ . '/config/conexao.php';
require_once __DIR__ . '/includes/funcoes.php';
require_once __DIR__ . '/includes/brinquedos_db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirecionar('index.php');
}

if (!csrfValido($_POST['csrf'] ?? null)) {
    definirMensagem('erro', 'Sessão expirada. Tente novamente.');
    redirecionar('index.php');
}

$id = validarId($_POST['id'] ?? null);

if ($id === null) {
    definirMensagem('erro', 'Brinquedo inválido.');
    redirecionar('index.php');
}

try {
    $pdo = conectar();
    $apagados = excluirBrinquedo($pdo, $id);

    if ($apagados > 0) {
        definirMensagem('sucesso', 'Brinquedo excluído com sucesso!');
    } else {
        definirMensagem('erro', 'Brinquedo não encontrado (talvez já tenha sido excluído).');
    }
} catch (RuntimeException $e) {
    definirMensagem('erro', $e->getMessage());
} catch (PDOException $e) {
    error_log('Erro ao excluir: ' . $e->getMessage());
    definirMensagem('erro', 'Não foi possível excluir o brinquedo. Tente novamente.');
}

redirecionar('index.php');
