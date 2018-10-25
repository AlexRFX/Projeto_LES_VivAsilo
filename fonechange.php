<?php
session_start();
// inclui o arquivo de inicialização:
require 'init.php';
// Resgata variáveis do formulário do painel.php:
$telefone = isset($_POST['telefone']) ? $_POST['telefone'] : '';

// Caso falte algum parametro:
if ((empty($telefone))){
    echo "Digite o seu número de telefone";
    //header("Refresh:5; painel.php");?>
    </br></br><a href="painel.php">Voltar para o painel</a>
    <?php exit;
}

// Chama a função da conexão PDO::
try {
    $pdo = db_connect();
    $stmt = $pdo->prepare('UPDATE tb_mantenedor SET tel_mantenedor = :telefone WHERE fk_id = :id') OR die("Error:".mysql_error());
    $stmt->execute(array(':id' => $_SESSION['id_usuario'], ':telefone' => $telefone));

    //echo $stmt->rowCount(); 
}catch(PDOException $e){
    echo 'Algo não está, correto, por favor, entre novamente'; $e->getMessage();
    //header("Refresh:5; painel.php");?>
    </br></br><a href="painel.php">Voltar para o painel</a>
    <?php exit;
}

// Volta para a Home
header('Location: painel.php');?>
</br></br><a href="painel.php">Voltar para o painel</a>