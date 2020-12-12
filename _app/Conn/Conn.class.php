<?php

class Conn
{
	private static $Host = HOST;
	private static $User = USER;
	private static $Pass = PASS;
	private static $Dbsa = DBSA;
	/** @Var PDO */
	private static $connect = null;
	
	/** 
	* Conecta com o banco de dados com o pattern singleton 
	* Retorna um objeto PDO
	*/
	private static function Conectar()
	{
		try
		{
			$dsn = 'mysql:host='.self::$Host.';dbname='.self::$Dbsa;
			$options = [ PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'];
			if(self::$connect == null):
				self::$connect = new PDO($dsn, self::$User, self::$Pass, $options);
			endif;
		}
		catch(PDOException $e)
		{
			PHPErro($e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine());
			die;
		}
		
		self::$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return self::$connect;
	}
	
	/** Retorna um objeto PDO Singleton Pattern */
	public static function getConn()
	{
		return self::Conectar();
	}
}

?>