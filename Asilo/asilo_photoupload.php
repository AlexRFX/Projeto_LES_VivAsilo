<?php
session_start();
// inclui o arquivo de inicialização:
require_once '../init.php';
include "../resize-img.php";
// https://vivasilo.000webhostapp.com/Painel/painel.php
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
    </head>
    <body bgcolor="#000000">
        <?php
        $arquivo = $_FILES['arquivo']['name'];
        

        // Pasta onde o arquivo vai ser salvo:
        $_UP['pasta'] = '../imgs/imgsasilo/';

        $_UP['extensoes'] = array('png', 'jpg', 'jpeg', 'gif');

        // Renomeiar:
        $_UP['renomeia'] = true;

        // Array com os tipos de erros de upload do PHP:
        $_UP['erros'][0] = 'Não houve erro';
        $_UP['erros'][1] = 'O arquivo no upload é maior que o limite do PHP';
        $_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especificado no HTML';
        $_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
        $_UP['erros'][4] = 'Não foi feito o upload do arquivo';

        // Verifica se houve algum erro com o upload. Sem sim, exibe a mensagem do erro:
        if ($_FILES['arquivo']['error'] != 0) {
            echo "<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=http://localhost/Projeto_LES_VivAsilo/Painel/painel.php'>
                    <script type=\"text/javascript\">
                    alert(\"Não foi possivel fazer o upload da imagem, tente outro arquivo.;
                    </script>";
            exit; //Para a execução do script
        }

        // Faz a verificação da extensao do arquivo:
        $extensao = strtolower(end(explode('.', $_FILES['arquivo']['name'])));
        if (array_search($extensao, $_UP['extensoes']) === false) {
            echo "<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=http://localhost/Projeto_LES_VivAsilo/Painel/painel.php'>
                    <script type=\"text/javascript\">
                    alert(\"A imagem foi cadastrada com extesão inválida.\");
                    </script>";
        }

        // O arquivo passou em todas as verificações, hora de tentar move-lo para a pasta foto:
        else {
            // Primeiro verifica se deve trocar o nome do arquivo:
            if ($_UP['renomeia'] == true) {
                // Cria um nome baseado no UNIX TIMESTAMP atual e com extensão .jpg:
                $nome_final = $_SESSION['user_id'].'.jpg';
            } else {
                // mantem o nome original do arquivo:
                $nome_final = $_FILES['arquivo']['name'];
            }
            // Verificar se é possivel mover o arquivo para a pasta escolhida:
            if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $_UP['pasta'] . $nome_final)) {
                // *** 1) Inicializar Imagem
                $resizeObj = new resize('../imgs/imgsasilo/'.$_SESSION['user_id'].'.jpg');

                // *** 2) Redimensionar imagens (Opções: exato, retrato, paisagem, auto, crop)
                $resizeObj -> resizeImage(640, 480, 'exact');

                // *** 3) Salvar imagem
                $resizeObj -> saveImage('../imgs/imgsasilo/'.$_SESSION['user_id'].'.jpg', 1000);    
                $pdo = db_connect();
                // Upload efetuado com sucesso, exibe a mensagem:
                $stmt = $pdo->prepare("UPDATE tb_asilo SET asilo_foto = :linkimg WHERE asilo_mantenedor_fk = :id");
                $stmt->bindParam(':linkimg', $nome_final);
                $stmt->bindParam(':id', $_SESSION['user_id']);
                $stmt->execute();
                echo "<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=http://localhost/Projeto_LES_VivAsilo/Painel/painel.php'>
                        <script type=\"text/javascript\">
                        alert(\"Imagem cadastrada com Sucesso.\");
                        </script>";
            } else {
                // Upload não efetuado com sucesso, exibe a mensagem:
                echo "<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=http://localhost/Projeto_LES_VivAsilo/Painel/painel.php'>
                        <script type=\"text/javascript\">
                        alert(\"Imagem não foi cadastrada com Sucesso.\");
                        </script>";
            }
        }
        ?>
    </body>
</html>