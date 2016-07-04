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
        <script type="text/javascript" src="../js/relMunicipalDataHorario.js"></script>

</head>
<!--  <a href='javascript:history.back(2)' class='Voltar' >Voltar</a> -->
<body>
<h1>Relat&oacute;rio di&aacute;rio de vagas em escolas municipais</h1>
<form id="frmMunicipalData" name="frmMunicipalData" method="post" action="relListaMunicipalData.php">
<table>
	<tr>
		<td>Dia: *<br />
		<input name="txtDt" type="text" id="txtDt" class="validate[required]"/>
	</td></tr>
	<?php $data = implode("-",array_reverse(explode("/",'". $_POST["txtDt"] ."')));?>
	<tr>
		<td>Hora: *<br />

 <select id="txtHR" name="txtHR">
                                <option value="">Todos hor&aacute;rios</option>
                                <option value="08:00">08:00</option>
                                <option value="08:30">08:30</option>
                                <option value="09:00">09:00</option>
                                <option value="09:30">09:30</option>
                                <option value="10:00">10:00</option>
                                <option value="10:30">10:30</option>
                                <option value="11:00">11:00</option>
                                <option value="11:30">11:30</option>
                                <option value="12:00">12:00</option>
                                <option value="12:30">12:30</option>
                                <option value="13:00">13:00</option>
                                <option value="13:30">13:30</option>
                                <option value="14:00">14:00</option>
                                <option value="14:30">14:30</option>
                                <option value="15:00">15:00</option>
                                <option value="15:30">15:30</option>
                                <option value="16:00">16:00</option>
                                <option value="16:30">16:30</option>
                                <option value="17:00">17:00</option>
                                <option value="17:30">17:30</option>
                                <option value="18:00">18:00</option>
                                <option value="18:30">18:30</option>
                                <option value="19:00">19:00</option>
                                <option value="19:30">19:30</option>
                                <option value="20:00">20:00</option>
                                <option value="20:30">20:30</option>
                                <option value="21:00">21:00</option>
                            </select>
		
		
	</td></tr>
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
