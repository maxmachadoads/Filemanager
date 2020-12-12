<?php
// CONFIGURAÇÕES DO APP ####################
define('HOST','localhost');
define('USER','root'); // Usuário para acessar o banco de dados
define('PASS',''); // Senha para acessaro o banco de ados
define('DBSA','dbispconfig');
// AUTO LOAD DE CLASSES  ####################
spl_autoload_register(function ($Class) {
 
	$cDir = ['Conn', 'Helpers', 'Models'];
	$iDir = null;
	
	foreach($cDir as $dirName)
	{
		if(!$iDir && file_exists(__DIR__ . "/{$dirName}/{$Class}.class.php") && !is_dir(__DIR__ . "/{$dirName}/{$Class}.class.php")):
			include_once (__DIR__ . "/{$dirName}/{$Class}.class.php");
			$iDir = true;
		endif;
	}
        if(!$iDir):
            trigger_error("Não foi possível incluir {$Class}.class.php", E_USER_ERROR);
            die;
	endif;
});

// TRATAMENTO DE ERROS  ####################
// CSS CONSTANTES :: Mensagens de Erro
define('UI_ACCEPT','accept');
define('UI_INFOR','infor');
define('UI_ALERT','alert');
define('UI_ERROR','error');

//UIErro :: Exibe erros lançados :: Front
function UIErro($ErrMsg, $ErrNo, $ErrDie = null)
{
	$CssClass = ($ErrNo == E_USER_NOTICE ? UI_INFOR : ($ErrNo == E_USER_WARNING ? UI_ALERT : ($ErrNo == E_USER_ERROR ? UI_ERROR : $ErrNo)));
	echo "<div class=\"trigger {$CssClass}\">{$ErrMsg}<span class=\"ajax_close\"></span></div>";
	
	if($ErrDie):
		die;
	endif;
}
//PHPErro :: Personaliza o gatilho do PHP
function PHPErro($ErrNo, $ErrMsg, $ErrFile, $ErrLine)
{
	$CssClass = ($ErrNo == E_USER_NOTICE ? UI_INFOR : ($ErrNo == E_USER_WARNING ? UI_ALERT : ($ErrNo == E_USER_ERROR ? UI_ERROR : $ErrNo)));
	echo "<p class=\"trigger {$CssClass}\">";
	echo "<b>Erro na linha: #{$ErrLine} ::</b> {$ErrMsg}<br />";
	echo "<small>{$ErrFile}</small>";
	echo "<span class=\"ajax_close\"></span></p>";
	
	if($ErrNo == E_USER_ERROR):
		die;
	endif;
}

?>