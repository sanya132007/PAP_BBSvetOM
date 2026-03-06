<?php 
session_start(); // Sempre o primeiro!

include 'BASE_DE_DADOS/ligacao_bd.php'; 

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: vitrine.php");
    exit;
}

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = ?");
$stmt->execute([$id]);
$p = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt_img = $pdo->prepare("SELECT caminho_imagem FROM produto_imagens WHERE id_produto = ?");
$stmt_img->execute([$id]);
$imagens_extras = $stmt_img->fetchAll(PDO::FETCH_ASSOC);

if (!$p) {
    echo "Peça não encontrada.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $p['nome'] ?> | BBSvetOM</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="RECURSOS/CSS/produto_detalhes.css">
</head>
<body>
    <?php include 'COMPONENTES/cabecalho.php'; ?>
    <div class="caixa-fundo">
        <div class="cartao-produto-detalhes"> 
            <div class="galeria-miniaturas">
                <img src="ANEXOS/<?= $p['imagem_capa'] ?>" class="thumb active" onclick="trocar(this.src, this)">
                <?php foreach ($imagens_extras as $img): ?>
                <img src="ANEXOS/<?= $img['caminho_imagem'] ?>" class="thumb" onclick="trocar(this.src, this)">
                <?php endforeach; ?>
            </div>

            <div class="produto-imagem">
                <img id="principal" src="ANEXOS/<?= $p['imagem_capa'] ?>" alt="<?= $p['nome'] ?>">
            </div>

            <div class="produto-info">
                <h2 class="nome-peca"><?= $p['nome'] ?></h2>

                <div class="preco-status">
                    <p class="preco-peca"><?= number_format($p['preco'], 2, ',', '.') ?>€</p>
                        
                    <?php if ($p['disponivel'] == 1): ?>
                        <span class="etiqueta status-disponivel">Pronto a Entrega</span>
                    <?php else: ?>
                        <span class="etiqueta status-encomenda">Sob Encomenda</span>
                    <?php endif; ?>
                </div>

                <div class="descricao-peca">
                    <p><?= nl2br($p['descricao']) ?></p>
                </div>

                <?php 
                    $texto_wa = ($p['disponivel'] == 1) ? "Gostaria de comprar a peça: " : "Gostaria de encomendar a peça: ";
                    $btn_label = ($p['disponivel'] == 1) ? "Comprar via WhatsApp" : "Encomendar via WhatsApp";
                ?>
                <a href="https://wa.me/351938069479?text=Olá! <?= $texto_wa . urlencode($p['nome']) ?>" class="botao">
                    <i class="fab fa-whatsapp" style="margin-right: 10px; font-size: 1.2rem;"></i> <?= $btn_label ?>
                </a>            
            </div>
        </div>
    </div>
    <script>
function trocar(src, el) {
    document.getElementById('principal').src = src;
    document.querySelectorAll('.thumb').forEach(t => t.classList.remove('active'));
    el.classList.add('active');
}
</script>
</body>
</html>