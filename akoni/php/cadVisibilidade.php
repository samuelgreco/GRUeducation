<?php
require_once ("../../lib/php/cmd_sql.php");
require_once ("cadLog.php");

$acao = $_POST["acao"];
$id = $_POST["id"];

switch($acao){
	case 'visivel':
		visivel($id);
		break;
	case 'excluir':
		excluir($id);
		break;
	default:
		break;
}

function visivel($id){
	$con = new cmd_SQL();
	
	if($_POST["tipo"]=='arquivo'){
		$tab = 'ARQUIVOS';
		$aux = 'ARQUIVO';
	}else if($_POST["tipo"]=='noticia'){
		$tab = 'INFORMACOES';
		$aux = 'INFORMACAO';
	}

	$db['sql']="UPDATE AKONI_".$tab." SET VISIVEL='".$_POST["valor"]."' WHERE ID".$aux." = " . $id;
	
	//echo $db[sql];
	
	if ($con->alterar($db)){
		echo true;
	}else {
		echo false;
	}
}



function excluir($id){
	$con = new cmd_SQL();
	setlocale(LC_CTYPE,"pt_BR");
	
	if($_POST["tipo"]=='arquivo'){
		$tab = 'ARQUIVOS';
		$aux = 'ARQUIVO';
	}else if($_POST["tipo"]=='noticia'){
		$tab = 'INFORMACOES';
		$aux = 'INFORMACAO';
	}
	
	$db[tab]="AKONI_".$tab;
	$db[cond]="ID".$aux."=" . $id;
	
	if ($con->excluir($db)){
		echo "1";
	}else {
		echo $db[cond];
		exit;
	}
}

?> 