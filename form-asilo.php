<?php
session_start();
// inclui o arquivo de inicialição:
require_once 'init.php';
// Verifica se o usuário está¡ logado:
require 'logincheck.php';
if($_SESSION['administrador'] != 0){
    header('Location: form-login.php');
} ?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Gerenciar Asilo - VivAsilo</title>
    </head>
    <style>
        table,tr,th,td{
            border: 1px solid black;
        }
    </style>
    <body>
        <?php 
        // Include da NavBar
        include 'navbar.php';?>
        <p><a href="painel.php"> Volta para o Painel</a></p><br/>
        <?php if($_SESSION['administrador'] == 0){ 
        // Verificar se foi enviando dados via POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = (isset($_POST["id"]) && $_POST["id"] != null) ? $_POST["id"] : "";
            $nome = (isset($_POST["nome"]) && $_POST["nome"] != null) ? $_POST["nome"] : "";
            $endereco = (isset($_POST["endereco"]) && $_POST["endereco"] != null) ? $_POST["endereco"] : "";
            $cnpj = (isset($_POST["cnpj"]) && $_POST["cnpj"] != null) ? $_POST["cnpj"] : "";
            $telefone = (isset($_POST["telefone"]) && $_POST["telefone"] != null) ? $_POST["telefone"] : "";
            $site = (isset($_POST["site"]) && $_POST["site"] != null) ? $_POST["site"] : "";
            $contabanco = (isset($_POST["contabanco"]) && $_POST["contabanco"] != null) ? $_POST["contabanco"] : "";
            $foto = (isset($_POST["foto"]) && $_POST["foto"] != null) ? $_POST["foto"] : "";
            $desc = (isset($_POST["desc"]) && $_POST["desc"] != null) ? $_POST["desc"] : "";
            $neces = (isset($_POST["neces"]) && $_POST["neces"] != null) ? $_POST["neces"] : "";

        } else if (!isset($id)) {
            // Se não se não foi setado nenhum valor para variável $id
            $id = (isset($_GET["id"]) && $_GET["id"] != null) ? $_GET["id"] : "";
            $nome = NULL;
            $endereco = NULL;
            $cnpj = NULL;
            $telefone = NULL;
            $site = NULL;
            $contabanco = NULL;
            $foto = NULL;
            $desc = NULL;
            $neces = NULL;
        }
        // Ação: cadastrar:
        if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" && $nome != ""){
            $pdo = db_connect();
            try {
                if ($id != "") {
                    $stmt = $pdo->prepare("UPDATE tb_asilo SET nome_asilo = ?, endereco_asilo = ?, cnpj_asilo = ?, tel_asilo = ?, site_asilo = ?, dbanco_asilo = ?, foto_asilo = ?, desc_asilo = ?, neces_asilo = ? WHERE id_asilo = ?");
                    $stmt->bindParam(10, $id);
                } else {
                    $stmt = $pdo->prepare("INSERT INTO tb_asilo (`nome_asilo`, `endereco_asilo`, `cnpj_asilo`, `tel_asilo`, `site_asilo`, `dbanco_asilo`, `foto_asilo`, `desc_asilo`, `neces_asilo`, `fk_id`, `status_asilo`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)");
                    $stmt->bindParam(10, $_SESSION['id_usuario']);
                }
                $stmt->bindParam(1, $nome);
                $stmt->bindParam(2, $endereco);
                $stmt->bindParam(3, $cnpj);
                $stmt->bindParam(4, $telefone);
                $stmt->bindParam(5, $site);
                $stmt->bindParam(6, $contabanco);
                $stmt->bindParam(7, $foto);
                $stmt->bindParam(8, $desc);
                $stmt->bindParam(9, $neces);
                if ($stmt->execute()) {
                    if ($stmt->rowCount() > 0) {
                        echo "Asilo cadastrado com sucesso!";
                        $nome = NULL;
                        $endereco = NULL;
                        $cnpj = NULL;
                        $telefone = NULL;
                        $site = NULL;
                        $contabanco = NULL;
                        $foto = NULL;
                        $desc = NULL;
                        $neces = NULL;
                    } else {
                        echo "Deu erro no cadastro!";
                    }} else {
                        throw new PDOException("Erro: Não conseguiu executar a declaração SQL!");
                    }} catch (PDOException $erro) {
                        echo "Erro: " . $erro->getMessage();
                    }}
                    }
                    // Ação: Alterar:
                    if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id != "") {
                        $pdo = db_connect();
                        try {
                            $stmt = $pdo->prepare("SELECT * FROM tb_asilo WHERE id_asilo = ?");
                            $stmt->bindParam(1, $id, PDO::PARAM_INT);
                        if ($stmt->execute()) {
                            $rs = $stmt->fetch(PDO::FETCH_OBJ);
                            $id = $rs->id_asilo;
                            $nome = $rs->nome_asilo;
                            $endereco = $rs->endereco_asilo;
                            $cnpj = $rs->cnpj_asilo;
                            $telefone = $rs->tel_asilo;
                            $site = $rs->site_asilo;
                            $contabanco = $rs->dbanco_asilo;
                            $foto = $rs->foto_asilo;
                            $desc = $rs->desc_asilo;
                            $neces = $rs->neces_asilo;
                        } else {
                            throw new PDOException("Erro: Não conseguiu executar a declaração SQL!");
                        }} catch (PDOException $erro) {
                            echo "Erro: ".$erro->getMessage();
                        }
                    }
                    // Ação: Deletar:
                    if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $id != "") {
                        $pdo = db_connect();
                        try {
                            $stmt = $pdo->prepare("DELETE FROM tb_asilo WHERE id_asilo = ?");
                            $stmt->bindParam(1, $id, PDO::PARAM_INT);
                            if ($stmt->execute()) {
                                echo "Asilo deletado com sucesso!";
                                $id = null;
                            } else {
                                throw new PDOException("Erro: Não conseguiu executar a declaração SQL!");
                            }} catch (PDOException $erro) {
                                echo "Erro: ".$erro->getMessage();
                            }
                    }?>
                    <form action="?act=save" method="POST" name="form1" >
                        <h1>Cadastrar Asilo</h1>
                        <input type="hidden" name="id" <?php
                        // Preenche o id no campo id com um valor "value"
                        if (isset($id) && $id != null || $id != "") {
                            echo "value=\"{$id}\"";
                        }?> />
                        Nome: <input type="text" name="nome" <?php
                        // Preenche o nome no campo nome com um valor "value"
                        if (isset($nome) && $nome != null || $nome != ""){
                            echo "value=\"{$nome}\"";
                        }?> />
                        Endereço: <input type="text" name="endereco" <?php
                        // Preenche o endereço no campo endereço com um valor "value"
                        if (isset($endereco) && $endereco != null || $endereco != ""){
                            echo "value=\"{$endereco}\"";
                        }?> />
                        CNPJ: <input type="text" name="cnpj" <?php
                        // Preenche o cnpj no campo cnpj com um valor "value"
                        if (isset($cnpj) && $cnpj != null || $cnpj != ""){
                            echo "value=\"{$cnpj}\"";
                        }?> />
                        Telefone: <input type="text" name="telefone" <?php
                        // Preenche o telefone no campo telefone com um valor "value"
                        if (isset($telefone) && $telefone != null || $telefone != ""){
                            echo "value=\"{$telefone}\"";
                        }?> />
                        Site: <input type="text" name="site" <?php
                        // Preenche o site no campo site com um valor "value"
                        if (isset($site) && $site != null || $site != ""){
                            echo "value=\"{$site}\"";
                        }?> />
                        Conta Bancaria: <input type="text" name="contabanco" <?php
                        // Preenche a conta bancaria no campo conta bancaria com um valor "value"
                        if (isset($contabanco) && $contabanco != null || $contabanco != ""){
                            echo "value=\"{$contabanco}\"";
                        }?> />
                        URL da Foto: <input type="url" name="foto" <?php
                        // Preenche a URL da Foto no campo URL das Foto com um valor "value"
                        if (isset($foto) && $foto != null || $foto != ""){
                            echo "value=\"{$foto}\"";
                        }?> />
                        Breve Descrição: <input type="text" name="desc" <?php
                        // Preenche a breve descrição no campo desc com um valor "value"
                        if (isset($desc) && $desc != null || $desc != ""){
                            echo "value=\"{$desc}\"";
                        }?> />
                        Nescessidades: <input type="text" name="neces" <?php
                        // Preenche a Nescessidades no campo nesces com um valor "value"
                        if (isset($neces) && $neces != null || $neces != ""){
                            echo "value=\"{$neces}\"";
                        }?> />                        
                        <br>
                        <input type="submit" value="Salvar"/>
                        <input type="reset" value="Resetar"/>
                    </form>
                    </b><h2>Meus Asilos:</h2>
                    <table border="1" width="100%">
                        <tr>
                            <th>Foto</th>
                            <th>Nome</th>
                            <th>Status</th>
                            <th>Ação</th>
                        </tr>
                        <?php try {
                        // Bloco que realiza o papel do Read - recupera os dados e apresenta na tela
                        $pdo = db_connect();
                        $stmt = $pdo->prepare("SELECT id_asilo, nome_asilo, status_asilo, foto_asilo FROM tb_asilo WHERE fk_id = :id");
                        $stmt->execute(array(':id' => $_SESSION['id_usuario']));
 
                        if ($stmt->execute()) {
                            while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                                echo "<tr>";
                                echo "<td>".$rs->foto_asilo."</td><td>".$rs->nome_asilo."</td><td>".$rs->status_asilo
                                ."</td><td><center><a href=\"?act=upd&id=" . $rs->id_asilo. "\">[Alterar]</a>"
                                ."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
                                ."<a href=\"?act=del&id=" . $rs->id_asilo. "\">[Deletar]</a></center></td>";
                                echo "</tr>";
                                }} else {
                                    echo "Erro: Não conseguiu recupaerar os dados do Banco de Dados!";
                                }} catch (PDOException $erro) {
                                    echo "Erro: ".$erro->getMessage();
                                }?>
                    </table>
    </body>
</html>