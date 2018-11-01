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
            text-align: center;
        }
    </style>
    <body>
        <?php 
        // Include da NavBar
        include 'navbar.php';?>
        <header>Solicitações</header>
        <?php if($_SESSION['administrador'] == 1){ 
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
                $stmt = $pdo->prepare("INSERT INTO tb_mantenedor (`fk_id`, `tel_mantenedor`, `foto_mantenedor`) VALUES (?, null, null)");
                $stmt->bindParam(1, $id, PDO::PARAM_INT);
                if ($stmt->execute()) {
                    if ($stmt->rowCount() > 0) {
                        echo "Usuario ativado com sucesso!";
                        $id = null;
                    } else {
                        echo "Ocorrou algum erro!";
                    }} else {
                        throw new PDOException("Erro: Não conseguiu executar a declaração SQL!");
                    }} catch (PDOException $erro) {
                        echo "Erro: " . $erro->getMessage();
                    }}
        // Ação: Deletar/Cancelar:
        if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $id != ""){
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
        
        <h2><center><u>Lista de Cadastros Pendentes:</u></center></h2>
        <table border="1" width="100%">
            <tr>
                <th><center>Nome</center></th>
                <th><center>E-mail</center></th>
                <th><center>Ação</center></th>
            </tr>
            <?php try {
                // Bloco que realiza o papel do Read - recupera os dados e apresenta na tela
                $pdo = db_connect();
                $stmt = $pdo->prepare("SELECT * FROM tb_usuario a LEFT JOIN tb_mantenedor b ON a.id_usuario = b.fk_id WHERE b.fk_id IS NULL AND a.administrador = 0");
 
                if ($stmt->execute()) {
                    while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                        echo "<tr>";
                        echo "<td>".$rs->nm_usuario."</td><td>".$rs->email
                        ."</td><td><center><a href=\"?act=acc&id=" . $rs->id_usuario. "\">[Ativar]</a>"
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