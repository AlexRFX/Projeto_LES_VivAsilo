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
        <header>Painel do Usuário - VivAsilo</header>>
        
        <p>Bem-vindo ao seu painel, <?php echo $_SESSION['nm_usuario']; ?> | <a href="loginout.php">Sair</a>
        <br/><?php if($_SESSION['administrador'] != 1){?>
                        Você pode <a onclick="document.getElementById('id02').style.display='block'"> Troque o seu E-mail</a>
                        ou <a onclick="document.getElementById('id03').style.display='block'"> Troque a sua Senha</a></br>
                        <?php if(maintainerch($_SESSION['id_usuario']) != true){?>
                            <p> Aguardando validação da conta.</p>
                        <?php } else { ?>
                            Agora você pode <a onclick="document.getElementById('id04').style.display='block'"> Troque o seu número de Telefone</a>
                            ou <a onclick="document.getElementById('id05').style.display='block'"> Troque a sua Foto</a>
                        <?php }
                    } ?>
        </p>
            <div id="id02" class="modal"> 
                <form action="emailchange.php" method="post" class="modal-content animate">
                    <div class="imgcontainer">
                        <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>
                    </div>
                    <div class="container">
                        <label for="email"><b>Email:</b></label>
                        <input type="email" placeholder="Digite o seu novo e-mail" name="email" id="email" required>

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