<?php 
// Include da NavBar
session_start();
require_once 'init.php';
include 'navbar.php';?>
<link href='css/login.css' type='text/css' rel='stylesheet'/>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Login - VivAsilo</title>
    </head>
    <body>
        <header><b>Login - VivAsilo</b></header>
        </br>
        <?php
        if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "login"){
            // Resgata variáveis do formulário do form-login.php:
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            $senhaHash = isset($_POST['senha']) ? $_POST['senha'] : '';
            // Caso falte algum parametro:
            if (empty($email) || empty($senhaHash)){
                echo "<center><h2>Informe email e senha</h2>";
            }else{
                // Cria o hash da senha:
                $senhaHash = make_hash($senhaHash);

                // Chama a função da conexão PDO::
                $pdo = db_connect();

                $sql = "SELECT id_usuario, nm_usuario, administrador FROM tb_usuario WHERE email = :email AND senha = :senha";
                $stmt = $pdo->prepare($sql);

                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':senha', $senhaHash);

                $stmt->execute();

                $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Messagem de erro:
                if (count($users) <= 0){
                    echo "<center><h2>Login e/ou senha incorretos</h2>";
                }else{
                    // Pega o usuário atual
                    $user = $users[0];
                    $_SESSION['logged_in'] = true;
                    $_SESSION['id_usuario'] = $user['id_usuario'];
                    $_SESSION['nm_usuario'] = $user['nm_usuario'];
                    $_SESSION['administrador'] = $user['administrador'];
                }
            }
        }
        if (!loggedin()){?>
            </br>
            <center><table>
                <form action="?act=login" method="post" name="login">
                    <tr><th colspan='2'><label for="email">E-mail: </label></th></tr>
                        <tr><td colspan='2'><input type="text" name="email" id="email" style="width:450px"></td></tr>
                        <tr><td colspan='2'></br></td></tr>
                        <tr><th colspan='2'<label for="senha">Senha: </label></th></tr>
                        <tr><td colspan='2'><input type="password" name="senha" id="senha" style="width:450px"></td></tr>
                        <tr><td colspan='2'></br></td></tr>
                    <tr><th><center><input type="submit" value="Entrar" style="width:150px;align:right;"></center></th>
                </form></table></center>
        <?php }else{
            echo "<center><h2>Login realizado com sucesso!</h2>";?>
            </br></br><a href="index.php">Voltar para a pagina principal</a>
        <?php } ?>
    </body>
</html>
