<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Formulário DPIE</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="language" content="en" />
<script type="text/javascript" language="javascript" src="../../lib/js/ajax.js"></script>
<script type="text/javascript" language="javascript" src="../../lib/js/jquery.js"></script>
<script type="text/javascript" language="javascript" src="../../lib/js/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="../js/escola.js"></script>
<script type="text/javascript" src="../../lib/js/objeto.js"></script>
<script type="text/javascript" src="../../lib/js/select.js"></script>
<link href="../../lib/css/jquery-ui-1.8.11.custom.css" rel="stylesheet" type="text/css" />
<link href="../../lib/css/demo_table_jui.css" rel="stylesheet" type="text/css" />
<link href="../../lib/css/estilo.css" rel="stylesheet" type="text/css" />

</head>
<body onload="carregaTipoDependencia()">
<div id="tela">

<div id="tela">
<div id="tela_centro">
<div id="right">
<div class="post">
<div class="post_content">
<form id="frmPesquisaEscola" name="frmPesquisaEscola" method="post" action="consultaEscola.php">
<h1>Escola</h1> <input class="Novo" type="button" value="Novo" onclick="window.location.href='escola.html';">
<p>&nbsp;</p>
<table border="0">
	<tr>
		<td>Escola:<br />
		<input type="text" name="txtEscola" id="txtEscola" size="50"/></td>
		<td>Tipo de escola:<br />
		<select name="cboTipo" id="cboTipo" >
		</select></td>
		<td><input style="border: none; height: 30px;" type="submit" name="btn_filtrar" id="btn_filtrar" value="" tabindex="5" class="Pesquisar" /></td>
	</tr>
</table>
<br />
<table width="800" border="0" class="display" id="tabela" >
<thead>
	<tr>
		<th>Nome</th>
		<th>Tipo</th>
		<th>Onibus Dia</th>
		<th>Onibus EJA</th>
		<th width='60'align="center">A&ccedil;&atilde;o</th>
	</tr>
</thead>
<tbody>
	<?php
	require_once ("../php/cmd_sql.php");
		$escola = "";
		$tipo = "";
		if (isset($_POST['txtEscola'])){
			$escola = $_POST["txtEscola"];
		}
		if (isset($_POST['cboTipo'])){
			$tipo = $_POST["cboTipo"];
		}
		$varConsulta = ConsultaLista($escola,$tipo);
		$i=0;
		if ($varConsulta) {
			foreach ($varConsulta as $lin) {
				$varNome = $varConsulta[$i]['nome'];
				$varTipo = $varConsulta[$i]['tipo'];
				$varOnibusDia = $varConsulta[$i]['onibusdia'];
				$varOnibusEja = $varConsulta[$i]['onibuseja'];
				$varID = $varConsulta[$i]['idEscola'];
								
				$linhas = "";
				
				$linhas .= "<td style='padding:10px;'>" . utf8_encode($varNome) . "</td>";
				$linhas .= "<td style='padding:10px;'><center>" . utf8_encode($varTipo) . "</center></td>";
				$linhas .= "<td style='padding:10px;'><center>" . utf8_encode($varOnibusDia) . "</center></td>";
				$linhas .= "<td style='padding:10px;'><center>" . utf8_encode($varOnibusEja) . "</center></td>";
				
				$linhas .= "<td><center>" .
							"<a href='#' onClick='editar(" . $varID . ")' class='Editar' title='Editar'>&nbsp;</a>" .
							"<center>
							</td>";						
				
				echo "<tr>" . $linhas . "</tr>";
				$i++;
			}
		}
		
		function ConsultaLista($escola,$tipo) {
		$sql = new cmd_SQL();
		$condicao = "";
		
		if ($escola!="") {
			$condicao = " nome like '%" . $escola . "%'";
		}
		if ($tipo!="") {
			if ($condicao != "") {
				$condicao .= " and ";
			}
			$condicao = " idtipo_dependencia=" . $tipo;
		}
						
		$bd['sql'] = "SELECT e.idEscola, e.nome, e.onibusdia, e.onibuseja, td.idtipo_dependencia, td.descricao as tipo FROM escola e
					LEFT JOIN tipo_dependencia td USING(idtipo_dependencia)";
						
		if ($condicao != "") {
			$bd['sql'] .= " where " . $condicao;
		}
		
		$bd['sql'] .= " order by e.nome,e.onibusdia";
		
		$bd['ret'] = "php";
		$rs = $sql->pesquisar($bd);
		
		return $rs;
	
	}
	?>
</tbody>
</table>
</form>
</div>
</div>
<div class="post"></div>
</div>
</div>
</div>
<div style="text-align: center; font-size: 0.75em;"></div>
</div>
</body>
</html>