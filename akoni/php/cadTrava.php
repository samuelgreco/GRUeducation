<?php

require_once("../../lib/php/cmd_sql.php");
require_once("cadLog.php");

Alterar();

function Alterar(){
	$con = new cmd_SQL();

	setlocale(LC_CTYPE,"pt_BR");

	$db[sql]="UPDATE AKONI_TRAVA SET " . $_POST["campo"];

	if ($con->alterar($db)){
		echo "1";
	}else {
		echo "0";
	}
}

?> 