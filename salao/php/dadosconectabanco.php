<?php

class DadosConectaBanco {
	/*public $tipo = "mysql";
	public $host = "172.16.208.29";
	public $host = "172.16.210.171";154
	public $bd = "salaolivro";
	public $user = "root";
	public $pass = "m0d3r4d0";*/
	
	public $tipo = "mysql";
	public $host = "172.16.208.29";
	public $bd = "salaolivro";
	public $user = "root";
	public $pass = "t3or3m4";
        
	public function __construct() {
		if ($_SERVER['SERVER_NAME'] == "educwebh03.educ.guarulhos.gov") {
			$this->host = "172.16.208.18";
			$this->user = "root";
			$this->pass = "m0d3r4d0";
		}
	}
}

?>
