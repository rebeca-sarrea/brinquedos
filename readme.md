# Gestão de Brinquedos – CRUD em PHP e MySQL

Sistema web para gerenciar os brinquedos de uma loja. Permite **cadastrar**, **listar**, **editar** e **excluir** brinquedos, usando **PHP (PDO)** e **MySQL**.
Projeto desenvolvido para a Atividade de Recuperação de CRUD, Prepared Statements e tratamento de erros em PHP.

## Funcionalidades

- **Create:** cadastro de brinquedo (nome, categoria, faixa etária, preço e quantidade em estoque).
- **Read:** listagem de todos os brinquedos, com busca por nome ou categoria.
- **Update:** edição dos dados de um brinquedo já cadastrado.
- **Delete:** exclusão de um brinquedo (com confirmação).

## O que foi aplicado

- **Prepared Statements** (PDO com `prepare()` e `execute()`) em **todas** as operações com o banco. Nenhum valor digitado pelo usuário é concatenado no SQL.
- **Validação dos dados** no servidor: tamanho do nome, categoria e faixa etária dentro das opções permitidas, preço válido (maior que zero) e estoque inteiro (0 ou mais).
- **Tratamento de erros:** falhas de conexão e de consulta são capturadas com `try/catch`; o usuário vê uma mensagem simples e o erro técnico vai para o log do PHP.
- **Segurança básica:** saída escapada com `htmlspecialchars` (contra XSS), token CSRF nos formulários e exclusão somente via POST.
- **Organização:** arquivos separados por responsabilidade (configuração, acesso ao banco, validação, páginas e layout).

## Estrutura de arquivos

```
gestao-brinquedos/
├── index.php               # Listagem (Read) e busca
├── cadastrar.php           # Cadastro (Create)
├── editar.php              # Edição (Update)
├── excluir.php             # Exclusão (Delete)
├── assets/
│   └── style.css           # Estilos da interface
├── config/
│   ├── config.php          # Dados de acesso ao MySQL
│   └── conexao.php         # Conexão PDO
├── database/
│   └── schema.sql          # Criação do banco e da tabela (com dados de exemplo)
└── includes/
    ├── brinquedos_db.php   # Funções do CRUD (Prepared Statements)
    ├── funcoes.php         # Validação, mensagens, CSRF e formatação
    ├── header.php          # Cabeçalho das páginas
    ├── footer.php          # Rodapé das páginas
    └── form_brinquedo.php  # Formulário de cadastro/edição
```


## Autor

rebeca sarrea – Turma dsm5
