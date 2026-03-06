<?php
session_start(); // Necessário para as mensagens de erro
include '../BASE_DE_DADOS/ligacao_bd.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 1. Limpeza e Validação de Texto
    $nome = trim($_POST['nome']);
    $descricao = trim($_POST['descricao']);
    $preco = filter_var($_POST['preco'], FILTER_VALIDATE_FLOAT);
    $disponivel = (int)$_POST['disponivel'];

    // Verificação de campos vazios ou preço inválido
    if (empty($nome) || empty($descricao) || $preco === false || $preco <= 0) {
        $_SESSION['erro'] = "Dados inválidos. Verifique o nome, descrição e se o preço é maior que 0.";
        header("Location: ../ADMINISTRACAO/produto_criar.php");
        exit();
    }

    // 2. Tratamos a CAPA (com validação de ficheiro)
    $novo_nome_capa = "";
    $extensoes_permitidas = ['jpg', 'jpeg', 'png', 'webp'];

    if (isset($_FILES['imagem_capa']) && $_FILES['imagem_capa']['error'] === UPLOAD_ERR_OK) {
        $extensao = strtolower(pathinfo($_FILES['imagem_capa']['name'], PATHINFO_EXTENSION));
        
        // Validar extensão
        if (!in_array($extensao, $extensoes_permitidas)) {
            $_SESSION['erro'] = "Formato de capa inválido. Use JPG, PNG ou WEBP.";
            header("Location: ../ADMINISTRACAO/produto_criar.php");
            exit();
        }

        $novo_nome_capa = bin2hex(random_bytes(10)) . "." . $extensao;
        $destino = "../ANEXOS/" . $novo_nome_capa;
        move_uploaded_file($_FILES['imagem_capa']['tmp_name'], $destino);
    } else {
        // A capa é obrigatória na criação
        $_SESSION['erro'] = " A imagem de capa é obrigatória.";
        header("Location: ../ADMINISTRACAO/produto_criar.php");
        exit();
    }

    // 3. INSERT com todos os campos
    $sql = "INSERT INTO produtos (nome, descricao, preco, disponivel, imagem_capa) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nome, $descricao, $preco, $disponivel, $novo_nome_capa]);
    
    $id_novo = $pdo->lastInsertId();

    // 4. Tratar a GALERIA
    if (isset($_FILES['galeria']) && !empty($_FILES['galeria']['name'][0])) {
        $fotos = $_FILES['galeria'];

        for ($i = 0; $i < count($fotos['name']); $i++) {
            if ($fotos['error'][$i] === UPLOAD_ERR_OK) {
                $ext = strtolower(pathinfo($fotos['name'][$i], PATHINFO_EXTENSION));
                
                // Validar extensão de cada foto da galeria
                if (in_array($ext, $extensoes_permitidas)) {
                    $nome_final = bin2hex(random_bytes(10)) . "." . $ext;
                    $destino_galeria = "../ANEXOS/" . $nome_final;

                    if (move_uploaded_file($fotos['tmp_name'][$i], $destino_galeria)) {
                        $sql_galeria = "INSERT INTO produto_imagens (id_produto, caminho_imagem) VALUES (?, ?)";
                        $pdo->prepare($sql_galeria)->execute([$id_novo, $nome_final]);
                    }
                }
            }
        }
    }

    header("Location: ../ADMINISTRACAO/produtos_listar.php?msg=sucesso_criar");
    exit();
}