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
<script type="text/javascript" src="../js/arquivos.js"></script>
</head>
<body onload="iniciar()">
<div id="tela">
	<div id="banner"></div>
	
	<div class="barra_menu">
		<div class="menu">
			<ul>
				<li><a href="../index.php">Início</a></li>
				<?php 
					require_once ("../../lib/php/cmd_sql.php");
					
					$varTravas = ConsultaTravas();
					
					if($varTravas[0]["INSCRICAO"]==1){
						echo '<li><a href="inscricao.php">Inscrição</a></li>';
					}
					if($varTravas[0]["SITUACAO"]==1){
						echo '<li><a href="situacao.php">Situação da inscrição</a></li>';
					}
					if($varTravas[0]["PUBLICACAO"]==1){
						echo '<li><a href="publicacao.php">Editais e publicações</a></li>';
					}
					
					function ConsultaTravas(){
						$sql = new cmd_SQL();
						$bd['sql'] = "SELECT * FROM AKONI_TRAVA";
						$bd['ret'] = "php";
						$rs = $sql->pesquisar($bd);
						
						return $rs;
					}
				?>
				<li style="float: right;font-size:9px;"><a href="../login.html"><img src="../images/lock.png" style="width: 10px;" />&nbsp;Acesso restrito</a></li>
			</ul>
		</div>              
	</div>
  
	<div id="tela_camp">
		<h2 style="padding:0px;font-size:18px;">Editais e publicações</h2>
		<table style="width:100%;">
		<?php 
			$varArquivos = ConsultaArquivos();
			
			if($varArquivos){
				foreach($varArquivos as $lin=>$v){
					echo "<tr>
							<td style='width:5%;'><a href='../php/gerarArquivo.php?id=".$v["IDARQUIVO"]."' target='_blank'><img src='../images/pdf.png' style='width:22px;' /></a></td>
							<td style='text-align:left;'><a href='../php/gerarArquivo.php?id=".$v["IDARQUIVO"]."' target='_blank' style='text-decoration:none;'>".utf8_encode($v["NOME"])."</a></td>
						</tr>";
				}
			}else{
				echo "<tr>
							<td style='text-align:center;'><i>Não há arquivos a serem exibidos.</i></td>
						</tr>";
			}
		?>
		</table>
	</div>
	
	<div id="rodape">
		<div id="rodape_texto">Secretaria Municipal de Educação de Guarulhos<br />DPIE - Departamento de Planejamento e Informática na Educação</div>
	</div>
</div>
</body>
</html>
<?php 
function ConsultaArquivos(){
	$sql = new cmd_SQL();
	$bd['sql'] = "SELECT * FROM AKONI_ARQUIVOS WHERE VISIVEL=1 ORDER BY IDARQUIVO";
	$bd['ret'] = "php";
	$rs = $sql->pesquisar($bd);

	return $rs;
}
?>
