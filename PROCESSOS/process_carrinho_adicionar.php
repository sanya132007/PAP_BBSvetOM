<?php
session_start();

if(isset($_POST['produto_id'])){
    $produto_id = (int)$_POST['produto_id'];

    if(!isset($_SESSION['carrinho'])){
        $_SESSION['carrinho'] = [];
    }

    if(!in_array($produto_id, $_SESSION['carrinho'])){
        $_SESSION['carrinho'][] = $produto_id;
    }
}

header("Location: ../carrinho.php");
exit;