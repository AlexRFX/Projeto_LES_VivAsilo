<?php
session_start();
// inclui o arquivo de inicializão:
require 'init.php';
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">

        <title>Home - VivAsilo</title>
        <style>
            td,tr,th{
                text-align: center;
            }
            
        </style>
    </head>

    <body>
        <?php 
        // Include da NavBar
        include 'navbar.php';?>

        <?php if (loggedin()):
                if($_SESSION['administrador'] != 1):?>
                    <div align="center"><p>Olá, <?php echo $_SESSION['nm_usuario']; ?></p></div>
                <?php else: ?>
                    <div align="center"><p>Olá, <?php echo $_SESSION['nm_usuario']; ?></p></div>
                <?php endif; ?>    
            <?php else: ?>
                    <div align="center"><p>Olá, visitante</p></div>
            <?php endif; ?>
            <!-- Exibe dos os asilos já cadastrados com uma foto, uma breve descrição e uma opção “ver mais” -->        
    </b><header>Asilos em Praia Grande</header>
    </br>
    </br>
                    <center><table class="table">
                        <?php try {
                        // Bloco que realiza o papel do Read - recupera os dados e apresenta na tela
                        $pdo = db_connect();
                        $stmt = $pdo->prepare("SELECT id_asilo, nome_asilo, desc_asilo, foto_asilo FROM tb_asilo");
 
                        if ($stmt->execute()) {
                            while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                                ?>
                            <tr><td colspan="3">
                                <?php
                                echo "<h3><b>".$rs->nome_asilo."</b></h3></td></tr>";
                                ?>
                                <tr><td rowspan="3" align="center">    <?php
                                echo "<img src=".$rs->foto_asilo."></td></tr><tr><td><h3>Descrição do asilo:</h3>".$rs->desc_asilo
                                ."</td></tr><tr><td><a href=\"asilo.php?id=" . $rs->id_asilo. "\"><u>[Ver Mais]</u></a></td></tr></tr>";
                                }} else {
                                    echo "Erro: Não conseguiu recupaerar os dados do Banco de Dados!";
                                }} catch (PDOException $erro) {
                                    echo "Erro: ".$erro->getMessage();
                                }?>
                        </table></center>
    </body>
</html>


