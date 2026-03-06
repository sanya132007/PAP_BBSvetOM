<?php
// Caminho atualizado: sai de PROCESSOS e entra em BASE_DE_DADOS
include '../BASE_DE_DADOS/ligacao_bd.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 2. Receber os dados dos inputs do HTML
    $nome    = htmlspecialchars(trim($_POST['nome']));
    $apelido = htmlspecialchars(trim($_POST['apelido']));
    $email   = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $pass    = $_POST['password'];
    $conf_pass = $_POST['confirmar_password'];

    // 3. Verificação básica: As passwords são iguais?
    if ($pass !== $conf_pass) {
        die("Erro: As palavras-passe não coincidem. Volte atrás e tente novamente.");
    }

    // 4. Encriptar a password (Fundamental para a segurança da tua PAP)
    $pass_encriptada = password_hash($pass, PASSWORD_DEFAULT);

    try {
        // 5. Inserir na tabela clientes
        // Nota: Certifica-te que na tua BD a coluna se chama 'apelido'
        $sql = "INSERT INTO clientes (nome, apelido, email, password) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        
        // 6. Executar a ordem
        $stmt->execute([$nome, $apelido, $email, $pass_encriptada]);

        echo "<h2>Registo concluído com sucesso!</h2>";
        echo "<p>Bem-vindo à BBSvetOM, $nome. A redirecionar...</p>";
        
        // Redireciona para o login para o utilizador entrar pela primeira vez
        header("Refresh: 3; url=../login_registro.php");

    } catch (PDOException $e) {
        // Erro 23000 costuma ser duplicado (email repetido)
        if ($e->getCode() == 23000) {
            echo "<h2>Erro: Este email já está registado.</h2>";
            header("Refresh: 3; url=../login_registro.php");
        } else {
            echo "Erro ao guardar na base de dados: " . $e->getMessage();
        }
    }
}
?>