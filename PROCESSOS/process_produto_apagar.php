<?php
// Caminho atualizado: sai de PROCESSOS e entra em BASE_DE_DADOS
include '../BASE_DE_DADOS/ligacao_bd.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // 1. Buscar o nome do ficheiro da capa
        $stmt = $pdo->prepare("SELECT imagem_capa FROM produtos WHERE id = ?");
        $stmt->execute([$id]);
        $capa = $stmt->fetchColumn();

        // 2. Buscar fotos da galeria (usando a tua coluna correta: id_produto)
        $stmt_gal = $pdo->prepare("SELECT caminho_imagem FROM produto_imagens WHERE id_produto = ?");
        $stmt_gal->execute([$id]);
        $fotos_galeria = $stmt_gal->fetchAll(PDO::FETCH_COLUMN);

        // 3. Limpeza de ficheiros na pasta ANEXOS
        // Saímos de PROCESSOS e entramos em ANEXOS
        if ($capa) {
            $caminho_capa = "../ANEXOS/" . $capa;
            if (file_exists($caminho_capa)) { 
                unlink($caminho_capa); 
            }
        }

        foreach ($fotos_galeria as $foto) {
            $caminho_foto = "../ANEXOS/" . $foto;
            if (file_exists($caminho_foto)) { 
                unlink($caminho_foto); 
            }
        }

        // 4. Apagar da Base de Dados
        // Nota: Se tiveres "ON DELETE CASCADE" na BD, apagar o produto apaga logo a galeria.
        // Se não tiveres, convém apagar a galeria primeiro:
        $pdo->prepare("DELETE FROM produto_imagens WHERE id_produto = ?")->execute([$id]);
        $pdo->prepare("DELETE FROM produtos WHERE id = ?")->execute([$id]);

        // Redireciona de volta para a lista (que está em ADMINISTRACAO)
        header("Location: ../ADMINISTRACAO/produtos_listar.php");
        exit();

    } catch (PDOException $e) {
        die("Erro ao apagar produto: " . $e->getMessage());
    }
}
?>