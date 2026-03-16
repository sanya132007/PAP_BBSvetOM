<?php
session_start();
include("BASE_DE_DADOS/ligacao_bd.php");
include("COMPONENTES/cabecalho.php");

if (!isset($_SESSION['cliente_id'])) {
    header("Location: login_registro.php?erro=acesso_negado");
    exit();
}

$total = 0;

$stmt = $pdo->prepare("
    SELECT p.id, p.nome, p.preco, p.imagem_capa, SUM(c.quantidade) AS quantidade
    FROM carrinho c
    JOIN produtos p ON p.id = c.id_produto
    WHERE c.id_cliente = ?
    GROUP BY p.id, p.nome, p.preco, p.imagem_capa
");
$stmt->execute([$_SESSION['cliente_id']]);

$carrinho = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho | BBSvetOM</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="RECURSOS/CSS/carrinho.css">
</head>
<body>
<div class="caixa-fundo">
    <div class="carrinho-titulo">
    <h1>Carrinho</h1>
    </div>

    <?php if(empty($carrinho)): ?>
        <p class="mensagem-carrinho-vazio">O seu carrinho está vazio.</p>
        <a href="vitrine.php" class="botao-vitrine">Aceder a vitrine</a>
    <?php else: ?>
        <ul class="lista-carrinho">
            <?php foreach($carrinho as $produto):
            $subtotal = $produto['preco'] * $produto['quantidade']  ;
            $total += $subtotal;
            ?>
            
            <li class="produto-carrinho">
                <img src="ANEXOS/<?php echo htmlspecialchars($produto['imagem_capa']); ?>" alt="Capa">
                <div class="produto-detalhes">
                    <h3><?php echo htmlspecialchars($produto['nome']); ?></h3>
                    <p><?php echo number_format($produto['preco'],2,',', '.') . "€ x " . $produto['quantidade'];?></p>
                    <span class="subtotal-produto"><?php echo "Subtotal: " . number_format($subtotal,2) . "€"; ?></span>
                </div>
                <button class="botao-remover" onclick="removerDoCarrinhoPagina(<?php echo $produto['id']; ?>)">&times;</button>
            </li>
            <?php endforeach; ?>
        </ul>

        <div class="conclusao-carrinho">
            <a href="vitrine.php" class="botao-vitrine">Aceder a vitrine</a>
            <div class="total-e-finalizar-compra">
                <p class="total-carrinho">Total: <span><?php echo number_format($total,2) . "€"; ?></span></p>
                <a href="finalizar-compra.php" class="botao-finalizar-compra">Finalizar Compra</a>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>

function removerDoCarrinhoPagina(id){

fetch('PROCESSOS/process_carrinho_remover.php?id=' + id)
.then(() => {
location.reload();
});

}

</script>

</body>
</html>