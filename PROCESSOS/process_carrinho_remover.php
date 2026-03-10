<?php
session_start();

if(!isset($_GET['id'])){
    echo json_encode(['status'=>'erro', 'mensagem'=>'Produto inválido']);
    exit;
}

$id = (int)$_GET['id'];

if(isset($_SESSION['carrinho'][$id])){
    $_SESSION['carrinho'][$id] -= 1;
    if($_SESSION['carrinho'][$id] <= 0){
        unset($_SESSION['carrinho'][$id]);
    }
}

$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
          strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

if($isAjax){
    echo json_encode(['status'=>'sucesso']);
} else {
    header("Location: ../carrinho.php");
    exit;
}