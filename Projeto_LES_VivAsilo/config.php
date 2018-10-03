<?php
/* Arquivo de configurações, contendo todos os caminhos e utilizações que serão
 * usadas mais de uma vez pelo sistema
 */

/*Nome do banco de dados */
define('DB_NAME', 'dbvivasilo');

/*Usuário do banco de dados */
define('DB_USER', 'admin');

/*Senha do banco de dados */
define('DB_PASSWORD', '');

/*Endereço do banco de dados */
define('DB_HOST', 'localhost');

/*Caminho absoluto para o sistema */
if (!defined('ABSPATH'))
    define('ABSPATH', dirname('VIVASILO') . '/');

/*Caminho no server para o sistema */
if (!defined('BASEURL'))
    define('BASEURL', '/VIVASILO/');

/*Caminho do arquivo de banco de dados*/
if (!defined('DBAPI'))
    define('DBAPI', ABSPATH . 'inc/DBconnec.php');

/*Caminho para o arquivo de tratamento de entrada para o registro */
if (!defined('TRATAMENTOREGISAPI'))
    define('TRATAMENTOREGISAPI', ABSPATH . 'inc/tratamentoregistro.php');

/**Caminho para o arquivo de tratamento de entrada para o login **/
if (!defined('TRATAMENTOLOGINAPI'))
    define('TRATAMENTOLOGINAPI', ABSPATH . 'inc/tratamentologin.php');

/**Caminho para o arquivo de tratamento de entrada para a modificação **/
if (!defined('TRATAMENTOMODIFICAPI'))
    define('TRATAMENTOMODIFICAPI', ABSPATH . 'inc/tratamentomodificar.php');

/*Caminho para o arquivo de retirada de dados do banco de dados */
if (!defined('OUTPUTDATA'))
    define('OUTPUTDATA', ABSPATH . 'inc/output.php');

/*Caminho pro template da header */
define('HEADER_TEMPLATE', ABSPATH . 'inc/header.php');
    
?>