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
                    <table class="table" width="100%">
                        <tr>
                            <th>Foto</th>
                            <th>Nome</th>
                            <th>Breve Descrição</th>
                            <th> </th>
                        </tr>
                        <?php try {
                        // Bloco que realiza o papel do Read - recupera os dados e apresenta na tela
                        $pdo = db_connect();
                        $stmt = $pdo->prepare("SELECT id_asilo, nome_asilo, desc_asilo, foto_asilo FROM tb_asilo");
 
                        if ($stmt->execute()) {
                            while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                                echo "<tr>";
                                echo "<td><img src=".$rs->foto_asilo."></td><td>".$rs->nome_asilo."</td><td>".$rs->desc_asilo;?>
                    </td><td><a href="asilo.php?id=<?php echo $id['id'];?>" title="Ler mais"><u> Ver mais</u></a></td></tr>
                                <?php }} else {
                                    echo "Erro: Não conseguiu recupaerar os dados do Banco de Dados!";
                                }} catch (PDOException $erro) {
                                    echo "Erro: ".$erro->getMessage();
                                }?>
                    </table>
    </body>
</html>


