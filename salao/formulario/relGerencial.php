<?php
session_start();
require_once ("../../lib/php/cmd_sql.php");
?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>SALAO</title>
	<link rel="stylesheet" type="text/css" href="../../lib/css/estilo.css" />
	<link rel="stylesheet" type="text/css" href="../../lib/css/jquery.validationEngine.css" />
	<link rel="stylesheet" type="text/css" href="../../lib/css/jquery-ui-1.8.11.custom.css" />
	<script type="text/javascript" src="../../lib/js/jquery-1.9.1.js"></script>
	<script type="text/javascript" src="../../lib/js/jquery-ui.js"></script>
	<script type="text/javascript" src="../../lib/js/jquery.validationEngine-ptBr.js"></script>
	<script type="text/javascript" src="../../lib/js/jquery.validationEngine.js"></script>
	<script type="text/javascript" src="../js/relGerencial.js"></script>

</head>
<!--  <a href='javascript:history.back(2)' class='Voltar' >Voltar</a> -->
<body>
<h1>Relat&oacute;rio de alunos inscritos por ano</h1>
<form id="frmGerencial" name="frmGerencial" method="post" action="relListaGerencial.php">
<table>
	<tr>
		<td>Dia: *<br />
		<input name="txtDt" type="text" id="txtDt"/>
	</td></tr>
	<?php $data = implode("-",array_reverse(explode("/",'". $_POST["txtDt"] ."')));?>
	
</table>
<br />
<br />
<table>
	<tr>
		<td><input type="button" name="cmdGerar" id="cmdGerar" value="Gerar" class="Relatorio" /></td>
	</tr>
</table>
</form>
</body>
</html>
