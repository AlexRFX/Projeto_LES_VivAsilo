<?php
// Função que conecta com o MySQL usando PDO:
function db_connect(){
    try{
        $pdo=new PDO("mysql:host=localhost;dbname=id7042898_dbvivasilo", "id7042898_admin", "vivasilo");
        return $pdo;
    }catch(PDOException $e){
        echo $e->getMessage();
    }
} 

/*Cria o hash da senha, usando MD5 e SHA-1:
function make_hash($str){
    return sha1(md5($str));
} */

// Verifica se o usuário está logado:
function loggedin(){
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true){
        return false;
    }
    return true;
}