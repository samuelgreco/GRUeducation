<?php

require_once("cmd_sql.php");
$id = $_POST["txtID"];

switch ( $_POST["acao"] ) {
	case "salvar":
		if ($id>0){
			Alterar($id);
		}else{
			Incluir();
		}
		break;
	case "alterarsenha":
		alterarSenha($id);
		break;
	case "alterardados":
		alterarDados($id);
		break;
	default:
		break;
}

function Incluir(){
	$con = new cmd_SQL();

	setlocale(LC_CTYPE,"pt_BR");

	$db['tab']="escola";
	$db['campos']="nome, " .
				"responsavel, " .
				"telefone, " .
				"email, " .
				"onibusdia, " .
				"onibuseja, " .
				"idtipo_dependencia, " .
				"login, " .
				"senha";

	$db['values']= mb_strtoupper(utf8_decode("'".($_POST["txtEscola"])."',".
				"'" . ($_POST["txtResponsavel"]) . "'," .
				"'" . ($_POST["txtTelefone"]) . "'," .
				"'" . ($_POST["txtEmail"]) . "'," .
				"'" . ($_POST["txtOnibusDia"]) . "'," .
				"'" . ($_POST["txtOnibusEJA"]) . "'," .
				"'" . ($_POST["cboTipo"]))) . "'," .
				"'" . ($_POST["txtLogin"]) . "'," .
				"'" . ($_POST["txtSenha"]) . "'";

	//echo "insert into " . $db['tab'] . "(" . $db['campos'] . ")values(" . $db['values'] . ")";

	if ($con->incluir($db)){
		echo true;
	}else {
		echo false; //false;
		//echo "insert into " . $db['tab'] . "(" . $db['campos'] . ")values(" . $db['values'] . ")";
	}
}

function Alterar($id){
	$con = new cmd_SQL();
	
	setlocale(LC_CTYPE,"pt_BR");

	$db['sql']=" Update escola set nome = " . mb_strtoupper (utf8_decode("'" . $_POST["txtEscola"] . "',")) .
			"responsavel = " . mb_strtoupper (utf8_decode("'" . $_POST["txtResponsavel"] . "',")) .
			"telefone = " . mb_strtoupper (utf8_decode("'" . $_POST["txtTelefone"] . "',")) .
			"email = " . mb_strtoupper (utf8_decode("'" . $_POST["txtEmail"] . "',")) .	
			"onibusdia = " . mb_strtoupper (utf8_decode("'" . $_POST["txtOnibusDia"] . "',")) .
			"onibuseja = " . mb_strtoupper (utf8_decode("'" . $_POST["txtOnibusEJA"] . "',")) .
			"login = '" . $_POST["txtLogin"] . "'," .
			"senha = '" . $_POST["txtSenha"] . "'," .	
			"idtipo_dependencia = " . $_POST["cboTipo"];

	$db['sql']= $db['sql'] . " Where idEscola = " . $id;
	
	//echo $db[sql];
	
	if ($con->alterar($db))
	{
		echo true;
	}else {
		echo false;
		//echo $db[sql];
	}
}

function alterarSenha($id) {
	$con = new cmd_SQL();
	$db['sql']=" UPDATE escola SET senha = '" . $_POST["txtSenha"] . "'";                                                
	$db['sql'].=" WHERE idEscola = " . $id;
	//echo $db[sql];

	if ($con->alterar($db)) {
		echo true;
	}else {
		echo false;
		//echo $db[sql];
	}
}

function alterarDados($id) {
	$con = new cmd_SQL();
	$db['sql']=" UPDATE escola SET senha = '" . $_POST["txtSenha"] . "'," .
			"responsavel = " . mb_strtoupper (utf8_decode("'" . $_POST["txtResponsavel"] . "',")) .
			"telefone = " . mb_strtoupper (utf8_decode("'" . $_POST["txtTelefone"] . "',")) .
			"email = " . mb_strtoupper (utf8_decode("'" . $_POST["txtEmail"] . "'")) .	                       
	$db['sql'].=" WHERE idEscola = " . $id;
	//echo $db[sql];

	if ($con->alterar($db)) {
		echo true;
	}else {
		echo false;
		//echo $db[sql];
	}
}
?> 