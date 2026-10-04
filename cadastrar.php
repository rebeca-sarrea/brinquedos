<?php

require_once __DIR__ . '/config/conexao.php';
require_once __DIR__ . '/includes/funcoes.php';
require_once __DIR__ . '/includes/brinquedos_db.php';

$erros = [];
$erroBanco = null;
$valores = ['nome' => '', 'categoria' => '', 'faixa_etaria' => '', 'preco' => '', 'quantidade' => '0'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrfValido($_POST['csrf'] ?? null)) {
        $erros[] = 'Sessão expirada. Recarregue a página e tente de novo.';
        $valores = array_merge($valores, array_intersect_key($_POST, $valores));
    } else {
        $resultado = validarBrinquedo($_POST);
        $erros = $resultado['erros'];
        $valores = $resultado['valores'];

        if (count($erros) === 0) {
            try {
                $pdo = conectar();
                cadastrarBrinquedo($pdo, $resultado['dados']);
                definirMensagem('sucesso', 'Brinquedo cadastrado com sucesso!');
                redirecionar('index.php');
            } catch (RuntimeException $e) {
                $erroBanco = $e->getMessage();
            } catch (PDOException $e) {
                error_log('Erro ao cadastrar: ' . $e->getMessage());
                $erroBanco = 'Não foi possível cadastrar o brinquedo. Tente novamente.';
            }
        }
    }
}

$tituloPagina = 'Cadastrar brinquedo';
$textoBotao = 'Cadastrar';
require __DIR__ . '/includes/header.php';
?>

<h2>Cadastrar brinquedo</h2>

<?php if ($erroBanco): ?>
    <div class="alerta alerta-erro"><?= e($erroBanco) ?></div>
<?php endif; ?>

<?php require __DIR__ . '/includes/form_brinquedo.php'; ?>

<?php require __DIR__ . '/includes/footer.php'; ?>
