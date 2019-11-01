<?php
session_start();
$pagina = "asilo";
$rate = NULL;
// inclui o arquivo de inicializão:
require '../init.php';
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Asilo - VivAsilo</title>
        <style>
            .dt{
                font-size:10px;
                text-align:left;
            }
            .comentario{
                text-align:left;
            }
            h3{
                font-weight: bold;
            }
            td, th{
                text-align:center;
            }
            .b{
               font-weight: bold;
               font-size: 25px;
            }
            .m{
                font-size: 18px;
            }
            </style>    </head>
    <body>
        <?php 
        // Include da NavBar
        include '../navbar.php';?>
        <?php
        // pega o id_asilo do asilo:
        $id = $_GET['id'];
        // recebe dados via POST:    
        $nota = isset($_POST['nota']) ? $_POST['nota'] : '';
        $data = date("y/m/d H:i:s");           
        $comentario = isset($_POST['comentario']) ? $_POST['comentario'] : '';
        $fk = isset($_POST['fk']) ? $_POST['fk'] : '';
        $cmt = isset($_POST['cmt']) ? $_POST['cmt'] : '';
        
        // Envia um comentario somente se não tiver chave estrangeira de outro comentario:
        if(isset($_REQUEST['submit_cmt']) && $id != "" && $fk == null){
            $pdo = db_connect();
            try {
                $stmt4 = $pdo->prepare("INSERT INTO tb_comentario (`coment_asilo_fk`, `coment_user_fk`, `coment_ds`, `coment_data`, `coment_nota`, `coment_coment_fk`) VALUES (?, ?, ?, ?, ?, NULL)");
                $stmt4->bindParam(1, $id);
                $stmt4->bindParam(2, $_SESSION['user_id']);
                $stmt4->bindParam(3, $comentario);
                $stmt4->bindParam(4, $data);
                $stmt4->bindParam(5, $nota);
                if ($stmt4->execute()) {
                    if ($stmt4->rowCount() > 0) { 
                        if($nota != NULL) {
                            $stmt3 = $pdo->prepare("SELECT asilo_nota, asilo_count FROM tb_asilo WHERE asilo_id = $id");
                            if ($stmt3->execute()) {
                                $asilonotacount = $stmt3->fetch(PDO::FETCH_OBJ);
                                $nota = $nota + $asilonotacount->asilo_nota;
                                $count = 1 + $asilonotacount->asilo_count;
                                $stmt5 = $pdo->prepare("UPDATE tb_asilo SET asilo_nota = $nota, asilo_count = $count WHERE asilo_id = $id");
                                $stmt5->execute();
                            }
                        } ?>
                        <center><h4 class="bg-success"><b>Comentario realizado com sucesso!</b></h4></center>
                        <?php
                        $comentario = null;
                        $data = null;
                        $nota = null;
                        $count = null;
                        echo "<meta http-equiv='refresh' content='3'>";
                    } else {?>
                        <center><h4 class="bg-danger">Erro ao realizar comentario!Tente novamente.</h4></center>
                        <?php
                    }
                } else {
                    throw new PDOException("<br><b>Erro: Não conseguiu executar a declaração SQL!</b><br>");
                }
            } catch (PDOException $erro) {
                echo "Erro: " . $erro->getMessage();
            }             
        }
        // Censura um comentario:
        if(isset($_REQUEST['censorship_cmt']) && $id != "" && $cmt != null){
            $pdo = db_connect();
            try {
                $stmt6 = $pdo->prepare("UPDATE tb_comentario SET coment_ds = '--CENSURADO--', coment_nota = NULL WHERE coment_asilo_fk = ? AND coment_id = ?");
                $stmt6->bindParam(1, $id);
                $stmt6->bindParam(2, $cmt);
                if ($stmt6->execute()) {
                    if ($stmt6->rowCount() > 0) {?>
                        <center><h4 class="bg-success">Comentario censurado com sucesso!</h4></center>
                        <?php
                        $cmt = null;
                        echo "<meta http-equiv='refresh' content='3'>";
                    } else {?>
                        <center><h4 class="bg-danger">Erro! Tente novamente.</h4></center>
                        <?php
                    }
                } else {
                    throw new PDOException("<br><b>Erro: Não conseguiu executar a declaração SQL!</b><br>");
                }
            } catch (PDOException $erro) {
                echo "Erro: " . $erro->getMessage();
            }             
        }
        // Envia uma resposta somente se tiver chave estrangeira de outro comentario:
        if (isset($_REQUEST['submit_res']) && $id != "" && $fk != null){
            $pdo = db_connect();
            try {
                $stmt7 = $pdo->prepare("INSERT INTO tb_comentario (`coment_asilo_fk`, `coment_user_fk`, `coment_ds`, `coment_data`, `coment_coment_fk`) VALUES (?, ?, ?, ?, ?)");
                $stmt7->bindParam(1, $id);
                $stmt7->bindParam(2, $_SESSION['user_id']);
                $stmt7->bindParam(3, $comentario);
                $stmt7->bindParam(4, $data);
                $stmt7->bindParam(5, $fk);
                if ($stmt7->execute()) {
                    if ($stmt7->rowCount() > 0) {?>
                        <center><h5 class="bg-success">Resposta enviada com sucesso!</h5></center>
                        <?php
                        $pessoa = null;
                        $comentario = null;
                        $data = null;
                        $fk = null;
                        echo "<meta http-equiv='refresh' content='3'>";
                    } else {?>
                        <center><h5 class="bg-danger">Erro no envio! Tente novamente.</h5></center>>
                        <?php
                    }
                } else {
                    throw new PDOException("<br><b>Erro: Não conseguiu executar a declaração SQL!</b><br>");
                }
            } catch (PDOException $erro) {
                echo "Erro: " . $erro->getMessage();
            }
        }
        // conecta com o banco; executa a query; exibe os dados do asilo:
        try {
            $pdo = db_connect();
            $stmt8 = $pdo->prepare("SELECT a.user_nm, a.user_email, b.asilo_nm, b.asilo_ds, b.asilo_foto, b.asilo_siteurl, b.asilo_telefone, b.asilo_cnpj, b.asilo_mensalidade, b.asilo_necessidade, b.asilo_endereco, b.asilo_nota, b.asilo_count, c.cidade_nm, d.tipo_nm "
                                   . "FROM tb_user a "
                                       . "RIGHT JOIN tb_asilo b ON a.user_id = b.asilo_mantenedor_fk "
                                       . "JOIN tb_cidade c ON b.asilo_cidade_fk = c.cidade_id "
                                       . "JOIN tb_tipo d ON b.asilo_tipo_fk = d.tipo_id "
                                           . "WHERE asilo_id = $id");
            if ($stmt8->execute()) {
                $rs = $stmt8->fetch(PDO::FETCH_OBJ);
                // exibe na pagina os dados do asilo, organize ao seu gosto:
                ?>
        <p class="nome"><?=$rs->asilo_nm;?></p>
        <div class="container">
            <div class="row comens verd">
                <div class="col-sm-5 col-1" style="text-align:center;">
                    <br>
                    <?php
                echo "<img src=../imgs/imgsasilo/".$rs->asilo_foto.">";
                if($rs->asilo_count == null):?>
                    <p class="fonte1 b">Nota:</p><p>Ainda não tem avaliações dos usuarios</p>
                <?php else: ?>
                    <p class="fonte1 b">Nota:</p><p class="m"><?=$rs->asilo_nota/$rs->asilo_count;?></p>
                <?php endif; ?>
                </div>
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-12 ">
                            <p class="fonte1 b">Nome do Mantenedor:</p><a href="mailto:<?=$rs->user_email;?>"><?=$rs->user_nm;?></p></a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 ">
                            <p class="fonte1 b">Descrição:</p><p class="m"><?=$rs->asilo_ds;?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 ">
                            <p class="fonte1 b">Categoria:</p><p class="m"><?=$rs->tipo_nm;?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 ">
                            <p class="fonte1 b">Cidade:</p><p class="m"><?=$rs->cidade_nm;?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 ">
                            <p class="fonte1 b">Endereço:</p><p class="m"><?=$rs->asilo_endereco;?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 ">
                            <p class="fonte1 b">Mensalidade:</p><p class="m">R$<?=$rs->asilo_mensalidade;?></p>
                        </div>
                        <div class="col-sm-6 ">
                            <p class="fonte1 b">Necessidades:</p><p class="m"><?=$rs->asilo_necessidade;?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 ">
                            <p class="fonte1 b">CNPJ:</p><p class="m"><?=$rs->asilo_cnpj;?> </p>
                        </div>
                        <div class="col-sm-4 ">
                            <p class="fonte1 b">Site:</p><a href="<?=$rs->asilo_siteurl;?>"><p class="m"><?=$rs->asilo_siteurl;?></p></a>
                        </div>
                        <div class="col-sm-4 ">
                            <p class="fonte1 b">Telefone:</p><p class="m"><?=$rs->asilo_telefone;?> </p>
                        </div>
                    </div>
                            <?php
            } else {?>
        <p class="bg-danger"> Não conseguiu recuperar os dados do Banco de Dados!</p>
                <?php
                
            }} catch (PDOException $erro) {
                echo "Erro: ".$erro->getMessage();
            }?>
        </br></div></div></br>
        <div class="row">
            <p class="nome" style="text-align:center;">Realizar comentário </p>
            <?php if (!LoggedIn()) {?>
                <h4 class="bg-warning"> É nescessário efetuar o login para poder fazer comentario!</h4>
            <?php } elseif ((LoggedIn() == true) && (usercomentcheck($_GET['id'], $_SESSION['user_id']) == true)){ ?>
                <h4 class="bg-warning"> Você já fez um comentario com nota para neste asilo!</h4>
            <?php } elseif ((LoggedIn() == true) && (maintaincheck($_SESSION['user_id'], $_GET['id']) == false)){ ?>
                    <div class="col-12 verd comens">
                        <!-- formulario de Comentario padrão (Faz a mesma coisa que o de baixo): -->
                        <form action="" method="post">
                            <div class="row">
                                <div class="col-sm-12">
                                    <label for="nome"><h4> Nome: <?=$_SESSION['user_nm']?></h4></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <label for="nota"><h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sua avaliação: </h4></label>
                                    <select name="nota">
                                        <option value="10">Nota 10</option>
                                        <option value="9">Nota 9</option>
                                        <option value="8">Nota 8</option>
                                        <option value="7">Nota 7</option>
                                        <option value="6">Nota 6</option>
                                        <option value="5">Nota 5</option>
                                        <option value="4">Nota 4</option>
                                        <option value="3">Nota 3</option>
                                        <option value="2">Nota 2</option>
                                        <option value="1">Nota 1</option>
                                        <option value="0">Nota 0</option>
                                        <option value="NULL">Não sou capaz de opinar</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <label for="comentario"><h4>Comentário: </h4></label>
                                    <input type="text" name="comentario" id="comentario" maxlength="255" placeholder="Máximo de 255 caracteres" required  class="form-control input-lg" style="width:60%;" >
                                </div>
                                <center>
                                <table>
                                    <tr><td><input type="submit" value="Enviar" name="submit_cmt" class="form-control" style="width:100%;"></td>
                                    <td><input type="reset" value="Limpar"  class="form-control" style="width:100%"></td><tr>
                                </table>
                            </center>
                        </div>
                        </form></center></br>
                    </div>
            <?php } else { ?>
                <h4 class="bg-warning"> Você é o mantenedor deste asilo, portanto só poderar responder ou censurar comentarios!</h4>
            <?php } ?>    
        </div></br>
        <p class="nome" style="text-align:center;">Comentários </p>
        <?php
        try {
            $pdo = db_connect();
            $stmt9 = $pdo->prepare("SELECT a.coment_id, a.coment_ds, a.coment_nota, a.coment_data, b.user_nm "
                                    . "FROM tb_comentario a "
                                        . "RIGHT JOIN tb_user b ON a.coment_user_fk = b.user_id "
                                            . "WHERE coment_asilo_fk = $id AND coment_coment_fk IS NULL "
                                                . "ORDER BY coment_id DESC");
            if ($stmt9->execute()) {
                // exibe os comentarios do asilo:
                while ($rs = $stmt9->fetch(PDO::FETCH_OBJ)){?>
                    <div class="col-12 comens verd">
                        <p class="dt">   
                            &nbsp;&nbsp;<?=$rs->coment_data;?></p>
                        <h4 class="comentario fonte2">
                            &nbsp;&nbsp;<b><?=$rs->user_nm?></b></h4>
                        <h4 class="comentario">
                            &nbsp;&nbsp;&nbsp;<?=$rs->coment_ds?>
                        </h4><br>
                        <h4 class="comentario fonte2">
                        <?php
                        if($rs->coment_nota != NULL): ?>
                            &nbsp;&nbsp;<b>Nota: <?=$rs->coment_nota?></b></h4>
                        <?php else: ?>
                            &nbsp;&nbsp;<b>Nota: Não sou capaz de opinar...</b></h4>
                        <?php endif;
                        
                        // verifica se o usuario logado é mantenedor do asilo, e libera o botão de excluir comentario:
                        if ((LoggedIn() == true) && (maintaincheck($_SESSION['user_id'], $_GET['id']) == true)){?>
                            <form action="" method="post">
                                <input type="submit" value="Censurar" name="censorship_cmt" style="size:50px;">
                                <input type="hidden" id="cmt" name="cmt" value="<?php echo htmlspecialchars($rs->coment_id); ?>">
                            </form><?php
                        }
                        echo "</br>";
                        // exibe os as respostas dos comentarios do asilo:
                        $sql = $pdo->prepare("SELECT a.coment_id, a.coment_ds, a.coment_nota, a.coment_data, b.user_nm "
                                    . "FROM tb_comentario a "
                                        . "RIGHT JOIN tb_user b ON a.coment_user_fk = b.user_id "
                                            . "WHERE coment_asilo_fk = $id AND coment_coment_fk = $rs->coment_id "
                                                . "ORDER BY coment_id ASC");
                        if ($sql->execute()) {
                            // exibe os comentarios do do asilo:
                            while ($sr = $sql->fetch(PDO::FETCH_OBJ)){ ?>
                                <p class="dt">&nbsp;&nbsp;<?=$sr->coment_data?></p>
                                <h4 class="comentario fonte2" >
                                    &nbsp;&nbsp;<b><?=$sr->user_nm?>, respondeu:</b></h4>
                                <h4 class="comentario">
                                    &nbsp;&nbsp;&nbsp;<?=$sr->coment_ds;?>
                                </h4>
                                <?php
                                // verifica se o usuario logado é mantenedor do asilo, e libera o botão de excluir resposta de comentario:
                                if ((LoggedIn() == true) && (maintaincheck($_SESSION['user_id'], $_GET['id']) == true)){?>
                                    <form action="" method="post">
                                        <input type="submit" value="Censurar" name="censorship_cmt" style="size:50px;">
                                        <input type="hidden" id="cmt" name="cmt" value="<?php echo htmlspecialchars($sr->coment_id); ?>">
                                    </form><?php 
                                }
                            }
                        }?>
                <h3 class="fonte1" style="text-align:center;"><b>Responder comentário: </b></h3>
                <?php if (!LoggedIn()) {?>
                    <h4 class="bg-warning"> É nescessário efetuar o login para poder responder comentarios!</h4>
                <?php } else {?>
                    <!-- formulario de Resposta de Comentario padrão (funciona): -->
                    <form action="" method="post" style="text-align:left;">
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="nome"><h4>Nome: <?=$_SESSION['user_nm']?></h4></label>
                            </div>
                   
                            <div class="row">   
                                <div class="col-sm-12">
                                    <label for="comentario"><h4>Comentário:</h4></label>
                                    <input type="text" name="comentario" maxlength="255" id="comentario" placeholder="Máximo de 255 caracteres" required class="form-control input-lg newes" style="width:60%;">
                                </div>
                            <center>
                            <table>
                                <tr><td><input type="submit" value="Enviar" name="submit_res" class="form-control" style="width:100%;"></td>
                                <td><input type="reset" value="Limpar" class="form-control" style="width:100%;"></td></tr>
                            </table>
                        </center>
                        <input type="hidden" id="fk" name="fk" value="<?php echo htmlspecialchars($rs->coment_id); ?>">
                    </form></br>
                </div></div>
                <?php } ?>
                </br>
                <?php
                }
            } else {
                echo "<br><b>Erro: Não conseguiu recupaerar os dados do Banco de Dados!</b><br>";
            }} catch (PDOException $erro) {
                echo "Erro: ".$erro->getMessage();
            }?>   
            <!-- Botão que invoca modal de cadastro de comentario: -->
        </div></div>
    </body>
</html>