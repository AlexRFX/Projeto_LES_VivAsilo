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
        <h1>Login - VivAsilo</h1>

        <form action="login.php" method="post">
            <label for="email">E-mail: </label>
            <br>
            <input type="text" name="email" id="email">

            <br><br>

            <label for="senha">Senha: </label>
            <br>
            <input type="password" name="senha" id="senha">

            <br><br>

            <input type="submit" value="Entrar">
        </form>
    </body>
</html>