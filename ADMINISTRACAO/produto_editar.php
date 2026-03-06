<?php include '../PROCESSOS/process_verificacao_admin.php'; ?>
<?php 
include '../BASE_DE_DADOS/ligacao_bd.php'; 

if (!isset($_GET['id'])) {
    header("Location: produtos_listar.php");
    exit();
}

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = ?");
$stmt->execute([$id]);
$p = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$p) {
    die("Produto não encontrado.");
}

$stmt_galeria = $pdo->prepare("SELECT * FROM produto_imagens WHERE id_produto = ?");
$stmt_galeria->execute([$id]);
$fotos_galeria = $stmt_galeria->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto - BBSvetOM</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="produto_editar.css">
</head>
<body>
    <?php include 'CABECALHO/cabecalho_admin.php'; ?>
    <div class="caixa-fundo">
        <div class="caixa-cabecalho">
            <h1 class="titulo-produto">Editar Peça #<?= $p['id'] ?></h1>
            <a href="produtos_listar.php" class="link-voltar">Cancelar</a>
        </div>

        <form action="../PROCESSOS/process_produto_editar.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $p['id'] ?>">

            <div class="submeter-caixa">
                <label>Nome do Produto:</label>
                <textarea name="nome" rows="2" required><?= htmlspecialchars($p['nome']) ?></textarea>
            </div>
            
            <div class="submeter-caixa">
                <label>Descrição:</label>
                <textarea name="descricao" rows="4"><?= htmlspecialchars($p['descricao']) ?></textarea>
            </div>
            
            <div class="submeter-caixa">
                <label>Preço (€):</label>
                <input type="number" step="0.01" name="preco" value="<?= $p['preco'] ?>" required>
            </div>

            <div class="submeter-caixa">
                <label>Disponibilidade:</label>
                <select name="disponivel">
                    <option value="1" <?= $p['disponivel'] == 1 ? 'selected' : '' ?>>Disponível</option>
                    <option value="0" <?= $p['disponivel'] == 0 ? 'selected' : '' ?>>Indisponível</option>
                </select>
            </div>
            
            <div class="submeter-caixa">
                <label>Capa Atual:</label>
                <img src="../ANEXOS/<?= $p['imagem_capa'] ?>" class="ver-foto">
                
                <label>Substituir CAPA:</label>
                <input type="file" name="imagem_capa" id="submeter-foto" accept="image/*">
                
                <div id="caixa-ver-foto" class="caixa-ver-foto-escondido"></div>
            </div>

            <div class="submeter-caixa">
                <label>Galeria de Imagens Atual:</label>
                <div class="caixa-ver-galeria-foto">
                    <?php if (count($fotos_galeria) > 0): ?>
                        <?php foreach ($fotos_galeria as $foto): ?>
                            <div class="foto-produto">
                                <img src="../ANEXOS/<?= $foto['caminho_imagem'] ?>" class="ver-foto-galeiria">
                                <a href="../PROCESSOS/process_produto_remover_foto.php?id_foto=<?= $foto['id'] ?>&id_produto=<?= $id ?>" 
                                   class="botao-remover" 
                                   onclick="return confirm('Queres mesmo apagar esta imagem da galeria?')">×</a>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p style="font-size: 12px; color: #888;">Este produto ainda não tem galeria.</p>
                    <?php endif; ?>
                </div>

                <label>Adicionar mais imagens à Galeria:</label>
                <input type="file" name="galeria[]" id="submeter-galeria" multiple accept="image/*">

                <div id="caixa-ver-galeria-foto" class="caixa-ver-foto-escondido">
                    <p class="caixa-ver-texto">PREVIEW DAS NOVAS FOTOS DA GALERIA:</p>
                    <div id="caixa-ver-galeria-foto-painel"></div>
                </div>
            </div>
            
            <button type="submit" class="botao">Guardar alterações</button>
        </form>
    </div>
    <script src="produto_preview.js"></script>
</body>
</html>