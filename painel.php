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
        <title>Usuário - VivAsilo</title>
    </head>
    
    <style><?php include 'css/login.css'; ?></style>

    <body>   
        <?php 
        // Include da NavBar
        include 'navbar.php';?>
        <h1>Painel do Usuário - VivAsilo</h1>

        <p>Bem-vindo ao seu painel, <?php echo $_SESSION['nm_usuario']; ?> | <a href="loginout.php">Sair</a>
        <br/><?php if($_SESSION['id_usuario'] != 0){?>
                    Você pode <a onclick="document.getElementById('id02').style.display='block'"> Troque o seu E-mail</a>
                    ou <a onclick="document.getElementById('id03').style.display='block'"> Troque a sua Senha</a>
                    <?php } ?>
                    </p>
            <div id="id02" class="modal"> 
                <form action="emailchange.php" method="post" class="modal-content animate">
                    <div class="imgcontainer">
                        <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>
                    </div>
                    <div class="container">
                        <label for="email"><b>Email:</b></label>
                        <input type="text" placeholder="Digite o seu novo e-mail" name="email" id="email" required>

                        <button type="submit">Trocar E-mail</button>
                        <button type="button" onclick="document.getElementById('id02').style.display='none'" class="cancelbtn">Cancelar</button>
                    </div>
                </form>
            </div><div id="id03" class="modal"> 
                <form action="passwordchange.php" method="post" class="modal-content animate">
                    <div class="imgcontainer">
                        <span onclick="document.getElementById('id03').style.display='none'" class="close" title="Close Modal">&times;</span>
                    </div>
                    <div class="container">
                        <label for="senha"><b>Antiga Senha:</b></label>
                        <input type="password" placeholder="Digite a sua Antiga Senha" name="senha" id="senha" required>

                        <label for="novasenha"><b>Nova Senha:</b></label>
                        <input type="password" placeholder="Digite a sua Nova Senha" name="novasenha" id="novasenha" required>
                        
                        <label for="confsenha"><b>Confirmar Nova Senha::</b></label>
                        <input type="password" placeholder="Confirme a Sua Nova Senha" name="confsenha" id="confsenha" required>

                        <button type="submit">Trocar Senha</button>
                        <button type="button" onclick="document.getElementById('id03').style.display='none'" class="cancelbtn">Cancelar</button>
                    </div>
                </form>
            </div>
    <script>
        // Get the modal
        var modal = document.getElementById('id02') || document.getElementById('id03');

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        };
    </script>
    </body>
</html>