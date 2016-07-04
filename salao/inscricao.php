<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sistema DPIE</title>


<link href="css/estilo_tela.css" rel="stylesheet" type="text/css" />
<link href="css/reset.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/inscricao.js"></script>
<script type="text/javascript" src="js/ajax.js"></script>
<script type="text/javascript" src="js/select.js"></script>
<script type="text/javascript" src="js/objeto.js"></script>
</head>

<body>
<div id="tela">
<div id="tela_centro">
<a href="comprovante.php?par1=<?php echo $_GET['par3']; ?>&par2=<?php echo $_GET['par4']; ?>" target='_blank'><img alt='imprimir' src='imagens/imprimir.gif' align="right"></a>
<h1>Espetáculos</h1>
<br />Digite a quantidade de participantes para cada espetáculo, sem ultapassar a quantidade máxima de 45.
</div>
<div id="tela_centro">
<form>
  <br />
  <br />
  
  <table width="660" >
	<thead>
		<tr class='cabeca'>
			<th>Espetáculo</th>
			<th><center>Vagas Restantes</center></th>
			<th><center>Quantidade</center></th>
		</tr>
	</thead>
	<tbody>
	<?php
			
		require_once ("php/cmd_sql.php");
		
		$onibus = $_GET['par3'];
		$tipo =$_GET['par4'];
		
		$varConsulta = ConsultaLista($_GET['par1'],$_GET['par2']);
		$i=0;
		if ($varConsulta) {
			foreach ($varConsulta as $lin) {
				$varTema = $varConsulta[$i]['nome'];
				$varVagas = $varConsulta[$i]['vagas'];
				$varID = $varConsulta[$i]['idHorario'];
				
				if (($i+1) % 2) {
					$cor = "impar";
				} else {
					$cor = "par";
				}
				
				$linhas = "";
				
				$linhas .= "<td class=" . $cor . ">" . utf8_encode($varTema) . "</td>";
				$linhas .= "<td class=" . $cor . "><center><div id='vagas" . $varID . "'>" . utf8_encode($varVagas) . "</div></center></td>";
				$linhas .= "<td class=" . $cor . " width='100'><center><input name='txtQtd" . $i . "' size=5 id='txtQtd" . $i . "' type='text' /><input name='txtID" . $i . "' size=5 id='txtID" . $i . "' type='hidden' value=" . $varID . " /><center></td>";
				
				echo "<tr>" . $linhas . "</tr>";
				$i++;
			}
		}
		
		echo "</tbody>
			<tfoot><tr>" .
					"<td><a href='javascript:history.back()'><img width=30 alt='voltar' src='imagens/voltar.png'></a></td>" .
					"<td></td>" .
					"<td><center><a href='javascript:inscrever(" . $i . ");'><img width=50 alt='Inscrever' src='imagens/OK.png'></a></center></td></tfoot>
			</table>";	
		echo "<input type='hidden' name='txtOnibus' id='txtOnibus' value='" . $onibus . "'>";
		echo "<input type='hidden' name='txtTipo' id='txtTipo' value='" . $tipo . "'>";
		
		function ConsultaLista($data, $hora) {
		$sql = new cmd_SQL();

				
		$bd[sql] = "SELECT e.nome, e.vagas as full, vagas.total, if((e.vagas - vagas.total) is null,e.vagas, (e.vagas - vagas.total)) as vagas, h.idHorario, h.dataEspetaculo, h.horaInicio, h.horaFim
					FROM espetaculo e join horario h using(idEspetaculo)
					left join
					(SELECT espetaculo, sum(vagas) as total FROM inscricao group by espetaculo) vagas on h.idHorario = espetaculo
					WHERE h.dataEspetaculo = '" . $data . "' and h.horaInicio = '" . $hora . "'
					order by dataEspetaculo, horaInicio, nome";
          		
		$bd[ret] = "php";
		$rs = $sql->pesquisar($bd);
		
		return $rs;
	
	}
	?>
	</tbody>
	</table>
  
<br />
<br />
<br />
<br />
</form>

</div>
</div>

</body>
</html>
