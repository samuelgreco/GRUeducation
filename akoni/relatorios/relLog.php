<?php 
require_once ("../../lib/php/cmd_sql.php");
?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Processo Seletivo Simplificado 2015</title>
	<link rel="stylesheet" type="text/css" href="../css/estilo.css" />
	<link rel="stylesheet" type="text/css" href="../css/estiloTabela.css" />
	<link rel="stylesheet" type="text/css"  media='print' href="../css/estiloTabela.css" />
	<link rel="stylesheet" type="text/css" href="../../lib/css/estilo.css" />
	
	<script type="text/javascript" src="../../lib/js/jquery-1.9.1.js"></script>
	<script src="../../lib/js/graphics/highcharts.js"></script>
	<script src="../../lib/js/graphics/exporting.js"></script>
	<script src="../../lib/js/graphics/drilldown.js"></script>
	<script src="../../lib/js/graphics/data.js"></script>
	<style type=text/css>
		.data{
		font: 10px verdana, arial, helvetica, sans-serif;
		text-align:center;
		width: 100%;	
		}
	</style>
	<style type=text/css media='print'>
		.Imprimir, form{
		display: none;
		}
		.tabela{
		background-color: #AAAAAA;
		color: black;
		border:1px solid  #000000;
		border-bottom-style: outset;
		margin-top:7px;
		margin-right: 15px;
		}
		.data{
		font: 10px verdana, arial, helvetica, sans-serif;
		text-align:center;
		width: 100%;	
		}
	</style>
	<body>
	<a id='botao' type='button' class='Imprimir' onclick='window.print()' style='position: absolute; text-align: right; left: 85%;'>Imprimir</a>
	<table style="width: 100%;text-align:center;">
		<tr>
			<td rowspan="2" style="text-align:left;width: 20%;"><img src="../../lib/images/logo_sem_fundo.png" width="90"/></td>
			<td><h1 style="padding:0;margin:0;text-align:center;font-size:22px;">Processo Seletivo Simplificado 2015</h1></td>
			<td rowspan="2" style="width: 20%;"><!-- <img src="../images/logo.png" width="50" /> --></td>
		</tr>
		<tr>
			<td><i>Histórico de ações - Log</i></td>
		</tr>
	</table><br />
	<form id="frmPesquisaLog" name="frmPesquisaLog" method="post" action="relLog.php">
		<table>
			<tr>
				<td>
					Usuário:<br />
					<input type="text" name="txtUser" id="txtUser" />
				</td>
				<td><a href="#" onclick="document.getElementById('frmPesquisaLog').submit();" class="Pesquisar" title="Filtrar">&nbsp;</a></td>
			</tr>
		</table>
	</form>
	<center>
<?php
	$varLog = ConsultaLog($_POST["txtUser"]);
		
	//echo "<h2 style='padding:0;margin:0;text-align:center;font-size:16px;'>Quantidade de inscritos por dia</h2>";
	echo "<table class='CSSTabela' style='width:100%;'>
    		<thead>
    			<tr>
    				<th style='width:125px;'>Data operação</th>
    				<th>Usuário</th>
    				<th>Tabela</th>
    				<th>Ação</th>
    				<th>Comando</th>
    			</tr>
    		</thead>
    		<tbody>";
	
	$qtde=0;$i=0;
	
	foreach ($varLog as $lin => $w) {
		$linhas = "<td>" . utf8_encode($w["DTSISTEMA"]) . "</td>
					<td>" . utf8_encode($w["LOGIN"]) . "</td>
					<td>" . utf8_encode($w["TABELA"]) . "</td>
					<td>" . utf8_encode($w["ACAO"]) . "</td>
					<td>" . utf8_encode($w["CMD"]) . "</td>";
		
		echo "<tr>" . $linhas . "</tr>";
		$i++;
	}
	
	echo "</tbody></table>";
	
	echo "<br /><div class=data>Relat&oacute;rio gerado em ".date("d/m/Y H:i:s")."</div>";
	
	function ConsultaLog($user){
		if($user!=""){
			$condicao = " where LOGIN like '%".$user."%' ";
		}
		
		$sql = new cmd_SQL();
		$bd['sql'] = "select l.*, dbms_lob.substr(COMANDO, 10000, 1) CMD, to_char(DATASISTEMA, 'DD/MM/YYYY HH24:MI:SS') DTSISTEMA, u.LOGIN from CONCURSO_LOG l
						inner join CONCURSO_USUARIO u on u.IDUSUARIO = l.IDUSUARIO ";
		$bd['sql'] .= $condicao;
		$bd['sql'] .= "order by DATASISTEMA";
		$bd['ret'] = "php";
		$rs = $sql->pesquisar($bd);
		return $rs;
	}
?>
</div>
</body>
</html>