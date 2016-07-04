<?php

require_once("cmd_sql.php");

switch ( $_POST["acao"] ) {
	
	case "salvar":
		$id = $_POST["txtID"];

		if ($id>0){
			Alterar($id);
		}else{
			Incluir();
		}
		break;
	default:
		break;
}

function Incluir(){
	$con = new cmd_SQL();

	setlocale(LC_CTYPE,"pt_BR");

	$data = substr($_POST["txtData"], 6, 4) . "-" . substr($_POST["txtData"], 3, 2) . "-" . substr($_POST["txtData"], 0, 2);

	$db['tab']="horario";
	$db['campos']="data, " .
				"horaInicio, " .
				"horaFim, " .
				"vagas, " .
				"idtipo_dependencia";

	$db['values']= mb_strtoupper(utf8_decode("'".$data."',".
				"'" . ($_POST["cboHoraInicio"]) . "'," .
				"'" . ($_POST["cboHoraFim"]) . "'," .
				"'" . ($_POST["txtVagas"]) . "'," .
				"" . ($_POST["cboTipo"])));

	//echo "insert into " . $db['tab'] . "(" . $db['campos'] . ")values(" . $db['values'] . ")";

	if ($con->incluir($db))
	{
		echo true;
	}else {
		echo false; //false;
		//echo "insert into " . $db['tab'] . "(" . $db['campos'] . ")values(" . $db['values'] . ")";
	}
}

function Alterar($id)
{
	$con = new cmd_SQL();
	
	setlocale(LC_CTYPE,"pt_BR");

	$data = substr($_POST["txtData"], 6, 4) . "-" . substr($_POST["txtData"], 3, 2) . "-" . substr($_POST["txtData"], 0, 2);

	$db['sql']=" Update horario set data = " . mb_strtoupper (utf8_decode("'" . $data . "',")) .
			"horaInicio = " . mb_strtoupper (utf8_decode("'" . $_POST["cboHoraInicio"] . "',")) .
			"horaFim = " . mb_strtoupper (utf8_decode("'" . $_POST["cboHoraFim"] . "',")) .
			"vagas = " . mb_strtoupper (utf8_decode("'" . $_POST["txtVagas"] . "',")) .			
			"idtipo_dependencia = " . mb_strtoupper (utf8_decode("" . $_POST["cboTipo"] . ""));

	$db['sql']= $db['sql'] . " Where idHorario = " . $id;
	
	//echo $db['sql'];
	
	if ($con->alterar($db))
	{
		echo true;
	}else {
		echo false;
		//echo $db['sql'];
	}
}
?> 