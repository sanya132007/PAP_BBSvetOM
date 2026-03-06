<?php

session_start();

include '../BASE_DE_DADOS/ligacao_bd.php';



if (!isset($_SESSION['id_utilizador'])) {

    echo json_encode(['status' => 'erro', 'mensagem' => 'Login obrigatório!']);

    exit;

}



if (isset($_POST['id_produto'])) {

    $id_produto = $_POST['id_produto'];

    $id_utilizador = $_SESSION['id_utilizador'];



    try {

        $check = $pdo->prepare("SELECT id_carrinho FROM carrinho WHERE id_utilizador = ? AND id_produto = ?");

        $check->execute([$id_utilizador, $id_produto]);

       

        if ($check->rowCount() > 0) {

            echo json_encode(['status' => 'sucesso', 'mensagem' => 'O produto já está no seu carrinho!']);

            exit;

        }



        $sql = "INSERT INTO carrinho (id_utilizador, id_produto) VALUES (?, ?)";

        $stmt = $pdo->prepare($sql);

       

        if ($stmt->execute([$id_utilizador, $id_produto])) {

            echo json_encode(['status' => 'sucesso', 'mensagem' => 'Produto adicionado ao seu carrinho!']);

        } else {

            echo json_encode(['status' => 'erro', 'mensagem' => 'Falha ao adicionar o produto.']);

        }



    } catch (PDOException $e) {

        echo json_encode(['status' => 'erro', 'mensagem' => 'Erro na base de dados: ' . $e->getMessage()]);

    }

} else {

    echo json_encode(['status' => 'erro', 'mensagem' => 'Dados inválidos.']);

}

?>