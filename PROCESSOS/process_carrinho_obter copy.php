<?php
session_start();
include("../BASE_DE_DADOS/ligacao_bd.php");

$carrinho = $_SESSION['carrinho'] ?? [];
$result = [];

foreach($carrinho as $id => $quantidade){
    $stmt = $pdo->prepare("SELECT id, nome, preco, imagem_capa FROM produtos WHERE id = ?");
    $stmt->execute([$id]);
    $produto = $stmt->fetch(PDO::FETCH_ASSOC);
    if($produto){
        if(!$produto['imagem_capa']) $produto['imagem_capa'] = 'default.jpg';
        $produto['quantidade'] = $quantidade;
        $result[] = $produto;
    }
}

header('Content-Type: application/json');
echo json_encode($result);
exit;
?>