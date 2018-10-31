<?php
// Função que conecta com o MySQL usando PDO:
function db_connect(){
    try{
        $pdo=new PDO("mysql:host=localhost;dbname=id7042898_dbvivasilo", "root", "");
        //$pdo=new PDO("mysql:host=localhost;dbname=id7042898_dbvivasilo", "id7042898_admin", "vivasilo");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }catch(PDOException $e){
        echo "Connection error:". $e->getMessage();
    }
} 

//Cria o hash da senha, usando MD5:
function make_hash($str){
    return md5($str);
}

// Verifica se o usuario está, logado:
function loggedin(){
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true){
        return false;
    }
    return true;
}

// Verifica se o usuario é mantenedor:
function maintainerch($id){
    $pdo = db_connect();
    $stmt = $pdo->prepare("SELECT fk_id FROM tb_mantenedor WHERE fk_id = :id");
    $stmt->bindParam(':id', $id); $stmt->execute();
    if ($stmt->rowCount() > 0) {
        return true;
    }
    return false;
}

// Conta e retorna o número de requisições de cadastro de mantenedor:
function requestcount(){
    $pdo = db_connect();
    $stmt = $pdo->prepare("SELECT a.id_usuario FROM tb_usuario a LEFT JOIN tb_mantenedor b ON a.id_usuario = b.fk_id WHERE a.administrador = 0 AND b.fk_id IS NULL");
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        echo $stmt->rowCount();
    }else{
        echo "Nenhuma solicitação";
    }
}