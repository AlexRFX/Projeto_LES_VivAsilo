<?php
session_start();
$pagina = "index";
// inclui o arquivo de inicializão:
require 'init.php';
/* Recebe o número da página via parâmetro na URL */  
$pagina_atual = (isset($_GET['page']) && is_numeric($_GET['page'])) ? $_GET['page'] : 1;   
/* Calcula a linha inicial da consulta */  
$linha_inicial = ($pagina_atual -1) * QTDE_REGISTROS;
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
        // Verificar se foi enviando dados via POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nome = (isset($_POST["nome"]) && $_POST["nome"] != null) ? $_POST["nome"] : "";
            $endereco = (isset($_POST["endereco"]) && $_POST["endereco"] != null) ? $_POST["endereco"] : "";
            $cidade = (isset($_POST["cidade"]) && $_POST["cidade"] != null) ? $_POST["cidade"] : "";
            $mensal = (isset($_POST["mensal"]) && $_POST["mensal"] != null) ? $_POST["mensal"] : "";
            $categoria = (isset($_POST["categoria"]) && $_POST["categoria"] != null) ? $_POST["categoria"] : "";

            } else {
                $nome = '';
                $endereco = NULL;
                $cidade = '*';
                $mensal = NULL;
                $categoria = '*';
            }
        ?>
        <p class="nome">Procurar Asilo</p>
        <div class="container">
            <div class="row">
                <div class="col-12 comens verd">
                    <form action="?act=search" method="POST" name="form0" >
                        <center>
                            <!-- Nome -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <label for="nome"><h4>Nome:</h4></label>
                                    <input type="text" name="nome" maxlength="30" pattern="[a-zA-Z0-9]+" style="width:60%;" class="form-control input-lg" <?php
                                    // Preenche o nome no campo nome com um valor "value"
                                    if (isset($nome) && $nome != null || $nome != ""){
                                        echo "value=\"{$nome}\"";
                                    }?> />
                                </div>
                            </div>
                            <!-- Categoria -->    
                            <div class="row">
                                <div class="col-sm-12">
                                    <label for="categoria"><h4>Categoria:</h4></label>
                                    <?php try {
                                        // Bloco que realiza o papel do Read - recupera os dados e apresenta na tela
                                        $pdo = db_connect();
                                        $stmt1 = $pdo->prepare("SELECT tipo_id, tipo_nm FROM tb_tipo");
                                        $stmt1->execute();
                                        if ($stmt1->execute()) { ?>
                                            <select name="categoria">
                                                    <option value="*">Todas</option>
                                                <?php while ($rs1 = $stmt1->fetch(PDO::FETCH_OBJ)) {?>
                                                    <option value="<?=$rs1->tipo_id?>" style="width:60%;"  class="form-control input-lg"><?=$rs1->tipo_nm?></option>
                                                    <?php
                                                    // Preenche a conta bancaria no campo conta bancaria com um valor "value"
                                                    if (isset($categoria) && $categoria != null || $categoria != ""){
                                                        echo "value=\"{$categoria}\"";
                                                    }
                                                }} else {
                                                    echo "Erro: Não conseguiu recupaerar os dados do Banco de Dados!";
                                                }} catch (PDOException $erro) {
                                                    echo "Erro: ".$erro->getMessage();
                                                }?>
                                            </select>
                                    <label for="cidade"><h4>Cidade:</h4></label>
                                    <?php try {
                                        // Bloco que realiza o papel do Read - recupera os dados e apresenta na tela
                                        $pdo = db_connect();
                                        $stmt2 = $pdo->prepare("SELECT cidade_id, cidade_nm FROM tb_cidade");
                                        $stmt2->execute();
                                        if ($stmt2->execute()) { ?>
                                            <select name="cidade">
                                                <?php
                                                /* Preenche a conta bancaria no campo conta bancaria com um valor "value"
                                                if (isset($cidade) && $cidade != null || $cidade != ""){?>
                                                    <option value="<?=$cidade;?>"</option>
                                                <?php } */?>
                                                <option value="*">Todas</option>
                                                <?php while ($rs2 = $stmt2->fetch(PDO::FETCH_OBJ)) {?>
                                                    <option value="<?=$rs2->cidade_id?>" style="width:60%;"  class="form-control input-lg"><?=$rs2->cidade_nm?></option>
                                                    <?php
                                                    }} else {
                                                        echo "Erro: Não conseguiu recupaerar os dados do Banco de Dados!";
                                                    }} catch (PDOException $erro) {
                                                        echo "Erro: ".$erro->getMessage();
                                                    }?>
                                            </select>
                                </div>
                            </div>
                            <table>    
                                <tr>
                                    <td><input type="submit" value="BUSCAR" style="width:160px;" class="form-control input-lg"/></td>
                                    <td><input type="reset" value="RESETAR" style="width:160px;" class="form-control input-lg"/></td>
                                </tr>
                            </table>
                        </center>
                    </form>
                </div>        
            </div>       
        </div>
        <!-- Exibe dos os asilos já cadastrados com uma foto, uma breve descrição e uma opção “ver mais” -->        
        <p class="nome">Asilos em destaque:</p>
        <div class="container">
            <?php
            echo "<br>Nome = ". $nome;
            echo "<br>Cidade = ". $cidade;
            echo "<br>categoria = ". $categoria;
            try {
                // Bloco que realiza o papel do Read - recupera os dados e apresenta na tela
                $pdo = db_connect();
                if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "search"):
                    if(($categoria == '*') && ($cidade == '*')):
                        $sql = "SELECT a.asilo_id, a.asilo_nm, a.asilo_ds, a.asilo_foto, a.asilo_mensalidade, a.asilo_endereco, a.asilo_nota, a.asilo_count, b.cidade_nm, c.tipo_nm "
                                            . "FROM tb_asilo a "
                                                . "JOIN tb_cidade b ON a.asilo_cidade_fk = b.cidade_id "
                                                . "JOIN tb_tipo c ON a.asilo_tipo_fk = c.tipo_id "
                                                    . "WHERE a.asilo_nm LIKE '%$nome%' AND a.asilo_status = 1 ORDER BY a.asilo_nota/a.asilo_count DESC";
                        $stmt = $pdo->prepare($sql);   
                        $stmt->execute();   
                        $dados = $stmt->fetchAll(PDO::FETCH_OBJ);
                        // Conta quantos resultados serão exibidos na tela 
                        $sqlCount = "SELECT COUNT(a.asilo_id) AS total_registros "
                                            . "FROM tb_asilo a "
                                                . "JOIN tb_cidade b ON a.asilo_cidade_fk = b.cidade_id "
                                                . "JOIN tb_tipo c ON a.asilo_tipo_fk = c.tipo_id "
                                                    . "WHERE a.asilo_nm LIKE '%$nome%' AND a.asilo_status = 1";   
                        $stmCount = $pdo->prepare($sqlCount);   
                        $stmCount->execute();   
                        $valor = $stmCount->fetch(PDO::FETCH_OBJ);
                            
                    elseif(($categoria != '*') && ($cidade == '*')):
                        $sql = "SELECT a.asilo_id, a.asilo_nm, a.asilo_ds, a.asilo_foto, a.asilo_mensalidade, a.asilo_endereco, a.asilo_nota, a.asilo_count, b.cidade_nm, c.tipo_nm "
                                            . "FROM tb_asilo a "
                                                . "JOIN tb_cidade b ON a.asilo_cidade_fk = b.cidade_id "
                                                . "JOIN tb_tipo c ON a.asilo_tipo_fk = c.tipo_id "
                                                    . "WHERE a.asilo_nm LIKE '%$nome%' AND c.tipo_id = $categoria AND a.asilo_status = 1 ORDER BY a.asilo_nota/a.asilo_count DESC";
                        $stmt = $pdo->prepare($sql);   
                        $stmt->execute();   
                        $dados = $stmt->fetchAll(PDO::FETCH_OBJ);
                    // Conta quantos resultados serão exibidos na tela 
                        $sqlCount = "SELECT COUNT(a.asilo_id) AS total_registros "
                                            . "FROM tb_asilo a "
                                                . "JOIN tb_cidade b ON a.asilo_cidade_fk = b.cidade_id "
                                                . "JOIN tb_tipo c ON a.asilo_tipo_fk = c.tipo_id "
                                                    . "WHERE a.asilo_nm LIKE '%$nome%' AND c.tipo_id = $categoria AND a.asilo_status = 1";   
                        $stmCount = $pdo->prepare($sqlCount);   
                        $stmCount->execute();   
                        $valor = $stmCount->fetch(PDO::FETCH_OBJ);
                           
                    elseif(($categoria == '*') && ($cidade != '*')):
                        $sql = "SELECT a.asilo_id, a.asilo_nm, a.asilo_ds, a.asilo_foto, a.asilo_mensalidade, a.asilo_endereco, a.asilo_nota, a.asilo_count, b.cidade_nm, c.tipo_nm "
                                            . "FROM tb_asilo a "
                                                . "JOIN tb_cidade b ON a.asilo_cidade_fk = b.cidade_id "
                                                . "JOIN tb_tipo c ON a.asilo_tipo_fk = c.tipo_id "
                                                    . "WHERE a.asilo_nm LIKE '%$nome%' AND b.cidade_id = $cidade AND a.asilo_status = 1 ORDER BY a.asilo_nota/a.asilo_count DESC";
                        $stmt = $pdo->prepare($sql);   
                        $stmt->execute();   
                        $dados = $stmt->fetchAll(PDO::FETCH_OBJ);
                        // Conta quantos resultados serão exibidos na tela 
                        $sqlCount = "SELECT COUNT(a.asilo_id) AS total_registros "
                                            . "FROM tb_asilo a "
                                                . "JOIN tb_cidade b ON a.asilo_cidade_fk = b.cidade_id "
                                                . "JOIN tb_tipo c ON a.asilo_tipo_fk = c.tipo_id "
                                                    . "WHERE a.asilo_nm LIKE '%$nome%' AND b.cidade_id = $cidade AND a.asilo_status = 1";  
                        $stmCount = $pdo->prepare($sqlCount);   
                        $stmCount->execute();   
                        $valor = $stmCount->fetch(PDO::FETCH_OBJ);
                           
                    else:
                        $sql = "SELECT a.asilo_id, a.asilo_nm, a.asilo_ds, a.asilo_foto, a.asilo_mensalidade, a.asilo_endereco, a.asilo_nota, a.asilo_count, b.cidade_nm, c.tipo_nm "
                                            . "FROM tb_asilo a "
                                                . "JOIN tb_cidade b ON a.asilo_cidade_fk = b.cidade_id "
                                                . "JOIN tb_tipo c ON a.asilo_tipo_fk = c.tipo_id "
                                                    . "WHERE a.asilo_nm LIKE '%$nome%' AND b.cidade_id = $cidade AND c.tipo_id = $categoria AND a.asilo_status = 1 ORDER BY a.asilo_nota/a.asilo_count DESC";
                        $stmt = $pdo->prepare($sql);   
                        $stmt->execute();   
                        $dados = $stmt->fetchAll(PDO::FETCH_OBJ);
                        // Conta quantos resultados serão exibidos na tela 
                        $sqlCount = "SELECT COUNT(a.asilo_id) AS total_registros "
                                            . "FROM tb_asilo a "
                                                . "JOIN tb_cidade b ON a.asilo_cidade_fk = b.cidade_id "
                                                . "JOIN tb_tipo c ON a.asilo_tipo_fk = c.tipo_id "
                                                    . "WHERE a.asilo_nm LIKE '%$nome%' AND b.cidade_id = $cidade AND c.tipo_id = $categoria AND a.asilo_status = 1";  
                        $stmCount = $pdo->prepare($sqlCount);   
                        $stmCount->execute();   
                        $valor = $stmCount->fetch(PDO::FETCH_OBJ);
                           
                    endif;
                else:
                    $sql = "SELECT a.asilo_id, a.asilo_nm, a.asilo_ds, a.asilo_foto, a.asilo_mensalidade, a.asilo_endereco, a.asilo_nota, a.asilo_count, b.cidade_nm, c.tipo_nm "
                                   . "FROM tb_asilo a "
                                       . "JOIN tb_cidade b ON a.asilo_cidade_fk = b.cidade_id "
                                       . "JOIN tb_tipo c ON a.asilo_tipo_fk = c.tipo_id "
                                           . "WHERE a.asilo_status = 1 ORDER BY a.asilo_nota/a.asilo_count DESC";
                    $stmt = $pdo->prepare($sql);   
                    $stmt->execute();   
                    $dados = $stmt->fetchAll(PDO::FETCH_OBJ);
                    // Conta quantos resultados serão exibidos na tela 
                    $sqlCount = "SELECT COUNT(a.asilo_id) AS total_registros "
                                        . "FROM tb_asilo a "
                                            . "JOIN tb_cidade b ON a.asilo_cidade_fk = b.cidade_id "
                                            . "JOIN tb_tipo c ON a.asilo_tipo_fk = c.tipo_id "
                                                . "WHERE a.asilo_status = 1";
                    $stmCount = $pdo->prepare($sqlCount);   
                    $stmCount->execute();   
                    $valor = $stmCount->fetch(PDO::FETCH_OBJ);
                           
                endif;
                    if ($stmt->rowCount() === 0):?>
                        <center><h4 class="bg-warning"> Sua pesquisa <?=$nome;?> não encontrou nenhum asilo correspondente.</br></br>
                        Sugestões:
                        </br></br>
                        Certifique-se de que todas as palavras estejam escritas corretamente.<br>
                        Tente palavras-chave diferentes.<br>
                        Tente palavras-chave mais genéricas.<br></h4></center>
                    <?php else:
                        
                        // Variaveis, e funções de controle da paginação
                        require 'pagination.php';
                        
                        foreach($dados as $rs): ?>
                            <div class ="row verd bord">
                                <h1 class="fonte2"><?= strtoupper($rs->asilo_nm) ?></h1>
                                <div class="col-sm-7 col-1">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            </br><?php echo "<img src=imgs/imgsasilo/" . $rs->asilo_foto . ">" ?></br></br>
                                        </div>
                                        <?php if($rs->asilo_count == null):?>
                                            <p class="fonte2 b">Nota:</p><p>Ainda não tem avaliações dos usuarios</p>
                                        <?php else: ?>
                                            <p class="fonte2 b">Nota:</p><p class="m"><?=$rs->asilo_nota/$rs->asilo_count;?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <h3 class="fonte2"><?= $rs->tipo_nm ?> em <?= $rs->cidade_nm ?></h3>
                                <div class="col-sm-5 col-2">
                                    <h3 class="fonte2"><b>Descrição:</b> <?= $rs->asilo_ds ?></h3>
                                    <?php echo "</h3><a href=\"Asilo/asilo.php?id=" . $rs->asilo_id . "\"><h4>[Ver Mais]</a></h4>"; ?>
                                </div>
                            </div></br>
                        <?php endforeach;
                        
                    // Botões da paginação
                    require 'pagination_buttons.php';

                    endif;     
            } catch (PDOException $erro) {
                echo "Erro: " . $erro->getMessage();
            }?>
        </div>
    </body>
</html>