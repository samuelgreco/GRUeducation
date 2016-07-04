<?php
session_start ();
require_once ("../php/cmd_sql.php");
$varConteudo = ConsultaConteudo ( $id );

echo "
		<head>
		<meta http-equiv='Content-Type' content='text/html' charset='utf-8' />
<title>Relat&oacute;rio</title>
<link type='text/css' rel='stylesheet' href='../../lib/css/estilo.css' />
<link type='text/css' rel='stylesheet' href='../css/estiloTabela.css' />
<link type='text/css' rel='stylesheet' href='../css/estilo(2).css' />
<script type='text/javascript' src='../../lib/js/jquery-1.9.1.js'></script>
<style type=text/css media='print'>
<script type='text/javascript' src='../js/exportarexcel.js'></script>
<script type='text/javascript' src='../js/src/jquery.table2excel.js'></script>
		</head>	
#landscape { 
writing-mode: tb-rl;
height: 80%;
margin: 10% 0%;
}

.Imprimir,.Voltar{
visibility: hidden;
}
.par{
background-color: #CCCCCC;
font: 12px verdana, arial, helvetica, sans-serif;
color: #666666;
border:1px solid  #000000;
border-bottom-style: outset;
margin-top:7px;
margin-right: 15px;
height:24px;
width: auto;
}
.impar{
background-color: white;
font: 12px verdana, arial, helvetica, sans-serif;
color: #666666;
border:1px solid  #000000;
border-bottom-style: outset;
margin-top:7px;
margin-right: 15px;
height:24px;
width: auto;
}		
.tabela{
background-color: #CCCCCC;
font: 14px verdana, arial, helvetica, sans-serif;
color: black;
border:1px solid  #CCCCCC;
border-bottom-style: outset;
width: auto;	
}
.corpo{
font: 12px verdana, arial, helvetica, sans-serif;
margin-top:7px;
margin-right: 15px;
width: auto;	
}	
</style>
<meta name='keywords' content='fixed table header; non-scroll header; freeze header; print repeating headers'>
<html>
<body>
<a href='javascript:history.back(1)' class='Voltar' >Voltar</a>
<a href='#' onclick='window.print();' class='Imprimir' style='left:85%; position: absolute;' title='Imprimir'>Imprimir</a></br>
<table width='90%'>
<tr>
<td width=140><div align=center><img src='../../lib/images/logo_sem_fundo.png' width=90%></div></td>
<td class=corpo width=1890 height=38><center><h1 style='text-align: center;'echo 'Relat&oacute;rio de vagas em &ocirc;nibus municipais'</h1></center>
<div style='margin-left:25%'><h2>Quantidade de vagas em &ocirc;nibus municipais</h2></div></td>

</tr>
</table>
<div id='tbOnibusMun' name='tbOnibusMun'>
<table width='100%' id='listachamados' class='CSSTabela'>
<thead>
<tr>
<th class=tabela>Data</th>
<th class=tabela>Hora</th>
<th class=tabela>Preenchido</th>
<th class=tabela>Vago</th>
<th class=tabela>Tipo</th>
</tr>
</thead>
<tbody>";



$i = 0;
$cont = 0;
$varConteudo = ConsultaConteudo();
// $varConteudoR = ConsultaListaReserva($idTurma);
// $varConteudoD = ConsultaListaDesistente($idTurma);


if ($varConteudo) {
	foreach ( $varConteudo as $lin ) {
		
		$linhas = "";
		$varData = ($varConteudo [$i]['data']);
		$varHora = ($varConteudo [$i] ['horainicio']);
		$varPreenchido = $varConteudo [$i] ['count(onibus)'];
		$varVago = ($varConteudo [$i] ['vagas']);
		$varTipo = ($varConteudo [$i] ['tipo']);
		$varReserva = $varVago - $varPreenchido;
		
		$linhas .= "<td	 class=" . $cor . ">" .  ( $varData ) . "</td>" . 
					"<td class=" . $cor . ">" . ( $varHora ) . "</td>" .
					"<td class=" . $cor . ">" . ( $varPreenchido ) . "</td>" .
					"<td class=" . $cor . ">" .  ( $varReserva ) . "</td>" .
					"<td class=" . $cor . ">" . ( $varTipo ). "</td>" ;

		
		echo "<tr>" . $linhas . "</tr>";
		
		$i ++;
	}
	echo "</tbody>
		</table>
		</div>";
}

//(explode('/',$varDT)


function ConsultaConteudo() {
$varDT = explode('/',$_POST["txtDt"]); 
/* echo '<pre>';
print_r ($varDT);
echo '</pre>';
exit; */
	//$varDT = $_POST["txtDt"];
	$varDT = $varDT[2].'-'.$varDT[1].'-'.$varDT[0];
	//echo $varDT;exit;
	$sql = new cmd_SQL ();
	$bd ['sql'] = "SELECT DATE_FORMAT(data,'%d/%m/%Y') AS data
	,horainicio,idtipo_dependencia,hr.vagas,count(onibus),
	case tipo
  WHEN 1 THEN 'Fundamental'
  WHEN 2 THEN 'EJA'
  ELSE 'Estadual/Particular'
	END tipo
	FROM salaolivro.horario hr inner join salaolivro.inscricao i on (hr.idHorario = i.idHorario) ";
			
		if($varDT == '--'){
		$bd ['sql'] .= "where idtipo_dependencia = 1 group by data,horainicio order by data,horainicio ";
		}
	
		else{
		$bd ['sql'] .= "where idtipo_dependencia = 1 and data = '".$varDT."' group by data,horainicio order by data,horainicio ";
		}
		
		
	$bd ['ret'] = "php";

	$rs = $sql->pesquisar( $bd );
	
	//echo $bd ['sql'];exit;
		
	return $rs;
}





?><br>
<br><div class="data">Relat&oacute;rio gerado em <?php echo date("d/m/Y H:i:s") ?></div>

</body>
</html>
