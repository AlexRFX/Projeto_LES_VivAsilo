<?php
// inclui o arquivo de inicialização:
require_once 'init.php';
// Verifica se o usuário está logado, se não estiver logado; envia para o formulario de login:
if (!LoggedIn())
{
    header('Location: form-login.php');
}

