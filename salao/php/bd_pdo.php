<?php

require_once("dadosconectabanco.php");

class Banco
{
	
	private function pegaDadosConexao($db)
	{
		//Atribui os dados para o vetor de conexão com o banco
		
		$dadosCon = new DadosConectaBanco();
		$db['tipo']=$dadosCon->tipo;
		$db['host']=$dadosCon->host;
		$db['bd']=$dadosCon->bd;
		$db['user']=$dadosCon->user;
		$db['pass']=$dadosCon->pass;
		
		return $db;
	}
	
	public function conectar($db)
	{
		//Pega dados de conexão
		$db = $this->pegaDadosConexao($db);
		
		$con = $this->tipo_bd($db);
		
		if ($con) 
			{try
			{$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $con;}
			catch(PDOException $e)
		{$msg = "Erro de conexão com o banco de dados: Código: " . $e->getCode() . "Mensagem " . $e->getMessage()."hora: ".date('H:i:s');}
		return ($con=false);}
	}
		
		// &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
		
	private function tipo_bd($db)
	{
		switch ($tipo = $db['tipo']){
		case 'mysql':
			
			$con = new PDO("mysql:host=".$db['host'].";dbname=".$db['bd'],$db['user'],$db['pass']);
			break;
		case 'pgsql':
			$con = new PDO("pgsql:dbname={$bd};user={$user}; password={$pass};host=$host");
			break;
		case 'oci8':
			$tns = "(DESCRIPTION=(ADDRESS_LIST=(ADDRESS=(PROTOCOL=TCP)(HOST=".$db['host'].")(PORT=1521)))(CONNECT_DATA=(SID=".$db['bd'].")))";
			$con = new PDO("oci:dbname=".$tns,$db['user'],$db['pass'],array( PDO::ATTR_PERSISTENT => true));
			break;
		case 'mssql':
			$con = new PDO("mssql:host={$host},1433;dbname={$bd}", $user, $pass);
			break;
		}return $con;
	}
}
?>
