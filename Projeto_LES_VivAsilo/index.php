<?php session_start();?>
<?php require_once 'config.php'; ?>	
<?php require_once DBAPI; ?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        $db = open_database();
        ?>
    </body>
</html>
<?php $_SESSION["error_message"] = ""; $_SESSION["error_color"] = ""; ?>