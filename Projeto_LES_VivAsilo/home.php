<?php
session_start();
// inclui o arquivo de inicialização:
require 'init.php';
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">

        <title>Sistema de Login PHP</title>
    </head>

    <body>
        
        <h1>Sistema de Login PHP</h1>

        <?php if (loggedin()): ?>
            <p>Olá, <?php echo $_SESSION['nm_user']; ?>. <a href="painel.php">Painel</a> | <a href="logout.php">Sair</a></p>
        <?php else: ?>
            <p>Olá, visitante. <a href="form-login.php">Login</a></p>
        <?php endif; ?>

    </body>
</html>
