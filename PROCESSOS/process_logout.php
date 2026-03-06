<?php
session_start();

// 1. Destrói todas as variáveis da sessão (queima os bilhetes)
$_SESSION = array();

// 2. OBRIGATÓRIO PARA SEGURANÇA: Apagar o cookie da sessão no navegador
// Isto garante que o "rasto" da chave de acesso é eliminado do browser do utilizador.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 3. Destrói a sessão no servidor
session_destroy();

// 4. Manda o utilizador de volta para a página inicial ou login
header("Location: ../_index.php?msg=saiu");
exit();
?>