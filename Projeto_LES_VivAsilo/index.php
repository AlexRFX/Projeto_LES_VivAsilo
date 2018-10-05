<?php
session_start();
// inclui o arquivo de inicialização:
require 'init.php';
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">

        <title>Home - VivAsilo</title>
    </head>

    <body>
        <h1>Home - VivAsilo</h1>

        <?php if (loggedin()): ?>
            <p>Olá, <?php echo $_SESSION['nm_usuario']; ?>. <a href="painel.php">Painel</a> | <a href="loginout.php">Sair</a></p>
        <?php else: ?>
            <p>Olá, visitante. <a href="form-login.php">Login</a></p>
        <?php endif; ?>

    </body>
</html>
