<?php

session_start();

include '../BASE_DE_DADOS/ligacao_bd.php';



if (isset($_GET['id']) && isset($_SESSION['id_utilizador'])) {

    $id_carrinho = $_GET['id'];

    $id_user = $_SESSION['id_utilizador'];



    $sql = "DELETE FROM carrinho WHERE id_carrinho = ? AND id_utilizador = ?";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([$id_carrinho, $id_user]);

}



exit;

?>