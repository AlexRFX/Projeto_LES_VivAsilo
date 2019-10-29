<?php 
// Include da NavBar
session_start();
$pagina="form-login";
require_once '../init.php';
include '../navbar.php';?>
<link href='css/login.css' type='text/css' rel='stylesheet'/>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Login - VivAsilo</title>
        <style>
  
        </style>
    </head>
    <body>
        <p class="nome">Login</p>
        <?php
        if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "login"){
            // Resgata variáveis do formulário do form-login.php:
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            $senhaHash = isset($_POST['senha']) ? $_POST['senha'] : '';
            // Caso falte algum parametro:
            if (empty($email) || empty($senhaHash)){?>
               <center><h4 class="bg-warning fonte2">Informe email e senha</h4>
            <?php }else{
                // Cria o hash da senha:
                $senhaHash = make_hash($senhaHash);

                // Chama a função da conexão PDO::
                $pdo = db_connect();

                $sql = "SELECT user_id, user_nm, user_adm FROM tb_user WHERE user_email = :email AND user_senha = :senha";
                $stmt = $pdo->prepare($sql);

                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':senha', $senhaHash);

                $stmt->execute();

                $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Messagem de erro:
                if (count($users) <= 0){?>
                   <center><h4 class="bg-danger fonte2">Login e/ou senha incorretos</h4></center>
                <?php }else{
                    // Pega o usuário atual
                    $user = $users[0];
                    $_SESSION['logged_in'] = true;
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['user_nm'] = $user['user_nm'];
                    $_SESSION['user_adm'] = $user['user_adm'];
                }
            }
        }
        if (!loggedin()){?>
            <div class="container">
                <div class="row">
                    <div class="col-12 verd comens">
            <center><table>
                <form action="?act=login" method="post" name="login">
                    <tr><th colspan='3'><label for="email" class="fonte2">E-mail: </label></th></tr>
                    <tr><td colspan='3'><input type="text" name="email" id="email" class="form-control input-lg"></td></tr>
                        <tr><td colspan='3'></br></td></tr>
                        <tr><th colspan='3'<label for="senha" class="fonte2">Senha: </label></th></tr>
                        <tr><td colspan='3'><input type="password" name="senha" id="senha" class="form-control input-lg"></td></tr>
                        <tr><td colspan='3'></br></td></tr>
                        <tr><td></td>
                            <td><input type="submit" value="Entrar"  class="form-control input-lg"></td>
                            <td><input type="reset" value="Limpar"  class="form-control input-lg"/></td>
                </form></table></center>
            </div></div></div>
        <?php }else{?>
            <center><h4 class="bg-success"><b>Login efetuado com sucesso!</b></h4>
                </br></br><h3><a href="../index.php"><span class="glyphicon glyphicon-home"></span>  Voltar para a página principal</a></h3>
        <?php } ?>
    </body>
</html>
