<?php
session_start();

if(isset($_GET['id'])){
    $id = (int)$_GET['id'];

    if(isset($_SESSION['carrinho'])){
        $_SESSION['carrinho'] = array_filter(
            $_SESSION['carrinho'],
            fn($pid) => $pid !== $id
        );
    }
}

header("Location: ../carrinho.php");
exit;