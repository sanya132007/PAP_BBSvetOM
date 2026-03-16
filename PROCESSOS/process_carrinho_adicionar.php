<?php
session_start();
include("../BASE_DE_DADOS/ligacao_bd.php");

if(!isset($_SESSION['cliente_id'])) {
    echo json_encode(['status'=>'erro', 'mensagem'=>'Por favor, faça login para adicionar produtos ao carrinho.']);
    exit;
}

$cliente_id = (int)$_SESSION['cliente_id'];

if(!isset($_POST['id_produto'])){
    echo json_encode(['status'=>'erro', 'mensagem'=>'Produto inválido']);
    exit;
}

$id_produto = (int)$_POST['id_produto'];

try {
    $sql = "INSERT INTO carrinho (id_cliente, id_produto, quantidade, data_adicionado)
            VALUES (:cliente, :produto, 1, NOW())
            ON DUPLICATE KEY UPDATE quantidade = quantidade + 1, data_adicionado = NOW()";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(['cliente' => $cliente_id, 'produto' => $id_produto]);

    echo json_encode(['status'=>'sucesso']);
} catch (Exception $e) {
    echo json_encode(['status'=>'erro', 'mensagem'=>'Erro ao adicionar produto']);
}
exit;