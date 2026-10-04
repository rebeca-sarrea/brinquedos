<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

const CATEGORIAS = [
    'Bonecos',
    'Carrinhos',
    'Blocos de Montar',
    'Jogos de Tabuleiro',
    'Educativos',
    'Pelúcias',
    'Outros',
];

const FAIXAS_ETARIAS = [
    '0-2 anos',
    '3-5 anos',
    '6-8 anos',
    '9-12 anos',
    '13+ anos',
];

function e($texto): string
{
    return htmlspecialchars((string) $texto, ENT_QUOTES, 'UTF-8');
}

function formatarPreco($valor): string
{
    return 'R$ ' . number_format((float) $valor, 2, ',', '.');
}

function redirecionar(string $url): void
{
    header('Location: ' . $url);
    exit;
}


function definirMensagem(string $tipo, string $texto): void
{
    $_SESSION['mensagem'] = ['tipo' => $tipo, 'texto' => $texto];
}

function pegarMensagem(): ?array
{
    $mensagem = $_SESSION['mensagem'] ?? null;
    unset($_SESSION['mensagem']);
    return $mensagem;
}


function tokenCsrf(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(16));
    }
    return $_SESSION['csrf'];
}

function csrfValido(?string $token): bool
{
    return is_string($token) && !empty($_SESSION['csrf']) && hash_equals($_SESSION['csrf'], $token);
}


function validarId($valor): ?int
{
    $id = filter_var($valor, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    return $id === false ? null : $id;
}

function validarBrinquedo(array $post): array
{
    $erros = [];

    $nome        = trim($post['nome'] ?? '');
    $categoria   = trim($post['categoria'] ?? '');
    $faixa       = trim($post['faixa_etaria'] ?? '');
    $precoTexto  = trim($post['preco'] ?? '');
    $quantidadeT = trim($post['quantidade'] ?? '');

    if (mb_strlen($nome) < 2 || mb_strlen($nome) > 100) {
        $erros[] = 'O nome deve ter entre 2 e 100 caracteres.';
    }

    if (!in_array($categoria, CATEGORIAS, true)) {
        $erros[] = 'Escolha uma categoria válida.';
    }

    if (!in_array($faixa, FAIXAS_ETARIAS, true)) {
        $erros[] = 'Escolha uma faixa etária válida.';
    }

    $preco = str_replace(',', '.', $precoTexto);
    if (!preg_match('/^\d{1,8}(\.\d{1,2})?$/', $preco) || (float) $preco <= 0) {
        $erros[] = 'Informe um preço válido, maior que zero (exemplo: 49,90).';
    }

    $quantidade = filter_var($quantidadeT, FILTER_VALIDATE_INT, ['options' => ['min_range' => 0, 'max_range' => 1000000]]);
    if ($quantidade === false) {
        $erros[] = 'A quantidade em estoque deve ser um número inteiro, de 0 a 1.000.000.';
    }

    return [
        'erros'   => $erros,
        'dados'   => [
            'nome'         => $nome,
            'categoria'    => $categoria,
            'faixa_etaria' => $faixa,
            'preco'        => number_format((float) $preco, 2, '.', ''),
            'quantidade'   => (int) $quantidade,
        ],
        'valores' => [
            'nome'         => $nome,
            'categoria'    => $categoria,
            'faixa_etaria' => $faixa,
            'preco'        => $precoTexto,
            'quantidade'   => $quantidadeT,
        ],
    ];
}
