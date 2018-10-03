<?php
$conn = open_database();
$login = $_SESSION["email"];
$senha = $_SESSION["senha"];
$sqlFetch = "SELECT u.nm_usuario,u.email, m.foto_mantenedor, m.tel_mantenedor"
        . " FROM tb_usuario u, tb_mantenedor m WHERE id_user = '$idUser'";
$result = $conn->query($sqlFetch);

if ($result->num_rows > 0) {
$row = $result->fetch_assoc();
$nomeUser = $row["nm_usuario"]
$emailUser = $row["email"];

}
?>
