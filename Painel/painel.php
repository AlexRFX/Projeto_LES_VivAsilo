<?php
session_start();
$pagina = "painel";
// inclui o arquivo de inicialização:
require_once '../init.php';
// Verifica se o usuário está logado:
require '../logincheck.php';
?>
<!doctype html>
<html>
    <head>
        <title>Usuário - VivAsilo</title>
    </head>

    <style>
<?php include 'css/login.css'; ?>
        .wi{
            text-align:right;
        }
    </style>

    <body>   
        <?php
        // Include da NavBar
        include '../navbar.php'; ?>
        <p class="nome">Painel do Usuário</p>
        <?php
        if ($_SESSION['user_adm'] != 1) {
            if (maintainerch($_SESSION['user_id']) != true) {
                // Bloco que realiza o papel do Read - recupera os dados e apresenta na tela
                    $pdo = db_connect();
                    $stmt0 = $pdo->prepare("SELECT user_nm, user_email FROM tb_user WHERE user_id = :id");
                    $stmt0->bindParam(':id', $_SESSION['user_id']);
                    if ($stmt0->execute()) {
                        while ($rs = $stmt0->fetch(PDO::FETCH_OBJ)) {
                            ?>
                            <div class="container">
                                <div class="row comens verd">
                                    <div class="col-sm-12 font2" style="text-align:left;">
                                        </br>
                                        <p class="nome">Minhas Informações</p>
                                        </br>
                                        <center>
                                        <h3><b>Nome:</b> <?php echo $rs->user_nm; ?>&nbsp;<a onclick="document.getElementById('id01').style.display = 'block'">[Editar]</a></h3></br>
                                        <h3><b>E-mail:</b> <?php echo $rs->user_email; ?>&nbsp;<a onclick="document.getElementById('id02').style.display = 'block'">[Editar]</a></h3></br>
                                        <h3><b>Senha:</b> ************* &nbsp;<a onclick="document.getElementById('id03').style.display = 'block'">[Editar]</a></h3></br>
                                        </center>
                                        </br><br>
                                    </div>
                                </div>
                            </div>
                        <?php }  
                        }
            } else {
                try {
                    // Bloco que realiza o papel do Read - recupera os dados e apresenta na tela
                    $pdo = db_connect();
                    $stmt = $pdo->prepare("SELECT a.user_nm, a.user_email, b.mantenedor_telefone, b.mantenedor_foto FROM tb_user a, tb_mantenedor b WHERE a.user_id = :id AND a.user_id = b.mantenedor_fk");
                    $stmt->bindParam(':id', $_SESSION['user_id']);
                    if ($stmt->execute()) {
                        while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                            ?>
                            <div class="container">
                                <div class="row comens verd">
                                    <div class="col-sm-5">
                                        </br>
                                        <div class="col-sm-12">
                                            <a onclick="document.getElementById('id05').style.display = 'block'"><img style="width:50%" src="../imgs/imgsuser/<?php echo $rs->mantenedor_foto; ?>"</img><br>[Editar]</a></br></br></br>
                                        </div>
                                    </div>
                                    <div class="col-sm-7 font2" style="text-align:left;">
                                        </br>
                                        <p class="nome">Minhas Informações</p>
                                        </br>
                                        <h3><b>Nome:</b> <?php echo $rs->user_nm; ?>&nbsp;<a onclick="document.getElementById('id01').style.display = 'block'">[Editar]</a></h3></br>
                                        <h3><b>E-mail:</b> <?php echo $rs->user_email; ?>&nbsp;<a onclick="document.getElementById('id02').style.display = 'block'">[Editar]</a></h3></br>
                                        <h3><b>Senha:</b> ************* &nbsp;<a onclick="document.getElementById('id03').style.display = 'block'">[Editar]</a></h3></br>
                                        <h3><b>Telefone: </b>
                                        <?php
                                        if ($rs->mantenedor_telefone != null) {
                                            echo $rs->mantenedor_telefone;
                                            ?>&nbsp;<a onclick="document.getElementById('id04').style.display = 'block'">[Editar]</a></h3></br>
                                        <?php } else { ?>
                                            Telefone não cadastrado.&nbsp;<a onclick="document.getElementById('id04').style.display = 'block'">[Cadastrar]</a></h3></br>
                                        <?php
                                            }   
                        }
                        if (maintainerch($_SESSION['user_id']) != true) { ?>
                            </br><br></div>
                                </div>
                            </div>
                            </br><br>
                        <?php } else { ?>
                            </br><br></div>
                                </div>
                            </div>
                            <p class="nome">Meu Asilo:</p>
                                <?php if (asilocheck($_SESSION['user_id']) != true) { ?>
                                    <h3 class="cen"><a href="../Asilo/form-asilo.php"><span class="glyphicon glyphicon-plus"></span><u> Cadastrar asilo</u></a></h3>
                                <?php } else { ?>
                                    <h3 class="cen"><a href="../Asilo/form-asilo.php"><span class="glyphicon glyphicon-wrench"></span><u> Gerenciar asilo</u></a></h3>
                                <?php } ?>
                            <?php if(asilocheck($_SESSION['user_id'])== true) { ?>
                                <div class="container">
                                    <div class="row comens verd">
                                        <?php
                                        try {
                                            // Bloco que realiza o papel do Read - recupera os dados e apresenta na tela
                                            $pdo = db_connect();
                                            $stmt = $pdo->prepare("SELECT asilo_id, asilo_nm, asilo_ds, asilo_foto FROM tb_asilo WHERE asilo_mantenedor_fk = :id");
                                            $stmt->execute(array(':id' => $_SESSION['user_id']));
                                            if ($stmt->execute()) {
                                                while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) { ?>
                                                    </br>
                                                    <div class="col-sm-6 col-1">
                                                        <a onclick="document.getElementById('id06').style.display = 'block'"><img src="../imgs/imgsasilo/<?php echo $rs->asilo_foto; ?>"</img><br>[Click para trocar foto]</a>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <h2 class="fonte1"><?= $rs->asilo_nm ?></h2><p></br><?= $rs->asilo_ds ?></p>
                                                        <p><?php
                                                        echo "<a href=\"../Asilo/asilo.php?id=" . $rs->asilo_id . "\">[Ir para página do Asilo]</center></a>";                                                
                                                }
                                            } else {
                                                echo "Erro: Não conseguiu recupaerar os dados do Banco de Dados!";
                                            }
                                            } catch (PDOException $erro) {
                                                echo "Erro: " . $erro->getMessage();
                                            }
                            }
                        }
                                    } else {
                                        echo "Erro: Não conseguiu recupaerar os dados do Banco de Dados!";
                                    }
                                } catch (PDOException $erro) {
                                    echo "Erro: " . $erro->getMessage();
                                }
            }
        }?>
            </p></div></center></div></div>

        <!-- Formularios de troca do nome(ID01), e-mail(ID02), Senha(ID03), telefone(ID04) e foto(ID05): -->
        <div id="id01" class="modal"> 
            <form action="namechange.php" method="post" class="modal-content animate">
                <div class="imgcontainer">
                    <span onclick="document.getElementById('id01').style.display = 'none'" class="close" title="Close Modal">&times;</span>
                </div>
                <p class="fonte2 nome">Editar nome</p>
                <div class="row">
                    <div class="col-sm-12">
                        <center>
                            <input type="nome" placeholder="Digite o seu nome" name="nome" id="nome" required class="form-control input-lg" style="width:60%">
                            </br>
                            <table>
                                <tr>
                                    <td><button type="submit" class="form-control input-lg" style="width:100%">Confirmar</button></td>
                                    <td><button type="button" onclick="document.getElementById('id01').style.display = 'none'" class="cancel form-control input-lg" style="width:100%">Cancelar</button></td></tr>
                            </table>
                            </br>
                        </center>
                    </div>
                </div>
            </form>
        </div>
        <div id="id02" class="modal"> 
            <form action="emailchange.php" method="post" class="modal-content animate">
                <div class="imgcontainer">
                    <span onclick="document.getElementById('id02').style.display = 'none'" class="close" title="Close Modal">&times;</span>
                </div>
                <p class="fonte2 nome">Editar e-mail</p>
                <div class="row">
                    <div class="col-sm-12">
                        <center>
                            <input type="email" placeholder="Digite o seu novo e-mail" name="email" id="email" required class="form-control input-lg" style="width:60%">
                            </br>
                            <table>
                                <tr>
                                    <td><button type="submit" class="form-control input-lg" style="width:100%">Confirmar</button></td>
                                    <td><button type="button" onclick="document.getElementById('id02').style.display = 'none'" class="cancel form-control input-lg" style="width:100%">Cancelar</button></td></tr>
                            </table>
                            </br>
                        </center>
                    </div>
                </div>
            </form>
        </div>
        <div id="id03" class="modal"> 
            <form action="passwordchange.php" method="post" class="modal-content animate">
                <div class="imgcontainer">
                    <span onclick="document.getElementById('id03').style.display = 'none'" class="close" title="Close Modal">&times;</span>
                </div>
                <p class="fonte2 nome">Editar Senha</p>
                <div class="row">
                    <div class="col-sm-12">
                        <label for="senha" class="fonte2">Senha:</label></br>
                        <input type="password" placeholder="Digite a senha atual" name="senha" id="senha" class="form-control input-lg" style="width:60%" required>
                    </div>
                    <div class="col-sm-12">
                        <label for="novasenha" class="fonte2">Nova senha:</label></br>
                        <input type="password" placeholder="Digite a sua nova senha" name="novasenha" id="novasenha" class="form-control input-lg" style="width:60%" required>
                    </div>
                    <div class="col-sm-12">
                        <label for="confsenha" class="fonte2">Confirmar nova senha:</label></br>
                        <input type="password" placeholder="Confirme a Sua nova senha" name="confsenha" id="confsenha" class="form-control input-lg" style="width:60%" required>
                    </div>
                    </br>
                    <center>
                        <table>
                            <tr><td><button type="submit" class="form-control input-lg" style="width:100%">Trocar Senha</button></td>
                                <td><button type="button" onclick="document.getElementById('id03').style.display = 'none'" class="cancelbtn form-control input-lg" style="width:100%">Cancelar</button></td></tr> 
                    </center></table>
                </div>
            </form>
        </div>
        <div id="id04" class="modal"> 
            <form action="fonechange.php" method="post" class="modal-content animate">
                <div class="imgcontainer">
                    <span onclick="document.getElementById('id04').style.display = 'none'" class="close" title="Close Modal">&times;</span>
                </div>
                <p class="fonte2 nome">Editar Telefone</p>
                <div class="row">
                    <div class="col-sm-12">
                        <center>
                            <input type="telefone" placeholder="Digite o seu novo número de telefone" name="telefone" id="telefone" class="form-control input-lg" style="width:60%" required>
                        </center>
                    </div>
                    <center>
                        <table>
                            <tr><td><button type="submit" class="form-control input-lg" style="width:100%">Confirmar</button></td>
                            <td><button type="button" onclick="document.getElementById('id04').style.display = 'none'" class="cancelbtn form-control input-lg" style="width:100%">Cancelar</button></td></tr>
                        </table>
                    </center>
                </div></br>
            </form>
        </div>
        <div id="id05" class="modal"> 
            <form method="POST" action="painel_photoupload.php" enctype="multipart/form-data" class="modal-content animate">
                <div class="imgcontainer">
                    <span onclick="document.getElementById('id05').style.display = 'none'" class="close" title="Close Modal">&times;</span>
                </div>
                <p class="nome">Editar Foto</p>
                <div class="row">
                    <div class="col-sm-12"></div>
                        </br><label for="ds" class="fonte2">Recomendado:</label></br>
                        <label for="ds" class="fonte2">Tamanho: 200X220</label></br>
                        <label for="ds" class="fonte2">Formato: .jpg</label></br>
                        <div class="col-sm-12">
                            <center>
                                <input name="arquivo" type="file" class="" style="width:90%" required>
                            </center>
                        <center>
                            <table>
                                <tr><td><input type="submit" value="Enviar" class="form-control input-lg" style="width:100%"></td>
                                <td><button type="button" onclick="document.getElementById('id05').style.display = 'none'" class="cancelbtn form-control input-lg" style="width:100%">Cancelar</button></td></tr>
                            </table>
                        </center>
                </div>
            </form>
        </div>
       </div>
       <div id="id06" class="modal"> 
            <form method="POST" action="../Asilo/asilo_photoupload.php" enctype="multipart/form-data" class="modal-content animate">
                <div class="imgcontainer">
                    <span onclick="document.getElementById('id06').style.display = 'none'" class="close" title="Close Modal">&times;</span>
                </div>
                <p class="nome">Mudar foto do asilo</p>
                <div class="row">
                    <div class="col-sm-12"></div>
                        </br><label for="ds" class="fonte2">Recomendado:</label></br>
                        <label for="ds" class="fonte2">Tamanho: 640X480</label></br>
                        <label for="ds" class="fonte2">Formato: .jpg</label></br>
                        <div class="col-sm-12">
                            <center>
                                <input name="arquivo" type="file" class="" style="width:90%" required>
                            </center>
                        </div>
                        <center>
                            <table>
                                <tr><td><input type="submit" value="Enviar" class="form-control input-lg" style="width:100%"></td>
                                <td><button type="button" onclick="document.getElementById('id06').style.display = 'none'" class="cancelbtn form-control input-lg" style="width:100%">Cancelar</button></td></tr>
                            </table>
                        </center>
                </div>
            </form>
        </div>
    <script>
        // Get the modal
        var modal = document.getElementById('id02') || document.getElementById('id03') || document.getElementById('id04') || document.getElementById('id05') || document.getElementById('id06');

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function (event) {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        };
    </script>
</body>
</html>