<?php
// Iniciar a sessão para o site se lembrar do utilizador
session_start();

// Caminho atualizado: sai de PROCESSOS e entra em BASE_DE_DADOS
include '../BASE_DE_DADOS/ligacao_bd.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $pass  = $_POST['password'];

    try {
        // 1. Tentar encontrar primeiro na tabela ADMIN
        $sqlAdmin = "SELECT * FROM admin WHERE email = ?";
        $stmtAdmin = $pdo->prepare($sqlAdmin);
        $stmtAdmin->execute([$email]);
        $admin = $stmtAdmin->fetch();

        if ($admin && $pass === $admin['password']) {
            // SUCESSO ADMIN! (Nota: admin usa texto limpo na tua BD atual)
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['nome'] = $admin['nome'];
            $_SESSION['tipo'] = 'admin';

            echo "<h2>Olá, Administrador! A entrar no painel...</h2>";

            header("Refresh: 2; url=../ADMINISTRACAO/painel.php"); 
            exit();
        }

        // 2. Se não encontrou admin, procurar na tabela CLIENTES
        $sqlCliente = "SELECT * FROM clientes WHERE email = ?";
        $stmtCliente = $pdo->prepare($sqlCliente);
        $stmtCliente->execute([$email]);
        $cliente = $stmtCliente->fetch();

        // Verificar se o cliente existe e se a password (hash) está correta
        if ($cliente && password_verify($pass, $cliente['password'])) {
            
            // SUCESSO CLIENTE! 
            $_SESSION['cliente_id'] = $cliente['id'];
            $_SESSION['nome'] = $cliente['nome'];
            $_SESSION['tipo'] = 'cliente';

            echo "<h2>Bem-vindo de volta, " . $cliente['nome'] . "!</h2>";
            
            // Redireciona para a área de cliente na raiz
            header("Refresh: 2; url=../area_cliente.php"); 
            exit();
            
        } else {
            // ERRO! Email ou password errados em ambas as tabelas
            echo "<h2>Email ou Palavra-passe incorretos!</h2>";
            echo "<p>A redirecionar...</p>";
            header("Refresh: 2; url=../login_registro.php");
            exit();
        }

    } catch (PDOException $e) {
        error_log("Erro no login: " . $e->getMessage());
        die("Erro técnico ao processar o login.");
    }
}
?>