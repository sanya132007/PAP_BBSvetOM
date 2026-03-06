<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// O teu login cria $_SESSION['admin_id'], por isso o segurança verifica essa!
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../_index.php?erro=acesso_negado");
    exit();
}
?>