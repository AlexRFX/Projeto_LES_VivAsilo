<?php
session_start();
// inclui o arquivo de inicializão:
require 'init.php';
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">

        <title>Home - VivAsilo</title>
    </head>

    <body>
        <?php 
        // Include da NavBar
        include 'navbar.php';?>
        <h1>Home - VivAsilo</h1>

        <?php if (loggedin()):
                if($_SESSION['administrador'] != 1):?>
                    <p>Olá, <?php echo $_SESSION['nm_usuario']; ?> | <a href="painel.php">Painel</a> | <a href="loginout.php">Sair</a></p>
                <?php else: ?>
                    <p>Olá, <?php echo $_SESSION['nm_usuario']; ?> | <a href="admpainel.php">Painel</a> | <a href="loginout.php">Sair</a></p>
                <?php endif; ?>    
            <?php else: ?>
                <p>Olá, visitante | <a href="form-login.php">Login</a> | <a href="form-register.php">Cadastre-se</a></p>
            <?php endif; ?>

    </body>
</html>

