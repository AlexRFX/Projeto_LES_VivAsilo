<!doctype html>
<html>
    <head>
        <meta charset="utf-8">        
        <title>Cadastro - VivAsilo</title>
        <style></style>    
    </head>
    <body>
        <?php 
        // Include da NavBar
        $pagina="form-register";
        include '../navbar.php';?>
        
        <p class="nome">Cadastro - VivAsilo</p>
        <div class="container">
                <div class="row">
                    <div class="col-12 verd comens">
        <center><table>
        <form action="register.php" method="post">
            <tr><th colspan='3'><label for="nome" class="fonte2">Nome: </label></th></tr>
            <tr><td colspan='3' ><input type="text" name="nome" maxlength="40" id="nome" class="form-control input-lg" required></td></tr>
            <tr><td colspan='3'></br></td></tr>
            <tr><th colspan='3'><label for="email" class="fonte2">E-mail: </label></th></tr>
            <tr><td colspan='3'><input type="email" name="email" id="email"  class="form-control input-lg" required></td></tr>
            <tr><td colspan='3'></br></td></tr>
            <tr><th colspan='3'><label for="senha" class="fonte2">Senha: </label></th></tr>
            <tr><td colspan='3' ><input type="password" name="senha" minlength="6" maxlength="12" placeholder="De 6 a 12 caracteres" id="senha"  class="form-control input-lg" required></td></tr>
            <tr><td></br></td></tr>
            <tr><td></td>
                <td><input type="submit" value="Cadastrar" class="form-control input-lg"></th>
                <td><input type="reset" value="Limpar" class="form-control input-lg"/></th></tr>
        </form></table></center></div></div></div>
    </body>
</html>
