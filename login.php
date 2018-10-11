<?php
// inclui o arquivo de inicializa��o:
require 'init.php';
// Resgata vari�veis do formul�rio do form-login.php:
$email = isset($_POST['email']) ? $_POST['email'] : '';
$senhaHash = isset($_POST['senha']) ? $_POST['senha'] : '';

// Caso falte algum parametro:
if (empty($email) || empty($senhaHash)){
    echo "Informe email e senha";
    //header('Refresh:5; form-login.php');
    exit;
}

// Cria o hash da senha:
$senhaHash = make_hash($senhaHash);

// Chama a fun��o da conex�o PDO::
$pdo = db_connect();

$sql = "SELECT id_usuario, nm_usuario FROM tb_usuario WHERE email = :email AND senha = :senha";
$stmt = $pdo->prepare($sql);

$stmt->bindParam(':email', $email);
$stmt->bindParam(':senha', $senhaHash);

$stmt->execute();

$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Messagem de erro:
if (count($users) <= 0){
    echo "login ou senha incorretos";
    exit;
}

// Pega o usu�rio atual
$user = $users[0];

session_start();
$_SESSION['logged_in'] = true;
$_SESSION['id_usuario'] = $user['id_usuario'];
$_SESSION['nm_usuario'] = $user['nm_usuario'];

// Volta para a Home
header('Location: index.php');
