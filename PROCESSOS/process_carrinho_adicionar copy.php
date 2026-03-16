<?php
session_start();
include("../BASE_DE_DADOS/ligacao_bd.php");

// Verifica login
if(!isset($_SESSION['cliente_id'])) {
    echo json_encode(['status'=>'erro', 'mensagem'=>'Por favor, faça login para adicionar produtos ao carrinho.']);
    exit;
}

$cliente_id = (int)$_SESSION['cliente_id'];

// Verifica produto
if(!isset($_POST['id_produto'])){
    echo json_encode(['status'=>'erro', 'mensagem'=>'Produto inválido']);
    exit;
}

$id = (int)$_POST['id_produto'];

// Inicializa carrinho da sessão
if(!isset($_SESSION['carrinho'])){
    $_SESSION['carrinho'] = [];
}

// Adiciona à sessão
if(isset($_SESSION['carrinho'][$id])){
    $_SESSION['carrinho'][$id] += 1;
} else {
    $_SESSION['carrinho'][$id] = 1;
}

$stmt = $pdo->prepare("
INSERT INTO carrinho (id_cliente, id_produto, quantidade, data_adicionado)
VALUES (?, ?, 1, NOW())
ON DUPLICATE KEY UPDATE quantidade = quantidade + 1
");
$stmt->execute([$cliente_id,$id]);

header('Content-Type: application/json');
echo json_encode(['status'=>'sucesso']);
exit;
?>