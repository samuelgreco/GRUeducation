<?php
session_start();
require_once ("php/cmd_sql.php");

$id = "";
if (isset($_GET['idinscricao'])){
	$id = $_GET["idinscricao"];
}


//class atFrequencia{
	
	//public function __construct()
	//	{
			echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
			</script>
			<link href='../lib/css/estilo.css' rel='stylesheet' type='text/css' />
			<style type=text/css>
			.par{
			background-color: #CCCCCC;
			font: 16px verdana, arial, helvetica, sans-serif;
			color: #666666;
			border:1px solid  #CCCCCC;
			border-bottom-style: outset;
			margin-top:7px;
			margin-right: 15px;
			height:18px;
			width: auto;
			}
			.impar{
			background-color: white;
			font: 16px verdana, arial, helvetica, sans-serif;
			color: #666666;
			border:1px solid  #CCCCCC;
			border-bottom-style: outset;
			margin-top:7px;
			margin-right: 15px;
			height:18px;
			width: auto;
			}		
			.tabela{
			background-color: #AAAAAA;
			font: 20px verdana, arial, helvetica, sans-serif;
			color: black;
			border:1px solid  #CCCCCC;
			border-bottom-style: outset;
			margin-top:7px;
			margin-right: 15px;
			width: auto;	
			}
			.corpo{
			font: 12px verdana, arial, helvetica, sans-serif;
			margin-top:7px;
			margin-right: 15px;
			width: auto;	
			}	
			.data{
			font: 10px verdana, arial, helvetica, sans-serif;
			text-align:center;
			width: 100%;	
			}
			</style>
			
			<style type=text/css media='print'>
			#landscape { 
			writing-mode: tb-rl;
			height: 80%;
			margin: 10% 0%;
			}
			
			.Imprimir{
			visibility: hidden;
			}
			.par{
			background-color: #CCCCCC;
			font: 16px verdana, arial, helvetica, sans-serif;
			color: #666666;
			border:1px solid  #CCCCCC;
			border-bottom-style: outset;
			margin-top:7px;
			margin-right: 15px;
			height:18px;
			width: auto;
			}
			.impar{
			background-color: white;
			font: 16px verdana, arial, helvetica, sans-serif;
			color: #666666;
			border:1px solid  #CCCCCC;
			border-bottom-style: outset;
			margin-top:7px;
			margin-right: 15px;
			height:18px;
			width: auto;
			}		
			.tabela{
			background-color: #AAAAAA;
			font: 20px verdana, arial, helvetica, sans-serif;
			color: black;
			border:1px solid  #CCCCCC;
			border-bottom-style: outset;
			margin-top:7px;
			margin-right: 15px;
			width: auto;	
			}
			.corpo{
			font: 12px verdana, arial, helvetica, sans-serif;
			margin-top:7px;
			margin-right: 15px;
			width: auto;	
			}	
			.data{
			font: 10px verdana, arial, helvetica, sans-serif;
			text-align:center;
			width: 100%;	
			}
			</style>
			<html>
			<body>
			<table width=700>
			<tr>
			<td width='175'><img src='imagens/logo_gru_brc.png' width='100%'></td>
			<td class='corpo' width='525' height='38'><div style='text-align:center;'><b><h1 style='padding:0px;margin:0px;text-align:center;'>5&#176; Sal&atilde;o do Livro</h1></b>
			<i>Cidade amiga da leitura</i></div></td>
			</tr>
			</table>
			<form id='frmFrequencia' name='frmFrequencia' method='post' action=''>";
			MontaRelatorio($id);
		//}
	
	function MontaRelatorio($id){
		$varConteudo = ConsultaListaChamada($id);
		if ($varConteudo) {
		$i = 0;
			echo " 
			<table width=700>
			<tr>
			<td class=corpo width=699><center><b><u><font size=4>A escola está inscrita num horário do Salão do Livro.</font></u></b></center></td>
			</tr>
			<tr>
			<td class=corpo width=699><center><b><u><font size=4>Fique atento(a) para a(s) data(s) e hora(s) escolhidos.</font></u></b></center></td>
			</tr>
			</table>
			
			<table width=700>
			<tbody>";
			$i = 0;
				
				$linhas = "";
				$varEscola = $varConteudo[0]['nomeEsc'];
				$varOnibus = $varConteudo[0]['onibus'];
				$varTipoDependencia = $varConteudo[0]['idtipo_dependencia'];
				//$varHoraOnibus = "Saída da Escola: " . $varConteudo[0]['horaSaida'] . " <=> Retorno para a escola: " . $varConteudo[0]['horaRetorno'];
				
				$linhas .= "<tr><td class=corpo colspan=4><font size='3'><b><center><br />Escola:</center></b></td></tr>";
				$linhas .= "<tr><td class=corpo colspan=4><font size='3'><center>" . utf8_encode($varEscola) . "</center></td></tr>";
				//$linhas .= "<tr><td class=corpo colspan=3><font size='3'><b><center><br />Data do Evento: </b>" . $varData . " | " . $varHora . "</center></td></tr>";
				$linhas .= "<tr><td class=corpo colspan=4><font size='3'><center><br /><b>O tempo m&aacute;ximo de perman&ecirc;ncia dos alunos visitantes de cada<br />
							&ocirc;nibus, no Sal&atilde;o do Livro 2016, &eacute; de at&eacute; duas horas.</b></center><br /></td></tr>";
				//$linhas .= "<tr><td class=corpo><font size='3'><b><center><br />Ônibus " . $varOnibus . " - </b>" . $varHoraOnibus . "</center><br /><br /></td></tr>";
				
				echo $linhas;
				
				foreach ($varConteudo as $lin) {
					$varAlunos = $varConteudo[$i]['vagas'];
					$varData = $varConteudo[$i]['data'];
					$varTipo = $varConteudo[$i]['tipo'];
					$varHora = $varConteudo[$i]['horaInicio'];// . " - " . $varConteudo[$i]['horaFim'];
					$linhas = ""; $tipo = "";
					if (($i+1) % 2) {
						$cor = "impar";
					} else {
						$cor = "par";
					}
					if($varTipoDependencia==1){
						if($varTipo==1){
							$tipo = "Educa&ccedil;&atilde;o Infantil/Fundamental";
						}else{
							$tipo = "Educa&ccedil;&atilde;o EJA/MOVA";
						}
						$linhas .= "<td class=$cor><font size='3'><center>".$varData."</center></td><td class=$cor><center>".$varHora."</center></td><td class=$cor><center>".$varAlunos." alunos</center></td><td class=$cor><center>".$tipo."</center></td>";				
					}else{
						$linhas .= "<td class=$cor><font size='3'><center>".$varData."</center></td><td class=$cor><center>".$varHora."</center></td><td class=$cor><center>".$varAlunos." alunos</center></td>";
					}
					
					echo "<tr>" . $linhas . "</tr>";
					$i++;
				}
				echo "</tbody>
				<tfoot>
				<tr><td colspan=4><div class=data>Relat&oacute;rio gerado em ".date("d/m/Y H:i:s")."</div></td></tr>
				<tr><td align=center colspan=4><br /><a href='#' class='Imprimir' onclick='window.print();'>Imprimir</a></td></tr>
				</tfoot>
				</table>
				
				</form>";
			//}
		}else{
			echo "<br /><br /><div style='width: 700px;text-align:center;'>N&atilde;o h&aacute; dados a serem exibidos.</div>";
		}
	}
	
	function ConsultaListaChamada() {
		$sql = new cmd_SQL();
		$bd['sql'] = "select esc.nome as nomeEsc, esc.idtipo_dependencia, i.onibus, i.vagas, i.tipo, date_format(h.data, '%d/%m/%Y') as data, h.horaInicio, h.horaFim
					from inscricao i inner join horario h on i.idHorario = h.idHorario
					inner join escola esc on i.escola = esc.idEscola
					where i.escola=".$_SESSION["ID"]."
					order by h.data, h.horaInicio";
		$bd['ret'] = "php";
		//echo $bd['sql'];
		$rs = $sql->pesquisar($bd);
		return $rs;
	}


?>

</body>
</html>