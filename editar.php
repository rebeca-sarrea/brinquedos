<?php

require_once __DIR__ . '/config/conexao.php';
require_once __DIR__ . '/includes/funcoes.php';
require_once __DIR__ . '/includes/brinquedos_db.php':

$id = validarId($_GET['id'] ?? null);

if ($id === null) {
    definirMensagem('erro', 'Brinquedo inválido.');
    redirecionar('index.php');
}

$erros = [];
$erroBanco = null;
$valores = null;

try {
    $pdo = conectar();
    $brinquedo = buscarBrinquedo($pdo, $id);

    if ($brinquedo === null) {
        definirMensagem('erro', 'Brinquedo não encontrado.');
        redirecionar('index.php');
    }

    $valores = [
        'nome'         => $brinquedo['nome'],
        'categoria'    => $brinquedo['categoria'],
        'faixa_etaria' => $brinquedo['faixa_etaria'],
        'preco'        => number_format((float) $brinquedo['preco'], 2, ',', ''),
        'quantidade'   => (string) $brinquedo['quantidade'],
    ];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!csrfValido($_POST['csrf'] ?? null)) {
            $erros[] = 'Sessão expirada. Recarregue a página e tente de novo.';
        } else {
            $resultado = validarBrinquedo($_POST);
            $erros = $resultado['erros'];
            $valores = $resultado['valores'];

            if (count($erros) === 0) {
                atualizarBrinquedo($pdo, $id, $resultado['dados']);
                definirMensagem('sucesso', 'Brinquedo atualizado com sucesso!');
                redirecionar('index.php');
            }
        }
    }
} catch (RuntimeException $e) {
    $erroBanco = $e->getMessage();
} catch (PDOException $e) {
    error_log('Erro ao editar: ' . $e->getMessage());
    $erroBanco = 'Não foi possível salvar as alterações. Tente novamente.';
}

$tituloPagina = 'Editar brinquedo';
$textoBotao = 'Salvar alterações';
require __DIR__ . '/includes/header.php';
?>

<h2>Editar brinquedo #<?= (int) $id ?></h2>

<?php if ($erroBanco): ?>
    <div class="alerta alerta-erro"><?= e($erroBanco) ?></div>
<?php endif; ?>

<?php if ($valores !== null): ?>
    <?php require __DIR__ . '/includes/form_brinquedo.php'; ?>
<?php else: ?>
    <p><a href="index.php" class="btn btn-cinza">Voltar para a lista</a></p>
<?php endif; ?>

<?php require __DIR__ . '/includes/footer.php'; ?>
