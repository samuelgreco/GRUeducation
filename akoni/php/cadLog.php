<?php
session_start();
/* require_once("../../lib/php/cmd_sql.php");

$tab = "CONCURSO_TESTE";
$acao = "ACAO TESTE";
$cmd = "INSERT INTO CONCURSO_TESTE (TESTE) VALUES ('TESTE')"; */

//SalvarLog($tab, $acao, $cmd);

function SalvarLog($tab, $acao, $cmd){
	$con = new cmd_SQL ();
		
	setlocale ( LC_CTYPE, "pt_BR" );
	
	$db [tab] = "AKONI_LOG";
	$db [campos] = "IDUSUARIO,
					DATASISTEMA,
					TABELA,
					ACAO,
					COMANDO";
	
	$db [values] = "'" . ($_SESSION ["varIDUser"]) . "'," .
											"SYSDATE," .
											"'" . ($tab) . "'," .
											"'" . ($acao) . "'," .
											"'" . (htmlentities(utf8_encode($cmd), ENT_QUOTES)) . "'";
	
	if ($con->incluir ( $db )) {		
		//echo "salvo";
	}else{
		echo "Erro ao inserir registro de histórico (log)";
		echo "<br /><br />insert into " . $db [tab] . "(" . $db [campos] . ")values(" . $db [values] . ")</h1>";
	}
}

?> 