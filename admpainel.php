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
        <p><a href="loginout.php"> Logout</a></p><br/>
        <?php if($_SESSION['administrador'] == 1){ 
        // Verificar se foi enviando dados via POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = (isset($_POST["id"]) && $_POST["id"] != null) ? $_POST["id"] : "";
            $nome = (isset($_POST["nome"]) && $_POST["nome"] != null) ? $_POST["nome"] : "";
            $email = (isset($_POST["email"]) && $_POST["email"] != null) ? $_POST["email"] : "";
            $senha = (isset($_POST["senha"]) && $_POST["senha"] != null) ? $_POST["senha"] : NULL;
            $senha = make_hash($senha);
        } else if (!isset($id)) {
            // Se nÃ£o se não foi setado nenhum valor para variável $id
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
                    $stmt = $pdo->prepare("UPDATE tb_usuario SET nm_usuario = ?, email = ?, senha = ? WHERE id_usuario = ?");
                    $stmt->bindParam(4, $id);
                } else {
                    $stmt = $pdo->prepare("INSERT INTO tb_usuario (`nm_usuario`, `email`, `senha`) VALUES (?, ?, ?)");
                }
                $stmt->bindParam(1, $nome);
                $stmt->bindParam(2, $email);
                $stmt->bindParam(3, $senha);
                if ($stmt->execute()) {
                    if ($stmt->rowCount() > 0) {
                        echo "Usuario cadastrado com sucesso!";
                        $id = null;
                        $nome = null;
                        $email = null;
                        $senha = null;
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
                            $stmt = $pdo->prepare("SELECT * FROM tb_usuario WHERE id_usuario = ?");
                            $stmt->bindParam(1, $id, PDO::PARAM_INT);
                        if ($stmt->execute()) {
                            $rs = $stmt->fetch(PDO::FETCH_OBJ);
                            $id = $rs->id_usuario;
                            $nome = $rs->nm_usuario;
                            $email = $rs->email;
                            $senha = $rs->senha;
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
                            $stmt = $pdo->prepare("DELETE FROM tb_usuario WHERE id_usuario = ?");
                            $stmt->bindParam(1, $id, PDO::PARAM_INT);
                            if ($stmt->execute()) {
                                echo "Usuario deletado com sucesso!";
                                $id = null;
                            } else {
                                throw new PDOException("Erro: Não conseguiu executar a declaração SQL!");
                            }} catch (PDOException $erro) {
                                echo "Erro: ".$erro->getMessage();
                            }
                    }?>
                    <form action="?act=save" method="POST" name="form1" >
                        <h2>User Registration</h2>
                        <input type="hidden" name="id" <?php
                        // Preenche o id no campo id com um valor "value"
                        if (isset($id) && $id != null || $id != "") {
                            echo "value=\"{$id}\"";
                        }?> />
                        Nome: <input type="text" name="nome" <?php
                        // Preenche o nome no campo name com um valor "value"
                        if (isset($nome) && $nome != null || $nome != ""){
                            echo "value=\"{$nome}\"";
                        }?> />
                        E-mail: <input type="email" name="email" <?php
                        // Preenche o email no campo email com um valor "value"
                        if (isset($email) && $email != null || $email != ""){
                            echo "value=\"{$email}\"";
                        }?> />
                        Senha: <input type="password" name="senha" <?php
                        // Preenche o celular no campo password com um valor "value"
                        if (isset($senha) && $senha != null || $senha != ""){
                            echo "value=\"{$senha}\"";
                        }?> />
                        <input type="submit" value="Salvar"/>
                        <input type="reset" value="Resetar"/>
                    </form>
                    <table border="1" width="100%">
                        <tr>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Senha</th>
                            <th>Ação</th>
                        </tr>
                        <?php try {
                            // Bloco que realiza o papel do Read - recupera os dados e apresenta na tela
                            $pdo = db_connect();
                            $stmt = $pdo->prepare("SELECT * FROM tb_usuario WHERE id_usuario > 0");
 
                            if ($stmt->execute()) {
                                while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                                    echo "<tr>";
                                    echo "<td>".$rs->nm_usuario."</td><td>".$rs->email."</td><td>".$rs->senha
                                    ."</td><td><center><a href=\"?act=upd&id=" . $rs->id_usuario. "\">[Alterar]</a>"
                                    ."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
                                    ."<a href=\"?act=del&id=" . $rs->id_usuario. "\">[Deletar]</a></center></td>";
                                    echo "</tr>";
                                }} else {
                                    echo "Erro: Não conseguiu recupaerar os dados do Banco de Dados!";
                                }} catch (PDOException $erro) {
                                    echo "Erro: ".$erro->getMessage();
                                }?>
                    </table>
    </body>
</html>