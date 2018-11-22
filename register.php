<?php
// inclui o arquivo de inicialização:
require 'init.php';
 include 'navbar.php';
// Resgata variáveis do formulário do form-register.php:
$nome = isset($_POST['nome']) ? $_POST['nome'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$senhaHash = isset($_POST['senha']) ? $_POST['senha'] : '';
?><header><b>Cadastro - VivAsilo</b></header></br></br><?php
// Caso falte algum parametro:
if (empty($nome) ||empty($email) || empty($senhaHash)){?>
<div style="color:#ff3333 "><b>Informe nome, email e senha;</b></div>
</br></br><h3><a href="index.php">Voltar para a pagina principal</a></h3>
    <?php exit;
}

// Cria o hash da senha:
$senhaHash = make_hash($senhaHash);

// Chama a função da conexão PDO::
$pdo = db_connect();

$stmt = $pdo->prepare("INSERT INTO tb_usuario (`nm_usuario`, `email`, `senha`, `administrador`) VALUES (?, ?, ?, 0)");
$stmt->bindParam(1, $nome);
$stmt->bindParam(2, $email);
$stmt->bindParam(3, $senhaHash);
    if ($stmt->execute()) {
        if ($stmt->rowCount() > 0) {?>
        <div style="color:#47d147 "><b>Usuario cadastrado com sucesso!</b></div>
            <?php
            $id = null;
            $nome = null;
            $email = null;
            $senhaHash = null;
        } else {?>
        <div style="color:#ff3333 "><b>Cadastro Inválido!</b></div>
            <?php
        }} else {
            throw new PDOException("Erro: Não conseguiu executar a declaração SQL!");
        }
        
// Volta para a Home
//header('Location: index.php');?>
    </br></br><div ><a href="index.php"><span class="glyphicon glyphicon-home"></span>  Voltar para a pagina principal</a></div>