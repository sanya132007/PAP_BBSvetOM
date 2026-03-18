    <?php
    session_start();
    include("BASE_DE_DADOS/ligacao_bd.php");
    include("COMPONENTES/cabecalho.php");

    if (!isset($_SESSION['cliente_id'])) {
        header("Location: login_registro.php?erro=acesso_negado");
        exit();
    }

    $cliente_id = (int)$_SESSION['cliente_id'];

    $stmt = $pdo->prepare("
        SELECT p.id, p.nome, p.preco, p.imagem_capa, SUM(c.quantidade) AS quantidade
        FROM carrinho c
        JOIN produtos p ON p.id = c.id_produto
        WHERE c.id_cliente = ?
        GROUP BY p.id, p.nome, p.preco, p.imagem_capa
    ");
    $stmt->execute([$_SESSION['cliente_id']]);
    $carrinho_produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt_pagamento = $pdo->prepare("SELECT id, nome FROM metodos_pagamento");
    $stmt_pagamento->execute();
    $metodos_pagamento = $stmt_pagamento->fetchAll(PDO::FETCH_ASSOC);

    $total = 0;
    ?>

    <!DOCTYPE html>
    <html lang="pt-pt">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Finalizar Compra | BBSvetOM</title>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <link rel="stylesheet" href="RECURSOS/CSS/finalizar_compra.css">
    </head>
    <body>
        <div class="caixa-fundo">
            <div class="titulo-finalizar-compra">
                <h1>Finalizar Compra (simulação)</h1>
            </div>

            <?php if(empty($carrinho_produtos)): ?>
                <p class="mensagem-carrinho-vazio">O seu carrinho está vazio.</p>
                <a href="vitrine.php" class="botao-vitrine">Aceder à Vitrine</a>
            <?php else: ?>

            <div class="finalizar-compra">
                <form id="form-finalizar" method="post" action="PROCESSOS/process_finalizar_compra.php">
                    <div class="grelha-form">
                        <div class="blabla">
                            <h3>Dados de envio</h3>
                            <label>Nome</label>
                            <input type="text" name="nome" required>
                            <label>Apelido</label>
                            <input type="text" name="apelido" required>
                            <label>Email</label>
                            <input type="email" name="email" required>
                            <label>Morada</label>
                            <input type="text" name="morada" required>
                            <div class="grelha-form">
                                <div class="blabla">
                                    <label>Código Postal</label>
                                    <input type="text" name="codigo_postal" required>
                                <!--</div>
                                <div class="blabla">-->
                                    <label>Localidade</label>
                                    <input type="text" name="localidade" required>
                                </div>
                            </div>
                        </div>

                        <div class="blabla">
                            <h3>Dados de pagamento</h3>
                            <label>Método de Pagamento</label>
                            <select name="metodo_pagamento" id="pagamento-metodo" class="menu-pagamento" required onchange="mudarPagamento()">
                                <option value="">Selecione um método</option>
                                <?php foreach($metodos_pagamento as $metodo): ?>
                                    <option value="<?php echo $metodo['id']; ?>"><?php echo htmlspecialchars($metodo['nome']); ?></option>
                                <?php endforeach; ?>
                            </select>

                            <div id="frase-pagamento" class="caixa-frase">
                                <p>Escolha um método de pagamento.</p>
                                <p>Nota: Esta é uma simulação. Nenhum pagamento real será processado.</p>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="botao-finalizar">Finalizar Compra</button>
                </form>
            </div>
            <div class="resumo-compra">
                <div class="caixa-resumo">
                    <h4>Resumo da compra</h4>
                    <ul class="lista-resumo">
                        <?php foreach($carrinho_produtos as $produto):
                $subtotal = $produto['preco'] * $produto['quantidade']  ;
                $total += $subtotal;
                ?>
                
                <li class="produto-carrinho">
                    <img src="ANEXOS/<?php echo htmlspecialchars($produto['imagem_capa']); ?>" alt="Capa">
                    <div class="produto-detalhes">
                        <h3><?php echo htmlspecialchars($produto['nome']); ?></h3>
                        <p><?php echo number_format($produto['preco'],2,',', '.') . "€ x " . $produto['quantidade'];?></p>
                        <span class="subtotal-produto"><?php echo "Subtotal: " . number_format($subtotal, 2, ',', '.') . "€"; ?></span>
                    </div>
                    <button class="botao-remover" onclick="removerDoCarrinhoPagina(<?php echo $produto['id']; ?>)">&times;</button>
                </li>
                <?php endforeach; ?>
                    </ul>
                    <!--<hr class="separador">-->
                    <p class="total-compra">Total: <span><?php echo number_format($total, 2, ',', '.') . "€"; ?></span></p>
                    <div class="links-navegacao">
                        <a href="carrinho.php" class="botao-carrinho">Aceder ao Carrinho</a>
                        <a href="vitrine.php" class="botao-vitrine">Aceder à Vitrine</a>
                    </div>
                </div>
            </div>

            <?php endif; ?>
        </div>

        <script>
            function mudarPagamento() {
                const select = document.getElementById('pagamento-metodo');
                const display = document.getElementById('frase-pagamento');
                const opcao = select.options[select.selectedIndex].text;

                let conteudo = '';
                if(opcao === 'MB WAY') {
                    conteudo = '<label style="color: var(--dourado);">Telemóvel MB WAY</label><input type="text" name="telemovel" placeholder="9xx xxx xxx" required>';
                } else if(opcao === 'Transferência Bancária') {
                    conteudo = '<div class="transferencia"><p>IBAN:<strong> IBAN: PT50 0000 0000 0000 000</strong></p></div>';
                } else if(opcao === 'Entidade e Referência') {
                    conteudo = '<div class="entidade-referencia"><p>Entidade: <strong>00000</strong></p><p>Referência: <strong>000 000 000</strong></p><p>Montante: <strong><span><?php echo number_format($total, 2, ',', '.') . "€"; ?></span></strong></p></div>';
                } else {
                    conteudo = '<p>Escolha um método de pagamento.</p><p>Nota: Esta é uma simulação. Nenhum pagamento real será processado.</p>';
                }
                display.innerHTML = conteudo;
            }

            function removerDoCarrinhoPagina(id){

            fetch('PROCESSOS/process_carrinho_remover.php?id=' + id)
            .then(() => {
            location.reload();
            });

            }

        </script>

    </body>
    </html>