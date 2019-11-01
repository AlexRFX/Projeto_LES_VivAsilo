<?php
session_start();   
$pagina = "admpainel_user";
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
            $email = (isset($_POST["email"]) && $_POST["email"] != null) ? $_POST["email"] : "";
            $senha = (isset($_POST["senha"]) && $_POST["senha"] != null) ? $_POST["senha"] : NULL;
            $senha = make_hash($senha);
        } else if (!isset($id)) {
            // Se não se não foi setado nenhum valor para variável $id
            $id = (isset($_GET["id"]) && $_GET["id"] != null) ? $_GET["id"] : "";
            $nome = NULL;
            $email = NULL;
            $senha = NULL;
        }
        // Ação: cadastrar:
        if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" && $nome != ""){
            $pdo = db_connect();
            try {
                if ($id != "") {
                    $stmt = $pdo->prepare("UPDATE tb_user SET user_nm = ?, user_email = ?, user_senha = ? WHERE user_id = ?");
                    $stmt->bindParam(4, $id);
                } else {
                    $stmt = $pdo->prepare("INSERT INTO tb_user (`user_nm`, `user_email`, `user_senha`) VALUES (?, ?, ?)");
                }
                $stmt->bindParam(1, $nome);
                $stmt->bindParam(2, $email);
                $stmt->bindParam(3, $senha);
                if ($stmt->execute()) {
                    if ($stmt->rowCount() > 0) {?>
                        <center><h4 class="bg-success">Usuario cadastrado com sucesso!</h4></center>
                        <?php
                        $id = null;
                        $nome = null;
                        $email = null;
                        $senha = null;
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
                            $stmt = $pdo->prepare("SELECT * FROM tb_user WHERE user_id = ?");
                            $stmt->bindParam(1, $id, PDO::PARAM_INT);
                        if ($stmt->execute()) {
                            $rs = $stmt->fetch(PDO::FETCH_OBJ);
                            $id = $rs->user_id;
                            $nome = $rs->user_nm;
                            $email = $rs->user_email;
                            $senha = $rs->user_senha;
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
                            $stmt = $pdo->prepare("DELETE FROM tb_mantenedor WHERE mantenedor_fk  = ?");
                            $stmt->bindParam(1, $id, PDO::PARAM_INT);
                            //$stmt = $pdo->prepare("DELETE FROM tb_usuario WHERE id_usuario = ?");
                            //$stmt->bindParam(1, $id, PDO::PARAM_INT);
                            if ($stmt->execute()) {?>
                                <center><h4 class="bg-success"><b>Usuario deletado com sucesso!</b></h4></center>
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
                    <?php if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "newuser"): 
                    else: ?>
                    <form action="?act=newuser" method="POST" name="formB1" >
                        <input type="submit" value="Registrar Usuário" class="form-control input-lg"/>
                    </form>
                    <?php endif; ?>
                    <form action="admpainel_city.php" name="formB2" >
                        <input type="submit" value="Gerenciar Cidades" class="form-control input-lg"/>
                    </form>
                    <form action="admpainel_category.php" name="formB3" >
                        <input type="submit" value="Gerenciar Categorias" class="form-control input-lg"/>
                    </form>
                </div>
            </div>
        </div> 
        <?php if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id != "") { ?>
            <div class="container">
                <div class="row">
                    <div class="col-12 comens">
                        <form action="?act=save" method="POST" name="form1" >
                            <h2 class="fonte2">Alterar Mantenedor:</h2>
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
                                        <td colspan="3"><p class="fonte2">E-mail</p><input type="text" name="email" class="form-control input-lg"<?php
                                        // Preenche o email no campo email com um valor "value"
                                        if (isset($email) && $email != null || $email != ""){
                                            echo "value=\"{$email}\"";
                                            }?> />
                                        </td>
                                    </tr>
                                <tr><td colspan="3"><p class="fonte2">Senha</p><input type="password" name="senha" class="form-control input-lg" <?php
                                // Preenche a senha no campo password com um valor "value"
                                if (isset($senha) && $senha != null || $senha != ""){
                                    echo "value=\"{$senha}\"";
                                    }?> /> &nbsp;</td></tr>
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
            if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "newuser") { 
                $id = null;
                $nome = null;
                $email = null;
                $senha = null;
                ?>
                <div class="container">
                    <div class="row">
                        <div class="col-12 comens">
                            <form action="?act=save" method="POST" name="form1" >
                                <h2 class="fonte2">Registrar Usuário:</h2>
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
                                        <td colspan="3"><p class="fonte2">E-mail</p><input type="text" name="email" class="form-control input-lg"<?php
                                        // Preenche o email no campo email com um valor "value"
                                        if (isset($email) && $email != null || $email != ""){
                                            echo "value=\"{$email}\"";
                                            }?> />
                                        </td>
                                    </tr>
                                <tr><td colspan="3"><p class="fonte2">Senha</p><input type="password" name="senha" class="form-control input-lg" <?php
                                // Preenche a senha no campo password com um valor "value"
                                if (isset($senha) && $senha != null || $senha != ""){
                                    echo "value=\"{$senha}\"";
                                    }?> /> &nbsp;</td></tr>
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
                <p class="nome">Lista de Mantenedores:</p>
                <div class="container">
                    <div class="row">
                <div class='col-12 comens'>
                    <table width='100%' >
                        <tr>
                            <th><center>Nome</center></th>
                            <th><center>E-mail</center></th>
                            <th><center>Telefone</center></th>
                            <th><center>Foto</center></th>
                            <th><center>Ação</center></th>
                        </tr>
                        <?php
                        /* Cria uma conexão PDO com MySQL */  
                        $pdo = db_connect();
                        try {
                            /* Instrução de consulta para paginação com MySQL */  
                            $sql = "SELECT a.user_id, a.user_nm, a.user_email, b.mantenedor_telefone, b.mantenedor_foto FROM tb_user a, tb_mantenedor b WHERE a.user_id = b.mantenedor_fk LIMIT {$linha_inicial}, " . QTDE_REGISTROS;  
                            $stm = $pdo->prepare($sql);   
                            $stm->execute();   
                            $dados = $stm->fetchAll(PDO::FETCH_OBJ);   
   
                            /* Conta quantos registos existem na tabela */  
                            $sqlCount = "SELECT COUNT(a.user_id) AS total_registros FROM tb_user a, tb_mantenedor b WHERE a.user_id = b.mantenedor_fk";   
                            $stmCount = $pdo->prepare($sqlCount);   
                            $stmCount->execute();   
                            $valor = $stmCount->fetch(PDO::FETCH_OBJ);
                            
                            // Variaveis, e funções de controle da paginação
                            require '../pagination.php';
                                  
                            foreach($dados as $rs): ?>
                                <tr>
                                <?php echo "<td>".$rs->user_nm."</td><td>".$rs->user_email."</td><td>".$rs->mantenedor_telefone."</td>"?>
                                <td><img style="width:25%" src="../imgs/imgsuser/<?php echo $rs->mantenedor_foto; ?>"</img></td>
                                
                                <td>
                                    <center>
                                        <a href=?act=upd&id=<?=$rs->user_id;?>><button type="button" class="btn btn-outline-secondary">[Alterar]</button></a>
                                        
                                        <a href=?act=del&id=<?=$rs->user_id?>><button type="button" class="btn btn-outline-warning">[Deletar]</button></a>
                                    </center>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                </td>
                                </tr>
                                
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