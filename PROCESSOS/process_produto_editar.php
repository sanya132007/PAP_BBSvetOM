<?php
session_start(); // OBRIGATÓRIO para enviar mensagens de erro
include '../BASE_DE_DADOS/ligacao_bd.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    
    // 1. LIMPEZA E VALIDAÇÃO (Obrigatório para nota técnica)
    $nome = trim($_POST['nome']);
    $descricao = trim($_POST['descricao']);
    $preco = filter_var($_POST['preco'], FILTER_VALIDATE_FLOAT);
    $disponivel = $_POST['disponivel'];

    // Se os campos básicos estiverem errados, para aqui e avisa o Admin
    if (empty($nome) || empty($descricao) || $preco === false || $preco <= 0) {
        $_SESSION['erro'] = "Preencha o nome, descrição e um preço válido.";
        header("Location: ../ADMINISTRACAO/produto_editar.php?id=$id");
        exit();
    }

    $extensoes_permitidas = ['jpg', 'jpeg', 'png', 'webp'];

    // 2. Atualizar os dados básicos
    $sql = "UPDATE produtos SET nome = ?, descricao = ?, preco = ?, disponivel = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nome, $descricao, $preco, $disponivel, $id]);

    // 3. Verificar nova CAPA com validação de formato
    if (isset($_FILES['imagem_capa']) && $_FILES['imagem_capa']['error'] === UPLOAD_ERR_OK) {
        $extensao = strtolower(pathinfo($_FILES['imagem_capa']['name'], PATHINFO_EXTENSION));
        
        if (in_array($extensao, $extensoes_permitidas)) {
            $novo_nome_img = bin2hex(random_bytes(10)) . "." . $extensao;
            $destino = "../ANEXOS/" . $novo_nome_img;

            if (move_uploaded_file($_FILES['imagem_capa']['tmp_name'], $destino)) {
                $sql_img = "UPDATE produtos SET imagem_capa = ? WHERE id = ?";
                $pdo->prepare($sql_img)->execute([$novo_nome_img, $id]);
            }
        } else {
            $_SESSION['erro'] = "Formato de capa inválido.";
        }
    }

    // 4. Tratar GALERIA com validação de formato por cada foto
    if (isset($_FILES['galeria']) && !empty($_FILES['galeria']['name'][0])) {
        $fotos = $_FILES['galeria'];

        for ($i = 0; $i < count($fotos['name']); $i++) {
            if ($fotos['error'][$i] === UPLOAD_ERR_OK) {
                $ext = strtolower(pathinfo($fotos['name'][$i], PATHINFO_EXTENSION));
                
                if (in_array($ext, $extensoes_permitidas)) {
                    $nome_final = bin2hex(random_bytes(10)) . "." . $ext;
                    $destino_galeria = "../ANEXOS/" . $nome_final;

                    if (move_uploaded_file($fotos['tmp_name'][$i], $destino_galeria)) {
                        $sql_galeria = "INSERT INTO produto_imagens (id_produto, caminho_imagem) VALUES (?, ?)";
                        $pdo->prepare($sql_galeria)->execute([$id, $nome_final]);
                    }
                }
            }
        }
    }

    header("Location: ../ADMINISTRACAO/produtos_listar.php?msg=sucesso");
    exit();
}