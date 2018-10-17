<?php
// inclui o arquivo de inicialização:
require 'init.php';
// Resgata variáveis do formulário do form-register.php:
$nome = isset($_POST['nome']) ? $_POST['nome'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$senhaHash = isset($_POST['senha']) ? $_POST['senha'] : '';

// Caso falte algum parametro:
if (empty($nome) ||empty($email) || empty($senhaHash)){
    echo "Informe nome, email e senha";
    //header('Refresh:5; form-register.php');?>
    </br></br><a href="index.php">Voltar para a pagina principal</a>
    <?php exit;
}

// Cria o hash da senha:
$senhaHash = make_hash($senhaHash);

// Chama a função da conexão PDO::
$pdo = db_connect();

$stmt = $pdo->prepare("INSERT INTO tb_usuario (`nm_usuario`, `email`, `senha`, `administrador`) VALUES (?, ?, ?, 0)");
$stmt->bindParam(1, $nome);
$stmt->bindParam(2, $email);
$stmt->bindParam(3, $senhaHash);
    if ($stmt->execute()) {
        if ($stmt->rowCount() > 0) {
            echo "Usuario cadastrado com sucesso!";
            $id = null;
            $nome = null;
            $email = null;
            $senhaHash = null;
        } else {
            echo "Deu erro no cadastro!";
        }} else {
            throw new PDOException("Erro: Não conseguiu executar a declaração SQL!");
        }
        
// Volta para a Home
//header('Location: index.php');?>
</br></br><a href="index.php">Voltar para a pagina principal</a>