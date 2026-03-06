<?php
include '../BASE_DE_DADOS/ligacao_bd.php';

// 1. Verificar se recebemos os IDs necessários
if (isset($_GET['id_foto']) && isset($_GET['id_produto'])) {
    $id_foto = $_GET['id_foto'];
    $id_produto = $_GET['id_produto'];

    // 2. Primeiro, vamos buscar o nome do ficheiro para o podermos apagar da pasta
    $stmt = $pdo->prepare("SELECT caminho_imagem FROM produto_imagens WHERE id = ?");
    $stmt->execute([$id_foto]);
    $foto = $stmt->fetch();

    if ($foto) {
        $caminho_completo = "../ANEXOS/" . $foto['caminho_imagem'];

        // 3. Apagar o ficheiro físico da pasta se ele existir
        if (file_exists($caminho_completo)) {
            unlink($caminho_completo);
        }

        // 4. Apagar o registo da base de dados
        $stmt_del = $pdo->prepare("DELETE FROM produto_imagens WHERE id = ?");
        $stmt_del->execute([$id_foto]);
    }

    // 5. Redirecionar de volta para a página de edição
    header("Location: ../ADMINISTRACAO/produto_editar.php?id=" . $id_produto);
    exit();
} else {
    // Se algo falhar, volta para a listagem
    header("Location: ../ADMINISTRACAO/produtos_listar.php");
    exit();
}
?>