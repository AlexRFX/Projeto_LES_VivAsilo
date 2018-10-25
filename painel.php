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
        <header>Painel do Usuário - VivAsilo</header>
        
        <div>Bem-vindo ao seu painel, <?php echo $_SESSION['nm_usuario']; ?> | <a href="loginout.php">Sair</a></div>
        <br/><?php if($_SESSION['administrador'] != 1){?>
        </br>
        <div>Alterações de Perfil:</div>
    <center><a onclick="document.getElementById('id02').style.display='block'"> Editar e-mail</a></br>
                        <a onclick="document.getElementById('id03').style.display='block'"> Editar senha</a></br>
                        <?php if(maintainerch($_SESSION['id_usuario']) != true){?>
                            <p> Aguardando validação da conta.</p>
                        <?php } else { ?>
                            <a onclick="document.getElementById('id04').style.display='block'"> Editar número de telefone</a></br>
                            <a onclick="document.getElementById('id05').style.display='block'"> Trocar foto</a></center>
                        <?php }
                    } ?>
        
            <div id="id02" class="modal"> 
                <form action="emailchange.php" method="post" class="modal-content animate">
                    <div class="imgcontainer">
                        <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>
                    </div>
                    
                        <label for="email"><b>Email:</b></label>
                        <input type="email" placeholder="Digite o seu novo e-mail" name="email" id="email" required>

                        <button type="submit">Trocar E-mail</button>
                        <button type="button" onclick="document.getElementById('id02').style.display='none'" class="cancelbtn">Cancelar</button>
                    
                </form>
            </div><div id="id03" class="modal"> 
                <form action="passwordchange.php" method="post" class="modal-content animate">
                    <div class="imgcontainer">
                        <span onclick="document.getElementById('id03').style.display='none'" class="close" title="Close Modal">&times;</span>
                    </div>
                    
                        <label for="senha"><b>Antiga senha:</b></label>
                        <input type="password" placeholder="Digite a sua antiga senha" name="senha" id="senha" size="10" required>

                        <label for="novasenha"><b>Nova senha:</b></label>
                        <input type="password" placeholder="Digite a sua nova senha" name="novasenha" id="novasenha" required>
                        
                        <label for="confsenha"><b>Confirmar nova senha:</b></label>
                        <input type="password" placeholder="Confirme a sua nova senha" name="confsenha" id="confsenha" required>
                        </br>
                        </br>
                        <button type="submit">Confirmar</button>
                        <button type="button" onclick="document.getElementById('id03').style.display='none'" class="cancelbtn">Cancelar</button>
                    
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