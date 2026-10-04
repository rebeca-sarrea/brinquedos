<?php
?>
<?php if (!empty($erros)): ?>
    <div class="alerta alerta-erro">
        <strong>Corrija os seguintes problemas:</strong>
        <ul>
            <?php foreach ($erros as $erro): ?>
                <li><?= e($erro) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="post" class="formulario" novalidate>
    <input type="hidden" name="csrf" value="<?= e(tokenCsrf()) ?>">

    <label for="nome">Nome do brinquedo</label>
    <input type="text" id="nome" name="nome" maxlength="100" required
           value="<?= e($valores['nome']) ?>">

    <label for="categoria">Categoria</label>
    <select id="categoria" name="categoria" required>
        <option value="">Selecione...</option>
        <?php foreach (CATEGORIAS as $opcao): ?>
            <option value="<?= e($opcao) ?>" <?= $valores['categoria'] === $opcao ? 'selected' : '' ?>>
                <?= e($opcao) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="faixa_etaria">Faixa etária</label>
    <select id="faixa_etaria" name="faixa_etaria" required>
        <option value="">Selecione...</option>
        <?php foreach (FAIXAS_ETARIAS as $opcao): ?>
            <option value="<?= e($opcao) ?>" <?= $valores['faixa_etaria'] === $opcao ? 'selected' : '' ?>>
                <?= e($opcao) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="preco">Preço (R$)</label>
    <input type="text" id="preco" name="preco" inputmode="decimal" placeholder="49,90" required
           value="<?= e($valores['preco']) ?>">

    <label for="quantidade">Quantidade em estoque</label>
    <input type="number" id="quantidade" name="quantidade" min="0" step="1" required
           value="<?= e($valores['quantidade']) ?>">

    <div class="botoes">
        <button type="submit" class="btn btn-principal"><?= e($textoBotao) ?></button>
        <a href="index.php" class="btn btn-cinza">Cancelar</a>
    </div>
</form>
