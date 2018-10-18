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
        <header><b>VivAsilo</b></h1></center></header>

        <?php if (loggedin()):
                if($_SESSION['administrador'] != 1):?>
                     <div align="center"><p>Olá, <?php echo $_SESSION['nm_usuario']; ?> | <a href="painel.php">Painel</a> | <a href="loginout.php">Sair</a></p></div>
                <?php else: ?>
                     <div align="center"><p>Olá, <?php echo $_SESSION['nm_usuario']; ?> | <a href="admpainel.php">Painel</a> | <a href="loginout.php">Sair</a></p></div>
                <?php endif; ?>    
            <?php else: ?>
                    <div align="center"><p>Olá, visitante | <a href="form-register.php">Cadastrear-se</a> | <a href="form-login.php">Efetuar Login</a></p></div>
            <?php endif; ?>

    </body>
</html>


