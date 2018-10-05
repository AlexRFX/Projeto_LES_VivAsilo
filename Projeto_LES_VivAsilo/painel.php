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

        <title>Usuário - VivAsilo</title>
    </head>

    <body>
        
        <h1>Painel do Usuário - VivAsilo</h1>

        <p>Bem-vindo ao seu painel, <?php echo $_SESSION['nm_usuario']; ?> | <a href="loginout.php">Sair</a></p>
    </body>
</html>