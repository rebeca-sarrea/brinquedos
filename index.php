<?php

require_once __DIR__ . '/config/conexao.php';
require_once __DIR__ . '/includes/funcoes.php';
require_once __DIR__ . '/includes/brinquedos_db.php';

$busca = trim($_GET['busca'] ?? '');
$brinquedos = [];
$erroBanco = null;

try {
    $pdo = conectar();
    $brinquedos = listarBrinquedos($pdo, $busca);
} catch (RuntimeException $e) {
    $erroBanco = $e->getMessage();
} catch (PDOException $e) {
    error_log('Erro ao listar: ' . $e->getMessage());
    $erroBanco = 'Ocorreu um erro ao consultar os brinquedos. Tente novamente.';
}

$tituloPagina = 'Brinquedos cadastrados';
require __DIR__ . '/includes/header.php';
?>

<h2>Brinquedos cadastrados</h2>

<?php if ($erroBanco): ?>
    <div class="alerta alerta-erro"><?= e($erroBanco) ?></div>
<?php else: ?>

    <form method="get" class="busca">
        <input type="text" name="busca" placeholder="Buscar por nome ou categoria" value="<?= e($busca) ?>">
        <button type="submit" class="btn btn-principal">Buscar</button>
        <?php if ($busca !== ''): ?>
            <a href="index.php" class="btn btn-cinza">Limpar</a>
        <?php endif; ?>
    </form>

    <?php if (count($brinquedos) === 0): ?>
        <p class="vazio">
            <?= $busca !== '' ? 'Nenhum brinquedo encontrado para essa busca.' : 'Nenhum brinquedo cadastrado ainda.' ?>
            <a href="cadastrar.php">Cadastrar brinquedo</a>
        </p>
    <?php else: ?>
        <p><?= count($brinquedos) ?> brinquedo(s) encontrado(s).</p>
        <div class="tabela-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Categoria</th>
                        <th>Faixa etária</th>
                        <th>Preço</th>
                        <th>Estoque</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($brinquedos as $b): ?>
                        <tr>
                            <td><?= (int) $b['id'] ?></td>
                            <td><?= e($b['nome']) ?></td>
                            <td><?= e($b['categoria']) ?></td>
                            <td><?= e($b['faixa_etaria']) ?></td>
                            <td><?= e(formatarPreco($b['preco'])) ?></td>
                            <td><?= (int) $b['quantidade'] ?></td>
                            <td class="acoes">
                                <a href="editar.php?id=<?= (int) $b['id'] ?>" class="btn btn-pequeno btn-editar">Editar</a>
                                <form method="post" action="excluir.php"
                                      onsubmit="return confirm('Excluir o brinquedo &quot;<?= e(addslashes($b['nome'])) ?>&quot;?');">
                                    <input type="hidden" name="csrf" value="<?= e(tokenCsrf()) ?>">
                                    <input type="hidden" name="id" value="<?= (int) $b['id'] ?>">
                                    <button type="submit" class="btn btn-pequeno btn-excluir">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

<?php endif; ?>

<?php require __DIR__ . '/includes/footer.php'; ?>
