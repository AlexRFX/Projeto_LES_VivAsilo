<?php
session_start();
$pagina = "admpainel_category";
// inclui o arquivo de inicialição:
require_once '../init.php';
/* Recebe o número da página via parâmetro na URL */  
$pagina_atual = (isset($_GET['page']) && is_numeric($_GET['page'])) ? $_GET['page'] : 1;   
/* Calcula a linha inicial da consulta */  
$linha_inicial = ($pagina_atual -1) * QTDE_REGISTROS;
// Verifica se o usuário está logado:
require '../logincheck.php';
if($_SESSION['user_adm'] != 1){
    if($pagina == "index"):
        header('Location: ../Login/form-login.php');
    else:
        header('Location: Login/form-login.php');
    endif;
} ?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Painel do ADM - VivAsilo</title>
    </head>
    <style>
        table,tr,th,td.tamb{
            text-align: center;
        }
    </style>
    <body>
        <?php 
        // Include da NavBar
        include '../navbar.php';?>
        <p class="nome">Painel de Controle</p>
        <?php if($_SESSION['user_adm'] == 1){ 
        // Verificar se foi enviando dados via POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = (isset($_POST["id"]) && $_POST["id"] != null) ? $_POST["id"] : "";
            $nome = (isset($_POST["nome"]) && $_POST["nome"] != null) ? $_POST["nome"] : "";
            $desc = (isset($_POST["desc"]) && $_POST["desc"] != null) ? $_POST["desc"] : "";
        } else if (!isset($id)) {
            // Se não se não foi setado nenhum valor para variável $id
            $id = (isset($_GET["id"]) && $_GET["id"] != null) ? $_GET["id"] : "";
            $nome = NULL;
            $desc = NULL;
        }
        // Ação: cadastrar:
        if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" && $nome != ""){
            $pdo = db_connect();
            try {
                if ($id != "") {
                    $stmt = $pdo->prepare("UPDATE tb_tipo SET tipo_nm = ?, tipo_ds = ? WHERE tipo_id = ?");
                    $stmt->bindParam(3, $id);
                } else {
                    $stmt = $pdo->prepare("INSERT INTO tb_tipo (`tipo_nm`, `tipo_ds`) VALUES (?, ?)");
                }
                $stmt->bindParam(1, $nome);
                $stmt->bindParam(2, $desc);
                if ($stmt->execute()) {
                    if ($stmt->rowCount() > 0) {?>
                        <center><h4 class="bg-success">Categoria cadastrada com sucesso!</h4></center>
                        <?php
                        $id = null;
                        $nome = null;
                        $desc = null;
                    } else {?>
                        <center><h4 class="bg-danger">Deu erro no cadastro!</h4></center>
                        <?php
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
                            $stmt = $pdo->prepare("SELECT * FROM tb_tipo WHERE tipo_id = ?");
                            $stmt->bindParam(1, $id, PDO::PARAM_INT);
                        if ($stmt->execute()) {
                            $rs = $stmt->fetch(PDO::FETCH_OBJ);
                            $id = $rs->tipo_id;
                            $nome = $rs->tipo_nm;
                            $desc = $rs->tipo_ds;
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
                            $stmt = $pdo->prepare("DELETE FROM tb_tipo WHERE tipo_id  = ?");
                            $stmt->bindParam(1, $id, PDO::PARAM_INT);
                            if ($stmt->execute()) {?>
                                <h4 class="bg-success">Categoria deletada com sucesso!</h4>
                                <?php $id = null;
                            } else {
                                throw new PDOException("Erro: Não conseguiu executar a declaração SQL!");
                            }} catch (PDOException $erro) {
                                echo "Erro: ".$erro->getMessage();
                            }
                    }?>
        <div class="container">
            <div class="row">
                <div class="col-12 comens">
                    <h2 class="fonte2">Opções:</h2></br>
                    <form action="admpainel_user.php" name="formB1" >
                        <input type="submit" value="Gerenciar Usuários" class="form-control input-lg"/>
                    </form>
                    <form action="admpainel_city.php" name="formB2" >
                        <input type="submit" value="Gerenciar Cidades" class="form-control input-lg"/>
                    </form>
                    <?php if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "newcategory"): 
                    else: ?>
                        <form action="?act=newcategory" method="POST" name="formB3" >
                            <input type="submit" value="Cadastrar Categoria" class="form-control input-lg"/>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div> 
        <?php if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id != "") { ?>
            <div class="container">
                <div class="row">
                    <div class="col-12 comens">
                        <form action="?act=save" method="POST" name="form1" >
                            <h2 class="fonte2">Alterar Informações da Categoria:</h2>
                            <input type="hidden" name="id" <?php
                            // Preenche o id no campo id com um valor "value"
                            if (isset($id) && $id != null || $id != "") {
                                echo "value=\"{$id}\"";
                            }?> />
                            <center>
                                <table style="border:0px;">
                                    <tr>
                                    <tr><td colspan="3"><p class="fonte2">Nome</p><input type="text" name="nome" class="form-control input-lg" style="width:500px;" <?php
                                    // Preenche o nome no campo nome com um valor "value"
                                    if (isset($nome) && $nome != null || $nome != ""){
                                    echo "value=\"{$nome}\"";
                                    }?> /></td></tr>
                                    <tr>
                                        <td colspan="3"><p class="fonte2">Descrição</p><input type="text" name="desc" class="form-control input-lg"<?php
                                        // Preenche o email no campo email com um valor "value"
                                        if (isset($desc) && $desc != null || $desc != ""){
                                            echo "value=\"{$desc}\"";
                                            }?> />
                                        </td>
                                    </tr>
                                <tr>
                                    <td></td>
                                    <td><input type="submit" value="Salvar" class="form-control input-lg"/></td>
                                    <td><input type="reset" value="Resetar" class="form-control input-lg"/></td>
                                </tr>
                                </table>
                            </center>
                        </form>
                    </div>
                </div>
            </div> 
            <?php }
            if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "newcategory") { 
                $id = null;
                $nome = null;
                $desc = null;
                ?>
                <div class="container">
                    <div class="row">
                        <div class="col-12 comens">
                            <form action="?act=save" method="POST" name="form1" >
                                <h2 class="fonte2">Cadastrar Categoria:</h2>
                                <input type="hidden" name="id" <?php
                                // Preenche o id no campo id com um valor "value"
                                if (isset($id) && $id != null || $id != "") {
                                    echo "value=\"{$id}\"";
                                }?> />
                                <center>
                                    <table style="border:0px;">
                                        <tr>
                                        <tr><td colspan="3"><p class="fonte2">Nome</p><input type="text" name="nome" class="form-control input-lg" style="width:500px;" <?php
                                        // Preenche o nome no campo nome com um valor "value"
                                        if (isset($nome) && $nome != null || $nome != ""){
                                            echo "value=\"{$nome}\"";
                                        }?> /></td></tr>
                                        <tr>
                                        <td colspan="3"><p class="fonte2">Descrição</p><input type="text" name="desc" class="form-control input-lg"<?php
                                        // Preenche o email no campo email com um valor "value"
                                        if (isset($edesc) && $desc != null || $desc != ""){
                                            echo "value=\"{$desc}\"";
                                            }?> />
                                        </td>
                                    </tr>
                                <tr>
                                    <td></td>
                                    <td><input type="submit" value="Salvar" class="form-control input-lg"/></td>
                                    <td><input type="reset" value="Resetar" class="form-control input-lg"/></td>
                                </tr>
                                </table>
                            </center>
                        </form>
                    </div>
                </div>
            </div> <?php } ?>
                <p class="nome">Lista de Categorias:</p>
                <div class="container">
                    <div class="row">
                        <div class='col-12 comens'>
                            <table width='100%' >
                                <tr>
                                    <th><center>Nome</center></th>
                                    <th><center>Descrição</center></th>
                                    <th><center>Ação</center></th>
                                </tr>
                                <?php
                                /* Cria uma conexão PDO com MySQL */  
                                $pdo = db_connect();
                                try {
                                    /* Instrução de consulta para paginação com MySQL */  
                                    $sql = "SELECT tipo_id, tipo_nm, tipo_ds FROM tb_tipo LIMIT {$linha_inicial}, " . QTDE_REGISTROS;  
                                    $stm = $pdo->prepare($sql);   
                                    $stm->execute();   
                                    $dados = $stm->fetchAll(PDO::FETCH_OBJ);   
   
                                    /* Conta quantos registos existem na tabela */  
                                    $sqlCount = "SELECT COUNT(tipo_id) AS total_registros FROM tb_tipo";   
                                    $stmCount = $pdo->prepare($sqlCount);   
                                    $stmCount->execute();   
                                    $valor = $stmCount->fetch(PDO::FETCH_OBJ);
                                    
                                    // Variaveis, e funções de controle da paginação
                                    require '../pagination.php';
 
                                    foreach($dados as $rs): ?>
                                            <tr><?php
                                            echo "<td>".$rs->tipo_nm."</td><td>".$rs->tipo_ds."</td>"?>
                                            <td>
                                                <center>
                                                    <a href=?act=upd&id=<?=$rs->tipo_id;?>><button type="button" class="btn btn-outline-secondary">[Alterar]</button></a>
                                                    <a href=?act=del&id=<?=$rs->tipo_id?>><button type="button" class="btn btn-outline-warning">[Deletar]</button></a>
                                                </center></br>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            </td>
                                    <?php endforeach; ?>
                            </table>
                            <?php
                            // Botões da paginação
                            require '../pagination_buttons.php';                    
                            } catch (PDOException $erro) {
                                echo "Erro: " . $erro->getMessage();
                            } ?>
                        </div>
                    </div>
                </div>
    </body>
</html>