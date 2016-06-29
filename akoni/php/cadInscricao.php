<?php
	require_once ("../../lib/php/cmd_sql.php");
	require_once ("cadLog.php");
	
	switch($_POST["acao"]){
		case 'etapa1':
			Etapa1();
			break;
		case 'etapa2':
			Etapa2();
			break;
		case 'finaliza':
			Finaliza();
			break;
		case 'addcurso':
			AddCurso();
			break;
		case 'removecurso':
			ExcluirCurso($_POST['idcurso']);
			break;
		case 'aprovacao':
			Aprovacao();
			break;
		case 'pontuacao':
			if($_POST ["txtIDPontuacao"]!=""){
				AlterarPontuacao();
			}else{
				IncluirPontuacao();
			}
			break;
		default:
			break;
	}
	
	function Etapa1() {
		$con = new cmd_SQL ();
		
		setlocale ( LC_CTYPE, "pt_BR" );
		
		$db [tab] = "CONCURSO_CANDIDATO";
		$db [campos] = "NOME,
						CPF,
						RG,
						UFEXPEDICAO,
						ORGAOEXPEDICAO,
						DATAEXPEDICAO,
						TITULOELEITOR,
						ZONAELEITOR,
						SECAOELEITOR,
						DATANASC,
						SEXO,
						ESTADOCIVIL,
						ENCARGO,
						NACIONALIDADE,
						NATURALIDADE,
						UFNATURALIDADE,
						MAE,
						PAI,
						PROFISSAO,
						ESCOLARIDADE,
						ENDERECO,
						NUMERO,
						COMPLEMENTO,
						BAIRRO,
						CIDADE,
						UF,
						CEP,
						CELULAR,
						TELEFONE,
						EMAIL,
						STATUS,
						DATASISTEMA";
		
		$db [values] = mb_strtoupper(utf8_decode("'" . ($_POST ["txtNome"]) . "'," .
												"'" . ($_POST ["txtCPF"]) . "'," .
												"'" . ($_POST ["txtRG"]) . "'," .
												"'" . ($_POST ["cboEstadoRG"]) . "'," .
												"'" . ($_POST ["cboOrgaoRG"]) . "'," .
												"'" . ($_POST ["txtDataRG"]) . "'," .
												"'" . ($_POST ["txtTituloEleitor"]) . "'," .
												"'" . ($_POST ["txtZonaEleitor"]) . "'," .
												"'" . ($_POST ["txtSecaoEleitor"]) . "'," .
												"'" . ($_POST ["txtDtNasc"]) . "'," .
												"'" . ($_POST ["cboSexo"]) . "'," .
												"'" . ($_POST ["cboEstadoCivil"]) . "'," .
												"'" . ($_POST ["cboNFilhos"]) . "'," .
												"'" . ($_POST ["txtNacionalidade"]) . "'," .
												"'" . ($_POST ["txtNaturalidade"]) . "'," .
												"'" . ($_POST ["cboEstadoNatural"]) . "'," .
												"'" . ($_POST ["txtMae"]) . "'," .
												"'" . ($_POST ["txtPai"]) . "'," .
												"'" . ($_POST ["txtProfissao"]) . "'," .
												"'" . ($_POST ["txtEscolaridade"]) . "'," .
												"'" . ($_POST ["txtEndereco"]) . "'," .
												"'" . ($_POST ["txtNumero"]) . "'," .
												"'" . ($_POST ["txtComplemento"]) . "'," .
												"'" . ($_POST ["txtBairro"]) . "'," .
												"'" . ($_POST ["txtCidade"]) . "'," .
												"'" . ($_POST ["txtUF"]) . "'," .
												"'" . ($_POST ["txtCEP"]) . "'," .
												"'" . ($_POST ["txtCelular"]) . "'," .
												"'" . ($_POST ["txtTelefone"]) . "'," .
												"'" . ($_POST ["txtEmail"]) . "'," .
												"'" . ($_POST ["status"]) . "'," .
												"SYSDATE"));
		
		if ($con->incluir ( $db )) {		
			$id = PesqID();
			echo $id;
		} else {
			echo "<h1 style='padding:0px;font-size:22px;text-align:center;'>Ocorreu um erro! Entre em contato com a administra&ccedil;&atilde;o."; // false;
			echo "<br /><br />insert into " . $db [tab] . "(" . $db [campos] . ")values(" . $db [values] . ")</h1>";
		}
	}
	
	function Etapa2(){
		$con = new cmd_SQL();
	
		$db[sql]=" update CONCURSO_CANDIDATO set FORMACAO = " . mb_strtoupper (utf8_decode("'" . $_POST ["txtFormacao"] . "',")) .
												"MAGISTERIO = " . mb_strtoupper (utf8_decode("'" . $_POST ["cboMagisterio"] . "',")) .
												"PEDAGOGIA = " . mb_strtoupper (utf8_decode("'" . $_POST ["cboPedagogia"] . "',")) .
												"NORMAL = " . mb_strtoupper (utf8_decode("'" . $_POST ["cboNormal"] . "',")) .
												"POSGRADUACAO = " . mb_strtoupper (utf8_decode("'" . $_POST ["txtPos"] . "',")) .
												"DESCPOS = " . mb_strtoupper (utf8_decode("'" . $_POST ["txtDescPos"] . "',")) .
												"INSTPOS = " . mb_strtoupper (utf8_decode("'" . $_POST ["txtInstPos"] . "',")) .
												"MESTRADO = " . mb_strtoupper (utf8_decode("'" . $_POST ["txtMestre"] . "',")) .
												"DESCMESTRADO = " . mb_strtoupper (utf8_decode("'" . $_POST ["txtDescMestre"] . "',")) .
												"INSTMESTRADO = " . mb_strtoupper (utf8_decode("'" . $_POST ["txtInstMestre"] . "',")) .
												"DOUTORADO = " . mb_strtoupper (utf8_decode("'" . $_POST ["txtDoutor"] . "',")) .
												"DESCDOUTORADO = " . mb_strtoupper (utf8_decode("'" . $_POST ["txtDescDoutor"] . "',")) .
												"INSTDOUTORADO = " . mb_strtoupper (utf8_decode("'" . $_POST ["txtInstDoutor"] . "',")) .
												"ANOEXPERIENCIA = " . mb_strtoupper (utf8_decode("'" . $_POST ["cboAnoExperiencia"] . "',")) .
												"MESEXPERIENCIA = " . mb_strtoupper (utf8_decode("'" . $_POST ["cboMesExperiencia"] . "',")) .
												"DATASISTEMA = SYSDATE," .
												"STATUS = " . mb_strtoupper (utf8_decode("'" . $_POST ["status"] . "'"));
		
		$db[sql]= $db[sql] . " where IDCANDIDATO = " . $_POST ["txtID"];
	
		if ($con->alterar($db)){
			echo "true";
		}else {
			echo " Erro na alteração!";
			echo $db[sql];
		}
	}
	
	function Finaliza(){
		echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
				<html xmlns='http://www.w3.org/1999/xhtml'>
				<head>
				<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
				<meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1' />
				<title>Processo Seletivo Simplificado 2015</title>
				<link href='../css/estilo.css' rel='stylesheet' type='text/css' />
				<link href='../css/estiloTabela.css' rel='stylesheet' type='text/css' />
				<link rel='stylesheet' type='text/css' href='../css/style.css' />
				<link rel='stylesheet' type='text/css' href='../../lib/css/estilo.css' />
				<script src='../../lib/js/jquery-1.9.1.js' type='text/javascript'></script>
				<script type='text/javascript' src='../../lib/js/ajax.js'></script>
				<script type='text/javascript' src='../../lib/js/select.js'></script>
				<script type='text/javascript' src='../../lib/js/objeto.js'></script>
				<script type='text/javascript' src='../../lib/js/funcoes.js'></script>
				<script type='text/javascript' src='../js/jquery.mask.js'></script>
				<script type='text/javascript' src='../js/situacao.js'></script>
				</head>
				<body onload=''>
				<div id='tela'>
					<div id='banner'></div>
					
					<div class='barra_menu'>
						<div class='menu'>
							<ul>
								<li><a href='../index.php'>Início</a></li>";
		
								//require_once ("../../lib/php/cmd_sql.php");
								
								$varTravas = ConsultaTravas();
								
								if($varTravas[0]["INSCRICAO"]==1){
									echo '<li><a href="../formularios/inscricao.php">Inscrição</a></li>';
								}
								if($varTravas[0]["SITUACAO"]==1){
									echo '<li><a href="../formularios/situacao.php">Situação da inscrição</a></li>';
								}
								if($varTravas[0]["PUBLICACAO"]==1){
									echo '<li><a href="../formularios/publicacao.php">Editais e publicações</a></li>';
								}
								
						echo "
								<li style='float: right;font-size:9px;'><a href='../login.html'><img src='../images/lock.png' style='width: 10px;' />&nbsp;Acesso restrito</a></li>
							</ul>
						</div>              
					</div>
				  
					<div id='tela_camp'>
						<h1 style='padding:0px;font-size:22px;text-align:center;'>Inscrição realizada com sucesso!</h1>
						<h2 style='padding:0px;font-size:18px;text-align:center;'>Inscrição n° ".$_POST ["txtID"]."</h2>
						<table>
							<tr>
								<td><img src='../images/aviso.png' /></td>
								<td>
									Não se esqueça de imprimir as fichas para serem apresentadas no momento da entrega dos documentos.
									<b>Não serão recebidos documentos sem a apresentação das fichas.</b> Para imprimi-las, clique no botão \"Imprimir\".
									<br /><br />
									Obs.: Anexar cópia simples acompanhado de original para certificação, de todos os documentos que 
									comprovem as informações prestadas neste formulário, inclusive da certidão de nascimento dos filhos.
									(os originais serão para atestar a veracidade das cópias e serão devolvidos ao candidato no ato da
									efetivação da inscrição).
									<br /><br />
									* Novas vias das fichas poderão ser impressas a qualquer momento acessando o menu \"Situação da Inscrição\".
								</td>
							</tr>
						</table>
						<br />
						<div style='width:100%;text-align:center;'>
							<a href='../relatorios/ficha.php?id=".$_POST ["txtID"]."' class='Imprimir' target='_blank'>Imprimir</a>
						</div>
						<br /><br />
						<p style='text-align: center;font-family: Arial;color: #000;'>
						   Para mais informações, ligue para a Secretaria de Educação de Guarulhos<br /> 
						   Telefone: 2475-7300 - Ramal: 7309<br /> ou mande e-mail para: comissaoprocessoseletivo2015@googlegroups.com
						</p>
					</div>
					
					<div id='rodape'>
						<div id='rodape_texto'>Secretaria Municipal de Educação de Guarulhos<br />DPIE - Departamento de Planejamento e Informática na Educação</div>
					</div>
				</div>";
	}
	
	function AddCurso(){
		$con = new cmd_SQL ();
		
		setlocale ( LC_CTYPE, "pt_BR" );
		
		$db [tab] = "CONCURSO_CURSOS";
		$db [campos] = "DESCRICAO,
						INSTITUICAO,
						DTINICIO,
						DTTERMINO,
						CARGA,
						IDCANDIDATO";
		
		$db [values] = mb_strtoupper(utf8_decode("'" . ($_POST ["txtCurso"]) . "'," .
				"'" . ($_POST ["txtInstCurso"]) . "'," .
				"'" . ($_POST ["txtDtInicio"]) . "'," .
				"'" . ($_POST ["txtDtTermino"]) . "'," .
				"'" . ($_POST ["txtCarga"]) . "'," .
				"'" . ($_POST ["txtID"]) . "'"));
		
		if ($con->incluir ( $db )) {
			echo "true";
		} else {
			echo "<h1 style='padding:0px;font-size:22px;text-align:center;'>Ocorreu um erro! Entre em contato com a administra&ccedil;&atilde;o."; // false;
			echo "<br /><br />insert into " . $db [tab] . "(" . $db [campos] . ")values(" . $db [values] . ")</h1>";
		}
	}
	
	function ExcluirCurso($id){
		$con = new cmd_SQL();
	
		setlocale(LC_CTYPE,"pt_BR");
	
		$db[tab]="CONCURSO_CURSOS";
		$db[cond]="IDCURSO=" . $id;
	
		if ($con->excluir($db)){
			echo "true";
		}else {
			echo $db[cond];
			exit;
		}
	}
	
	function Aprovacao(){
		$con = new cmd_SQL();
		
		if($_POST["cboAprovacao"]==1){
			$status=2;
		}else{
			$status=3;
		}
	
		$db[sql]=" update CONCURSO_CANDIDATO set JUSTIFICATIVA = '" . utf8_decode($_POST ["txtJustificativa"]) . "'," .
												"STATUS = '" . $status . "'";
		
		$db[sql]= $db[sql] . " where IDCANDIDATO = " . $_POST ["txtID"];
	
		if ($con->alterar($db)){
			echo "true";
			if($_POST["cboAprovacao"]==1){
				SalvarLog("CONCURSO_CANDIDATO", "APROVA INSCRICAO", $db[sql]);
			}else{
				SalvarLog("CONCURSO_CANDIDATO", "INDEFERE INSCRICAO", $db[sql]);
			}
		}else {
			echo "Erro na alteração!";
			echo $db[sql];
		}
	}
	
	function IncluirPontuacao() {
		$con = new cmd_SQL ();
	
		setlocale ( LC_CTYPE, "pt_BR" );
	
		$db [tab] = "CONCURSO_PONTUACAO";
		$db [campos] = "IDCANDIDATO,
						DOUTORADO,
						MESTRADO,
						POSGRADUACAO,
						SUPERIOR,
						MAGISTERIO,
						PEDAGOGIA,
						EXPERIENCIA,
						TOTAL";
	
		$db [values] = mb_strtoupper(utf8_decode("'" . ($_POST ["txtID"]) . "'," .
												"'" . ($_POST ["lblQtdeDoutor"]) . "'," .
												"'" . ($_POST ["lblQtdeMestre"]) . "'," .
												"'" . ($_POST ["lblQtdePos"]) . "'," .
												"'" . ($_POST ["lblQtdeSuperior"]) . "'," .
												"'" . ($_POST ["lblQtdeMagisterio"]) . "'," .
												"'" . ($_POST ["lblQtdePedagogia"]) . "'," .
												"'" . ($_POST ["lblQtdeDocente"]) . "'," .
												"'" . ($_POST ["txtTotal"]) . "'"));
	
		if ($con->incluir ( $db )) {
			$id = PesqIDPontuacao();
			echo $id;
			SalvarLog("CONCURSO_PONTUACAO", "ATRIBUI PONTUACAO", "insert into " . $db [tab] . "(" . $db [campos] . ")values(" . $db [values] . ")");
		} else {
			echo "<h1 style='padding:0px;font-size:22px;text-align:center;'>Ocorreu um erro! Entre em contato com a administra&ccedil;&atilde;o."; // false;
			echo "<br /><br />insert into " . $db [tab] . "(" . $db [campos] . ")values(" . $db [values] . ")</h1>";
		}
	}
	
	function AlterarPontuacao(){
		$con = new cmd_SQL();
	
		$db[sql]=" update CONCURSO_PONTUACAO set DOUTORADO = " . mb_strtoupper (utf8_decode("'" . $_POST ["lblQtdeDoutor"] . "',")) .
												"MESTRADO = " . mb_strtoupper (utf8_decode("'" . $_POST ["lblQtdeMestre"] . "',")) .
												"POSGRADUACAO = " . mb_strtoupper (utf8_decode("'" . $_POST ["lblQtdePos"] . "',")) .
												"SUPERIOR = " . mb_strtoupper (utf8_decode("'" . $_POST ["lblQtdeSuperior"] . "',")) .
												"MAGISTERIO = " . mb_strtoupper (utf8_decode("'" . $_POST ["lblQtdeMagisterio"] . "',")) .
												"PEDAGOGIA = " . mb_strtoupper (utf8_decode("'" . $_POST ["lblQtdePedagogia"] . "',")) .
												"EXPERIENCIA = " . mb_strtoupper (utf8_decode("'" . $_POST ["lblQtdeDocente"] . "',")) .
												"TOTAL = " . mb_strtoupper (utf8_decode("'" . $_POST ["txtTotal"] . "'"));
	
		$db[sql]= $db[sql] . " where IDPONTUACAO = " . $_POST ["txtIDPontuacao"];
	
		if ($con->alterar($db)){
			echo $_POST["txtIDPontuacao"];
			SalvarLog("CONCURSO_PONTUACAO", "ALTERA PONTUACAO", $db[sql]);
		}else {
			echo "Erro na alteração!";
			echo $db[sql];
		}
	}
	
	function PesqID(){
		$sql = new cmd_SQL();
		$bd['sql']="select * from CONCURSO_CANDIDATO where NOME='" . mb_strtoupper (utf8_decode($_POST ["txtNome"])) . "' and " .
												"CPF='" . mb_strtoupper (utf8_decode($_POST ["txtCPF"])) . "' and " .
												"RG='" . mb_strtoupper (utf8_decode($_POST ["txtRG"])) . "' and " .
												"DATANASC='" . mb_strtoupper (utf8_decode($_POST ["txtDtNasc"])) . "'";
		$bd['ret']="php";
		$rs = $sql->pesquisar($bd);
		
		return $rs[0]["IDCANDIDATO"];
	}
	
	function PesqIDPontuacao(){
		$sql = new cmd_SQL();
		$bd['sql']="select * from CONCURSO_PONTUACAO where IDCANDIDATO='" . mb_strtoupper(utf8_decode($_POST ["txtID"])) . "'";
		$bd['ret']="php";
		$rs = $sql->pesquisar($bd);
		
		return $rs[0]["IDPONTUACAO"];
	}
	
	function ConsultaTravas(){
		$sql = new cmd_SQL();
		$bd['sql'] = "SELECT * FROM CONCURSO_TRAVA";
		$bd['ret'] = "php";
		$rs = $sql->pesquisar($bd);
			
		return $rs;
	}
?>