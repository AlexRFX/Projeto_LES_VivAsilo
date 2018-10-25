<!doctype html>
<html>
    <head>
        <meta charset="utf-8">

        <title>Cadastro - VivAsilo</title>
    </head>

    <body>
        <?php 
        // Include da NavBar
        include 'navbar.php';?>
        
        <header><b>Cadastro - VivAsilo</b></header>
        <br>
        <br>
        <center><table>
        <form action="register.php" method="post">
            <tr><th colspan='2'><label for="nome">Nome: </label></th></tr>
            <tr><td colspan='2' ><input type="text" name="nome" id="nome" required></td></tr>
            <tr><td colspan='2'></br></td></tr>
            <tr><th colspan='2'><label for="email">E-mail: </label></th></tr>
            <tr><td colspan='2'><input type="email" name="email" id="email" required style="width:415px"></td></tr>
            <tr><td colspan='2'></br></td></tr>
            <tr><th colspan='2'><label for="senha">Senha: </label></th></tr>
            <tr><td colspan='2' ><input type="password" name="senha" id="senha" required></td></tr>
            <tr><td></br></td></tr>
            <tr><th><input type="submit" value="Cadastrar"></th>
                <th><input type="reset" value="  Limpar  "/></th></tr>
        </form></table></center>
    </body>
</html>
