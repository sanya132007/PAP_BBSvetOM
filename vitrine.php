<?php

session_start(); // Sempre o primeiro!

include 'BASE_DE_DADOS/ligacao_bd.php';

?>

<!DOCTYPE html>

<html lang="pt">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>BBSvetOM | Vitrine</title>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="RECURSOS/CSS/vitrine.css">

</head>

<body>

    <?php include 'COMPONENTES/cabecalho.php'; ?>

    <div class="caixa-fundo">

        <div class="caixa-cabecalho">

            <h1 class="titulo-vitrine">Vitrine</h1>

        </div>

        <div class="grelha-vitrine">

            <?php

            $query = "

                SELECT id, imagem_capa AS imagem FROM produtos

                UNION ALL

                SELECT id_produto AS id, caminho_imagem AS imagem FROM produto_imagens

                ORDER BY RAND()";



            $stmt = $pdo->query($query);

            while ($p = $stmt->fetch(PDO::FETCH_ASSOC)) {

            ?>

            <div class="cartao-produto">

                <a href="produto_detalhes.php?id=<?= $p['id'] ?>">

                    <img src="ANEXOS/<?= $p['imagem'] ?>" class="imagem-vitrine">

                </a>          

            </div>

            <?php } ?>

        </div>

    </div>

</body>

</html>