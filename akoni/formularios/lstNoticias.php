<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Akoni</title>
	<link href="../../lib/css/estilo.css" type="text/css" rel="stylesheet">
	<link href="../../lib/css/jquery-ui-1.8.11.custom_flat.css" type="text/css" rel="stylesheet">
	<link href="../../lib/css/demo_table_jui_flat.css" type="text/css" rel="stylesheet">
	 
	<script type="text/javascript" src="../../lib/js/jquery-1.8.3.js"></script>
	<script type="text/javascript" src="../../lib/js/jquery.dataTables.js"></script>
	<script type="text/javascript" src="../../lib/js/ajax.js"></script>
	<script type="text/javascript" src="../../lib/js/select.js"></script>
	<script type="text/javascript" src="../../lib/js/objeto.js"></script>
	<script type="text/javascript" src="../js/noticias.js"></script>
	<script type="text/javascript" src="../js/verifica_sessao.js"></script>
</head>
<body onload="verificar()">
<h1>Informa&ccedil;&otilde;es</h1>
<form id="frmPesquisaNoticia" name="frmPesquisaNoticia" method="post" action="lstNoticias.php">
<input class="Novo" type="button" value="Novo" onclick="novo()">
<br/>

<table width="500" border="0">
	<tr>
		<td>T&iacute;tulo da informa&ccedil;&atilde;o:<br />
		<input type="text" name='titulo' id='titulo' tabindex="1" size="60" maxlength="100"  />
		</td>
		<td>Vis&iacute;vel?<br />
		<select id="visivel" name="visivel">
			<option value=""></option>
			<option value="1">SIM</option>
			<option value="0">N&Atilde;O</option>
		</select></td>
		<td><a href="#" onclick="document.getElementById('frmPesquisaNoticia').submit();" class="Pesquisar" title="Filtrar">&nbsp;</a></td>
	</tr>
</table>
<table id="lst" class="display">            
            <thead>
                <tr>                    
                    <th>
                        Id
                    </th>
                    <th>
                        T&iacute;tulo
                    </th>
                    <th>
                        Vis&iacute;vel?
                    </th>
                    <th>
                        Editar
                    </th>                    
                </tr>
            </thead>
            <tbody>
               <?php
				require_once ("../../lib/php/cmd_sql.php");
				
				$varConsulta = ConsultaLista($_POST["titulo"],$_POST["visivel"]);
				//var_dump($varConsulta);
				
				$i=0;
				if ($varConsulta) {
					foreach ($varConsulta as $lin) {
						$varID= $varConsulta[$i]['IDINFORMACAO'];
						$varTitulo= $varConsulta[$i]['TITULO'];
						$varVisivel = $varConsulta[$i]['VISIVEL'];
						
						if ($varVisivel==0) {
							$visivel = "<img src='../../lib/images/icones/delete-24.png' onclick='ativarVisibilidade(" . $varID . ")' style='cursor: pointer;' >";
						}else{
							$visivel = "<img src='../../lib/images/icones/valid-24.png' onclick='desativarVisibilidade(" . $varID . ")' style='cursor: pointer;' >";
						}
						
						$linhas = "";
						
						$linhas .= "<td width='75px;'><center>" . utf8_encode($varID) . "</center></td>";
						$linhas .= "<td style='padding: 10px;'>" . utf8_encode($varTitulo) . "</td>";
						$linhas .= "<td width='75px;' id='tdVisivel" . $varID . "' ><center>" . $visivel . "<center></td>";
						$linhas .= "<td width='75px;'><center><a href='#' onclick=editar(".$varID.") class='Editar' title='Editar'>&nbsp;</a></center></td>";
						
						echo "<tr>" . $linhas . "</tr>";
						$i++;
					}
				}
				
				function ConsultaLista($titulo, $visivel) {
					$sql = new cmd_SQL();
					$condicao = "";
						
					if($titulo!=''){
						$condicao .= " TITULO like '%" . utf8_decode($titulo) . "%'";
					}
					if ($visivel!=""){
						if ($condicao != "") {
							$condicao .= " AND ";
						}
						$condicao .= "VISIVEL ='". $visivel ."'";
					}
				
					$bd['sql'] = "SELECT * FROM AKONI_INFORMACOES";
					
					if ($condicao != "") {
						$bd['sql'] .= " WHERE " . $condicao;
					}
					
					$bd['sql'] .= " ORDER BY IDINFORMACAO DESC";
					
					$bd['ret'] = "php";
					//echo $bd[sql];
					$rs = $sql->pesquisar($bd);
		
					return $rs;
				}
				?>	
            </tbody>
        </table>
     </body>