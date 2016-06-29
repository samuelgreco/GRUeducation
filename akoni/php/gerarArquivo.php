<?php
session_start();
ob_start();

class GerarArquivo{
	
	public function __construct(){
		$request = $_POST;
		if ($_SERVER["REQUEST_METHOD"] == "GET") {
			$request = $_GET;
		}
		
		require_once("../../lib/php/bd_pdo.php");
		$banco = new Banco();
		$conn = $banco->conectar($bd);
		try{
			$stmt = $conn->prepare("SELECT * FROM AKONI_ARQUIVOS WHERE VISIVEL=1 AND IDARQUIVO=".$request["id"], array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
			$stmt->execute();
			$result = $stmt->fetchAll();
			$result = $result[0];
		}catch (PDOException $e){
			echo "PDOException: ".$e->getMessage();
		}
		
		try{
			header("Content-type:application/pdf");
			echo stream_get_contents($result["ARQUIVO"]);
		}catch (Exception $e){
			echo "PDOException: ".$e->getMessage();
		}
	}
	
}
$GerarArquivo = new GerarArquivo();
?>