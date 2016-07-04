<?php
session_start();

require_once("cmd_sql.php");
switch($_POST["acao"]){
	case 'editar':
		Alterar($_POST["idinscricao"]);
		break;
	case 'salvar':
		Incluir();
		break;
	case 'excluir':
		Excluir($_POST["idinscricao"]);
		break;
}
	//Incluir($onibus, $espetaculo, $vagas);
		

function Incluir(){
	$con = new cmd_SQL();

	setlocale(LC_CTYPE,"pt_BR");

	//$data_inicio = substr($_POST["Data"], 6, 4) . "-" . substr($_POST["txtData"], 3, 2) . "-" . substr($_POST["txtData"], 0, 2);

	$db['tab']="inscricao";
	$db['campos']="idhorario, " .
				"escola, " .
				"onibus, " .
				"tipo, " .
				"vagas";
	

	$db['values']= mb_strtoupper (utf8_decode("" . ($_POST["idhorario"]) . "," .
				 "" . ($_SESSION["ID"]) . "," .
			 	 "" . ($_POST["onibus"]) . "," .
			 	 "" . ($_POST["tipo"]) . "," .	
				 trim(($_POST["vagas"]))));
	
	if($_POST["tipo"]=='1') {
		$db['campos'].=",estagio_1, estagio_2, ano_1, ano_2, ano_3, ano_4, ano_5";
		$db['values'].= "," . $_POST["estagio1"] . "," .
						$_POST["estagio2"] . "," .
						$_POST["ano1"] . "," .
						$_POST["ano2"] . "," .
						$_POST["ano3"] . "," .
						$_POST["ano4"] . "," .
						$_POST["ano5"];
	}

//echo "insert into " . $db['tab'] . "(" . $db['campos'] . ")values(" . $db['values'] . ")";

	if ($con->incluir($db)){
		echo true;
	}else {
		echo false;
		//echo "insert into " . $db['tab'] . "(" . $db['campos'] . ")values(" . $db['values'] . ")";
	}
}

function Alterar($id){
	$con = new cmd_SQL();
	
	setlocale(LC_CTYPE,"pt_BR");

	$db['sql']=" Update inscricao set vagas = " . $_POST["vagas"];
	
	if($_POST["tipo"]=='1') {
		$db['sql'].= ", estagio_1 = ". $_POST["estagio1"] . 
					", estagio_2 = " . $_POST["estagio2"] .
					", ano_1 = " . $_POST["ano1"] .
					", ano_2 = " . $_POST["ano2"] .
					", ano_3 = " . $_POST["ano3"] .
					", ano_4 = " . $_POST["ano4"] .
					", ano_5 = " . $_POST["ano5"];
	}
	
	$db['sql'].= " where idinscricao = " . $id;
	//echo $db['sql'];
	
	if ($con->alterar($db)){
		echo true;
	}else {
		echo false;
		//echo $db['sql'];
	}
}

function Excluir($id){
	$con = new cmd_SQL();

	setlocale(LC_CTYPE,"pt_BR");

	$db[tab]="inscricao";
	$db[cond]="idInscricao=" . $id;

	if ($con->excluir($db)){
		echo true;
	}else {
		echo false; //false;
	}
}

?> 