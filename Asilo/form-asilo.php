<?php
session_start();
$pagina = "form-asilo";
// inclui o arquivo de inicialição:
require_once '../init.php';
// Verifica se o usuário está¡ logado:
require '../logincheck.php';
if($_SESSION['user_adm'] != 0){
    header('Location: form-login.php');
} ?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Gerenciar Asilo - VivAsilo</title>
        <style>
            .mid{
                text-align:center;
            }
            .tam{
                width: 200px;
            }
            td{
                text-align: right;
            }
        </style>
    </head>
    <body>
        <?php 
        // Include da NavBar
        include '../navbar.php';?>
        <?php if($_SESSION['user_adm'] == 0){ 
            // Verificar se foi enviando dados via POST
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $id = (isset($_POST["id"]) && $_POST["id"] != null) ? $_POST["id"] : "";
                $nome = (isset($_POST["nome"]) && $_POST["nome"] != null) ? $_POST["nome"] : "";
                $endereco = (isset($_POST["endereco"]) && $_POST["endereco"] != null) ? $_POST["endereco"] : "";
                $cnpj = (isset($_POST["cnpj"]) && $_POST["cnpj"] != null) ? $_POST["cnpj"] : "";
                $telefone = (isset($_POST["telefone"]) && $_POST["telefone"] != null) ? $_POST["telefone"] : "";
                $cidade = (isset($_POST["cidade"]) && $_POST["cidade"] != null) ? $_POST["cidade"] : "";
                $desc = (isset($_POST["desc"]) && $_POST["desc"] != null) ? $_POST["desc"] : "";
                $neces = (isset($_POST["neces"]) && $_POST["neces"] != null) ? $_POST["neces"] : "";
                $mensal = (isset($_POST["mensal"]) && $_POST["mensal"] != null) ? $_POST["mensal"] : "";
                $categoria = (isset($_POST["categoria"]) && $_POST["categoria"] != null) ? $_POST["categoria"] : "";
                $site = (isset($_POST["site"]) && $_POST["site"] != null) ? $_POST["site"] : "";

            } else if (!isset($id)) {
                // Se não se não foi setado nenhum valor para variável $id
                $id = (isset($_GET["id"]) && $_GET["id"] != null) ? $_GET["id"] : "";
                $nome = NULL;
                $endereco = NULL;
                $cnpj = NULL;
                $telefone = NULL;
                $cidade = NULL;
                $desc = NULL;
                $neces = NULL;
                $mensal = NULL;
                $categoria = NULL;
                $site = NULL;
            }
            // Ação: cadastrar:
            if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" && $nome != ""){
                $pdo = db_connect();
                try {
                    if ($id != "") {
                        $stmt = $pdo->prepare("UPDATE tb_asilo SET asilo_nm = ?, asilo_endereco = ?, asilo_cnpj = ?, asilo_telefone = ?, asilo_cidade_fk = ?, asilo_ds = ?, asilo_necessidade = ?, asilo_mensalidade = ?, asilo_tipo_fk = ?, asilo_siteurl = ? WHERE asilo_id = ?");
                        $stmt->bindParam(11, $id);
                    } else {
                        $stmt = $pdo->prepare("INSERT INTO tb_asilo (`asilo_nm`, `asilo_endereco`, `asilo_cnpj`, `asilo_telefone`, `asilo_cidade_fk`, `asilo_ds`, `asilo_necessidade`, `asilo_mensalidade`, `asilo_tipo_fk`, `asilo_siteurl`, `asilo_mantenedor_fk`, `asilo_status`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)");
                        $stmt->bindParam(11, $_SESSION['user_id']);
                    }
                    $stmt->bindParam(1, $nome);
                    $stmt->bindParam(2, $endereco);
                    $stmt->bindParam(3, $cnpj);
                    $stmt->bindParam(4, $telefone);
                    $stmt->bindParam(5, $cidade);
                    $stmt->bindParam(6, $desc);
                    $stmt->bindParam(7, $neces);
                    $stmt->bindParam(8, $mensal);
                    $stmt->bindParam(9, $categoria);
                    $stmt->bindParam(10, $site);
                    if ($stmt->execute()) {
                        if ($stmt->rowCount() > 0) {
                            ?> <center> <h3 style="background-color:#A9F5A9;"> Dados do Asilo cadastrado com sucesso! </h3> </center>
                                <?php
                            $nome = NULL;
                            $endereco = NULL;
                            $cnpj = NULL;
                            $telefone = NULL;
                            $cidade = NULL;
                            $desc = NULL;
                            $neces = NULL;
                            $mensal = NULL;
                            $categoria = NULL;
                            $site = NULL;
                        } else {
                            ?> <center> <h3 style="background-color:#F78181;"> Erro no cadastro! Tente Novamente.</h3> </center>
                            <?php
                        }} else {
                            throw new PDOException("Erro: Não conseguiu executar a declaração SQL!");
                        }} catch (PDOException $erro) {
                            echo "Erro: " . $erro->getMessage();
                        }                       
            }
        }
        // Ação: Alterar:
        if (asilocheck($_SESSION['user_id']) == true) {
            $pdo = db_connect();
            try {
                $stmt = $pdo->prepare("SELECT * FROM tb_asilo WHERE asilo_mantenedor_fk = ?");
                $stmt->bindParam(1, $_SESSION['user_id'], PDO::PARAM_INT);
                if ($stmt->execute()) {
                    $rs = $stmt->fetch(PDO::FETCH_OBJ);
                    $id = $rs->asilo_id;
                    $nome = $rs->asilo_nm;
                    $endereco = $rs->asilo_endereco;
                    $cnpj = $rs->asilo_cnpj;
                    $telefone = $rs->asilo_telefone;
                    $cidade = $rs->asilo_cidade_fk;
                    $desc = $rs->asilo_ds;
                    $neces = $rs->asilo_necessidade;
                    $mensal = $rs->asilo_mensalidade;
                    $categoria = $rs->asilo_tipo_fk;
                    $site = $rs->asilo_siteurl;
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
                $stmt = $pdo->prepare("DELETE FROM tb_asilo WHERE asilo_id = ?");
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
    <p class="nome">Cadastrar Asilo</p>
    <div class="container">
        <div class="row">
            <div class="col-12 comens verd">
                    <form action="?act=save" method="POST" name="form1" >
                        <center>
                        <input type="hidden" name="id" <?php
                        // Preenche o id no campo id com um valor "value"
                        if (isset($id) && $id != null || $id != "") {
                            echo "value=\"{$id}\"";
                        }?> />
                        <!-- Nome -->
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="nome"><h4>Nome:</h4></label><br>
                                <input type="text" name="nome" maxlength="30" style="width:60%;" class="form-control input-lg" <?php
                                // Preenche o nome no campo nome com um valor "value"
                                if (isset($nome) && $nome != null || $nome != ""){
                                    echo "value=\"{$nome}\"";
                                }?> />
                            </div>
                        </div>
                        <!-- Endereço -->
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="endereco"><h4>Endereço:</h4></label><br>
                                <input type="text" name="endereco" maxlength="50" style="width:60%;"  class="form-control input-lg"<?php
                                // Preenche o endereço no campo endereço com um valor "value"
                                if (isset($endereco) && $endereco != null || $endereco != ""){
                                    echo "value=\"{$endereco}\"";
                                }?> />
                            </div>
                        </div>
                        <!-- CNPJ -->
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="cnpj"><h4>CNPJ:</h4></label><br>
                                <center><input type="number" name="cnpj" maxlength="14" minlength="14" style="width:60%;"  class="form-control input-lg" <?php
                                // Preenche o cnpj no campo cnpj com um valor "value"
                                if (isset($cnpj) && $cnpj != null || $cnpj != ""){
                                    echo "value=\"{$cnpj}\"";
                                }?> /></center>
                            </div>
                        </div>
                        <!-- Telefone -->
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="telefone"><h4>Telefone:</h4></label><br>
                                <input type="text" name="telefone" style="width:60%;"  class="form-control input-lg" <?php
                                // Preenche o telefone no campo telefone com um valor "value"
                                if (isset($telefone) && $telefone != null || $telefone != ""){
                                    echo "value=\"{$telefone}\"";
                                }?> />
                            </div>
                        </div>
                        <!-- Cidade -->    
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="cidade"><h4>Cidade:</h4></label><br>
                                <?php try {
                                    // Bloco que realiza o papel do Read - recupera os dados e apresenta na tela
                                    $pdo = db_connect();
                                    $stmt = $pdo->prepare("SELECT cidade_id, cidade_nm FROM tb_cidade");
                                    $stmt->execute();
                                    if ($stmt->execute()) { ?>
                                        <select name="cidade">
                                                <?php if($cidade != '*'): ?>
                                                    <option value="<?=$cidade;?>"><?=optionname($optiontype = 'cidade', $cidade);?></option>
                                                    <option value="*">Todas</option>
                                                <?php else: ?>
                                                    <option value="*">Todas</option>
                                                <?php endif;
                                                while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                                                    if($rs->cidade_id != $cidade): ?>
                                                        <option value="<?=$rs->cidade_id?>" style="width:60%;"  class="form-control input-lg"><?=$rs->cidade_nm?></option>
                                                    <?php endif;
                                    }} else {
                                        echo "Erro: Não conseguiu recupaerar os dados do Banco de Dados!";
                                    }} catch (PDOException $erro) {
                                        echo "Erro: ".$erro->getMessage();
                                    }?>
                                        </select>
                            </div>
                        </div>
                        <!-- Descrição -->
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="desc"><h4>Breve Descrição:</h4></label><br>
                                <input type="text" name="desc" style="width:60%;"  class="form-control input-lg" <?php
                                // Preenche a breve descrição no campo desc com um valor "value"
                                if (isset($desc) && $desc != null || $desc != ""){
                                    echo "value=\"{$desc}\"";
                                } ?> />
                            </div>
                        </div>
                        <!-- Necessidade -->
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="neces"><h4>Necessidades:</h4></label><br>
                                <input type="text" name="neces" style="width:60%;"  class="form-control input-lg" <?php
                                // Preenche a Nescessidades no campo nesces com um valor "value"
                                if (isset($neces) && $neces != null || $neces != ""){
                                    echo "value=\"{$neces}\"";
                                }?> />
                            </div>
                        </div>
                        <!-- Valor da Mensalidade -->
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="mensal"><h4>Valor da Mensalidade:</h4></label><br>
                                <center><input type="number" name="mensal" maxlength="6" style="width:60%;" class="form-control input-lg" <?php
                                // Preenche a mensalide no campo mensal com um valor "value"
                                if (isset($mensal) && $mensal != null || $mensal != ""){
                                    echo "value=\"{$mensal}\"";
                                }?> /></center>
                            </div>
                        </div>
                        <!-- Categoria -->    
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="categoria"><h4>Categoria:</h4></label><br>
                                <?php try {
                                    // Bloco que realiza o papel do Read - recupera os dados e apresenta na tela
                                    $pdo = db_connect();
                                    $stmt2 = $pdo->prepare("SELECT tipo_id, tipo_nm FROM tb_tipo");
                                    $stmt2->execute();
                                    if ($stmt2->execute()) { ?>
                                        <select name="categoria">
                                                <?php if($categoria != '*'): ?>
                                                    <option value="<?=$categoria;?>"><?=optionname($optiontype = 'categoria', $categoria);?></option>
                                                    <option value="*">Todas</option>
                                                <?php else: ?>
                                                    <option value="*">Todas</option>
                                                <?php endif;
                                                while ($rs = $stmt2->fetch(PDO::FETCH_OBJ)) {
                                                    if($rs->tipo_id != $categoria): ?>
                                                        <option value="<?=$rs->tipo_id?>" style="width:60%;"  class="form-control input-lg"><?=$rs->tipo_nm?></option>
                                                    <?php endif;
                                    }} else {
                                        echo "Erro: Não conseguiu recupaerar os dados do Banco de Dados!";
                                    }} catch (PDOException $erro) {
                                        echo "Erro: ".$erro->getMessage();
                                    }?>
                                        </select>
                            </div>
                        </div>
                        <!-- Site -->
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="site"><h4>Site Oficial:</h4></label><br>
                                <input type="text" name="site" style="width:60%;"  class="form-control input-lg" <?php
                                // Preenche a breve descrição no campo desc com um valor "value"
                                if (isset($site) && $site != null || $site != ""){
                                    echo "value=\"{$site}\"";
                                } ?> />
                            </div>
                        </div></br>
                        
                        <table>    
                        <tr>
                            <td><input type="submit" value="SALVAR" style="width:160px;" class="form-control input-lg"/></td>
                            <td><input type="reset" value="RESETAR" style="width:160px;" class="form-control input-lg"/></td></tr></table></center>
                    </form>
            </div></div></div>
    </body>
</html>