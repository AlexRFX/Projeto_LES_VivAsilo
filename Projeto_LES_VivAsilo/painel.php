<?php
session_start();
// inclui o arquivo de inicialização:
require_once 'init.php';
// Verifica se o usuário está logado:
require 'logincheck.php';
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">

        <title>Sistema de Login PHP</title>
    </head>

    <body>
        
        <h1>Painel do Usuário</h1>

        <p>Bem-vindo ao seu painel, <?php echo $_SESSION['nm_user']; ?> | <a href="logout.php">Sair</a></p>
    </body>
</html>