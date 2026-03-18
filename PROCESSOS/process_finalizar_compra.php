<?php
session_start();
include("../BASE_DE_DADOS/ligacao_bd.php");

if (!isset($_SESSION['cliente_id'])) {
    header("Location: ../login_registro.php?erro=acesso_negado");
    exit();
}

$cliente_id = (int)$_SESSION['cliente_id'];

$stmt = $pdo->prepare("DELETE FROM carrinho WHERE id_cliente = :cliente_id");
$stmt->bindParam(':cliente_id', $cliente_id, PDO::PARAM_INT);
$stmt->execute();

header("Location: ../agradecimento.php");
exit;