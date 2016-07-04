<?php

session_start();

switch ($_POST["filtro"]) {
	case 'IDPesquisa':
		$_SESSION["varID"] = $_POST["varID"];
		//echo $_SESSION["varID"];
		break;
	case 'DestroiSessao':
		unset($_SESSION["varID"]);
		unset($_SESSION["ID"]);
		unset($_SESSION["Nome"]);
		unset($_SESSION["oniDia"]);
		unset($_SESSION["oniEJA"]);
		unset($_SESSION["Tipo"]);
		//session_destroy();
		break;
	case 'DefineEscola':
		$_SESSION["Nome"] = $_POST["Nome"];
		$_SESSION["ID"] = $_POST["IDUser"];
		$_SESSION["oniDia"] = $_POST["oniDia"];
		$_SESSION["oniEJA"] = $_POST["oniEJA"];
		$_SESSION["Tipo"] = $_POST["Tipo"];
	    break;
	case 'GetLogin':
		if (isset($_SESSION["ID"])) {
			echo $_SESSION["ID"];
		}else{
			echo 0;
		}
	    break;
	case 'GetTipo':
		if (isset($_SESSION["Tipo"])) {
			echo $_SESSION["Tipo"];
		}else{
			echo 0;
		}
	    break;
	case 'GetIDPesquisa':
		echo $_SESSION["varID"];
		break;
	default:
		break;
}

?>