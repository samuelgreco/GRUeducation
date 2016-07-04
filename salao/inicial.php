<?php
require_once ("php/cmd_sql.php");
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sistema DPIE</title>


<link href="../lib/css/estilo.css" rel="stylesheet" type="text/css" />
<link href="css/estilo_tela.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="tela">
<div id="tela_centro">
<a href="comprovante.php" target='_blank' class="Imprimir" style='left: 90%; position: absolute;'>Imprimir</a>
<?php
echo "<h1 style='padding: 0px;'>Escola: ".$_SESSION["Nome"]."</h1>
<a href='tutorial.html' target='_blank' class='Tutorial'>Veja o passo a passo da inscri&ccedil;&atilde;o</a><br /><br />
<h2 style='padding: 0px;'>Escolha o ﾃ馬ibus</h2>
</div>
<div id='tela_centro'>
<form>";
	/* par1 -> nﾃｺmero do ﾃｴnibus
	 * par2 -> tipo da matricula (1-infantil/fundamental  |  2-EJA)
	 * par3 -> flag de inscri鈬o*/
		if($_SESSION["oniDia"]>0){
			echo"<center><h3 style='padding: 0px;'>Educa&ccedil;&atilde;o Infantil/Fundamental</h3></center><br />
				<table width='' border='0' style='margin: 0 auto'>
		    		<tr>";
		    		for ( $i = 1; $i <= $_SESSION["oniDia"] ; $i++ ) {
		    			$varOnibus = ConsultaOnibus($i,1);
		    			if($varOnibus){
			    			$varData = $varOnibus[0]['data'];
			    			$varHora = $varOnibus[0]['horaInicio'];
			    			$varVagas = $varOnibus[0]['vagas'];
			    			
			    			echo "<td width='96' height='67' style='vertical-align: top; width:125px; text-align:center;  border-right:#CCC 1px solid; border-left:#CCC 1px solid;' >
			    					<a class='link' href='dataHora.php?par1=" . $i . "&par2=1&par3=1'>ﾃ馬ibus " . $i . "<img src='imagens/onibus-cheio.png' width='104' height='61' /><br />
			    					Data: ".$varData." <br />
			    					Hor&aacute;rio: ".$varHora."<br />
			    					Qtde. Alunos: ".$varVagas."
			    					</a>
			    				 </td>";
		    			}else{
		    				echo "<td width='96' height='67' style='vertical-align: top; width:125px; text-align:center;  border-right:#CCC 1px solid; border-left:#CCC 1px solid;' >
			    					<a class='link' href='dataHora.php?par1=" . $i . "&par2=1&par3=0'>ﾃ馬ibus " . $i . "<img src='imagens/onibus-vazio.png' width='104' height='61' />
			    					</a>
			    				 </td>";
		    			}
					}
				    echo "</tr>
				</table><br /><br /><br />";	
		}
		if($_SESSION["oniEJA"]>0){
			echo"<center><h3 style='padding: 0px;'>Educa&ccedil;&atilde;o EJA/MOVA</h3></center><br />
				<table width='' border='0' style='margin: 0 auto'>
		    		<tr>";
		    		for ( $i = 1; $i <= $_SESSION["oniEJA"] ; $i++ ) {
		    			$varOnibus = ConsultaOnibus($i,2);
		    			if($varOnibus){
			    			$varData = $varOnibus[0]['data'];
			    			$varHora = $varOnibus[0]['horaInicio'];
			    			$varVagas = $varOnibus[0]['vagas'];
			    			
			    			echo "<td width='96' height='67' style='vertical-align: top; width:125px; text-align:center;  border-right:#CCC 1px solid; border-left:#CCC 1px solid;' >
			    					<a class='link' href='dataHoraEja.php?par1=" . $i . "&par2=2&par3=1'>ﾃ馬ibus " . $i . "<img src='imagens/onibus-cheio.png' width='104' height='61' /><br />
			    					Data: ".$varData." <br />
			    					Hor&aacute;rio: ".$varHora."<br />
			    					Qtde. Alunos: ".$varVagas."
			    					</a>
			    				 </td>";
		    			}else{
		    				echo "<td width='96' height='67' style='vertical-align: top; width:125px; text-align:center;  border-right:#CCC 1px solid; border-left:#CCC 1px solid;' >
			    					<a class='link' href='dataHoraEja.php?par1=" . $i . "&par2=2&par3=0'>ﾃ馬ibus " . $i . "<img src='imagens/onibus-vazio.png' width='104' height='61' />
			    					</a>
			    				 </td>";
		    			}
					}
				    echo "</tr>
				</table>";	
		}
	?>
  
<br />
<br />
<div style="text-align: right;margin-right: 20px;"><input type="button" value="Logout" class="Logout" onclick="parent.location.href='index.html'" /></div>
<br />
<br />
</form>

</div>
</div>
<?php 
function ConsultaOnibus($i,$tipo) {
	$sql = new cmd_SQL();
	$bd['sql'] = "select i.*, h.horaInicio, date_format(h.data, '%d/%m/%y') as data from inscricao i
				inner join horario h on h.idhorario=i.idhorario
				inner join escola e on e.idescola=i.escola
				where e.idescola=".$_SESSION["ID"]." and i.onibus=".$i." and i.tipo=".$tipo;
	//echo $bd['sql'];
	$bd['ret'] = "php";
	$rs = $sql->pesquisar($bd);
	return $rs;
 }
?>
</body>
</html>
