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
<script type="text/javascript" src="../../lib/js/jquery.click-calendario-1.0.js"></script>
<script type="text/javascript" language="javascript" src="../js/horario.js"></script>
<link href="../../lib/css/jquery-ui-1.8.11.custom.css" rel="stylesheet" type="text/css" />
<link href="../../lib/css/jquery.click-calendario-1.0.css" rel="stylesheet" type="text/css" />
<link href="../../lib/css/demo_table_jui.css" rel="stylesheet" type="text/css" />
<link href="../../lib/css/estilo.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
    	              
    $(document).ready(function(){    	              
        $('#txtData').focus(function(){
        	$(this).calendario({
        		target:'#txtData'
        	});
        });                       
    });                     
            
</script> 
</head>
<body>
<div id="tela">

<div id="tela">
<div id="tela_centro">
<div id="right">
<div class="post">
<div class="post_content">
<form id="frmPesquisaHorario" name="frmPesquisaHorario" method="post" action="consultaHorario.php">
<h1>Hor&aacute;rios</h1> <input class="Novo" type="button" value="Novo" onclick="window.location.href='horario.html';">
<p>&nbsp;</p>
<table width="560" border="0">
	<tr>
		<td>
		Tipo:<br />
		<select id="cboTipo" name="cboTipo">
			<option value=""></option>
			<option value="1">Municipal</option>
			<option value="2">Estadual / Particular</option>
		</select>
		</td>
		<td width="20%" height="46">Data<br />
		<input name="txtData" type="text" id='txtData' size="20" onFocus="this.select()" readonly="readonly"/></td>
		<td><input style="border: none; height: 30px;" type="submit" name="btn_filtrar" id="btn_filtrar" value="" tabindex="5" class="Pesquisar" /></td>
	</tr>
</table>
<br />
<table width="800" border="0" class="display" id="tabela" >
<thead>
	<tr>
		<th>Tipo</th>
		<th>Data</th>
		<th>Hora Inicio</th>
		<th>N&uacute;mero de Vagas</th>
		<th width='60'align="center">A&ccedil;&atilde;o</th>
	</tr>
</thead>
<tbody>
	<?php
	require_once ("../php/cmd_sql.php");
		$tipo = "";
		$data = "";
		if (isset($_POST['cboTipo'])){
			$tipo = $_POST["cboTipo"];
		}
		if (isset($_POST['txtData'])){
			$data = $_POST["txtData"];
		}
		
		$varConsulta = ConsultaLista($tipo, $data);
		$i=0;
		if ($varConsulta) {
			foreach ($varConsulta as $lin) {
				$varTipo = $varConsulta[$i]['tipo'];
				$varData = $varConsulta[$i]['data'];
				$varHora = $varConsulta[$i]['horaInicio'];
				$varVagas = $varConsulta[$i]['vagas'];
				$varID = $varConsulta[$i]['idHorario'];
				$varIDTipo = $varConsulta[$i]['idtipo_dependencia'];
				
				if($varIDTipo==1){
					$tipo = "&ocirc;nibus";
				}else{
					$tipo = "alunos";
				}

				$linhas = "";
				
				$linhas .= "<td style='padding:10px;'>" . utf8_encode($varTipo) . "</td>";
				$linhas .= "<td><center>" . utf8_encode($varData) . "</center></td>";
				$linhas .= "<td><center>" . utf8_encode($varHora) . "</center></td>";
				$linhas .= "<td><center>" . utf8_encode($varVagas) . " " . $tipo . "</center></td>";
				
				$linhas .= "<td><center>" .
							"<a href='#' onClick='editar(" . $varID . ")' class='Editar' title='Editar'>&nbsp;</a>" .				
							"<center>
							</td>";		
				
				echo "<tr>" . $linhas . "</tr>";
				$i++;
			}
		}
		
		function ConsultaLista($tipo, $data) {
		$sql = new cmd_SQL();
		$condicao = "";
		
		if ($tipo!="") {
			$condicao .= " idtipo_dependencia='" . $tipo . "'";
		}
		
		if ($data!="") {
			$aux = explode("/",$data);
			$data = $aux[2]."-".$aux[1]."-".$aux[0];
			if ($condicao!=""){
				$condicao .= " and ";
			}
			$condicao .= " data ='" . $data . "'";
		}
						
		$bd['sql'] = "SELECT idHorario, date_format(h.data, '%d/%m/%y') as data, h.horaInicio, td.descricao as tipo, h.vagas, td.idtipo_dependencia
					FROM horario h inner join tipo_dependencia td using(idtipo_dependencia) ";
						
		if ($condicao != "") {
			$bd['sql'] .= "where " . $condicao;
		}
		
		$bd['sql'] .= " order by data, horaInicio";
		
		$bd['ret'] = "php";
		$rs = $sql->pesquisar($bd);
		
		return $rs;
	
	}
	?>
</tbody>
</table>
<p></p>
<br />
<br />
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