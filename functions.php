<?php
// Função que conecta com o MySQL usando PDO:
function db_connect(){
    try{
        //$pdo=new PDO("mysql:host=localhost;dbname=dbvivasilo", "root", "");
        $pdo=new PDO("mysql:host=localhost;dbname=id7042898_dbvivasilo", "id7042898_admin", "vivasilo");
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