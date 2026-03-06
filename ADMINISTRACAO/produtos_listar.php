<?php include '../PROCESSOS/process_verificacao_admin.php'; ?>
<?php include '../BASE_DE_DADOS/ligacao_bd.php'; ?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock - BBSvetOM</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="produtos_listar.css">
</head>
<body>
    <?php include 'CABECALHO/cabecalho_admin.php'; ?>
    <div class="caixa-fundo">
        <div class="caixa-cabecalho">
            <h1 class="titulo-produto">Stock de Peças</h1>
            
            <a href="produto_criar.php" class="botao">+ Novo Produto</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Capa</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Preço</th>
                    <th>Estado</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = $pdo->query("SELECT * FROM produtos ORDER BY id DESC");
                while ($p = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $disp = ($p['disponivel'] == 1) ? "Disponível" : "Indisponível";
                ?>
                <tr>
                    <td data-label="ID">#<?= $p['id'] ?></td>
                    <td data-label="Capa"><img src="../ANEXOS/<?= $p['imagem_capa'] ?>" class="foto-miniatura"></td>
                    <td data-label="Nome"><strong><?= $p['nome'] ?></strong></td>
                    <td data-label="Descrição"><div class="descricao"><?= $p['descricao'] ?></div></td>
                    <td data-label="Preço"><?= number_format($p['preco'], 2, ',', '.') ?>€</td>
                    <td data-label="Estado"><?= $disp ?></td>
                    <td data-label="Ações">
                        <a href="produto_editar.php?id=<?= $p['id'] ?>" class="botao botao-editar">Editar</a>
                        <a href="../PROCESSOS/process_produto_apagar.php?id=<?= $p['id'] ?>" class="botao botao-apagar" onclick="return confirm('Apagar produto #<?= $p['id'] ?>?')">Apagar</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>