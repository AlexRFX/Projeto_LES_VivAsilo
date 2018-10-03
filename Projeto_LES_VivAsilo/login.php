<?php session_start();?>
<?php require_once 'config.php'; ?>	
<?php require_once DBAPI; ?>
<?php require_once TRATAMENTOLOGINAPI?>
<?php $_SESSION["error_message"] = "";?>
<?php
$conn = open_database();

$sqlQuery = "SELECT * FROM tb_usuario WHERE email= '$loginUser' and senha= '$senhaUser'";
$result = $conn->query($sqlQuery);

if($result->num_rows > 0) {
 $_SESSION['email'] = $loginUser;
$_SESSION['senha'] = $senhaUser;
header('location:home.php');
}else{
    unset ($_SESSION['email']);
    unset ($_SESSION['senha']);
    $_SESSION["error_message"] = "Email ou senha inválidos";
    header('location:index.php');
}

 
?>