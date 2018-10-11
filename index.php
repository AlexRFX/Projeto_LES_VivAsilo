<?php
session_start();
// inclui o arquivo de inicializ�o:
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
                if($_SESSION['id_usuario'] != 0):?>
                    <p>Ol�, <?php echo $_SESSION['nm_usuario']; ?> | <a href="painel.php">Painel</a> | <a href="loginout.php">Sair</a></p>
                <?php else: ?>
                    <p>Ol�, <?php echo $_SESSION['nm_usuario']; ?> | <a href="admpainel.php">Painel</a> | <a href="loginout.php">Sair</a></p>
                <?php endif; ?>    
            <?php else: ?>
                <p>Ol�, visitante | <a href="form-login.php">Login</a></p>
            <?php endif; ?>

    </body>
</html>
