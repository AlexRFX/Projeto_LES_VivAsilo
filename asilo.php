<!-- AVISO IMPORTATE: Tive que fazer alterações na tabela "tb_comentario"!
---- É de extrema importancia pegar o arquivo SQL do banco de dados no host 000.webhost!
-->
<?php
//session_start();
// inclui o arquivo de inicializão:
require 'init.php';?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Asilo - VivAsilo</title>
    </head>
    <body>
        <?php 
        // Include da NavBar
        include 'navbar.php';?>
        <header><b>VivAsilo</b></h1></center></header>
        <?php
        // pega o id_asilo da pagina index.php:
        $id = $_GET['id'];
        // conecta com o banco; executa a query; exibe os dados do asilo:
        try {
            $pdo = db_connect();
            $stmt = $pdo->prepare("SELECT * FROM tb_asilo WHERE id_asilo = $id");
            if ($stmt->execute()) {
                $rs = $stmt->fetch(PDO::FETCH_OBJ);
                // exibe na pagina os dados do asilo:
                echo "<br>Foto do Asilo:" .$rs->foto_asilo;
                echo "<br>Nome do Asilo:" .$rs->nome_asilo;
                echo "<br>Endereço do Asilo:" .$rs->endereco_asilo;
                echo "<br>CNPJ do Asilo:" .$rs->cnpj_asilo;
                echo "<br>Telefone do Asilo:" .$rs->tel_asilo;
                echo "<br>Descrição do Asilo:" .$rs->desc_asilo;
                echo "<br>Nescessidades do Asilo:" .$rs->neces_asilo;
                echo "<br>Site do Asilo:" .$rs->site_asilo;
                echo "<br>Conta Bancaria do Asilo:" .$rs->dbanco_asilo;
                echo "<br>Comentarios do Asilo:" .$rs->fk_comentario;
            } else {
                echo "Erro: Não conseguiu recupaerar os dados do Banco de Dados!";
            }} catch (PDOException $erro) {
                echo "Erro: ".$erro->getMessage();
            }?>
        <hr>
        <h2>Comentarios</h2>
        <?php
        try {
            $pdo = db_connect();
            $stmt = $pdo->prepare("SELECT * FROM tb_comentario WHERE fk_asilo = $id ORDER BY id_comentario desc");
            if ($stmt->execute()) {
                // exibe os comentarios do do asilo:
                while ($rs = $stmt->fetch(PDO::FETCH_OBJ)){
                    echo "</hr>".$rs->data_comentario."</br>".$rs->nome_comentario."</br>".$rs->resposta_comentario."<br>"
                        ."<a href=\"?act=res&id=" . $rs->id_comentario. "\">[Responder]</a></br><hr>";
                }
            } else {
                echo "Erro: Não conseguiu recupaerar os dados do Banco de Dados!";
            }} catch (PDOException $erro) {
                echo "Erro: ".$erro->getMessage();
            }?>
        <hr>
        <br>
        <h2>Fazer comentario</h2>
        <?php
        $pessoa = isset($_POST['pessoa']) ? $_POST['pessoa'] : '';
        $data = date("y/m/d");           
        $comentario = isset($_POST['comentario']) ? $_POST['comentario'] : '';
        
        // Envia um comentario somente se receber o parametro nome:
        if(isset($_REQUEST['submit_cmt']) && $id != ""){
            $pdo = db_connect();
            try {
                $stmt = $pdo->prepare("INSERT INTO tb_comentario (`fk_asilo`, `nome_comentario`, `resposta_comentario`, `data_comentario`, `fk_comentario`) VALUES (?, ?, ?, ?, NULL)");
                $stmt->bindParam(1, $id);
                $stmt->bindParam(2, $pessoa);
                $stmt->bindParam(3, $comentario);
                $stmt->bindParam(4, $data);
                if ($stmt->execute()) {
                    if ($stmt->rowCount() > 0) {
                        echo "Comentario realizado com sucesso!";
                        $pessoa = null;
                        $comentario = null;
                        $data = null;
                        echo "<meta http-equiv='refresh' content='3'>";
                    } else {
                        echo "Deu erro no envio!";
                    }
                } else {
                    throw new PDOException("Erro: Não conseguiu executar a declaração SQL!");
                }
            } catch (PDOException $erro) {
                echo "Erro: " . $erro->getMessage();
            }             
        }?>
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
    </body>
</html>