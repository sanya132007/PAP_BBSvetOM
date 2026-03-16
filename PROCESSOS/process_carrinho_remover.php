<?php
session_start();
include("../BASE_DE_DADOS/ligacao_bd.php");

if(!isset($_SESSION['cliente_id']) || !isset($_GET['id'])) {
    exit;
}

$cliente_id = (int)$_SESSION['cliente_id'];
$id_produto = (int)$_GET['id'];

$stmt = $pdo->prepare("
    SELECT quantidade 
    FROM carrinho 
    WHERE id_cliente = :cliente AND id_produto = :produto
");

$stmt->execute([
    'cliente' => $cliente_id,
    'produto' => $id_produto
]);


$item = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$item){
    exit;
}

if($item['quantidade'] > 1){

    /* diminui quantidade */
    $stmt = $pdo->prepare("
        UPDATE carrinho 
        SET quantidade = quantidade - 1 
        WHERE id_cliente = :cliente AND id_produto = :produto
    ");

} else {

    /* remove produto */
    $stmt = $pdo->prepare("
        DELETE FROM carrinho 
        WHERE id_cliente = :cliente AND id_produto = :produto
    ");

}

$stmt->execute([
    'cliente' => $cliente_id,
    'produto' => $id_produto
]);

exit;