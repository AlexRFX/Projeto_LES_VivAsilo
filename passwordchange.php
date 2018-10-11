<?php
session_start();
// inclui o arquivo de inicialização:
require 'init.php';
// Resgata variáveis do formulário do painel.php:
$senhaHash = isset($_POST['senha']) ? $_POST['senha'] : '';
$novasenhaHash = isset($_POST['novasenha']) ? $_POST['novasenha'] : '';
$confsenhaHash = isset($_POST['confsenha']) ? $_POST['confsenha'] : '';

// Caso falte algum parametro:
if ((empty($senhaHash) || empty($novasenhaHash) || empty($confsenhaHash))){
    echo "Digite sua senha antiga e sua nova senha";
    //header('Refresh:5; painel.php');
    exit;
}

// Cria o hash das senhas:
$senhaHash = make_hash($senhaHash); 
$novasenhaHash = make_hash($novasenhaHash); $confsenhaHash = make_hash($confsenhaHash);

// Caso a nova senha não seja igual a confirmação:
if ($novasenhaHash != $confsenhaHash){
    echo "As senhas n�o coincidem";
    //header("Refresh:5; painel.php");
    exit;
}

// Chama a função da conexão PDO::
try {
    $pdo = db_connect();
    $stmt = $pdo->prepare('UPDATE tb_usuario SET senha = :novasenha WHERE id_usuario = :id AND senha = :senha') OR die("Error:".mysql_error());
    $stmt->execute(array(':id' => $_SESSION['id_usuario'], ':senha' => $senhaHash, ':novasenha' => $novasenhaHash));

    //echo $stmt->rowCount(); 
}catch(PDOException $e){
    echo 'Sua senha antiga n�o est� correta. Por favor, tente outra'; $e->getMessage();
    //header("Refresh:5; painel.php");
    exit;
}

// Volta para a Home
header('Location: painel.php');