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
<script type="text/javascript" charset="utf-8" src="../../../../lib/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="../../lib/js/ajax.js"></script>
<script type="text/javascript" src="../../lib/js/select.js"></script>
<script type="text/javascript" src="../../lib/js/objeto.js"></script>
<script type="text/javascript" src="../../lib/js/funcoes.js"></script>
<script type="text/javascript" charset="utf-8" src="../js/entregaTrabalho.js"></script>



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

<h3>Entrega de Trabalhos</h3>


<br/>

<div name="divInscricoes" id="divInscricoes">
	<table id="tabInscricao" width="100%" style="font-size: 12px;" border="0">
		<thead>
			<tr>
				<th>Inscricao</th>
				<th>Educando/Turma</th>
				<th>Categoria</th>
				<th>Status</th>
				<th>Trabalho Entregue</th>
				
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
								<td id="statusTrabalho'.$v["IDINSCRICAO"].'" name="statusTrabalho" >'.($v['STATUS']==0?'PENDENTE</td>'
													:($v['STATUS']==1?'INSCRIÇÃO ON LINE FINALIZADA</td>':'TRABALHO ENTREGUE</td>')).
								'<td id="btnStatusTrabalho'.$v["IDINSCRICAO"].'" name="btnStatusTrabalho" align="center">'.
								($v['STATUS']==1?'<input type="button" value="Não" style="background-color:#FF0000; color:white; padding:5px; cursor:pointer;" onclick="entrega('.$v["IDINSCRICAO"].',2)"/></td>'
									:	($v['STATUS']==2?'<input type="button" value="Sim" style="background-color:#0080FF; color:white; padding:5px; cursor:pointer;" onclick="entrega('.$v["IDINSCRICAO"].',1)"/></td>'
											:'<input type="button" value="Sim" style="background-color:#0080FF; color:white; padding:5px; cursor:pointer;" onclick="alert(\''."Esse trabalho já foi analisado!".'\')"/></td>'
										)
								)						.
								'</td></tr>';
					echo $linha;
				}
				
				function listaInscricoes(){
					$sql = new cmd_SQL();
					$db ['sql'] = 	"SELECT DISTINCT AI.CPF, AI.IDINSCRICAO,
									(CASE WHEN AT.IDCATEGORIA=1 THEN ASE.SERIE||'-'||ATT.NOME_TURMA 
									WHEN AT.IDCATEGORIA IN (2,3,4) THEN ATE.NOME ELSE ''END) AS EDUCANDO_TURMA,
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
									WHERE AI.STATUS <> 0";
					$db['ret'] = "php";
					$rs = $sql->pesquisar($db);
					return $rs;
				}
				
			?>

		</tbody>
	</table>
</div>

</div>
<body>
</html>