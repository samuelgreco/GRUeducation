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
<td class=corpo width=1890 height=38><center><h1 style='text-align: center;'echo 'Relat&oacute;rio de &ocirc;nibus por escola'</h1></center>
<div style='margin-left:30%'><h1>Relat&oacute;rio de &ocirc;nibus por escola</h1></div></td>

</tr>
</table>
<div id='tbOnibusDisponiveis' name='tbOnibusDisponiveis'>
<table width='85%' style='margin-left:8%' id='listachamados' class='CSSTabela'>
<thead>
<tr>
<th class=tabela>Escola</th>
<th class=tabela>Disponibilizados</th>
<th class=tabela>Ocupados</th>
<th class=tabela>Vagos</th>
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
		$varEscola = ($varConteudo [$i]['nome']);
		$varQtdOnibus = ($varConteudo [$i] ['qtd_onibus']);
                $varOcupados = ($varConteudo [$i] ['preenchido']);
                $varVagas = ($varConteudo [$i] ['restante']);
		
	
		
		$linhas .=              "<td class=" . $cor . ">" . utf8_encode(( $varEscola )) . "</td>" . 
                                       "<td class=" . $cor . ">" .  ( $varQtdOnibus ) . "</td>" . 
                                        "<td class=" . $cor . ">" .  ( $varOcupados ) . "</td>" . 
					"<td class=" . $cor . "><b>" . ( $varVagas ) . "</td></b>" ;
					
	
		echo "<tr>" . $linhas . "</tr>";
		
		$i ++;
                $contador ++;
	}
	echo "</tbody>
		</table>
		</div>";
}
      
function ConsultaConteudo() {

	$sql = new cmd_SQL ();
	$bd ['sql'] = "select idescola, nome, qtd_onibus, (qtd_dia + qtd_eja) preenchido, (qtd_onibus - (qtd_dia + qtd_eja)) restante from (
select e.idescola, e.nome, (e.onibusdia + e.onibuseja) qtd_onibus, IF(dia.qtde IS NULL, 0, dia.qtde) qtd_dia, IF(eja.qtde IS NULL, 0, eja.qtde) qtd_eja from escola e
left join 
(select escola, count(escola) qtde from inscricao where tipo=1 group by escola) dia 
on e.idescola=dia.escola
left join 
(select escola, count(escola) qtde from inscricao where tipo=2 group by escola) eja
on e.idescola=eja.escola
where e.idtipo_dependencia=1
) esc";

		
	$bd ['ret'] = "php";

	$rs = $sql->pesquisar( $bd );
	
	//echo $bd ['sql'];exit;
		
	return $rs;
}

?><br>
<br><div class="data" style='text-align:center'>Relat&oacute;rio gerado em <?php echo date("d/m/Y H:i:s") ?></div>

</body>
</html>
