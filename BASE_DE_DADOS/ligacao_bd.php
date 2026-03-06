<?php
// Configurações da Ligação
$servername = "localhost";
$db         = "bbsvetomtent2";
$username   = "root";
$password   = "";
$charset    = "utf8mb4";

try {
    // Criação da instância PDO
    $pdo = new PDO("mysql:host=$servername;dbname=$db;charset=$charset", $username, $password);
    
    // Configuração para lançar exceções em caso de erro
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Para desativar a emulação de prepared statements (mais seguro)
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

} catch (PDOException $e) {
    // Regista o erro no log do servidor para o admin ver
    error_log("Erro BBSvetOM: " . $e->getMessage());
    
    // Mensagem amigável para o utilizador
    die("Lamentamos, mas estamos com dificuldades técnicas. Por favor, tente mais tarde.");
}
?>