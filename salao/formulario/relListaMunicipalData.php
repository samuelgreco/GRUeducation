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
<td class=corpo width=1890 height=38><center><h1 style='text-align: center;'echo 'Relat&oacute;rio di&aacute;rio de vagas em escolas municipais por data e hor&aacute;rio'</h1></center>
<div style='margin-left:15%'><h2>Relat&oacute;rio di&aacute;rio de vagas em escolas municipais por data e hor&aacute;rio</h2></div></td>



    

</tr>
</table>
<div id='tbMunicipalData' name='tbMunicipalData'>
<h3 style='margin-left:36%'><b>Data: " . $_POST["txtDt"] . "  " . $_POST["txtHR"] . " </b></h3>
<table width='85%' style='margin-left:5%' id='listachamados' class='CSSTabela'>
<thead>
<tr>
<th class=tabela>N&ordm;</th>
<th class=tabela>Escola</th>
<th class=tabela>Qtd Pessoas/Onibus</th>


</tr>
</thead>
<tbody>";



$i = 0;
$cont = 0;
$contador = 1;
$contadorescolas = 1;
$contadorescola = 0;
$aparece = 1;
$varConteudo = ConsultaConteudo();
// $varConteudoR = ConsultaListaReserva($idTurma);
// $varConteudoD = ConsultaListaDesistente($idTurma);


if ($varConteudo) {
	foreach ( $varConteudo as $lin ) {
		
		$linhas = "";
		$varEscola = ($varConteudo [$i]['nome']);
		$varQtdAlunos = ($varConteudo [$i] ['vagas']);
                $varVaga = ($varConteudo [$i] ['vaga']);
		
	
		
		$linhas .=              "<td class=" . $cor . ">" .  ( $contador ) . "</td>" . 
                                     "<td class=" . $cor . ">" .  utf8_encode(( $varEscola )) . "</td>" . 
					"<td class=" . $cor . ">" . ( $varQtdAlunos ) . "</td>" ;
					
	
		echo "<tr>" . $linhas . "</tr>";
		
		$i ++;
                $contador ++;
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
        $varHR = $_POST["txtHR"];
	$varDT = $varDT[2].'-'.$varDT[1].'-'.$varDT[0];
	//echo $varDT;exit;
	$sql = new cmd_SQL ();
	$bd ['sql'] = "SELECT nome,onibus,i.vagas,h.vagas as vaga,tipo,h.idhorario,data,horainicio,h.idtipo_dependencia 
			FROM salaolivro.inscricao i
			inner join salaolivro.horario h on 
			(i.idhorario = h.idhorario)
			inner join salaolivro.escola e on 
			(i.escola = e.idescola) ";
	
	
	if($varHR == ''){
		$bd ['sql'] .= "where data = '".$varDT."' and h.idtipo_dependencia = 1 
			order by nome";
	}
	
	else{
		$bd ['sql'] .= "where data = '".$varDT."' and horainicio = '".$varHR."' and h.idtipo_dependencia = 1 
			order by nome";
	}
	
	
		
	

		
	$bd ['ret'] = "php";

	$rs = $sql->pesquisar( $bd );
	
	//echo $bd ['sql'];exit;
		
	return $rs;
}





?><br>
<br><div class="data" style='text-align:center'>Relat&oacute;rio gerado em <?php echo date("d/m/Y H:i:s") ?></div>

</body>
</html>
