<?php
session_start();
include("../BASE_DE_DADOS/ligacao_bd.php");

if(!isset($_SESSION['cliente_id'])) {
    echo json_encode([]);
    exit;
}

$cliente_id = (int)$_SESSION['cliente_id'];

$stmt = $pdo->prepare("
    SELECT p.id, p.nome, p.preco, p.imagem_capa, SUM(c.quantidade) AS quantidade
    FROM carrinho c
    JOIN produtos p ON p.id = c.id_produto
    WHERE c.id_cliente = :cliente
    GROUP BY p.id, p.nome, p.preco, p.imagem_capa
");
$stmt->execute(['cliente' => $cliente_id]);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($result);
exit;