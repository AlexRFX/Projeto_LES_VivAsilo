<?php
session_start();
// inclui o arquivo de inicialição:
require_once 'init.php';
// Verifica se o usuário está¡ logado:
require 'logincheck.php';
if($_SESSION['administrador'] != 1){
    header('Location: form-login.php');
} ?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Painel do ADM - VivAsilo</title>
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
        <h1>Painel de Controle do ADM</h1>
        <p><a href="admpainel.php"> Painel do ADM</a> | <a href="loginout.php"> Logout</a></p><br/>
        <?php if($_SESSION['administrador'] == 1){ 
        // Verificar se foi enviando dados via POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = (isset($_POST["id"]) && $_POST["id"] != null) ? $_POST["id"] : "";
            $nome = (isset($_POST["nome"]) && $_POST["nome"] != null) ? $_POST["nome"] : "";
            $email = (isset($_POST["email"]) && $_POST["email"] != null) ? $_POST["email"] : "";
            $senha = (isset($_POST["senha"]) && $_POST["senha"] != null) ? $_POST["senha"] : NULL;
            $senha = make_hash($senha);
            $telefone = (isset($_POST["telefone"]) && $_POST["telefone"] != null) ? $_POST["telefone"] : "";
        } else if (!isset($id)) {
            // Se não se não foi setado nenhum valor para variável $id
            $id = (isset($_GET["id"]) && $_GET["id"] != null) ? $_GET["id"] : "";
            $nome = NULL;
            $email = NULL;
            $senha = NULL;
            $telefone = NULL;
        }
        // Ação: Deletar/Cancelar:
        if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $id != "") {
            $pdo = db_connect();
            try {
                $stmt = $pdo->prepare("DELETE FROM tb_usuario WHERE id_usuario = ?");
                $stmt->bindParam(1, $id, PDO::PARAM_INT);
                if ($stmt->execute()) {
                    echo "Requisição de cadastro cancelado com sucesso!";
                    $id = null;
                } else {
                    throw new PDOException("Erro: Não conseguiu executar a declaração SQL!");
                }} catch (PDOException $erro) {
                    echo "Erro: ".$erro->getMessage();
                }
            }
        }?>
        
        <h2>Lista de Cadastro Pendente:</h2>
        <table border="1" width="100%">
            <tr>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Ação</th>
            </tr>
            <?php try {
                // Bloco que realiza o papel do Read - recupera os dados e apresenta na tela
                $pdo = db_connect();
                $stmt = $pdo->prepare("SELECT * FROM tb_usuario a, tb_mantenedor b WHERE a.administrador = 0 AND a.id_usuario != b.fk_id");
 
                if ($stmt->execute()) {
                    while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                        echo "<tr>";
                        echo "<td>".$rs->nm_usuario."</td><td>".$rs->email
                        ."</td><td><center><a href=\"?act=upd&id=" . $rs->id_usuario. "\">[Ativar]</a>"
                        ."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
                        ."<a href=\"?act=del&id=" . $rs->id_usuario. "\">[Cancelar]</a></center></td>";
                        echo "</tr>";
                        }} else {
                            echo "Erro: Não conseguiu recupaerar os dados do Banco de Dados!";
                        }} catch (PDOException $erro) {
                            echo "Erro: ".$erro->getMessage();
                        }?>
        </table>
    </body>
</html>