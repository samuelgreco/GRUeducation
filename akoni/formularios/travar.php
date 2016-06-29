<?php 
	require_once ("../../lib/php/cmd_sql.php");
	
	$varTravas = ConsultaTravas();
	
	function ConsultaTravas(){
		$sql = new cmd_SQL();
		$bd['sql'] = "SELECT * FROM AKONI_TRAVA";
		$bd['ret'] = "php";
		$rs = $sql->pesquisar($bd);
		
		return $rs;
	}
?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<title>Processo Seletivo Simplificado 2015</title>
<link href="../css/estilo.css" rel="stylesheet" type="text/css" />
<link href="../css/estiloTabela.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../css/style.css" />
<link rel="stylesheet" type="text/css" href="../../lib/css/estilo.css" />
<link rel="stylesheet" type="text/css" href="../../lib/css/jquery.validationEngine.css" />

<script src="../../lib/js/jquery-1.9.1.js" type="text/javascript"></script>
<script type="text/javascript" src="../../lib/js/jquery.validationEngine-ptBr.js"></script>
<script type="text/javascript" src="../../lib/js/jquery.validationEngine.js"></script>
<script type="text/javascript" src="../../lib/js/ajax.js"></script>
<script type="text/javascript" src="../../lib/js/select.js"></script>
<script type="text/javascript" src="../../lib/js/objeto.js"></script>
<script type="text/javascript" src="../../lib/js/funcoes.js"></script>
<script type="text/javascript" src="../js/jquery.mask.js"></script>
<script type="text/javascript" src="../js/travar.js"></script>
<script type="text/javascript" src="../js/verifica_sessao.js"></script>
</head>
<body onload="verificar()">
<form name="frmTravar" id="frmTravar">
	<h1 style="padding:0px;">Travas do sistema</h1>
	<div style="padding:15px;">
		<table class="CSSTabela">
			<thead>
				<tr>
					<th>Inscrição<br />de candidato</th>
					<th>Situação<br />da inscrição</th>
					<th>Editais e<br />publicações</th>
				</tr>
			</thead>
			<tbody>
				<tr>
				<?php 
					if($varTravas[0]["INSCRICAO"]==1){
				?>
					<td id="inscricao">
						<center>
							<img src='../../lib/images/icones/aberto.png' width='32' onclick='travar("inscricao")' style='cursor: pointer;' title='Destravada'>
						</center>
					</td>
				<?php 
					}else{ 
				?>
					<td id="inscricao">
						<center>
							<img src='../../lib/images/icones/fechado.png' width='32' onclick='destravar("inscricao")' style='cursor: pointer;' title='Travada'>
						</center>
					</td>
				<?php 
					} 
				?>
				<?php 
					if($varTravas[0]["SITUACAO"]==1){
				?>
					<td id="situacao">
						<center>
							<img src='../../lib/images/icones/aberto.png' width='32' onclick='travar("situacao")' style='cursor: pointer;' title='Destravada'>
						</center>
					</td>
				<?php 
					}else{ 
				?>
					<td id="situacao">
						<center>
							<img src='../../lib/images/icones/fechado.png' width='32' onclick='destravar("situacao")' style='cursor: pointer;' title='Travada'>
						</center>
					</td>
				<?php 
					} 
				?>
				<?php 
					if($varTravas[0]["PUBLICACAO"]==1){
				?>
					<td id="publicacao">
						<center>
							<img src='../../lib/images/icones/aberto.png' width='32' onclick='travar("publicacao")' style='cursor: pointer;' title='Destravada'>
						</center>
					</td>
				<?php 
					}else{ 
				?>
					<td id="publicacao">
						<center>
							<img src='../../lib/images/icones/fechado.png' width='32' onclick='destravar("publicacao")' style='cursor: pointer;' title='Travada'>
						</center>
					</td>
				<?php 
					} 
				?>
				</tr>
			</tbody>
		</table>
	</div>
</form>
</body>
</html>
