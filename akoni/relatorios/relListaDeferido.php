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
			<td><i>Lista de Inscrições DEFERIDAS</i></td>
		</tr>
	</table><br />
	<center>
<?php
	$varInscritos = listaInscricoes();
		
	//echo "<h2 style='padding:0;margin:0;text-align:center;font-size:16px;'>Quantidade de inscritos por dia</h2>";
	echo "<table class='CSSTabela' style='width:700px;'>
    		<thead>
    			<tr>
    				<th style='width:75px;'>Inscrição</th>
    				<th>Escola</th>
    				<th>Categoria</th>
    				<th>Nome/Turma</th>
    			</tr>
    		</thead>
    		<tbody>";
	
	$qtde=0;$i=0;
	
	foreach ($varInscritos as $lin => $w) {
		$linhas = "<td>" . utf8_encode($w["IDINSCRICAO"]) . "</td>
					<td>" . utf8_encode($w["ESCOLA"]) . "</td>
					<td>" . utf8_encode($w["CATEGORIA"]) . "</td>
					<td>" . utf8_encode($w["EDUCANDO_TURMA"]) . "</td>";
		$qtde+=$w["QTDE"];
		
		$datas[$i] = $w["DTSISTEMA"];
		$valor[$i] = $qtde;
		$valor_dia[$i] = intval($w["QTDE"]);
		
		echo "<tr>" . $linhas . "</tr>";
		$i++;
	}
	
	echo "<tr><td colspan='3' style='border:0px solid #fff;'></td><td>Total: <b>" . $i . "</b></td></tr>";
	echo "</tbody></table>";
	
	echo "<br /><div class=data>Relat&oacute;rio gerado em ".date("d/m/Y H:i:s")."</div>";
	
	function listaInscricoes(){
		$sql = new cmd_SQL();
		$db ['sql'] = 	"SELECT DISTINCT AI.CPF, AI.IDINSCRICAO, 
						(CASE WHEN AT.IDCATEGORIA=1 THEN ASE.SERIE||'-'||ATT.NOME_TURMA 
						WHEN AT.IDCATEGORIA IN (2,3,4) THEN ATE.NOME ELSE ''END) AS EDUCANDO_TURMA,
						CASE WHEN AT.IDDEPENDENCIA=3 THEN MOVA.NOME 
						WHEN AT.IDDEPENDENCIA IN (1,2) THEN REDE.NOME END ESCOLA,
						AC.CATEGORIA,AI.STATUS
						FROM AKONI_INSCRICAO AI
						LEFT JOIN AKONI_TRABALHO AT
						ON AT.IDINSCRICAO=AI.IDINSCRICAO
						LEFT JOIN AKONI_TRAB_EDUCANDO ATE
						ON ATE.IDTRABALHO=AT.IDTRABALHO
						LEFT JOIN AKONI_TRAB_TURMA ATT
						ON ATT.IDTRABALHO=AT.IDTRABALHO
						LEFT JOIN AKONI_CATEGORIA AC
						ON AC.IDCATEGORIA=AT.IDCATEGORIA
						LEFT JOIN AKONI_SERIE ASE
						ON ASE.IDSERIE=ATT.IDSERIE
						LEFT JOIN (SELECT AT.IDPJ,VW.NOME,VW.TEL,VW.EMAIL FROM VW_APP_CONSULTA_ESCOLAS VW INNER JOIN AKONI_TRABALHO AT 
						ON AT.IDPJ=VW.IDPESSOA_JURIDICA WHERE AT.IDDEPENDENCIA IN (1,2))REDE
						ON AT.IDPJ=REDE.IDPJ
						LEFT JOIN (SELECT AT.IDPJ,VM.NOME,VM.TEL,VM.EMAIL FROM PREFADM_MOVA.VW_APP_CONSULTA_ESCOLAS VM INNER JOIN AKONI_TRABALHO AT
						ON AT.IDPJ=VM.IDPESSOA_JURIDICA WHERE AT.IDDEPENDENCIA=3)MOVA
						ON MOVA.IDPJ=AT.IDPJ
						WHERE AI.STATUS=3
						ORDER BY ESCOLA, CATEGORIA, AI.IDINSCRICAO";
		$db['ret'] = "php";
		$rs = $sql->pesquisar($db);
		return $rs;
	}
				
?>
</div>
</body>
</html>