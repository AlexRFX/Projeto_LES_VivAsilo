<!-- AVISO IMPORTATE: Tive que fazer alterações na tabela "tb_comentario"!
---- É de extrema importancia pegar o arquivo SQL do banco de dados no host 000.webhost!
-->
<?php
session_start();
// inclui o arquivo de inicializão:
require 'init.php';?>
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
                        <th rowspan="8">
                    <?php
                echo "<img src=".$rs->foto_asilo.">";
                ?>
                        </th>
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
        <h2>Comentarios</h2>
        <?php
        try {
            $pdo = db_connect();
            $stmt = $pdo->prepare("SELECT * FROM tb_comentario WHERE fk_asilo = $id AND fk_comentario IS NULL ORDER BY id_comentario DESC");
            if ($stmt->execute()) {
                // exibe os comentarios do asilo:
                while ($rs = $stmt->fetch(PDO::FETCH_OBJ)){
                    echo "</hr>Data: ".$rs->data_comentario."</br>".$rs->nome_comentario.", Disse:</br>".$rs->resposta_comentario."<br>";
                        // verifica se o usuario logado é mantenedor do asilo, e libera o botão de excluir comentario:
                        if ((LoggedIn() == true) && (maintaincheck($_SESSION['id_usuario'], $_GET['id']) == true)){?>
                            <form action="" method="post">
                                <input type="submit" value="Censurar" name="censorship_cmt">
                                <input type="hidden" id="cmt" name="cmt" value="<?php echo htmlspecialchars($rs->id_comentario); ?>">
                            </form><?php
                        }
                        echo "</br><hr>";
                        // exibe os as respostas dos comentarios do asilo:
                        $sql = $pdo->prepare("SELECT * FROM tb_comentario WHERE fk_asilo = $id AND fk_comentario = $rs->id_comentario ORDER BY id_comentario ASC");
                        if ($sql->execute()) {
                            // exibe os comentarios do do asilo:
                            while ($sr = $sql->fetch(PDO::FETCH_OBJ)){
                                echo "</hr>Data: ".$sr->data_comentario."</br>".$sr->nome_comentario.", Respondeu:</br>".$sr->resposta_comentario."<br>";
                                // verifica se o usuario logado é mantenedor do asilo, e libera o botão de excluir resposta de comentario:
                                if ((LoggedIn() == true) && (maintaincheck($_SESSION['id_usuario'], $_GET['id']) == true)){?>
                                    <form action="" method="post">
                                        <input type="submit" value="Censurar" name="censorship_cmt">
                                        <input type="hidden" id="cmt" name="cmt" value="<?php echo htmlspecialchars($sr->id_comentario); ?>">
                                    </form><?php 
                                }
                                echo "</br><hr>";
                            }
                        }?>
                    <a onclick="document.getElementById('id71').style.display='block'"><h2>Responder comentario</h2></a>
                    <!-- Formularios resposta de comentario(ID71) (Está bugado:): -->
                    <div id="id71" class="modal"> 
                    <form action="" method="post" class="modal-content animate">
                        <div class="imgcontainer">
                            <span onclick="document.getElementById('id71').style.display='none'" class="close" title="Close Modal">&times;</span>
                        </div>
                        <h2>Responder comentario</h2>
                        <label for="pessoa"><b>Nome:</b></label><br>
                        <input type="text" placeholder="Digite o seu nome" name="pessoa" id="pessoa" required>   
                        <br><br>
                        <label for="comentario"><b>Comentario:</b></label><br>
                        <input type="text" placeholder="Digite o seu comentario" name="comentario" id="comentario" required>
                        <br><br>
                        <button type="submit" name="submit_res">Enviar</button>
                        <input  type="hidden" id="fk" name="fk" value="<?php echo htmlspecialchars($rs->id_comentario); ?>">
                        <button type="reset">Limpar</button>
                        <button type="button" onclick="document.getElementById('id71').style.display='none'" class="cancelbtn">Cancelar</button>    
                    </form>
                </div>
                <br>
                <!-- formulario de Resposta de Comentario padrão (funciona): -->
                <form action="" method="post">
                    <label for="pessoa">Nome: </label><br>
                    <input type="text" name="pessoa" id="pessoa" required>
                    <br><br>
                    <label for="comentario">Comentario: </label><br>
                    <input type="text" name="comentario" id="comentario" required>
                    <br><br>
                    <input type="submit" value="Enviar" name="submit_res">
                    <input type="hidden" id="fk" name="fk" value="<?php echo htmlspecialchars($rs->id_comentario); ?>">
                    <input type=reset value=Limpar>
                </form>
                <hr>
                <?php
                }
            } else {
                echo "<br><b>Erro: Não conseguiu recupaerar os dados do Banco de Dados!</b><br>";
        }} catch (PDOException $erro) {
            echo "Erro: ".$erro->getMessage();
        }?>
        <!-- Botão que invoca modal de cadastro de comentario: -->
        <a onclick="document.getElementById('id70').style.display='block'"><h2>Fazer comentario</h2></a> 
        
        <!-- Formularios de comentario(ID70): -->
        <div id="id70" class="modal"> 
            <form action="" method="post" class="modal-content animate">
                <div class="imgcontainer">
                    <span onclick="document.getElementById('id70').style.display='none'" class="close" title="Close Modal">&times;</span>
                </div>
                <h2>Fazer comentario</h2>
                <label for="pessoa"><b>Nome:</b></label><br>
                <input type="text" placeholder="Digite o seu nome" name="pessoa" id="pessoa" required>   
                <br><br>
                <label for="comentario"><b>Comentario:</b></label><br>
                <input type="text" placeholder="Digite o seu comentario" name="comentario" id="comentario" required>
                <br><br>
                <button type="submit" name="submit_cmt">Enviar</button>
                <button type="reset">Limpar</button>
                <button type="button" onclick="document.getElementById('id70').style.display='none'" class="cancelbtn">Cancelar</button>    
            </form>
        </div>
        <br>
        <!-- formulario de Comentario padrão (Faz a mesma coisa que o de cima): -->
        <form action="" method="post">
            <label for="pessoa">Nome: </label><br>
            <input type="text" name="pessoa" id="pessoa" required>
            <br><br>
            <label for="comentario">Comentario: </label><br>
            <input type="text" name="comentario" id="comentario" required>
            <br><br>
            <input type="submit" value="Enviar" name="submit_cmt">
            <input type=reset value=Limpar>
        </form>
        <hr>
        <script>
            // Invoca modal:
            var modal = document.getElementById('id70') || document.getElementById('id71');

            // Quando clicar em qualquer lugar fora do modal; fecha:
            window.onclick = function(event) {
                if (event.target === modal) {
                    modal.style.display = "none";
                }
            };
        </script>
    </body>
</html>