<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Processo Seletivo Simplificado 2015</title>


<link href="../../lib/css/estilo.css" rel="stylesheet" type="text/css" />

</head>

<body>

	<div id="tela">
		
		<form class="form">

<?php

require_once("../../lib/php/cmd_sql.php");
require_once("cadLog.php");

$acao = "";
$id = "";

if (isset($_POST['txtID'])){
	$id = $_POST["txtID"];
}

if (isset($_GET['acao'])){
	$acao = $_GET["acao"];
}

if ($id>0){
	Alterar($id);
}else{
	Incluir();
}

function Incluir()
{
	$con = new cmd_SQL();

	setlocale(LC_CTYPE,"pt_BR");

	$db['tab']="AKONI_INFORMACOES";
	$db['campos']="TITULO,".
				"CORPO,".
				"DATASISTEMA,".
				"VISIVEL";	
				
	$db['values']= "'".$_POST["txtTitulo"]."',".
				"'".($_POST["txtTexto"])."',".
				"SYSDATE,".
				"'1'";
	
	$db['values']= (utf8_decode($db['values']));
	
	//echo $db[sql];
	
	if ($con->incluir($db))
	{
		echo "<br><h1>Salvo com sucesso!</h1>";
		SalvarLog("AKONI_INFORMACOES", "INSERE INFORMACAO", "insert into " . $db['tab'] . "(" . $db['campos'] . ")values(" . $db['values'] . ")");
		//echo "insert into " . $db['tab'] . "(" . $db['campos'] . ")values(" . $db['values'] . ")";
	}else {
		echo "Ocorreu um erro. Verifique se as informa&ccedil;&otilde;es est&atilde;o corretas!<br />";
		echo "insert into " . $db[tab] . "(" . $db[campos] . ")values(" . $db[values] . ")";
	}
}

function Alterar($id)
{
	$con = new cmd_SQL();

	$db['sql']="update AKONI_INFORMACOES set TITULO='".$_POST["txtTitulo"]."',".
										"CORPO='".$_POST["txtTexto"]."'";
	
	$db['sql']= utf8_decode($db['sql']) . " Where IDINFORMACAO = " . $id;
	
	//echo $db[sql];
	if ($con->alterar($db))
	{
		echo "<br> <h1>Salvo com sucesso!</h1>";
		SalvarLog("AKONI_INFORMACOES", "ALTERA INFORMACAO", $db['sql']);
	}else {
		echo " Erro na altera&ccedil;&atilde;o!<br />";
		echo $db[sql];
	}
}

?> 
		<center>
		<a href="../formularios/lstNoticias.php" class=Voltar>Voltar</a>
		</center>
		</form>
	</div>
</body>
</html>