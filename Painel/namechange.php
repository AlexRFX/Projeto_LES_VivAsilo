<?php
session_start();
// inclui o arquivo de inicialização:
require '../init.php';
// Resgata variáveis do formulário do painel.php:
$nome = isset($_POST['nome']) ? $_POST['nome'] : '';

// Caso falte algum parametro:
if ((empty($nome))){
    echo "Digite o seu nome";
    //header("Refresh:5; painel.php");?>
    </br></br><a href="painel.php">Voltar para o painel</a>
    <?php exit;
}

// Chama a função da conexão PDO::
try {
    $pdo = db_connect();
    $stmt = $pdo->prepare('UPDATE tb_user SET user_nm = :name WHERE user_id = :id') OR die("Error:".mysql_error());
    $stmt->execute(array(':id' => $_SESSION['user_id'], ':name' => $nome));

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