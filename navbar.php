<?php
// inclui o arquivo de inicialização:
require 'init.php';
?>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style>
    /* Remove the navbar's default margin-bottom and rounded borders */ 
    .navbar {
        margin-bottom: 0;
        border-radius: 0;
        background-color: #F7F8E0;
    }
    
    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    .row.content {height: 450px}
    
    .contentDX4 {
            padding-top: 20px;
            background-color: #F3E2A9;
            height: 100%;
        }
    
    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
    .sidenav {
        height: auto;
        padding: 15px;
    }
    .row.content {height:auto;} 
    }
    /* Set black background color, white text and some padding */
    center {
        padding: 15px;
    }
    body{
        background-color:#F7F8E0;
    }
    th{
	font-size:14pt;
        width:50px;
    }
    td{
        width:150px;
    }
    input{
        height:50px;
    }
    
    div{
    text-align:center;
    font-size:15pt;
    }
    header{
        font-size:25pt;
        background-color:#F3E2A9;
        text-align: center;
    }
    a { color: inherit; }
    img{
        width:450px;
        lidth:200px;      
    }
    <?php include 'css/login.css'; ?></style>
</style>
</head>
<body><center><img src="imgs/LogoV2.gif" alt="Projeto Logo" style="width:50%"></center>
<nav class="navbar">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>                        
            </button>
        <a class="navbar-brand" href="index.php">Página principal</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
            <li><a href="aboutus.php">Quem somos</a></li>
            <li><a href="contactus.php">Fale conosco</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <?php if (loggedin()):
                if($_SESSION['administrador'] != 1):?>
                    <li><a href="painel.php"> Meu painel</a></li>
                    <li><a href="loginout.php"><span class="glyphicon glyphicon-log-out"></span> Sair </a></li>
                <?php else: ?>
                    <li><a href="admpainel.php"> Painel </a></li>
                    <li><a href="solicitations.php">Solicitações (<?php echo requestcount(); ?>)</a></li>
                    <li><a href="loginout.php"><span class="glyphicon glyphicon-log-out"></span> Sair </a></li>
                <?php endif; ?>    
            <?php else: ?>
                    <li><a href="form-register.php">Cadastrar-se</a></li>
                <li><a href="form-login.php" style="width:auto;"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
            <?php endif; ?>
        </ul>
    </div>
    </div>
</nav>

<script>
// Get the modal
var modal = document.getElementById('id01');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target === modal) {
        modal.style.display = "none";
    }
};
</script>
</body>
