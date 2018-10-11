<?php
// inclui o arquivo de inicializaчуoo:
require_once 'init.php';
// Verifica se o usuсrio estс logado, se nуo estiver logado; envia para o formulario de login:
if (!LoggedIn())
{
    header('Location: form-login.php');
}

