<?php
session_start();

if(isset($_POST['produto_id'])){
    $produto_id = (int)$_POST['produto_id'];

    if(!isset($_SESSION['carrinho'])){
        $_SESSION['carrinho'] = [];
    }

    if(isset($_SESSION['carrinho'][$id])){
            $_SESSION['carrinho'][$id] += 1;
        } else {
            $_SESSION['carrinho'][$id] = 1;
        }
}

header('Content-Type: application/json');
echo json_encode(['status'=>'sucesso']);
exit;