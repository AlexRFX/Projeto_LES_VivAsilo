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
    <body>
        <?php 
        // Include da NavBar
        include 'navbar.php';?>
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
                                ?> <div style="background-color:#4dff4d;"><b>Asilo deletado com sucesso!</b></div>
                                <?php
                                $id = null;
                            } else {
                                throw new PDOException("Erro: Não conseguiu executar a declaração SQL!");
                            }} catch (PDOException $erro) {
                                echo "Erro: ".$erro->getMessage();
                            }
                    }?>
                    <form action="?act=save" method="POST" name="form1" >
                        <header>Cadastrar Asilo</header>
                        <center><table>
                        <input type="hidden" name="id" <?php
                        // Preenche o id no campo id com um valor "value"
                        if (isset($id) && $id != null || $id != "") {
                            echo "value=\"{$id}\"";
                        }?> />
                        <tr><td><h3>Nome</h3></td>
                            <td></td>
                            <td style="width:20;"></td>
                            <td><h3>Endereço:</h3></td>
                            <td></td>
                            <td style="width:20;"></td>
                            <td><h3>CNPJ:</h3></td>
                            <td></td>
                        </tr>
                        <tr>
                        <td colspan="2"><input type="text" name="nome" <?php
                        // Preenche o nome no campo nome com um valor "value"
                        if (isset($nome) && $nome != null || $nome != ""){
                            echo "value=\"{$nome}\"";
                            }?> /></td>
                        <td style="width:20;"></td>
                        
                        <td colspan="2"><input type="text" name="endereco" style="width:440;"<?php
                        // Preenche o endereço no campo endereço com um valor "value"
                        if (isset($endereco) && $endereco != null || $endereco != ""){
                            echo "value=\"{$endereco}\"";
                            }?> /></td>
                        <td style="width:20;"></td>
                        
                        <td colspan="2"><input type="text" name="cnpj" <?php
                        // Preenche o cnpj no campo cnpj com um valor "value"
                        if (isset($cnpj) && $cnpj != null || $cnpj != ""){
                            echo "value=\"{$cnpj}\"";
                            }?> /></td></tr>
                        <tr><td><h3>Telefone:</h3></td>
                            <td></td>
                            <td style="width:20;"></td>
                            <td><h3>Site:</h3></td>
                            <td></td>
                            <td style="width:20;"></td>
                            <td><h3>Conta Bancaria:</h3></td></tr>
                            <td></td>
                        
                         <tr><td colspan="2"><input type="text" name="telefone" style="width:440;" <?php
                        // Preenche o telefone no campo telefone com um valor "value"
                        if (isset($telefone) && $telefone != null || $telefone != ""){
                            echo "value=\"{$telefone}\"";
                        }?> /></td>
                             <td style="width:20;"></td>
                        <td colspan="2"><input type="text" name="site" <?php
                        // Preenche o site no campo site com um valor "value"
                        if (isset($site) && $site != null || $site != ""){
                            echo "value=\"{$site}\"";
                        }?> /></td>
                        <td style="width:20;"></td>
                        <td colspan="2"><input type="text" name="contabanco" <?php
                        // Preenche a conta bancaria no campo conta bancaria com um valor "value"
                        if (isset($contabanco) && $contabanco != null || $contabanco != ""){
                            echo "value=\"{$contabanco}\"";
                            }?> /></td></tr>
                         <tr><td><h3>URL da Foto:</h3></td>
                             <td></td>
                             <td style="width:20;"></td>
                             <td><h3>Breve Descrição:</h3></td>
                             <td></td>
                             <td style="width:20;"></td>
                             <td><h3>Necessidades:</h3></td></tr>
                         <tr><td colspan="2"><input type="url" name="foto" style="width:440;"<?php
                        // Preenche a URL da Foto no campo URL das Foto com um valor "value"
                        if (isset($foto) && $foto != null || $foto != ""){
                            echo "value=\"{$foto}\"";
                        }?> /></td>
                             <td style="width:20;"></td>
                        <td colspan="2"><input type="text" name="desc" <?php
                        // Preenche a breve descrição no campo desc com um valor "value"
                        if (isset($desc) && $desc != null || $desc != ""){
                            echo "value=\"{$desc}\"";
                        }?> /></td>
                        <td style="width:20;"></td>
                         <td colspan="2"><input type="text" name="neces" <?php
                        // Preenche a Nescessidades no campo nesces com um valor "value"
                        if (isset($neces) && $neces != null || $neces != ""){
                            echo "value=\"{$neces}\"";
                            }?> /></td></tr>                        
                         <tr><td></br></td></tr>
                        <tr><td colspan="6"></td>
                            <td><input type="submit" value="SALVAR" style="width:250;"/></td>
                            <td><input type="reset" value="RESETAR" style="width:250;"/></td></tr></table></center>
                    </form>
                    </b><header>Meus Asilos:</header>
                    <table class="table" border="1" width="100%">
                        <tr>
                            <th>Foto</th>
                            <th>Nome</th>
                            <th>Breve Descrição</th>
                            <th>Ação</th>
                        </tr>
                        <?php try {
                            // Bloco que realiza o papel do Read - recupera os dados e apresenta na tela
                            $pdo = db_connect();
                            $stmt = $pdo->prepare("SELECT id_asilo, nome_asilo, desc_asilo, foto_asilo FROM tb_asilo WHERE fk_id = :id");
                            $stmt->execute(array(':id' => $_SESSION['id_usuario'])); 
                            if ($stmt->execute()) {
                                while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                                    echo "<tr>";
                                    echo "<td><img src=".$rs->foto_asilo."></td><td>".$rs->nome_asilo."</td><td>".$rs->desc_asilo
                                    ."</td><td><center><a href=\"?act=upd&id=" . $rs->id_asilo. "\">[Alterar]</a>"
                                    ."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
                                    ."<a href=\"?act=del&id=" . $rs->id_asilo. "\">[Deletar]</a></center></td>";
                                }} else {
                                    echo "Erro: Não conseguiu recupaerar os dados do Banco de Dados!";
                                }} catch (PDOException $erro) {
                                    echo "Erro: ".$erro->getMessage();
                                }?>
                    </table>
    </body>
</html>