<?php
/*
$servername = "localhost";
$username = "id5213541_root";
$password = "senha";
*/

//Caso haja algum erro grave, será reportado
mysqli_report(MYSQLI_REPORT_STRICT);



// Abrindo conexão, e retornando conexão realizada. Exceção, caso haja erro
function open_database() {
    try {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        return $conn;
    } catch (Exception $e) {
        echo $e->getMessage();
        return null;
    }
}


// Fechando conexão; Exceção, caso haja erro
function close_database($conn) {
    try {
        mysqli_close($conn);
    } catch (Exception $e) {
        echo $e->getMessage();

    }
}
?>
