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
        
        <div>Bem-vindo ao seu painel, <?php echo $_SESSION['nm_usuario']; ?> | <a href="index.php">Página Principal</a> | <a href="loginout.php">Sair</a></div>
        <br/><?php if($_SESSION['administrador'] != 1){?>
    </br><center><h2>Alterações de Perfil:</h2>
            <center><h3><a onclick="document.getElementById('id02').style.display='block'"> Editar e-mail</a></br>
                <a onclick="document.getElementById('id03').style.display='block'"> Editar senha</a></br>
            <?php if(maintainerch($_SESSION['id_usuario']) != true){?>
                <p> Aguardando validação da conta.</p>
            <?php } else { ?>
                <a onclick="document.getElementById('id04').style.display='block'"> Editar telefone</a></br>
                <a onclick="document.getElementById('id05').style.display='block'"> Trocar foto</a></br>
                            
                </br><a href="form-asilo.php">Gerenciar asilo</a></p></center></h3>
                            <br>
                            <h2>Meus Asilos:</h2>
                            <table border="1" width="100%">
                                <tr>
                                    <th>Foto</th>
                                    <th>Nome</th>
                                    <th>Status</th>
                                </tr>
                                <?php try {
                                // Bloco que realiza o papel do Read - recupera os dados e apresenta na tela
                                $pdo = db_connect();
                                $stmt = $pdo->prepare("SELECT nome_asilo, status_asilo, foto_asilo FROM tb_asilo WHERE fk_id = :id");
                                $stmt->execute(array(':id' => $_SESSION['id_usuario']));
 
                                if ($stmt->execute()) {
                                    while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                                        echo "<tr>";
                                        echo "<td>".$rs->foto_asilo."</td><td>".$rs->nome_asilo."</td><td>".$rs->status_asilo;
                                        echo "</tr>";
                                        }} else {
                                            echo "Erro: Não conseguiu recupaerar os dados do Banco de Dados!";
                                        }} catch (PDOException $erro) {
                                            echo "Erro: ".$erro->getMessage();
                                        }?>
                            </table>
                        <?php }
                    } ?>
            <!-- Formularios de troca de e-mail(ID02), Senha(ID03), telefone(ID04) e foto(ID05): -->
            <div id="id02" class="modal"> 
                <form action="emailchange.php" method="post" class="modal-content animate">
                    <div class="imgcontainer">
                        <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>
                    </div>
                    
                        <label for="email"><b>Email:</b></label>
                        <input type="email" placeholder="Digite o seu novo e-mail" name="email" id="email" required>

                        <button type="submit">Trocar e-mail</button>
                        <button type="button" onclick="document.getElementById('id02').style.display='none'" class="cancelbtn">Cancelar</button>
                   
                </form>
            </div><div id="id03" class="modal"> 
                <form action="passwordchange.php" method="post" class="modal-content animate">
                    <div class="imgcontainer">
                        <span onclick="document.getElementById('id03').style.display='none'" class="close" title="Close Modal">&times;</span>
                    </div>
                    
                        <label for="senha"><b>Antiga senha:</b></label>
                        <input type="password" placeholder="Digite a sua antiga senha" name="senha" id="senha" style="width:200;" required>

                        <label for="novasenha"><b>Nova senha:</b></label>
                        <input type="password" placeholder="Digite a sua nova senha" name="novasenha" id="novasenha" style="width:200;" required>
                        
                        <label for="confsenha"><b>Confirmar nova senha:</b></label>
                        <input type="password" placeholder="Confirme a Sua nova senha" name="confsenha" id="confsenha" style="width:200;" required>

                        <button type="submit">Trocar Senha</button>
                        <button type="button" onclick="document.getElementById('id03').style.display='none'" class="cancelbtn">Cancelar</button>
                    
                </form>
            </div><div id="id04" class="modal"> 
                <form action="fonechange.php" method="post" class="modal-content animate">
                    <div class="imgcontainer">
                        <span onclick="document.getElementById('id04').style.display='none'" class="close" title="Close Modal">&times;</span>
                    </div>
                    <div class="container">
                        <label for="telefone"><b>Telefone:</b></label>
                        <input type="telefone" placeholder="Digite o seu novo número de telefone" name="telefone" id="telefone" required>

                        <button type="submit">Trocar número de telefone</button>
                        <button type="button" onclick="document.getElementById('id04').style.display='none'" class="cancelbtn">Cancelar</button>
                    </div>
                </form>
            </div><div id="id05" class="modal"> 
                <form action="photochange.php" method="post" class="modal-content animate">
                    <div class="imgcontainer">
                        <span onclick="document.getElementById('id05').style.display='none'" class="close" title="Close Modal">&times;</span>
                    </div>
                    <div class="container">
                        <label for="foto"><b>URL da foto:</b></label>
                        <input type="telefone" placeholder="https://" name="telefone" id="telefone" required>

                        <button type="button" onclick="document.getElementById('id05').style.display='none'" class="cancelbtn">Trocar Foto do Perfil</button>
                        <button type="button" onclick="document.getElementById('id05').style.display='none'" class="cancelbtn">Cancelar</button>
                    </div>
                </form>
            </div>
    <script>
        // Get the modal
        var modal = document.getElementById('id02') || document.getElementById('id03') || document.getElementById('id04') || document.getElementById('id05');

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        };
    </script>
    </body>
</html>