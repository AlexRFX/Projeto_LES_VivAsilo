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
    $stmt = $pdo->prepare("SELECT mantenedor_fk FROM tb_mantenedor WHERE mantenedor_fk = :id");
    $stmt->bindParam(':id', $id); $stmt->execute();
    if ($stmt->rowCount() > 0) {
        return true;
    }
    return false;
}

// Verifica se é mantenedor do asilo:
function maintaincheck($id_mantenedor, $id_asilo){
    $pdo = db_connect();
    $stmt = $pdo->prepare("SELECT asilo_status FROM tb_asilo WHERE asilo_mantenedor_fk = $id_mantenedor AND asilo_id = $id_asilo");
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        return true;
    }
    return false;
}

// Verifica se o mantenedor tem asilo:
function asilocheck($id_mantenedor){
    $pdo = db_connect();
    $stmt = $pdo->prepare("SELECT asilo_status FROM tb_asilo WHERE asilo_mantenedor_fk = $id_mantenedor");
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        return true;
    }
    return false;
}

// Verifica se o usuario já fez um comentario com nota para este asilo:
function usercomentcheck($asilo_id, $user_id){
    $pdo = db_connect();
    $stmt = $pdo->prepare("SELECT coment_data FROM `tb_comentario` WHERE coment_asilo_fk = $asilo_id AND coment_user_fk = $user_id");
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        return true;
    }
    return false;
}

// Conta e retorna o número de requisições de cadastro de mantenedor:
function requestcount(){
    $pdo = db_connect();
    $stmt = $pdo->prepare("SELECT a.user_id FROM tb_user a LEFT JOIN tb_mantenedor b ON a.user_id = b.mantenedor_fk WHERE a.user_adm = 0 AND b.mantenedor_fk IS NULL");
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        echo $stmt->rowCount();
    }else{
        echo "Nenhuma solicitação";
    }
    
// Conta e retorna o número de vezes que um asilo foi avaliado pelos usuarios:
function notacount($asilo_id){
    $pdo = db_connect();
    $stmt = $pdo->prepare("SELECT COUNT(coment_id) FROM tb_comentario WHERE coment_asilo_fk = $asilo_id AND coment_coment_fk IS NULL");
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        return $stmt->rowCount();
    }
}

}