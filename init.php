<?php 
 /*=============================
   Configura��es do PHP
   =============================*/
 // Define valores padr�o para diretivas do php.ini
ini_set( 'error_reporting', -1 );
ini_set( 'display_errors', 0 ); // deve ser definida para zero (0) em ambiente de produ��o
 
// Timezone:
date_default_timezone_set( 'America/Sao_Paulo' ); 
 
// Tempo m�ximo de execu��o de um script:
set_time_limit( 60 );

/*======================================
   Cria constantes usadas na aplica��o
  ======================================*/
// conex�o com base de dados:
define( 'BD_SERVIDOR', 'localhost' );
define( 'BD_USUARIO', 'root' );
define( 'BD_SENHA', '' );
define( 'BD_NOME', 'dbvivasilo' );
 
/* Conex�o SMTP:
define( 'SMTP_SERVIDOR', 'mail.servidor.com.br' );
define( 'SMTP_USUARIO', 'usuario' );
define( 'SMTP_SENHA', 'senha' );*/

// habilita todas as exibi��es de erros:
ini_set('display_errors', true);
error_reporting(E_ALL);

// inclui o arquivo de fun��es:
require_once 'functions.php';