<?php
session_start();
include("../BASE_DE_DADOS/ligacao_bd.php");

if(!isset($_POST['id_produto'])){
    echo json_encode(['status'=>'erro', 'mensagem'=>'Produto inválido']);
    exit;
}

$id = (int)$_POST['id_produto'];

if(!isset($_SESSION['carrinho'])){
    $_SESSION['carrinho'] = [];
}

if(isset($_SESSION['carrinho'][$id])){
    $_SESSION['carrinho'][$id] += 1;
} else {
    $_SESSION['carrinho'][$id] = 1;
}

echo json_encode(['status'=>'sucesso']);
exit;