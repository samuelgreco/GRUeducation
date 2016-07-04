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
<td class=corpo width=1890 height=38><center><h1 style='text-align: center;'echo 'Relat&oacute;rio de escolas estaduais e particulares'</h1></center>
<div style='margin-left:20%'><h1>Relat&oacute;rio de escolas estaduais e particulares</h1></div></td>

</tr>
</table>
<div id='tbOnibusDisponiveis' name='tbOnibusDisponiveis'>
<table width='85%' style='margin-left:8%' id='listachamados' class='CSSTabela'>
<thead>
<tr>
<th class=tabela>Data</th>
<th class=tabela>Hora</th>
<th class=tabela>Nome</th>
<th class=tabela>Respons&aacute;vel</th>
<th class=tabela>Fone</th>
<th class=tabela>Inscritos</th>
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
                $varNome = ($varConteudo [$i] ['nome']);
                $varResponsavel = ($varConteudo [$i] ['responsavel']);
                $varFone = ($varConteudo [$i] ['telefone']);
                $varVagas = ($varConteudo [$i] ['vagas']);
		
	
		
		$linhas .=            			"<td class=" . $cor . ">" . ( $varData ) . "</td>" . 
                                  	 	 "<td class=" . $cor . ">" .  ( $varHora ) . "</td>" . 
                                      	 "<td class=" . $cor . ">" .  utf8_encode(( $varNome )) . "</td>" . 
                                        "<td class=" . $cor . ">" .  utf8_encode(( $varResponsavel )) . "</td>" . 
                                        "<td class=" . $cor . ">" .  ( $varFone ) . "</td>" . 
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
	$bd ['sql'] = "SELECT escola,onibus,i.vagas,tipo,idescola,nome,onibusdia,onibuseja,e.idtipo_dependencia,responsavel,telefone,DATE_FORMAT(data,'%d/%m/%Y') AS data,horainicio FROM salaolivro.inscricao i
inner join salaolivro.escola e on (i.escola = e.idescola)
inner join salaolivro.horario h on (e.idtipo_dependencia = h.idtipo_dependencia)
			where h.idtipo_dependencia <> 1";

		
	$bd ['ret'] = "php";

	$rs = $sql->pesquisar( $bd );
	
	//echo $bd ['sql'];exit;
		
	return $rs;
}

?><br>
<br><div class="data" style='text-align:center'>Relat&oacute;rio gerado em <?php echo date("d/m/Y H:i:s") ?></div>

</body>
</html>
