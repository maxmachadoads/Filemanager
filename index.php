<?php
session_start();
//Endereço Base para arquivos
if( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ):
    $base = 'https://' . $_SERVER['HTTP_HOST'] . '/';
else:
    $base = 'http://' . $_SERVER['HTTP_HOST'] . '/';
endif;
define('BASE', $base);
?>
<!DOCTYPE html>
<html lang="pt_BR">
    <head>
        <meta charset="UTF-8">
        <title>File Manager - By Max Machado</title>
        <link rel="stylesheet" type="text/css" href="<?= BASE; ?>filemanager/assets/stylesheets/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="<?= BASE; ?>filemanager/assets/stylesheets/fontawesome.css">
        <link rel="stylesheet" type="text/css" href="<?= BASE; ?>filemanager/assets/stylesheets/main.css">
        
        <script type="text/javascript" src="<?= BASE; ?>filemanager/assets/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?= BASE; ?>filemanager/assets/js/main.js"></script>
    </head>
    <body>
        <div class="container" id="pageContent">
            <?php  
            if(!isset($_SESSION['sys'])):
                require_once './login.php';
            else:
                require_once './explorer.php';
            endif;            
            ?>
        </div>
    </body>
</html>
