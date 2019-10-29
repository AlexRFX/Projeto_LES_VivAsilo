<?php
session_start();
$pagina = "index";
// inclui o arquivo de inicializão:
require 'init.php';
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">

        <title>Home - VivAsilo</title>
        <style>
            .bord{
                border-style:solid;
                border-width:5px;
                border-color: #b3ffd9;
            }  

        </style>
    </head>

    <body>
        <?php
        // Include da NavBar
        include 'navbar.php';
        ?>
        <!-- Exibe dos os asilos já cadastrados com uma foto, uma breve descrição e uma opção “ver mais” -->        
        <p class="nome"></p>
        <div class="container">
            <?php
            try {
                // Bloco que realiza o papel do Read - recupera os dados e apresenta na tela
                $pdo = db_connect();
                $stmt = $pdo->prepare("SELECT asilo_id, asilo_nm, asilo_ds, asilo_foto FROM tb_asilo");

                if ($stmt->execute()) {
                    while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                        ?>
                        <div class ="row verd bord">
                            <h1 class="fonte2"><?= strtoupper($rs->asilo_nm) ?></h1>
                            <div class="col-sm-7 col-1">
                                <div class="row">
                                    <div class="col-sm-12">
                                        </br>
                                        <?php echo "<img src=imgs/imgsasilo/" . $rs->asilo_foto . ">" ?>
                                        </br>
                                        </br>
                                    </div></div></div><div class="col-sm-5 col-2">
                                <h3 class="fonte2"><?= $rs->asilo_ds ?></h3>
                        <?php echo "</h3><a href=\"Asilo/asilo.php?id=" . $rs->asilo_id . "\"><h4>[Ver Mais]</a></h4>"; ?>
                            </div></div></br>
                        <?php
                    }
                } else {
                    echo "Erro: Não conseguiu recupaerar os dados do Banco de Dados!";
                }
            } catch (PDOException $erro) {
                echo "Erro: " . $erro->getMessage();
            }
            ?>
        </div>
    </body>
</html>