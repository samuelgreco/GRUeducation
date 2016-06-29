<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<title>Processo Seletivo Simplificado 2015</title>
<link href="../../lib/css/estilo.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<h1>
<?php
require_once ("../../lib/php/cmd_sql.php");
require_once ("cadLog.php");

$acao = $_POST ["acao"];
$id = $_POST ["txtID"];

Incluir();

function Incluir() {
	$banco = new Banco();
	$conn = $banco->conectar($bd);
	
	// Montando a inclus�o
	$sql = "INSERT INTO AKONI_ARQUIVOS (NOME, ARQUIVO, VISIVEL) VALUES (".
            utf8_decode ( "'".$_POST['txtNome']."'," .
					"EMPTY_BLOB()," .
					"'1'") ."
        ) RETURNING ARQUIVO INTO :ARQUIVO";
	
	try {
		//Prepara a conex�o
		$stmt = $conn->prepare($sql);
		
		//$fp = fopen('../images/teste.pdf', 'rb');
		$fp = fopen($_FILES['txtArquivo']['tmp_name'], 'rb');
		$stmt->bindParam(':ARQUIVO', $fp, PDO::PARAM_LOB);
		
		//Inicia a transa��o, executa e realiza commit
		$conn->beginTransaction();
		$stmt->execute();
		$conn->commit();
		
		echo "Salvo com sucesso!";//true
		SalvarLog("AKONI_ARQUIVOS", "INSERE ARQUIVO", $sql);
	} catch (Exception $e) {
		echo " Ocorreu um erro! Entre em contato com a administra&ccedil;&atilde;o."; // false;
		echo $sql;
		exit;
	}
}

//echo $id;
?> 
</h1>
			<p>&nbsp;</p>
			<p></p> <br />
			<table style="width: 500px;">
				<tr>
					<td><a href="../formularios/lstArquivos.php" class="Voltar">Voltar</a></td>
				</tr>
			</table>
</body>
</html>