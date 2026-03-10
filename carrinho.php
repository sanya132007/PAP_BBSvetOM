<?php
session_start();
include("BASE_DE_DADOS/ligacao_bd.php");

$carrinho = $_SESSION['carrinho'] ?? [];
$total = 0;

echo "<h1>Carrinho</h1>";

if(empty($carrinho)){
    echo "<p>O seu carrinho está vazio.</p>";
} else {
    foreach($carrinho as $id => $quantidade){
        $stmt = $pdo->prepare("SELECT id, nome, preco, imagem_capa FROM produtos WHERE id=?");
        $stmt->execute([$id]);
        $produto = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$produto) continue;

        $subtotal = $produto['preco'] * $quantidade;
        $total += $subtotal;

        echo "<div style='display:flex; align-items:center; gap:15px; border-bottom:1px solid #D1A75E; padding:20px 20px;'>";
        echo "<img src='ANEXOS/" . htmlspecialchars($produto['imagem_capa']) . "' style='width:100px;'>";
        echo "<div>";
        echo "<p>" . htmlspecialchars($produto['nome']) . "</p>";
        echo "<p>" . number_format($produto['preco'],2) . "€ x $quantidade = " . number_format($subtotal,2) . "€</p>";
        echo "</div>";
        echo "<a href='PROCESSOS/process_carrinho_remover.php?id={$produto['id']}' style='margin-left:auto; color:red; text-decoration:none;'>&times;</a>";
        echo "</div>";
    }
    echo "<p style='margin-top:20px; font-weight:bold;'>Total: " . number_format($total,2) . "€</p>";
}
?>