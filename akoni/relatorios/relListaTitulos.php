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
		.Imprimir{
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
			<td><i>Lista nominal de resultado da prova de títulos</i></td>
		</tr>
	</table><br />
	<center>
<?php
	$varInscritos = ConsultaInscritos();
		
	//echo "<h2 style='padding:0;margin:0;text-align:center;font-size:16px;'>Quantidade de inscritos por dia</h2>";
	echo "<table class='CSSTabela' style='width:700px;'>
    		<thead>
    			<tr>
    				<th style='width:75px;'>Inscrição</th>
    				<th>Nome</th>
    				<th style='width:150px;'>CPF</th>
    				<th style='width:70px;'>Pontos</th>
    			</tr>
    		</thead>
    		<tbody>";
	
	$qtde=0;$i=0;
	
	foreach ($varInscritos as $lin => $w) {
		$linhas = "<td>" . utf8_encode($w["IDCANDIDATO"]) . "</td>
					<td>" . utf8_encode($w["NOME"]) . "</td>
					<td>" . utf8_encode($w["CPF"]) . "</td>
					<td>" . utf8_encode($w["TOTAL"]) . "</td>";
		$qtde+=$w["QTDE"];
		
		$datas[$i] = $w["DTSISTEMA"];
		$valor[$i] = $qtde;
		$valor_dia[$i] = intval($w["QTDE"]);
		
		echo "<tr>" . $linhas . "</tr>";
		$i++;
	}
	
	echo "<tr><td colspan='4'>Total: <b>" . $i . "</b></td></tr>";
	echo "</tbody></table>";
	
	echo "<br /><div class=data>Relat&oacute;rio gerado em ".date("d/m/Y H:i:s")."</div>";
	
	function ConsultaInscritos(){
		$sql = new cmd_SQL();
		$bd['sql'] = "select c.IDCANDIDATO, c.NOME, c.CPF, p.TOTAL from CONCURSO_CANDIDATO c
							inner join CONCURSO_PONTUACAO p on p.IDCANDIDATO = c.IDCANDIDATO
							order by NOME";
		$bd['ret'] = "php";
		$rs = $sql->pesquisar($bd);
		return $rs;
	}
?>
</div>
</body>
</html>