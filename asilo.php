<!-- AVISO IMPORTATE: Tive que fazer alterações na tabela "tb_comentario"!
---- É de extrema importancia pegar o arquivo SQL do banco de dados no host 000.webhost!
-->
<?php
require 'init.php';
if(loggedin()){
session_start();}
// inclui o arquivo de inicializão:
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Asilo - VivAsilo</title>
        <style>
            h3{
                font-weight: bold;
            }
            td, th{
                text-align: center;
            }
            </style>
    </head>
    <body>
        <?php 
        // Include da NavBar
        include 'navbar.php';?>
        <?php
        // pega o id_asilo do asilo:
        $id = $_GET['id'];
        // recebe dados via POST:    
        $pessoa = isset($_POST['pessoa']) ? $_POST['pessoa'] : '';
        $data = date("y/m/d");           
        $comentario = isset($_POST['comentario']) ? $_POST['comentario'] : '';
        $fk = isset($_POST['fk']) ? $_POST['fk'] : '';
        $cmt = isset($_POST['cmt']) ? $_POST['cmt'] : '';
        
        // Envia um comentario somente se não tiver chave estrangeira de outro comentario:
        if(isset($_REQUEST['submit_cmt']) && $id != "" && $fk == null){
            $pdo = db_connect();
            try {
                $stmt = $pdo->prepare("INSERT INTO tb_comentario (`fk_asilo`, `nome_comentario`, `resposta_comentario`, `data_comentario`, `fk_comentario`) VALUES (?, ?, ?, ?, NULL)");
                $stmt->bindParam(1, $id);
                $stmt->bindParam(2, $pessoa);
                $stmt->bindParam(3, $comentario);
                $stmt->bindParam(4, $data);
                if ($stmt->execute()) {
                    if ($stmt->rowCount() > 0) {
                        echo "<br><b>Comentario realizado com sucesso!</b><br>";
                        $pessoa = null;
                        $comentario = null;
                        $data = null;
                        echo "<meta http-equiv='refresh' content='3'>";
                    } else {
                        echo "<br><b>Deu erro no envio!</b><br>";
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
                $stmt = $pdo->prepare("UPDATE tb_comentario SET resposta_comentario = '--CENSURADO--' WHERE fk_asilo = ? AND id_comentario = ?");
                $stmt->bindParam(1, $id);
                $stmt->bindParam(2, $cmt);
                if ($stmt->execute()) {
                    if ($stmt->rowCount() > 0) {
                        echo "<br><b>Comentario censurado com sucesso!</b><br>";
                        $cmt = null;
                        echo "<meta http-equiv='refresh' content='3'>";
                    } else {
                        echo "<br><b>Deu erro no envio!</b><br>";
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
                $stmt = $pdo->prepare("INSERT INTO tb_comentario (`fk_asilo`, `nome_comentario`, `resposta_comentario`, `data_comentario`, `fk_comentario`) VALUES (?, ?, ?, ?, ?)");
                $stmt->bindParam(1, $id);
                $stmt->bindParam(2, $pessoa);
                $stmt->bindParam(3, $comentario);
                $stmt->bindParam(4, $data);
                $stmt->bindParam(5, $fk);
                if ($stmt->execute()) {
                    if ($stmt->rowCount() > 0) {
                        echo "<br><b>Resposta enviada com sucesso!</b><br>";
                        $pessoa = null;
                        $comentario = null;
                        $data = null;
                        $fk = null;
                        echo "<meta http-equiv='refresh' content='3'>";
                    } else {
                        echo "<br><b>Deu erro no envio!</b><br>";
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
            $stmt = $pdo->prepare("SELECT * FROM tb_asilo WHERE id_asilo = $id");
            if ($stmt->execute()) {
                $rs = $stmt->fetch(PDO::FETCH_OBJ);
                // exibe na pagina os dados do asilo, organize ao seu gosto:
                ?>
        <header><b><?php echo $rs->nome_asilo; ?></b></header>
                <table class="table">
                    <tr>
                        <th rowspan="8"><center>
                    <?php
                echo "<img src=".$rs->foto_asilo.">";
                ?>
                    </center></th>
                    <tr>
                    <th colspan="2">
                    <center>Endereço:</center></th>
                    <th>
                        <center>Dados Bancários:</center></th>
                    </tr>
                    <tr>
                    <td colspan="2">
                    <?php
                echo $rs->endereco_asilo;
                ?>  </td>
                    <td>
                    <?php
                echo $rs->dbanco_asilo;
                ?> </td>
                    <tr>
                        <th>
                       <center> Telefone:</center></th>
                    <th>
                       <center> CNPJ:</center></th>
                    <th>
                        <center>Site:</center></th>
                    </tr>
                    <tr>
                    <td>
                    <?php
                echo $rs->tel_asilo;
                ?> </td>
                    <td>
                    <?php
                echo $rs->cnpj_asilo;
                ?> </td>
                    <td>
                    <?php
                echo $rs->site_asilo;
                ?> </td>
                    </tr>
                    <tr>
                        <th colspan="2">
                            <center>Descrição:</center></th>
                        <th colspan="1">
                            <center>Necessidades:</center></th>
                    </tr>
                    <tr>
                    <td colspan="2">
                    <?php
                echo $rs->desc_asilo;
                ?>  
                    </td>
                    <td colspan="1">
                    <?php
                echo $rs->neces_asilo;
                ?> </td></tr></table><?php
                echo "$rs->fk_comentario;"
                ?><?php
            } else {
                echo "<br><b>Erro: Não conseguiu recupaerar os dados do Banco de Dados!</b><br>";
            }} catch (PDOException $erro) {
                echo "Erro: ".$erro->getMessage();
            }?>
           
        <hr>
        <header>Comentarios</header>
    <center>
        <?php
        try {
            $pdo = db_connect();
            $stmt = $pdo->prepare("SELECT * FROM tb_comentario WHERE fk_asilo = $id AND fk_comentario IS NULL ORDER BY id_comentario DESC");
            if ($stmt->execute()) {
                // exibe os comentarios do asilo:
                while ($rs = $stmt->fetch(PDO::FETCH_OBJ)){
                    ?>
        <div style="background-color:white;">
            </br>
            <h5>        
            <?php 
                    echo $rs->data_comentario."</br>";
                    ?></h5>
            <?php
            echo$rs->nome_comentario.": </br>".$rs->resposta_comentario."";
                        // verifica se o usuario logado é mantenedor do asilo, e libera o botão de excluir comentario:
                        if ((LoggedIn() == true) && (maintaincheck($_SESSION['id_usuario'], $_GET['id']) == true)){?>
                            <form action="" method="post">
                                <input type="submit" value="Censurar" name="censorship_cmt" style="size:50px;">
                                <input type="hidden" id="cmt" name="cmt" value="<?php echo htmlspecialchars($rs->id_comentario); ?>">
                            </form><?php
                        }
                        echo "</br><hr>";
                        ?>
        <?php
                        // exibe os as respostas dos comentarios do asilo:
                        $sql = $pdo->prepare("SELECT * FROM tb_comentario WHERE fk_asilo = $id AND fk_comentario = $rs->id_comentario ORDER BY id_comentario ASC");
                        if ($sql->execute()) {
                            // exibe os comentarios do do asilo:
                            while ($sr = $sql->fetch(PDO::FETCH_OBJ)){
                                ?><h5><?php echo $sr->data_comentario."</h5>".$sr->nome_comentario.", Respondeu:</br>".$sr->resposta_comentario;
                                // verifica se o usuario logado é mantenedor do asilo, e libera o botão de excluir resposta de comentario:
                                if ((LoggedIn() == true) && (maintaincheck($_SESSION['id_usuario'], $_GET['id']) == true)){?>
                                    <form action="" method="post">
                                        <input type="submit" value="Censurar" name="censorship_cmt" style="size:50px;">
                                        <input type="hidden" id="cmt" name="cmt" value="<?php echo htmlspecialchars($sr->id_comentario); ?>">
                                    </form><?php 
                                }
                                echo "</br><hr>";
                            }
                            }?></div>
        <h2><b>Responder comentario</b></h2>
                    <!-- Formularios resposta de comentario(ID71) (Está bugado:): -->
                    
                <br>
                <!-- formulario de Resposta de Comentario padrão (funciona): -->
                <form action="" method="post">
                    <table>
                        <tr>
                            <td><label for="pessoa"><h3>Nome: </h3></label></td>
                            <td colspan="3"><input type="text" name="pessoa" maxlength="30" id="pessoa" required style="width:600px;" pattern="[a-zA-Z0-9]+" required placeholder="Apenas caracteres alfanuméricos"></td>
                        </tr>
                    <tr>
                            <td>
                                <label for="comentario"><h3>Comentario: </h3></label></td>
                            <td colspan="3"><input type="text" name="comentario" maxlength="255" id="comentario" placeholder="Máximo de 255 caracteres" required style="width:600px;"></td>
                    </tr>
                    <tr><td colspan="2"></td>
                        <td><input type="submit" value="Enviar" name="submit_res" style="width:150px"></td>
                        <td><input type="reset" value="Limpar" style="width:150px;"></td>
                    <input type="hidden" id="fk" name="fk" value="<?php echo htmlspecialchars($rs->id_comentario); ?>">
                    </tr>
                    </table></form>
                </br>
                <header></br></header>
                <hr>
                <?php
                }
            } else {
                echo "<br><b>Erro: Não conseguiu recupaerar os dados do Banco de Dados!</b><br>";
        }} catch (PDOException $erro) {
            echo "Erro: ".$erro->getMessage();
        }?>
        <!-- Botão que invoca modal de cadastro de comentario: -->
        <h2><b>Fazer novo comentário</b></h2>
        
        </div>
        <br>
        <!-- formulario de Comentario padrão (Faz a mesma coisa que o de cima): -->
        <form action="" method="post">
            <table>
                <tr><td><label for="pessoa"><h3>Nome: </h3></label></td>
                    <td colspan="3"><input type="text" name="pessoa" id="pessoa" maxlength="30" pattern="[a-zA-Z0-9]+" required placeholder="Apenas caracteres alfanuméricos" required style="width:600px;"></td>
            </tr>
            <tr>
                <td><h3><label for="comentario"><h3>Comentario: </h3></label></h3></td>
            <td colspan="3"><input type="text" name="comentario" id="comentario" maxlength="255" placeholder="Máximo de 255 caracteres" required style="width:600px;"></td>
            </tr>
            <tr><td colspan="2"></td>
                <td><input type="submit" value="Enviar" name="submit_cmt" style="width:150px;"></td>
                <td><input type="reset" value="Limpar" style="width:150px;"></td>
            </tr>
            </table>
        </form>
        <hr>
    </body>
</html>