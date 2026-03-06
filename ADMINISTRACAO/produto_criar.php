<?php include '../PROCESSOS/process_verificacao_admin.php'; ?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Produto - BBSvetOM</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="produto_criar.css">
</head>
<body>
    <?php include 'CABECALHO/cabecalho_admin.php'; ?>
    <div class="caixa-fundo">
        <div class="caixa-cabecalho">
            <h1 class="titulo-produto">Nova Peça</h1>
            <a href="produtos_listar.php" class="link-voltar">Cancelar</a>
        </div>

        <form action="../PROCESSOS/process_produto_criar.php" method="POST" enctype="multipart/form-data">
            
            <div class="submeter-caixa">
                <label>Nome do Produto:</label>
                <textarea name="nome" rows="2" placeholder="Nome da peça..." required></textarea>
            </div>
            
            <div class="submeter-caixa">
                <label>Descrição:</label>
                <textarea name="descricao" rows="4" placeholder="Breve descrição..."></textarea>
            </div>
            
            <div class="submeter-caixa">
                <label>Preço (€):</label>
                <input type="number" step="0.01" name="preco" placeholder="0.00" required>
            </div>

            <div class="submeter-caixa">
                <label>Disponibilidade:</label>
                <select name="disponivel">
                    <option value="1">Disponível</option>
                    <option value="0">Indisponível</option>
                </select>
            </div>
            
            <div class="submeter-caixa">
                <label>Imagem da CAPA:</label>
                <input type="file" name="imagem_capa" id="submeter-foto" accept="image/*" required>
                
                <div id="caixa-ver-foto" class="caixa-ver-foto-escondido"></div>
            </div>

            <div class="submeter-caixa">
                <label>Galeria de Imagens:</label>
                <input type="file" name="galeria[]" id="submeter-galeria" multiple accept="image/*">

                <div id="caixa-ver-galeria-foto" class="caixa-ver-foto-escondido">
                    <p class="caixa-ver-texto">PREVIEW DAS FOTOS DA GALERIA:</p>
                    <div id="caixa-ver-galeria-foto-painel"></div>
                </div>
            </div>
            
            <button type="submit" class="botao">Criar Produto</button>
        </form>
    </div>
    <script src="produto_preview.js"></script>
</body>
</html>