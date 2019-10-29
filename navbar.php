<?php
// inclui o arquivo de inicialização:
require 'init.php';
$pagina
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
    }
    
    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    .row.content {height: 450px}
    
    .contentDX4 {
            padding-top: 20px;
            background-color: #F7F8E0;
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
    .nome{
        font-family: verdana;
        font-size:25pt;
        background-color:#b3ffd9;
        text-align: center;
        height: 50px;
        
    }
    a { color: inherit; }
    
    .fonte1{
                font-family: avantgarde;
            }
    .fonte2{
                font-family: verdana;
            }
                    
    .fonte3{
                font-family: times, serif;
            }
    .verd{
                background-color: #e6fff2;
            }
    .comens{
                word-wrap: break-word; 
                border-style:solid;
                border-width: 5px;
                border-color: #b3ffd9;
            }
            bg-warning{
                text-align: center;
            }
            bg-success{
                text-align: center;
            }
            bg-danger{
                text-align: center;
            }
    div.col-1 img
            {
                width: 90%;
            }
            .cen{
                text-align: center;
            }
    
    <?php include 'css/login.css'; ?></style>
</style>
</head>
<body>
    <?php if($pagina == "index" || $pagina == "contactus" || $pagina == "aboutus"):?>
        <div class="container-fluid" style="background-color:#b3ffd9"><center><img src="imgs/logo_vivasilo.png" alt="Projeto Logo" style="width:250px;" ></center></div>
    <?php else: ?>
        <div class="container-fluid" style="background-color:#b3ffd9"><center><img src="../imgs/logo_vivasilo.png" alt="Projeto Logo" style="width:250px;" ></center></div>
    <?php endif; ?>
    <nav class="navbar-default navbar-static-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>                        
            </button>
            <?php
            if($pagina == "index" || $pagina == "contactus" || $pagina == "aboutus"):?>
                <a class="navbar-brand fonte2" style="font-size:20px;"href="index.php">Página principal</a>
            <?php else: ?>
                <a class="navbar-brand fonte2" style="font-size:20px;"href="../index.php">Página principal</a>
            <?php endif ?>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
            <?php
            if($pagina == "index" || $pagina == "contactus" || $pagina == "aboutus"):?>
                <li><a href="aboutus.php" class="fonte2" style="font-size:20px;">Quem somos</a></li>
                <li><a href="contactus.php" class="fonte2" style="font-size:20px;">Fale conosco</a></li>
            <?php else: ?>
                <li><a href="../aboutus.php" class="fonte2" style="font-size:20px;">Quem somos</a></li>
                <li><a href="../contactus.php" class="fonte2" style="font-size:20px;">Fale conosco</a></li>
            <?php endif ?>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <?php if (loggedin()):
                if($_SESSION['user_adm'] != 1):
                    if($pagina == "index" || $pagina == "contactus" || $pagina == "aboutus"):?>
                        <li><a href="Painel/painel.php" class="fonte2" style="font-size:20px;"> Meu painel</a></li>
                        <li><a href="Login/loginout.php" class="fonte2" style="font-size:20px;"><span class="glyphicon glyphicon-log-out"></span> Sair </a></li>
                    <?php else: ?>
                        <li><a href="../Painel/painel.php" class="fonte2" style="font-size:20px;"> Meu painel</a></li>
                        <li><a href="../Login/loginout.php" class="fonte2" style="font-size:20px;"><span class="glyphicon glyphicon-log-out"></span> Sair </a></li>
                    <?php endif; ?>
                <?php else:
                    if($pagina == "index" || $pagina == "contactus" || $pagina == "aboutus"):?>
                        <li><a href="Painel/admpainel_user.php" class="fonte2" style="font-size:20px;"> ADM Painel </a></li>
                        <li><a href="Painel/solicitations.php" class="fonte2">Solicitações (<?php echo requestcount(); ?>)</a></li>
                        <li><a href="Login/loginout.php" class="fonte2" style="font-size:20px;"><span class="glyphicon glyphicon-log-out"></span> Sair </a></li>
                    <?php else: ?>
                        <li><a href="../Painel/admpainel_user.php" class="fonte2" style="font-size:20px;"> ADM Painel </a></li>
                        <li><a href="../Painel/solicitations.php" class="fonte2">Solicitações (<?php echo requestcount(); ?>)</a></li>
                        <li><a href="../Login/loginout.php" class="fonte2" style="font-size:20px;"><span class="glyphicon glyphicon-log-out"></span> Sair </a></li>
                    <?php endif; ?>
                <?php endif; ?>
            <?php else: 
                if($pagina == "index" || $pagina == "contactus" || $pagina == "aboutus"):?>                    
                    <li><a href="Registrar/form-register.php" class="fonte2" style="font-size:20px;">Cadastrar-se</a></li>
                    <li><a href="Login/form-login.php" style="width:auto;" class="fonte2" style="font-size:20px;"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                <?php elseif($pagina != "form-register"):?>
                    <li><a href="../Registrar/form-register.php" class="fonte2" style="font-size:20px;">Cadastrar-se</a></li>
                <?php elseif($pagina != "form-login"):?>
                    <li><a href="../Login/form-login.php" style="width:auto;" class="fonte2" style="font-size:20px;"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                <?php endif ?>
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
