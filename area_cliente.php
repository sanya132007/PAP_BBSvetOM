<?php
session_start();

// Segurança: Se não for um cliente logado, manda para o login
if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'cliente') {
    header("Location: login_registro.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-pt">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" conteudo="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Minha Conta - BBSvetOM</title>
        
        <link rel="stylesheet" href="RECURSOS/CSS/styles.css">
    </head>
    <body>
        
        <?php include 'COMPONENTES/cabecalho.php'; ?>

        <div class="caixa" style="margin-top: 150px;"> <div class="conteudo">
                <h3>Olá, <span><?php echo $_SESSION['nome']; ?></span></h3>
                <h1>Bem-vindo à sua área exclusiva</h1>
                <p>Aqui pode consultar o seu histórico e gerir o seu perfil.</p>
                
                <div style="margin-top: 20px;">
                    <a href="PROCESSOS/process_logout.php" class="botao" style="background-color: #ff9999;">Sair da conta</a>
                </div>
            </div>
        </div>
    </body>
</html>