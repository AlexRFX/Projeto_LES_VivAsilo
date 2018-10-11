<?php 
 /*=============================
   Configuraчѕes do PHP
   =============================*/
 // Define valores padrуo para diretivas do php.ini
ini_set( 'error_reporting', -1 );
ini_set( 'display_errors', 0 ); // deve ser definida para zero (0) em ambiente de produчуo
 
// Timezone:
date_default_timezone_set( 'America/Sao_Paulo' ); 
 
// Tempo mсximo de execuчуo de um script:
set_time_limit( 60 );

/*======================================
   Cria constantes usadas na aplicaчуo
  ======================================*/
// conexуo com base de dados:
define( 'BD_SERVIDOR', 'localhost' );
define( 'BD_USUARIO', 'root' );
define( 'BD_SENHA', '' );
define( 'BD_NOME', 'dbvivasilo' );
 
/* Conexуo SMTP:
define( 'SMTP_SERVIDOR', 'mail.servidor.com.br' );
define( 'SMTP_USUARIO', 'usuario' );
define( 'SMTP_SENHA', 'senha' );*/

// habilita todas as exibiчѕes de erros:
ini_set('display_errors', true);
error_reporting(E_ALL);

// inclui o arquivo de funчѕes:
require_once 'functions.php';