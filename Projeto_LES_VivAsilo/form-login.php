<!doctype html>
<html>
    <head>
        <meta charset="utf-8">

        <title>Login</title>
    </head>

    <body>
        <?php require 'init.php';?>
        <h1>Login</h1>

        <form action="login.php" method="post">
            <label for="email">E-mail: </label>
            <br>
            <input type="text" name="email" id="email">

            <br><br>

            <label for="password">Senha: </label>
            <br>
            <input type="password" name="senha" id="senha">

            <br><br>

            <input type="submit" value="Entrar">
        </form>
    </body>
</html>