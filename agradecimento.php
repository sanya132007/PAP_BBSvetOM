<?php
session_start();
include("COMPONENTES/cabecalho.php");
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compra Concluída | BBSvetOM</title>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="RECURSOS/CSS/carrinho.css">

    <style>
        .overlay-sucesso {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .popup-sucesso {
            background: #fff;
            padding: 40px;
            border-radius: 12px;
            text-align: center;
            width: 90%;
            max-width: 400px;
            font-family: 'Montserrat', sans-serif;
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
        }

        .popup-sucesso h1 {
            font-size: 24px;
            margin-bottom: 15px;
        }

        .popup-sucesso p {
            margin-bottom: 25px;
            color: #555;
        }

        .popup-botoes {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .popup-botoes a {
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
        }

        .btn-vitrine {
            background: #ccc;
            color: #000;
        }

        .btn-inicio {
            background: #28a745;
            color: #fff;
        }

        .btn-inicio:hover {
            background: #218838;
        }
    </style>
</head>
<body>

<div class="overlay-sucesso">
    <div class="popup-sucesso">
        <h1>Compra Concluída!</h1>
        <p>O seu pedido foi registado com sucesso.</p>

        <div class="popup-botoes">
            <a href="vitrine.php" class="btn-vitrine">Continuar</a>
            <a href="index.php" class="btn-inicio">Início</a>
        </div>
    </div>
</div>

</body>
</html>