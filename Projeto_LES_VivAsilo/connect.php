<!-- TESTE CAIXA BRANCA-->
<?php
    /*$host = "localhost";
    $user = "root";
    $pass = "";
    $dbname = "fadb";
    
    Modo 1:
    $con = mysqli_connect($host, $user, $pass);
    $db = mysqli_select_db($con, $dbname);
    
    Modo 2:
    $con = mysqli_connect($host, $user, $pass, $dbname); */
    try{
        $pdo=new PDO("mysql:host=localhost;dbname=fadb", "root", "");
    }catch(PDOException $e){
        echo $e->getMessage();
    }
    $id = $_GET["id"];
    $buscausuario = $pdo->query("SELECT * FROM tb_user WHERE = id_user = $id");
    
    $buscasegura = $pdo->prepare("SELECT * FROM tb_user WHERE id_user = :id");
    $buscasegura->bindValue(":id", $id);
    $buscasegura->execute();
    
    echo $buscasegura->rowCount();
?>