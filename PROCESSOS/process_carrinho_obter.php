<?php

session_start();

include '../BASE_DE_DADOS/ligacao_bd.php';



if (!isset($_SESSION['id_utilizador'])) {

    echo json_encode([]);

    exit;

}



$id_user = $_SESSION['id_utilizador'];



try {

    $sql = "SELECT c.id_carrinho, p.nome, p.preco, p.imagem_capa

            FROM carrinho c

            INNER JOIN produtos p ON c.id_produto = p.id_produto

            WHERE c.id_utilizador = ?";

           

    $stmt = $pdo->prepare($sql);

    $stmt->execute([$id_user]);

    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);



    echo json_encode($resultado);

} catch (PDOException $e) {

    echo json_encode(['erro' => $e->getMessage()]);

}

?>