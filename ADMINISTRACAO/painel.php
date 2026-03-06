<?php 
session_start(); // Sempre o primeiro!

// verificação da identidade do administrador e ligação à base de dados
include '../PROCESSOS/process_verificacao_admin.php'; 
include '../BASE_DE_DADOS/ligacao_bd.php'; 

// calculo o número de peças disponíveis
$consulta_disp = $pdo->query("SELECT COUNT(*) FROM produtos WHERE disponivel = 1");
$total_disponiveis = $consulta_disp->fetchColumn();

// calculo o número de peças que já foram vendidas
$consulta_vend = $pdo->query("SELECT COUNT(*) FROM produtos WHERE disponivel = 0");
$total_vendidas = $consulta_vend->fetchColumn();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Gestão BBSvetOM</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel='stylesheet' href='painel.css'>
</head>
<body>
    <?php include 'CABECALHO/cabecalho_admin.php'; ?>
    <div class="caixa-fundo">
        <div class="zona-conteudo">
            <div class="grelha-resumo">
                <div class="cartao-estatistica disponiveis">
                    <h4>Disponiveis</h4>
                    <p><?php echo $total_disponiveis; ?> Peças</p>
                </div>

                <div class="cartao-estatistica vendidas">
                    <h4>Vendido</h4>
                    <p><?php echo $total_vendidas; ?> Peças</p>
                </div>
            </div>

            <div class="zona-acoes">
                <a href="produtos_listar.php" class="bloco-atalho">
                    <h3>Gestão produtos</h3>
                </a>
                
                <a href="../PROCESSOS/process_logout.php" class="botao">Terminar Sessão</a>
            </div>
        </div>
    </div>
</body>
</html>