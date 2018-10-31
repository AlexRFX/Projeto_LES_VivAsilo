<!doctype html>
<html>
    <head>
        <meta charset="utf-8">

  <title>Login - VivAsilo</title>
    </head>

    <body>
        
        <?php 
        // Include da NavBar
        include 'navbar.php';?>
        
        <header><b>Login - VivAsilo</b></header>
    </br>
    </br>
   <center><table>
        <form action="login.php" method="post">
            <tr><th colspan='2'><label for="email">E-mail: </label></th></tr>
            <tr><td colspan='2'><input type="text" name="email" id="email" style="width:450px"></td></tr>
            <tr><td colspan='2'></br></td></tr>
            <tr><th colspan='2'<label for="senha">Senha: </label></th></tr>
            <tr><td colspan='2'><input type="password" name="senha" id="senha" style="width:450px"></td></tr>
            <tr><td colspan='2'></br></td></tr>
            <tr><th><center><input type="submit" value="Entrar" style="width:150px;align:right;"></center></th>
        </form></table></center>
    </body>
</html>
