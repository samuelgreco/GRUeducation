<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Sistema DPIE</title>

<link href="../../../../lib/css/estilo.css" rel="stylesheet" type="text/css" />
<link href="../../../../lib/css/jquery.dataTables.css" rel="stylesheet" type="text/css" />
<link href="../../../../lib/css/demo_table_jui.css" rel="stylesheet" type="text/css" />
<link href="../../../../lib/css/jquery-ui-1.8.11.custom.css" rel="stylesheet" type="text/css" />





<script type="text/javascript" charset="utf-8" src="../../../../lib/js/jquery-1.10.2.js"></script>
<script type="text/javascript" charset="utf-8" src="../../lib/js/jquery-ui-1.10.3.custom.min.js"></script>
<script type="text/javascript" charset="utf-8" src="../../lib/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="../../lib/js/ajax.js"></script>
<script type="text/javascript" src="../../lib/js/select.js"></script>
<script type="text/javascript" src="../../lib/js/objeto.js"></script>
<script type="text/javascript" src="../../lib/js/funcoes.js"></script>
<script type="text/javascript" charset="utf-8" src="../js/analiseTrabalho.js"></script>

<script type="text/javascript">
$(document).ready(function(){
	$("#tabInscricao").dataTable({
		"bProcessing" : true,
		"bJQueryUI" : true,
		"bAutoWidth": false,
		"bLengthChange": true,
		"bPaginate": true,
		"sPaginationType":"full_numbers"
	});

})

</script>
</head>
<body>

<h3>Analise dos Trabalhos</h3>


<br/>

<div name="divInscricoes" id="divInscricoes">
	<table id="tabInscricao" width="100%" style="font-size: 12px;" border="0">
		<thead>
			<tr>
				<th>Inscricao</th>
				<th>Educando/Turma</th>
				<th>Categoria</th>
				<th>Status</th>
				<th>Ficha de Inscricao</th>
				<th>Trabalho Deferido?</th>
				
			</tr>
		</thead>
		<tbody>
			<?php
				require_once ('../../lib/php/cmd_sql.php');
				$varConsultaInscricao = listaInscricoes();
						
				foreach ($varConsultaInscricao as $k => $v){
					$varINSCRICAO= $varConsultaInscricao[$i]['IDINSCRICAO'];
					$linha = '<tr>
								<td>'.utf8_encode($v['IDINSCRICAO']).'</td>
								<td>'.utf8_encode($v['EDUCANDO_TURMA']).'</td>
								<td>'.utf8_encode($v['CATEGORIA']).'</td>
								<td id="statusTrabalho'.$v["IDINSCRICAO"].'" name="statusTrabalho" >'.($v['STATUS']==2?'TRABALHO ENTREGUE (EM ANALISE)</td>'
													:($v['STATUS']==3?'DEFERIDO</td>':'INDEFERIDO (<a href="javascript:void(0)" onclick="justificativaTrabalho('.utf8_encode($v['IDJUSTIFICATIVA']).','.utf8_encode($v['IDINSCRICAO']).',\''.utf8_encode($v['JUSTIFICATIVA']).'\')">JUSTIFICATIVA</a>)</td>')).
									
								'<td align="center"><input type="button" value=" Imprimir inscricao " style="background-color:#5858FA; color:white; padding:5px; cursor:pointer;" onclick="imprimirInscricao('.$v["IDINSCRICAO"].')"/></td>'.
								//'<td><input type="button" value=" Imprimir inscricao " style="background-color:#5858FA; color:white; padding:5px; cursor:pointer;" onclick=window.open("../relatorios/ficha.php?idInscricao='+$v['IDINSCRICAO']+');"/></td>'.
								'<td id="btnStatusTrabalho'.$v["IDINSCRICAO"].'" name="btnStatusTrabalho" align="center">'.($v['STATUS']==2?'<input type="button" id="btnSim'.$v["IDINSCRICAO"].'"  value="Sim" style="background-color:#BDBDBD; color:white; padding:5px; cursor:pointer;" onclick="entrega('.$v["IDINSCRICAO"].',3)"/>
																																				<input type="button" id="btnNao'.$v["IDINSCRICAO"].'"  value="Nao" style="background-color:#BDBDBD; color:white; padding:5px; cursor:pointer;" onclick="entrega('.$v["IDINSCRICAO"].',4)"/></td>'
													:($v['STATUS']==3?'<input type="button" id="btnSim'.$v["IDINSCRICAO"].'"  value="Sim" style="background-color:#0080FF; color:white; padding:5px; cursor:pointer;"/>
														<input type="button" id="btnNao'.$v["IDINSCRICAO"].'" value="Não" style="background-color:#BDBDBD; color:white; padding:5px; cursor:pointer;" onclick="entrega('.$v["IDINSCRICAO"].',4)"/></td></tr>'
															:'<input type="button" id="btnSim'.$v["IDINSCRICAO"].'"  value="Sim" style="background-color:#BDBDBD; color:white; padding:5px; cursor:pointer;" onclick="entrega('.$v["IDINSCRICAO"].',3)"/>
																<input type="button" id="btnNao'.$v["IDINSCRICAO"].'"  value="Não" style="background-color:#FF0000; color:white; padding:5px; cursor:pointer;"/></td></tr>')
												);
					echo $linha;
				}
				
				function listaInscricoes(){
					$sql = new cmd_SQL();
					$db ['sql'] = 	"SELECT DISTINCT AI.CPF, AI.IDINSCRICAO,
									(CASE WHEN AT.IDCATEGORIA=1 THEN ASE.SERIE||'-'||ATT.NOME_TURMA 
									WHEN AT.IDCATEGORIA IN (2,3,4) THEN ATE.NOME ELSE ''END) AS EDUCANDO_TURMA,
									AC.CATEGORIA,AI.STATUS, AJ.IDJUSTIFICATIVA, AJ.JUSTIFICATIVA
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
									LEFT JOIN AKONI_JUSTIFICATIVA AJ
									ON AJ.IDINSCRICAO=AI.IDINSCRICAO				
									WHERE AI.STATUS > 1";
					
					$db['ret'] = "php";
					$rs = $sql->pesquisar($db);
					return $rs;
				}
				
			?>

		</tbody>
	</table>
	</div>
</div>

<div id="divJustificativa" display="none">
<input type="hidden" id="hdnIdJustificativa" value=""/>
<input type="hidden" id="hdnIdInscricao" value=""/>
Justificativa: <br />
<textarea id="txtJustificativa" maxlength="2000" name="txtJustificativa" cols="1" rows="10" style="width:600px; height:200px;"></textarea>
</div>

<body>
</html>