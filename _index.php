<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" conteudo="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BBSvetOM | Página Inicial</title>
    
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
    <link rel='stylesheet' href='RECURSOS/CSS/styles.css'>
</head>
<body>

    <?php include 'COMPONENTES/cabecalho.php'; ?>

    <main style="padding-top: 100px;"> <h1>Bem-vindo à BBSvetOM</h1>
        
        <p>Lorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex sapien vitae pellentesque sem placerat...</p>

        <section style="height:100vh; background:#f2f2f2; display:flex; align-items:center; justify-content:center;">
            <h1>Bloco 1 - Vitrine</h1>
        </section>
        
        <section style="height:100vh; background:#e0e0e0; display:flex; align-items:center; justify-content:center;">
            <h1>Bloco 2 - Nova Coleção</h1>
        </section>

        <section style="height:100vh; background:#d1c4ff; display:flex; align-items:center; justify-content:center;">
            <h1>Bloco 3 - Sobre a Marca</h1>
        </section>

    </main>

    <footer style="text-align: center; padding: 20px; background: aquamarine;">
        <p>&copy; 2026 BBSvetOM. Todos os direitos reservados.</p>
    </footer>

</body>
</html>