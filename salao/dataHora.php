<?php
session_start();
require_once ("php/cmd_sql.php");

$onibus = $_GET['par1'];
$tipo = $_GET['par2'];
$inscrito = $_GET['par3'];

if($inscrito>0){
	
	$varInscrito = ConsultaInscrito($onibus,$tipo);
	$varIDInscrito = $varInscrito[0]['idhorario'];
	$varIDInscricao = $varInscrito[0]['idinscricao'];
	$varVagasInscrito = $varInscrito[0]['vagas'];
	//echo "varIDInscrito---> ".$varIDInscrito." :::: inscrito---> ".$inscrito;
	
}else{
	$varIDInscricao = 0;
	//echo "NADA!";
}
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sistema DPIE</title>
<script type="text/javascript" src="../lib/js/ajax.js"></script>
<script type="text/javascript" src="../lib/js/funcoes.js"></script>
<script type="text/javascript" src="../lib/js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="../lib/js/select.js"></script>
<script type="text/javascript" src="../lib/js/objeto.js"></script>
<script type="text/javascript" src="js/inscricao.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery-ui.css" />
<link href="../lib/css/estilo.css" rel="stylesheet" type="text/css" />
<link href="css/estilo_tela.css" rel="stylesheet" type="text/css" />

</head>

<body>
<div id="tela">
<div id="tela_centro">
<input type="hidden" name="txtOnibus" id="txtOnibus" value="<?= $onibus ?>" />
<input type="hidden" name="txtTipo" id="txtTipo" value="<?= $tipo ?>" />

<a href="comprovante.php" target='_blank' class="Imprimir" style='left: 90%; position: absolute;'>Imprimir</a>
<h1 style="padding: 0px;">Escola: <?php echo $_SESSION["Nome"];?></h1>
<h2 style="padding: 0px;">Data e Hora</h2>
<br /> Escolha uma data e hora para se inscrever. N&atilde;o &eacute; permitido inscrever o mesmo &ocirc;nibus em mais de um hor&aacute;rio.<br />
Ao aparecer a janela, digite a quantidade de participantes de cada ano escolar para o hor&aacute;rio, sem ultapassar a quantidade m&aacute;xima de 45.<br />
Para cancelar alguma inscri&ccedil;&atilde;o, entre em contato com a administra&ccedil;&atilde;o.

</div>
<div id="tela_centro">
<form>
  <br />
  <br />
  <center>
  <table class="tabela">
	<tr>
		<td><center>Data</center></td>
		<td><center>Hora</center></td>
		<td><center>Inscrever</center></td>
	</tr>
	<?php
		$varConsulta = ConsultaLista($tipo);
		$i=0;
		if ($varConsulta) {
			foreach ($varConsulta as $lin) {
				$varID = $varConsulta[$i]['idHorario'];
				$varData = $varConsulta[$i]['data'];
				$varDataPesquisa = $varConsulta[$i]['dataPesquisa'];
				$varHoraInicio = $varConsulta[$i]['horaInicio'];
				$varHoraFim = $varConsulta[$i]['horaFim'];

				$varConsultaVagas = ConsultaVagas($varID);
				
				if($varConsultaVagas){
					$varVagas = $varConsultaVagas[0]['qtde'];
					$varVagasMax = $varConsultaVagas[0]['vagas'];
				}
				
				$linhas = "";
				$linhas .= "<td><center>" . utf8_encode($varData) . "</center></td>";
				$linhas .= "<td><center>" . utf8_encode($varHoraInicio) . " - " . utf8_encode($varHoraFim) . "</center></td>";
				
				//�NIBUS INSCRITO EM UM HOR�RIO
				if($inscrito>0){
					if($varID==$varIDInscrito){
						
						$linhas .= "<td width='100' style='border:2px solid #26A65B;'><center>
										<a style='cursor:pointer;' onclick='editar(".$varID.",".$varIDInscricao.");'><img width=30 alt='ver' id='imgInscrever".$varID."' src='imagens/inscrito.png'></a>
									</center></td>";
					}else{
						$linhas .= "<td>&nbsp;</td>";
					}
				}else{
				//�NIBUS N�O INSCRITO
					if($varConsultaVagas){
						if($varVagas<$varVagasMax){
							$linhas .= "<td width='100'><center>
										<a style='cursor:pointer;' onclick='inscrever(".$varID.");'><img width=30 alt='ver' id='imgInscrever".$varID."' src='../lib/images/icones/inscrever.png'></a>
										</center></td>";
						}else{
							$linhas .= "<td><p style='font-size: 11px; color: #f00;'>Encerrado</p></td>";
						}
					}else{
						$linhas .= "<td width='100'><center>
									<a style='cursor:pointer;' onclick='inscrever(".$varID.");'><img width=30 alt='ver' id='imgInscrever".$varID."' src='../lib/images/icones/inscrever.png'></a>
									</center></td>";
					}
					
				}
				
				echo "<tr>" . $linhas . "</tr>";
				$i++;
			}
		}
		
		function ConsultaLista() {
			$sql = new cmd_SQL();
			$bd['sql'] = "select distinct date_format(h.data,'%d/%m/%Y') as data, h.data as dataPesquisa, h.horaInicio, h.horaFim, h.idHorario from horario h
						where h.idtipo_dependencia=".$_SESSION["Tipo"]."
						order by h.data, h.horaInicio";
			$bd['ret'] = "php";
			$rs = $sql->pesquisar($bd);
			return $rs;
			
		}
		
		function ConsultaInscrito($onibus,$tipo){
			$sql = new cmd_SQL();
			$bd['sql'] = "SELECT * FROM inscricao where escola=".$_SESSION["ID"]." and onibus=".$onibus." and tipo=".$tipo;
			//echo $bd['sql']; 
			$bd['ret'] = "php";
			$rs = $sql->pesquisar($bd);
			return $rs;
			
		}
		
		function ConsultaVagas($idhorario){
			$sql = new cmd_SQL();
			$bd['sql'] = "SELECT count(i.vagas) as qtde, h.vagas FROM inscricao i inner join horario h on h.idhorario=i.idhorario where i.idhorario=".$idhorario." group by i.idhorario";
			//echo $bd['sql']; 
			$bd['ret'] = "php";
			$rs = $sql->pesquisar($bd);
			return $rs;
		}
	?>
	</table>
</center>
<div id="cadastro" title="Inscri&ccedil;&atilde;o no hor&aacute;rio" style="display: none;">
	Especifique, por <b>ano</b>, a quantidade de alunos que vir&atilde;o ao Sal&atilde;o do Livro neste &ocirc;nibus e hor&aacute;rio selecionados. 
	A quantidade m&aacute;xima &eacute; de 45.<br /><br />
	<input type="hidden" name="txtIDInscricao" id="txtIDInscricao" />
	<input type="hidden" name="txtIDHorario" id="txtIDHorario" />
	<input type="hidden" name="txtTotalAnt" id="txtTotalAnt" />
	<center>
		<table>
			<tr>
				<td>Est&aacute;gio I: </td>
				<td><input type="text" name="txtEstagioI" id="txtEstagioI" style="width:45px;text-align:center;" onkeydown='return EntradaNumerico(event)' onchange="contar()" /></td>
			</tr>
			<tr>
				<td>Est&aacute;gio II: </td>
				<td><input type="text" name="txtEstagioII" id="txtEstagioII" style="width:45px;text-align:center;" onkeydown='return EntradaNumerico(event)' onchange="contar()" /></td>
			</tr>
			<tr>
				<td>1&ordm; Ano: </td>
				<td><input type="text" name="txtAno1" id="txtAno1" style="width:45px;text-align:center;" onkeydown='return EntradaNumerico(event)' onchange="contar()" /></td>
			</tr>
			<tr>
				<td>2&ordm; Ano: </td>
				<td><input type="text" name="txtAno2" id="txtAno2" style="width:45px;text-align:center;" onkeydown='return EntradaNumerico(event)' onchange="contar()" /></td>
			</tr>
			<tr>
				<td>3&ordm; Ano: </td>
				<td><input type="text" name="txtAno3" id="txtAno3" style="width:45px;text-align:center;" onkeydown='return EntradaNumerico(event)' onchange="contar()" /></td>
			</tr>
			<tr>
				<td>4&ordm; Ano: </td>
				<td><input type="text" name="txtAno4" id="txtAno4" style="width:45px;text-align:center;" onkeydown='return EntradaNumerico(event)' onchange="contar()" /></td>
			</tr>
			<tr>
				<td>5&ordm; Ano: </td>
				<td><input type="text" name="txtAno5" id="txtAno5" style="width:45px;text-align:center;" onkeydown='return EntradaNumerico(event)' onchange="contar()" /></td>
			</tr>
			<tr>
				<td>Total de alunos: </td>
				<td><input type="text" name="txtTotal" id="txtTotal" style="border:0px solid #fff;width:45px;text-align:center;font-weight:bold;" onkeydown='return EntradaNumerico(event)' readonly="readonly" value="0" /></td>
			</tr>
		</table>
		<table>
			<tr>
				<td style="text-align: center;">
					<input type="button" value="Salvar" class="Salvar" onclick="salvar()" />
					<input type="button" value="Fechar" class="Cancelar" onclick="cancelar()" />
				</td>
			</tr>
		</table>
	</center>
</div>
<br />
<br />
<div style="text-align: right;margin-right: 20px;"><a type="button" class="Voltar" onclick="javascript:history.back()" >Voltar</a></div>
<br />
<br />
</form>

</div>
</div>

</body>
</html>
