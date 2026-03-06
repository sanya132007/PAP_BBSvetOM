<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="COMPONENTES/cabecalho.css">
</head>

<header class="cabecalho">
    <a href="_index.php" class="logo">BBSvetOM</a>
    
    <div class="menu-barras" id="menu-barras3">
        <div class="barra1"></div>
        <div class="barra2"></div>
        <div class="barra3"></div>
    </div>
    
    <nav class="navegacao">
        <div class="navegacao-links">
            <a href="vitrine.php">VITRINE</a>
            <a href="#">MARCA</a>
            <a href="#">CONTACTOS</a> 
            <?php if(isset($_SESSION['tipo'])): ?>
                <?php if($_SESSION['tipo'] == 'admin'): ?>
                    <!--<a href="ADMINISTRACAO/painel.php">PAINEL ADMIN</a>-->
                    <div class="cascata">
                        <button class="botao-cascata">OPÇÕES</button>
                        <div class="cascata-conteudo">
                            <a href="ADMINISTRACAO/painel.php">PAINEL ADMIN</a>
                            <a href="../PROCESSOS/process_logout.php">SAIR</a>
                        </div>
                    </div>                
                <?php else: ?>
                    <!--<a href="area_cliente.php">MINHA CONTA</a>-->
                    <div class="cascata">
                        <button class="botao-cascata">MINHA CONTA</button>
                        <div class="cascata-conteudo"> <a href="area_cliente.php">ACEDER PERFIL</a>
                            <a href="javascript:void(0)" onclick="abrirCarrinho()">VER CARRINHO</a>
                            <a href="../PROCESSOS/process_logout.php">SAIR</a>
                        </div>
                    </div>
                    
                <?php endif; ?>
            <?php else: ?>
                <a href="login_registro.php">LOGIN</a>
            <?php endif; ?>
        </div>
    </nav>

    <div id="carrinho-lateral" class="carrinho-lateral">
        <div class="carrinho-cabecalho">
            <span>O MEU CARRINHO</span>
            <button onclick="fecharCarrinho()" class="botao-fechar">&times;</button>
        </div>
        
        <div class="carrinho-corpo" id="conteudo-carrinho">
            <p style="text-align:center; color:var(--castanho); margin-top:20px;">O seu carrinho está vazio.</p>
        </div>

        <div class="carrinho-rodape">
            <div class="total">Total: 0.00€</div>
            <a href="../carrinho.php" class="botao-finalizar">FINALIZAR COMPRA</a>
        </div>
    </div>

    <div id="overlay-carrinho" onclick="fecharCarrinho()"></div>
</header>

<div class="navegacao-fundo"></div>

<script src="COMPONENTES/cabecalho.js"></script>