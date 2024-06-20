<?php
require_once "conexao.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['nome']) || $_SESSION['nome'] != 'admin') {
    header("Location: index.php");
    exit();
}

$produtos = selectDados($connect, 'produtos');
echo json_encode($produtos);
?>
