<!doctype html>
<html>
    <head>
        <meta charset="utf-8">

        <title>Cadastro - VivAsilo</title>
    </head>

    <body>
        <h1>Cadastro - VivAsilo</h1>

        <form action="register.php" method="post">
            <label for="nome">Nome: </label><br>
            <input type="text" name="nome" id="nome" required><br><br>
            <label for="email">E-mail: </label><br>
            <input type="email" name="email" id="email" required><br><br>
            <label for="senha">Senha: </label><br>
            <input type="password" name="senha" id="senha" required><br><br>

            <input type="submit" value="Cadastrar"><input type="reset" value="Limpar"/>
        </form>
    </body>
</html>