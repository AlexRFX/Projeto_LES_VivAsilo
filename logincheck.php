<?php
// inclui o arquivo de inicializa��oo:
require_once 'init.php';
// Verifica se o usu�rio est� logado, se n�o estiver logado; envia para o formulario de login:
if (!LoggedIn())
{
    header('Location: form-login.php');
}

