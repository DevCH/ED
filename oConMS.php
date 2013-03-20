<?php
class oConMS
{
	public  static $instancia;
	public $myServer;
	public $myUser;
	public $myPass;
	public $myDB;
	
	private function __construct()
	{
		$this->myServer = "192.168.254.247\COMPAC";
		$this->myUser   = "web1";
		$this->myPass   = "123";
		$this->myDB     = "ctSistema_Informativo_de_Tabasco_2010";
	}

	public static function getInstance(){
		if(!self::$instancia instanceof self){
			self::$instancia = new self;
		}
		return self::$instancia;
	}

	public function oConn(){
		$link = mssql_connect($this->myServer, $this->myUser, $this->myPass);
		if ( !$link ) {
  			if ( function_exists('error_get_last') ) {
     			var_dump(error_get_last());
           	}
  			die('connection failed');
		}
		die('connection allowed');
		return $link;
	}
}
?>
