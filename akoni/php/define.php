<?php

session_start();

switch ($_POST["filtro"]){
	case 'IDPesquisa':
		$_SESSION["varID"] = $_POST["varID"];
		break;
	case 'definirEtapa':
		definirEtapa($param);		
		break;
	case 'DefineLogin':
		$_SESSION["varIDUser"] = $_POST["IDUser"];
		break;
	case 'DestroiSessao':
		unset($_SESSION["varIDUser"]);
		unset($_SESSION["varID"]);
		break;
	case 'GetLogin':
		if (isset($_SESSION["varIDUser"])) {
			echo $_SESSION["varIDUser"];
		}else{
			echo 0;
		}
	    break;
	default:
		break;
}


function definirEtapa($param) {	
	switch ($_POST['txtEtapa']){
		case "0":
			//???
			break;
		case "1":
			$_SESSION['etapaInscricao'][1]['txtIdTipoEscola']=$_POST['txtIdTipoEscola'];
			$_SESSION['etapaInscricao'][1]['txtIdEscola']=$_POST['txtIdEscola'];
			$_SESSION['etapaInscricao'][1]['txtIdProfessor']=$_POST['txtIdProfessor'];
			$_SESSION['etapaInscricao'][1]['txtIdCategoria']=$_POST['txtIdCategoria'];	
			break;
		case "2":
			$_SESSION['etapaInscricao'][2]['txtIdTipoEscola']=$_POST['txtIdTipoEscola'];
			$_SESSION['etapaInscricao'][2]['txtIdEscola']=$_POST['txtIdEscola'];
			$_SESSION['etapaInscricao'][2]['txtIdProfessor']=$_POST['txtIdProfessor'];
			$_SESSION['etapaInscricao'][2]['txtIdCategoria']=$_POST['txtIdCategoria'];
			break;
		case "3":
			$_SESSION['etapaInscricao'][3]['txtIdTipoEscola']=$_POST['txtIdTipoEscola'];
			$_SESSION['etapaInscricao'][3]['txtIdEscola']=$_POST['txtIdEscola'];
			$_SESSION['etapaInscricao'][3]['txtIdProfessor']=$_POST['txtIdProfessor'];
			$_SESSION['etapaInscricao'][3]['txtIdCategoria']=$_POST['txtIdCategoria'];
			break;
		case "4":
			$_SESSION['etapaInscricao'][4]['txtIdTipoEscola']=$_POST['txtIdTipoEscola'];
			$_SESSION['etapaInscricao'][4]['txtIdEscola']=$_POST['txtIdEscola'];
			$_SESSION['etapaInscricao'][4]['txtIdProfessor']=$_POST['txtIdProfessor'];
			$_SESSION['etapaInscricao'][4]['txtIdCategoria']=$_POST['txtIdCategoria'];
			break;
	
		default:
			break;
	}
	
	//APOS GRAVAR tudo NO cadInscricao, ===>>> $_SESSION['etapaInscricao']==null;
}

?>