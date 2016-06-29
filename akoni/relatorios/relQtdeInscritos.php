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
			<td><h1 style="padding:0;margin:0;text-align:center;font-size:22px;">Prêmio AKONI 2016</h1></td>
			<td rowspan="2" style="width: 20%;"><!-- <img src="../images/logo.png" width="50" /> --></td>
		</tr>
		<tr>
			<td><i>Quantidade de inscrições por Categoria</i></td>
		</tr>
	</table><br />
	<center>
<?php
	$varInscritosDia = ConsultaInscritosDia();
		
	echo "<h2 style='padding:0;margin:0;text-align:center;font-size:16px;'>Quantidade de inscrições por Categoria e Status</h2>";
	echo "<table class='CSSTabela' width='700'>
    		<thead>
    			<tr>
    				<th>Categoria</th>
    				<th>Pendente</th>
    				<th>Finalizado</th>
    				<th>Total</th>
    			</tr>
    		</thead>
    		<tbody>";
	$i=0;
	$totalColuna1=0;
	$totalColuna2=0;
	$totalColuna3=0;
	

	foreach ($varInscritosDia as $lin => $w) {
		$totalLinha=$w["FINALIZADO"]+$w["PENDENTE"];
		
		$linhas = "<td>" . $w["CATEGORIA"] . "</td>
					<td>" . $w["PENDENTE"] . "</td>
					<td>" . $w["FINALIZADO"] . "</td>
					<td><b>" . $totalLinha. "</b></td>";
		$totalColuna1+=$w["PENDENTE"];
		$totalColuna2+=$w["FINALIZADO"];
		$totalColuna3+=$totalLinha;
		
		$datas[$i] = $w["CATEGORIA"];
		$valor[$i] = $qtde;
		$valor_Coluna1[$i] = intval($w["PENDENTE"]);
		$valor_Coluna2[$i] = intval($w["FINALIZADO"]);
		
		echo "<tr>" . $linhas . "</tr>";
		$i++;
	}
	
	echo "<tr>
			<td><b>TOTAL</b></td>
			<td><b>" . $totalColuna1 . "</b></td>
			<td><b>" . $totalColuna2 . "</b></td>
			<td><b>" . $totalColuna3 . "</b></td>
			
			</tr>";
	echo "</tbody></table>";
	
?>

<script>
	$(function () { 
		$('#grafico').highcharts({
			xAxis: {
				categories: <?php echo json_encode($datas); ?>
			},
			yAxis: {
				title: {
					text: 'Quantidade'
				}
			},
			title: {
				text: 'Número de Inscrições por Categoria'
			},
			series: [{
		            name: 'Inscri\u00e7\u00f5es Finalizadas',
		            color: '#BDC3C7',
		            type: 'column',
		            data: <?php echo json_encode($valor_Coluna2); ?>,
				}, {
	            name: 'Inscri\u00e7\u00f5es Pendentes',
	            color: '#FE2E2E',
	            type: 'column',
	            data: <?php echo json_encode($valor_Coluna1); ?>
			}]			

			
		});
	});
</script>
<br /><br />
<div id="grafico" style="min-width: 100px; max-width: 700px; height: 285px; margin: 0 auto"></div>
<?php 
	
	echo "<br /><div class=data>Relat&oacute;rio gerado em ".date("d/m/Y H:i:s")."</div>";
	
	function ConsultaInscritosDia(){
		$sql = new cmd_SQL();
		$bd['sql'] = "SELECT * FROM
						(SELECT A.IDINSCRICAO,  CASE WHEN A.STATUS>=1 THEN 1 ELSE 0 END AS STATUS, C.CATEGORIA FROM AKONI_INSCRICAO A
						INNER JOIN AKONI_TRABALHO B ON A.IDINSCRICAO=B.IDINSCRICAO
						INNER JOIN AKONI_CATEGORIA C ON B.IDCATEGORIA=C.IDCATEGORIA)
						PIVOT (COUNT(IDINSCRICAO) FOR STATUS IN ('0' AS PENDENTE, '1' FINALIZADO, '2' AGUARDANDO_DOC, '3' DEFERIDO, '4' INDEFERIDO))";
		$bd['ret'] = "php";
		$rs = $sql->pesquisar($bd);
		return $rs;
	}
?>
</div>
</body>
</html>