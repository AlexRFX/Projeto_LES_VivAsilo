<?php
session_start();
$pagina = "aboutus";
// inclui o arquivo de inicializão:
require 'init.php';
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">

        <title>Quem somos - VivAsilo</title>
    </head>

    <body>
        <?php 
        // Include da NavBar
        include 'navbar.php';?>
        <p class="nome">Quem Somos</p>
        <div>
            <h3 class="fonte1" style="line-height:2;"> Estudantes de Análise e Desenvolvimento de Sistemas</br>
                da Faculdade de Tecnologia de Praia Grande.</br> Com o conhecimento adquirido ao longo do curso,</br>
                decidimos fazer um sistema para a divulgação dos </br>asilos e casas de repouso
da nossa cidade (Praia Grande), para que a </br>população pudesse então voltar a sua atenção
para o público mais velho</br> da cidade e também contribuir para um melhor conforto destes.</br>
A visibilidade é muito importante, tendo em mente que 12,43% dos praia-grandenses</br> são idosos,
 segundo dados do último senso IBGE (2010).</h3>
        <br><br>
       
        </div>
    </body>
</html>
