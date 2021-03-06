<?php
session_start();
$pagina = "solicitations";
// inclui o arquivo de inicialição:
require_once '../init.php';
// Verifica se o usuário está¡ logado:
require '../logincheck.php';
if($_SESSION['user_adm'] != 1){
    if($pagina == "index"):
        header('Location: ../Login/form-login.php');
    else:
        header('Location: Login/form-login.php');
    endif;
} 
/* Recebe o número da página via parâmetro na URL */  
$pagina_atual = (isset($_GET['page']) && is_numeric($_GET['page'])) ? $_GET['page'] : 1;   
/* Calcula a linha inicial da consulta */  
$linha_inicial = ($pagina_atual -1) * QTDE_REGISTROS;?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Painel do ADM - VivAsilo</title>
    </head>
    <style>
        table,tr,th,td{
            border: 5px solid;
            text-align: center;
            border-color: #b3ffd9;
        }
    </style>
    <body>
        <?php 
        // Include da NavBar
        include '../navbar.php';?>
        <p class="nome">Solicitações</p>
        <?php if($_SESSION['user_adm'] == 1){ 
        // Verificar se foi enviando dados via POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nome = (isset($_POST["nome"]) && $_POST["nome"] != null) ? $_POST["nome"] : "";
            $_SESSION['nome'] = $nome;
            
            } else {
                $nome = (isset($_SESSION['nome']) && $_SESSION['nome'] != null) ? $_SESSION['nome'] : "";
            }
        // Verificar se foi enviando dados via POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = (isset($_POST["id"]) && $_POST["id"] != null) ? $_POST["id"] : "";
        } else if (!isset($id)) {
            // Se não se não foi setado nenhum valor para variável $id
            $id = (isset($_GET["id"]) && $_GET["id"] != null) ? $_GET["id"] : "";
        }
        // Ação: Aceitar:
        if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "acc" && $id != ""){
            $pdo = db_connect();
            try {
                $stmt = $pdo->prepare("INSERT INTO tb_mantenedor (`mantenedor_fk`, `mantenedor_telefone`) VALUES (?, null)");
                $stmt->bindParam(1, $id, PDO::PARAM_INT);
                if ($stmt->execute()) {
                    if ($stmt->rowCount() > 0) {?>
                        <center><h4 class="bg-success">Usuario ativado com sucesso!</h4></center>
                        <?php $id = null;
                    } else {?>
                        <center><h4 class="bg-danger">Ocorrou algum erro</h4></center>
                    <?php }} else {
                        throw new PDOException("Erro: Não conseguiu executar a declaração SQL!");
                    }} catch (PDOException $erro) {
                        echo "Erro: " . $erro->getMessage();
                    }}
        // Ação: Deletar/Cancelar:
        if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $id != ""){
            $pdo = db_connect();
            try {
                $stmt = $pdo->prepare("DELETE FROM tb_user WHERE user_id = ?");
                $stmt->bindParam(1, $id, PDO::PARAM_INT);
                if ($stmt->execute()) {?>
                    <h4 class="bg-success">Requisição de cadastro cancelada com sucesso!</h4>
                    <?php $id = null;
                } else {
                    throw new PDOException("Erro: Não conseguiu executar a declaração SQL!");
                }} catch (PDOException $erro) {
                    echo "Erro: ".$erro->getMessage();
                }
            }
        }?>
        <div class="container">
            <div class="row">
                <div class="col-12 comens verd">
                    <p class="nome">Procurar Usuário</p>
                    <form action="?act=search" method="POST" name="form0" >
                        <center>
                            <!-- Nome -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <label for="nome"><h4>Nome:</h4></label>
                                    <input type="text" name="nome" maxlength="30" pattern="[a-zA-Z0-9]+" style="width:60%;" class="form-control input-lg" <?php
                                    // Preenche o nome no campo nome com um valor "value"
                                    if (isset($nome) && $nome != null || $nome != ""){
                                        echo "value=\"{$nome}\"";
                                    }?> />
                                </div>
                            </div>
                            <table>    
                                <tr>
                                    <td><input type="submit" value="BUSCAR" style="width:160px;" class="form-control input-lg"/></td>
                                    <td><input type="reset" value="RESETAR" style="width:160px;" class="form-control input-lg"/></td>
                                </tr>
                            </table>
                        </center>
                    </form>
                </div>        
            </div>       
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <table width="100%">
                        <tr>
                            <th><center>Nome</center></th>
                            <th><center>E-mail</center></th>
                            <th><center>Ação</center></th>
                        </tr>
                        <?php try {
                            // Bloco que realiza o papel do Read - recupera os dados e apresenta na tela
                            $pdo = db_connect();
                            $sql = "SELECT a.user_id, a.user_nm, a.user_email FROM tb_user a LEFT JOIN tb_mantenedor b ON a.user_id = b.mantenedor_fk WHERE b.mantenedor_fk IS NULL AND a.user_adm = 0 AND a.user_nm LIKE '%$nome%' LIMIT {$linha_inicial}, " . QTDE_REGISTROS;
                            $stmt = $pdo->prepare($sql);   
                            $stmt->execute();   
                            $dados = $stmt->fetchAll(PDO::FETCH_OBJ);
                            
                            // Conta quantos resultados serão exibidos na tela 
                            $sqlCount = "SELECT COUNT(a.user_id) AS total_registros "
                                            ." FROM tb_user a LEFT JOIN tb_mantenedor b ON a.user_id = b.mantenedor_fk WHERE b.mantenedor_fk IS NULL AND a.user_adm = 0 AND a.user_nm LIKE '%$nome%'";                  
                            $stmCount = $pdo->prepare($sqlCount);   
                            $stmCount->execute();   
                            $valor = $stmCount->fetch(PDO::FETCH_OBJ);
                            
                            // Variaveis, e funções de controle da paginação
                            require '../pagination.php';
                            
                            foreach($dados as $rs):
                                echo "<tr>";
                                echo "<td>".$rs->user_nm."</td><td>".$rs->user_email
                                ."</td><td><center><a href=\"?act=acc&id=" . $rs->user_id. "\">[Ativar]</a>"
                                ."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
                                ."<a href=\"?act=del&id=" . $rs->user_id. "\">[Cancelar]</a></center></td>";
                                echo "</tr>";
                            endforeach;
                        
                            // Botões da paginação
                            require '../pagination_buttons.php';
                        } catch (PDOException $erro) {
                            echo "Erro: ".$erro->getMessage();
                        } ?>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>