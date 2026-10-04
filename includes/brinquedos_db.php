<?php

function listarBrinquedos(PDO $pdo, string $busca = ''): array
{
    if ($busca !== '') {
        $stmt = $pdo->prepare(
            'SELECT id, nome, categoria, faixa_etaria, preco, quantidade
               FROM brinquedos
              WHERE nome LIKE :busca_nome OR categoria LIKE :busca_categoria
              ORDER BY nome'
        );
        $termo = '%' . $busca . '%';
        $stmt->execute([':busca_nome' => $termo, ':busca_categoria' => $termo]);
    } else {
        $stmt = $pdo->prepare(
            'SELECT id, nome, categoria, faixa_etaria, preco, quantidade
               FROM brinquedos
              ORDER BY nome'
        );
        $stmt->execute();
    }

    return $stmt->fetchAll();
}

function buscarBrinquedo(PDO $pdo, int $id): ?array
{
    $stmt = $pdo->prepare(
        'SELECT id, nome, categoria, faixa_etaria, preco, quantidade
           FROM brinquedos
          WHERE id = :id'
    );
    $stmt->execute([':id' => $id]);

    $brinquedo = $stmt->fetch();
    return $brinquedo === false ? null : $brinquedo;
}

function cadastrarBrinquedo(PDO $pdo, array $dados): int
{
    $stmt = $pdo->prepare(
        'INSERT INTO brinquedos (nome, categoria, faixa_etaria, preco, quantidade)
         VALUES (:nome, :categoria, :faixa_etaria, :preco, :quantidade)'
    );
    $stmt->execute([
        ':nome'         => $dados['nome'],
        ':categoria'    => $dados['categoria'],
        ':faixa_etaria' => $dados['faixa_etaria'],
        ':preco'        => $dados['preco'],
        ':quantidade'   => $dados['quantidade'],
    ]);

    return (int) $pdo->lastInsertId();
}

function atualizarBrinquedo(PDO $pdo, int $id, array $dados): bool
{
    $stmt = $pdo->prepare(
        'UPDATE brinquedos
            SET nome = :nome,
                categoria = :categoria,
                faixa_etaria = :faixa_etaria,
                preco = :preco,
                quantidade = :quantidade
          WHERE id = :id'
    );

    return $stmt->execute([
        ':nome'         => $dados['nome'],
        ':categoria'    => $dados['categoria'],
        ':faixa_etaria' => $dados['faixa_etaria'],
        ':preco'        => $dados['preco'],
        ':quantidade'   => $dados['quantidade'],
        ':id'           => $id,
    ]);
}

function excluirBrinquedo(PDO $pdo, int $id): int
{
    $stmt = $pdo->prepare('DELETE FROM brinquedos WHERE id = :id');
    $stmt->execute([':id' => $id]);

    return $stmt->rowCount();
}
