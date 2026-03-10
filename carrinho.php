<?php
session_start();
include("BASE_DE_DADOS/ligacao_bd.php");

$carrinho = $_SESSION['carrinho'] ?? [];

?>

<h1>Carrinho</h1>

<?php if(empty($carrinho)): ?>
    <p>Carrinho vazio</p>
<?php else: ?>
    <ul>
        <?php 
        $total = 0;
        foreach($carrinho as $produto_id):
            $stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = ?");
            $stmt->execute([$produto_id]);
            $produto = $stmt->fetch(PDO::FETCH_ASSOC);
            $total += $produto['preco'];
        ?>
        <li>
            <?= htmlspecialchars($produto['nome']) ?> - <?= number_format($produto['preco'], 2) ?>€
            <a href="PROCESSOS/process_carrinho_remover.php?id=<?= $produto_id ?>">remover</a>
        </li>
        <?php endforeach; ?>
    </ul>

    <h3>Total: <?= number_format($total, 2) ?>€</h3>
<?php endif; ?>