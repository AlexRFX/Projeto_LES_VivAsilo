<?php
$pagina="register";
// inclui o arquivo de inicialização:
require '../init.php';
include '../navbar.php';

// Resgata variáveis do formulário do form-register.php:
$nome = isset($_POST['nome']) ? $_POST['nome'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$senhaHash = isset($_POST['senha']) ? $_POST['senha'] : '';
?>

<p class="nome">Cadastro</p></br>

<?php 
// Caso falte algum parametro:
if (empty($nome) || empty($email) || empty($senhaHash)){?>
    <h4 class="bg-warning">Informe nome, email e senha;</h4>
    </br></br><h3><a href="../index.php">Voltar para a pagina principal</a></h3>
    <?php exit;
} 

// Chama a função da conexão PDO:
$pdo = db_connect();

// Verifica se o e-mail já foi cadastrado no Banco de Dados:
$stmt = $pdo->prepare("SELECT user_email FROM tb_user WHERE user_email = :email");
$stmt->bindParam(':email', $email); $stmt->execute();
    if ($stmt->rowCount() > 0) {
        ?><h4 class="bg-warning">E-mail Já cadastrado;</h4>
        </br></br><h3><a href="../index.php">Voltar para a pagina principal</a></h3>
        <?php exit;
    }

// Cria o hash da senha:
$senhaHash = make_hash($senhaHash);

// Insere os dados no Banco de Dados:
$stmt2 = $pdo->prepare("INSERT INTO tb_user (`user_nm`, `user_email`, `user_senha`, `user_adm`) VALUES (?, ?, ?, 0)");
$stmt2->bindParam(1, $nome);
$stmt2->bindParam(2, $email);
$stmt2->bindParam(3, $senhaHash);
    if ($stmt2->execute()) {
        if ($stmt2->rowCount() > 0) {?>
            <h4 class="bg-success">Cadastro efetuado com sucesso!</h4>
            <?php
            $id = null;
            $nome = null;
            $email = null;
            $senhaHash = null;
        } else {?>
            <h4 class="bg-danger">Cadastro Inválido!</h4>
            <?php
        }} else {
            throw new PDOException("Erro: Não conseguiu executar a declaração SQL!");
        }
        
// Volta para a Home
//header('Location: index.php');?>
    </br></br><div ><a href="../index.php"><span class="glyphicon glyphicon-home"></span>  Voltar para a pagina principal</a></div>