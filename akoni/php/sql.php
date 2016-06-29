<?php
ob_start();
session_start();
ob_end_clean();

require_once("../../lib/php/cmd_sql.php");

switch ($_POST["filtro"]) {

/*DAVI */	

	case 'consultaInscricao':
		consultaInscricao();
		break;
	case 'CPFInscricao':
		CPFInscricao();
		break;
	case 'carregaEscolaMunicipal' :
		carregaEscolaMunicipal();
		break;		
	case 'carregaEscolaConveniada' :
		carregaEscolaConveniada();
		break;		
	case 'carregaEscolaMova' :
		carregaEscolaMova();
		break;		

	case 'carregaProfMova' :
		carregaProfMova();
		break;		

	case 'consultaProfMova' :
		consultaProfMova();
		break;		
	case 'gravaProfMova' :
		gravaProfMova();
		break;		
	case 'gravarDescTrab' :
		gravarDescTrab();
		break;		
	case 'excluirInscricao' :
		excluirInscricao();
		break;
	case 'editarInscricao' :
		editarInscricao();
		break;

	case 'editar_Trab' :
		editar_Trab();
		break;

		case 'carregarProf' :
			carregarProf();
			break;
	
	case 'gravarTrabalho' :
		gravarTrabalho();
		break;		

		
	case 'carregarDescTrabalho' :
		carregarDescTrabalho();
		break;		

	case 'salvarJustificativa' :
		salvarJustificativa();
		break;
		
	case 'upDateJustificativa' :
		upDateJustificativa();
		break;
		

	case 'excluirJustificativa' :
		excluirJustificativa();
		break;
		

		
		
		
	case 'upDateTrabalho' :
		upDateTrabalho();
		break;		
	case 'finalizar' :
		finalizar();
		break;		

	case 'entregaTrabalho' :
		entregaTrabalho();
		break;		

		
		
		
	case 'upDateProfMova' :
		upDateProfMova();
		break;
	case 'gravarTrabEducando' :
		gravarTrabEducando();
		break;		
	case 'gravarTrabTurma' :
		gravarTrabTurma();
		break;		
	case 'upDateTrabTurma' :
		upDateTrabTurma();
		break;		

	case 'upDateTrabEducando' :
		upDateTrabEducando();
		break;		
	case 'upDateDescTrab' :
		upDateDescTrab();
		break;		

	
	
	case 'gravarProf' :
		gravarProf();
		break;		
	case 'excluirProf' :
		excluirProf();
		break;

		
/*CONTADOR CATEGORIA*/ 
	case 'qtdInscricaoCategoria':
		qtdInscricaoCategoria();
		break;
		
	case 'qtdInscricaoCategoriaMova':
		qtdInscricaoCategoriaMova();
		break;
 
		
		
		
/*kelvin*/	
	case 'verificaCPF':
		verificaCPF();
		break;
	case 'verificaCPF_GS':
		verificaCPF_GS();
		break;
	case 'PesqInscricao':
		PesqInscricao();
		break;
	case 'PesqInscricaoReceber':
		PesqInscricaoReceber();
		break;
	case 'PesqCandidatoPontos':
		PesqCandidatoPontos();
		break;
	case 'PesqPontuacao':
		PesqPontuacao();
		break;
	case 'CarregaUltimasNoticias':
		CarregaUltimasNoticias();
		break;
	case 'CarregaNoticia':
		CarregaNoticia();
		break;
	case 'CarregaCursos':
		CarregaCursos();
		break;
	case 'CarregaQtdeCursos':
		CarregaQtdeCursos();
		break;
	case 'PesqTrava':
		PesqTrava();
		break;
	case 'Login':
		Login();
	default:
		break;
}

function consultaInscricao() {
	$sql = new cmd_SQL();
	$bd['sql'] = "SELECT * FROM AKONI_INSCRICAO where CPF='". $_POST['txtCPFResponsavel'] ."'";
	$bd['ret'] = "xml";
	$sql->pesquisar($bd);
}

function CPFInscricao(){
	$sql = new cmd_SQL ();
	$db ['tab'] = "AKONI_INSCRICAO";
	$db ['campos'] = "CPF,STATUS";
	$db ['values'] = "'".utf8_decode($_POST['txtCPFResponsavel'])."','0'";
	if ($sql->incluir($db)) {
		echo ultimaInscricao();
	} else {
		echo false;
	}
}
		
function ultimaInscricao(){
	$sql = new cmd_SQL();
	$bd['sql'] = "SELECT AKONI_INSC_IDINSCRICAO_SEQ.CURRVAL FROM DUAL";
	$bd['ret']='php';
	$rs=$sql->pesquisar($bd);
	echo $rs[0]['CURRVAL'];
}
		
		
function gravarTrabalho(){
	$sql = new cmd_SQL ();
	$db ['tab'] = "AKONI_TRABALHO";
	$db ['campos'] = "IDINSCRICAO,IDCATEGORIA,IDPJ,IDDEPENDENCIA";
	$db ['values'] = $_POST['IdInscricao'].",".$_POST['IdCategoria'].",".$_POST['IdEscola'].",".$_POST['IdDependencia'];
    //echo "INSERT INTO ". $db['tab']."(".$db['campos'].") VALUES (".$db['values'].")";
	if ($sql->incluir($db)) {
		echo ultimoTrabalho();
		} else {
		echo false;}
}
		

function UpDateTrabalho(){
	$sql = new cmd_SQL ();
	$db ['sql'] = "UPDATE AKONI_TRABALHO SET IDCATEGORIA=".$_POST['IdCategoria'].",IDPJ=".$_POST['IdEscola'].",IDDEPENDENCIA=".$_POST['IdDependencia']."  WHERE IDTRABALHO = " . $_POST ['IdTrabalho'];
//	echo $db ['sql']; 
	if ($sql->alterar($db)) {
		echo true;
	} else {
		echo false;
	}	
}

function UpDateProfMova(){

	$sql = new cmd_SQL ();
	$db ['sql'] = "UPDATE AKONI_MOVA SET IDSERVIDOR_PUBLICO=".$_POST['IdServidor_Publico']." WHERE IDTRABALHO = " . $_POST ['IdTrabalho'];
//	echo $db ['sql'];
	if ($sql->alterar($db)) {
		echo true;
	} else {
		echo false;
	}
}

function ultimoTrabalho(){
	$sql = new cmd_SQL();
	$bd['sql'] = "SELECT AKONI_TRAB_IDTRABALHO_SEQ.CURRVAL FROM DUAL";
	$bd['ret']='php';
	$rs=$sql->pesquisar($bd);
	echo $rs[0]['CURRVAL'];
}

function gravaProfMova(){
	$sql = new cmd_SQL ();
	$db ['tab'] = "AKONI_MOVA";
	$db ['campos'] = "IDSERVIDOR_PUBLICO, IDTRABALHO";
	$db ['values'] = $_POST['IdServidor_Publico'].",".$_POST['IdTrabalho'];
//	echo "INSERT INTO ". $db['tab']."(".$db['campos'].") VALUES (".$db['values'].")";
	if ($sql->incluir($db)) {
		echo true;
	} else {
		echo false;}
}

function gravarTrabEducando(){
	$sql = new cmd_SQL ();
	$db ['tab'] = "AKONI_TRAB_EDUCANDO";
	$db ['campos'] = "IDTRABALHO,NOME,DTNASC,IDRACA,TIPO_ENSINO,SEXO";
	$db ['values'] = $_POST['IdTrabalho'].",'".$_POST['Nome']."','".$_POST['DtNasc']."',".$_POST['Raca'].",".$_POST['TipoEnsino'].",'".$_POST['Sexo']."'";
//	echo "INSERT INTO ". $db['tab']."(".$db['campos'].") VALUES (".$db['values'].")";
	if ($sql->incluir($db)) {
		echo true;
	} else {
		echo false;}
}

function upDateTrabTurma(){
	$sql = new cmd_SQL ();
	$db ['sql'] = "UPDATE AKONI_TRAB_TURMA SET IDSERIE=".$_POST['Ano'].",NOME_TURMA='".$_POST['NomeTurma']."',QTD_ALUNOS=".$_POST['QtdAlunos']."  WHERE IDTRAB_TURMA = " . $_POST ['IdTrabTuma'];
	if ($sql->alterar($db)) {
		echo true;
	} else {
		echo false;
	}
	
	
}

function upDateTrabEducando(){
	$sql = new cmd_SQL ();
	$db ['sql'] = "UPDATE AKONI_TRAB_EDUCANDO SET NOME='".$_POST['Nome']."' ,DTNASC='".$_POST['DtNasc']."' ,IDRACA=".$_POST['Raca']." ,TIPO_ENSINO=".$_POST['TipoEnsino']." ,SEXO=".$_POST['Sexo']."  WHERE IDTRAB_EDUCANDO = " . $_POST ['IdTrabEducando'];
//	echo $db ['sql'];
	if ($sql->alterar($db)) {
		echo true;
	} else {
		echo false;
	}
}

function gravarTrabTurma(){
	$sql = new cmd_SQL ();
	$db ['tab'] = "AKONI_TRAB_TURMA";
	$db ['campos'] = "IDTRABALHO,IDSERIE,NOME_TURMA,QTD_ALUNOS";
	$db ['values'] = $_POST['IdTrabalho'].",'".$_POST['Ano']."','".$_POST['NomeTurma']."',".$_POST['QtdAlunos'];
//	echo "INSERT INTO ". $db['tab']."(".$db['campos'].") VALUES (".$db['values'].")";
	if ($sql->incluir($db)) {
		echo true;
	} else {
		echo false;}
}

function gravarProf(){

	for ($i=0;$i<count($_POST['txtNomeEducador']); $i++ ){
		if($_POST['hdnIdProf'][$i]!=''){
			upDataProf($i);
		}else{
			$sql = new cmd_SQL ();
			$db ['tab'] = "AKONI_EDUCADOR";
			$db ['campos'] = "IDTRABALHO,NOME,DTNASC,IDRACA,SEXO";
			$db ['values'] = $_POST['IdTrabalho'].",'".$_POST['txtNomeEducador'][$i]."','".$_POST['txtDtNascEducador'][$i]."',".$_POST['cboCorEducador'][$i].",'".$_POST['cboSexoEducador'][$i]."'";
			//echo "INSERT INTO ". $db['tab']."(".$db['campos'].") VALUES (".$db['values'].")";
			if ($sql->incluir($db)) {
				echo true;
			} else {
				echo false;}
		}	
	}
}

function upDataProf($i){
	$sql = new cmd_SQL ();
	$db ['sql'] = "UPDATE AKONI_EDUCADOR SET NOME='".$_POST['txtNomeEducador'][$i]."', DTNASC='".$_POST['txtDtNascEducador'][$i]."', IDRACA=".$_POST['cboCorEducador'][$i].", SEXO=".$_POST['cboSexoEducador'][$i]."  WHERE IDEDUCADOR = " . $_POST['hdnIdProf'][$i];
	echo $db ['sql'];
	if ($sql->alterar($db)) {
		echo true;
	} else {
		echo false;
	}
}

function gravarDescTrab(){
	$sql = new cmd_SQL ();
	$db ['tab'] = "AKONI_DESC_TRABALHO";
	$db ['campos'] = "IDTRABALHO,DATA,OBJETIVO,ACOES,RECURSOS,MATERIAL,SABERES,IMPRESSOES";
	$db ['values'] = $_POST['IdTrabalho'].",'".$_POST['txtDtRealizacao']."','".utf8_decode($_POST['txtObjetivo'])."','".utf8_decode($_POST['txtAcoes'])."','".utf8_decode(str_replace("'","\'",$_POST['txtRecursos']))."','".utf8_decode($_POST['txtMaterial'])."','".utf8_decode($_POST['txtSaberes'])."','".utf8_decode($_POST['txtImpressao'])."'";
//	echo "INSERT INTO ". $db['tab']."(".$db['campos'].") VALUES (".$db['values'].")";exit;
	if ($sql->incluir($db)) {
		true;
	} else {
		echo false;}
}

function upDateDescTrab(){
	$sql = new cmd_SQL ();
	$db ['sql'] = "UPDATE AKONI_DESC_TRABALHO SET 
					DATA='".$_POST['txtDtRealizacao']."', OBJETIVO='".utf8_decode($_POST['txtObjetivo'])."', ACOES='".utf8_decode($_POST['txtAcoes'])."', RECURSOS='".utf8_decode(str_replace("'","''",$_POST['txtRecursos']))."', MATERIAL='".utf8_decode($_POST['txtMaterial'])."', SABERES='".utf8_decode($_POST['txtSaberes'])."', IMPRESSOES='".utf8_decode($_POST['txtImpressao'])."'	
					WHERE IDDESCTRABALHO = " . $_POST ['IdDescTrabalho'];
//	echo $db ['sql'];
	if ($sql->alterar($db)) {
		echo true;
	} else {
		echo false;
	}
}

function vefificaString(){
		
}

function excluirInscricao(){
	    $sql = new cmd_SQL ();
	    $db ['tab'] = "AKONI_INSCRICAO";
	    $db ['cond'] = "IDINSCRICAO = ".$_POST ['IdInscricao'];
	    
	    if ($sql->excluir($db) == 'exclusão efetuada com sucesso') {
	        echo true;
	    } else {
	        echo false;
	    }
	}

	function editarInscricao(){
		$sql = new cmd_SQL();
		$bd['sql'] = "SELECT AI.IDINSCRICAO,AI.CPF,AI.STATUS,AT.IDTRABALHO,AT.IDCATEGORIA,AT.IDPJ,
					AT.IDDEPENDENCIA,AM.IDSERVIDOR_PUBLICO
					FROM AKONI_INSCRICAO AI
					LEFT JOIN AKONI_TRABALHO AT
					ON AT.IDINSCRICAO=AI.IDINSCRICAO
					LEFT JOIN AKONI_MOVA AM
					ON AM.IDTRABALHO=AT.IDTRABALHO
					WHERE AI.IDINSCRICAO = ". $_POST ['IdInscricao'];
		$bd['ret'] = "xml";
//		echo $bd['sql'] ;
		$sql->pesquisar($bd);
	}

	function editar_Trab(){
		$sql = new cmd_SQL();
		$bd['sql'] = "SELECT ATE.*,ATT.IDSERIE,ATT.IDTRAB_TURMA,ATT.NOME_TURMA,ATT.QTD_ALUNOS
						FROM AKONI_TRAB_EDUCANDO ATE
						FULL JOIN  AKONI_TRAB_TURMA ATT
						ON ATT.IDTRABALHO=ATE.IDTRABALHO
						WHERE ATE.IDTRABALHO=". $_POST ['IdTrabalho']." OR ATT.IDTRABALHO=". $_POST ['IdTrabalho'];
		$bd['ret'] = "xml";
		$sql->pesquisar($bd);

	}

		
/*function verificaCPF() {
													$sql = new cmd_SQL();
													$bd['sql'] = "SELECT *
																	FROM AKONI_CANDIDATO
																	WHERE CPF='". $_POST["cpf"] ."' AND STATUS>0";
													$bd['ret'] = "xml";
													$sql->pesquisar($bd);
												}
												
												function verificaCPF_GS() {
													$sql = new cmd_SQL();
													$bd['sql'] = "select * from VW_APP_VERIFICA_SERVIDORES_GS where IDSITUACAO_FUNCIONAL<>3 and CPF='". $_POST["cpf"] ."'";
													$bd['ret'] = "xml";
													$sql->pesquisar($bd);
												}*/

function PesqInscricao() {
	$sql = new cmd_SQL();
	$bd['sql'] = "SELECT AI.IDINSCRICAO,AT.IDPJ,VW.NOME AS ESCOLA,
					AT.IDDEPENDENCIA,
					AC.CATEGORIA,
					ATE.NOME,ATE.TIPO_ENSINO,
					ATT.IDSERIE, ASE.SERIE, ATT.NOME_TURMA,ATT.QTD_ALUNOS,
					AI.STATUS
					FROM AKONI_INSCRICAO AI
					LEFT JOIN AKONI_TRABALHO AT
					ON AT.IDINSCRICAO=AI.IDINSCRICAO
					left JOIN AKONI_TRAB_EDUCANDO ATE
					ON ATE.IDTRABALHO=ATE.IDTRABALHO
					LEFT JOIN AKONI_CATEGORIA AC
					ON AC.IDCATEGORIA=AT.IDCATEGORIA
					LEFT JOIN  VW_APP_CONSULTA_ESCOLAS VW
					ON VW.IDPESSOA_JURIDICA=AT.IDPJ
					FULL JOIN
					AKONI_TRAB_TURMA ATT
					ON ATT.IDTRABALHO=AT.IDTRABALHO
					LEFT JOIN AKONI_SERIE ASE
					ON ASE.IDSERIE=ATT.IDSERIE			
					WHERE AI.CPF='". $_POST["cpf"] ."'
					 ORDER BY AI.IDINSCRICAO";
//	echo $bd['sql'];
	$bd['ret'] = "xml";
	$sql->pesquisar($bd);
}

function PesqInscricaoReceber() {
	$sql = new cmd_SQL();
	$bd['sql'] = "select c.IDCANDIDATO, c.NOME, c.CPF, to_char(DATANASC, 'DD/MM/YYYY') DATANASC, STATUS, JUSTIFICATIVA
					from AKONI_CANDIDATO c
					where c.". $_POST["tipo"] ."='". $_POST["valor"] ."' and STATUS>0";
	$bd['ret'] = "xml";
	$sql->pesquisar($bd);
}

function PesqCandidatoPontos() {
	$sql = new cmd_SQL();
	$bd['sql'] = "select c.IDCANDIDATO, c.NOME, c.CPF, to_char(DATANASC, 'DD/MM/YYYY') DATANASC, STATUS, JUSTIFICATIVA,
						p.IDPONTUACAO, p.DOUTORADO, p.MESTRADO, p.POSGRADUACAO, p.SUPERIOR, p.MAGISTERIO, p.PEDAGOGIA, p.EXPERIENCIA, p.TOTAL
					from AKONI_CANDIDATO c
          			left join AKONI_PONTUACAO p on p.IDCANDIDATO = c.IDCANDIDATO
					where c.". $_POST["tipo"] ."='". $_POST["valor"] ."' and (STATUS=2 or STATUS=4)";
	$bd['ret'] = "xml";
	$sql->pesquisar($bd);
}

function PesqPontuacao() {
	$sql = new cmd_SQL();
	$bd['sql'] = "select * from AKONI_PONTUACAO p where p.IDCANDIDATO='". $_POST["idcandidato"] ."'";
	$bd['ret'] = "xml";
	$sql->pesquisar($bd);
}

function CarregaUltimasNoticias() {
	$sql = new cmd_SQL();
	$bd['sql']="SELECT IDINFORMACAO, TITULO, to_char(DATASISTEMA, 'YYYY-MM-DD HH24:MI:SS') DATASISTEMA, VISIVEL, dbms_lob.substr(CORPO, 10000, 1) as CORPO
					from AKONI_INFORMACOES
					WHERE VISIVEL=1
					ORDER BY DATASISTEMA DESC ";
	$bd['ret']="xml";
	$sql->pesquisar($bd);
}

function CarregaNoticia() {
	$sql = new cmd_SQL();
	$bd['sql']="SELECT IDINFORMACAO, TITULO, VISIVEL, dbms_lob.substr(CORPO, 10000, 1) as CORPO from AKONI_INFORMACOES WHERE IDINFORMACAO = " . $_SESSION["varID"];
	$bd['ret']="xml";
	$sql->pesquisar($bd);
	unset($_SESSION["varID"]);
}

function CarregaCursos() {
	$sql = new cmd_SQL();
	$bd['sql']="select * from AKONI_CURSOS where IDCANDIDATO=".$_POST["txtID"]." order by DTINICIO desc, DTTERMINO desc, DESCRICAO";
	$bd['ret']="xml";
	$sql->pesquisar($bd);
}

function CarregaQtdeCursos() {
	$sql = new cmd_SQL();
	$bd['sql']="select IDCANDIDATO, count(IDCURSO) QTDE from AKONI_CURSOS where IDCANDIDATO=".$_POST["txtID"]." group by IDCANDIDATO";
	$bd['ret']="xml";
	$sql->pesquisar($bd);
}

function PesqTrava(){
	$sql = new cmd_SQL();
	$bd['sql'] = "SELECT * FROM AKONI_TRAVA";
	$bd['ret']="xml";
	$sql->pesquisar($bd);
}

function Login() {
	$sql = new cmd_SQL();
	$bd['sql']="select * from AKONI_USUARIO where STATUS=1 and LOGIN='".$_POST["txtNome"]."' and SENHA='".$_POST["txtSenha"]."'";
	$bd['ret']="xml";
	$sql->pesquisar($bd);
}

function carregaEscolaMunicipal() {
	$sql = new cmd_SQL ();
		
	$db ['sql'] = "SELECT idpessoa_juridica, nome, tipo_dependencia, matricula FROM VW_APP_CONSULTA_ESCOLAS
			where tipo_dependencia='PROPRIA' and
       		matricula=1".
			" ORDER BY nome";
	$db ['ret'] = "xml";
	$rs = $sql->pesquisar ( $db );
}

function carregaEscolaConveniada() {
	$sql = new cmd_SQL ();
		
	$db ['sql'] = "SELECT idpessoa_juridica, nome, tipo_dependencia, matricula FROM VW_APP_CONSULTA_ESCOLAS
			where tipo_dependencia='CONVENIADA' and
       		matricula=1".
			" ORDER BY nome";
	$db ['ret'] = "xml";
	$rs = $sql->pesquisar ( $db );
}

function carregaEscolaMova() {
	$sql = new cmd_SQL ();
		
	$db ['sql'] = "SELECT DISTINCT idpessoa_juridica, escola as nome FROM PREFADM_MOVA.VW_APP_CONSULTA_ALUNOS
					ORDER BY escola";
	$db ['ret'] = "xml";
	$rs = $sql->pesquisar ( $db );
}

function carregaProfMova() {
	$sql = new cmd_SQL ();

	$db ['sql'] = "SELECT DISTINCT IDPESSOA_JURIDICA, IDSERVIDOR_PUBLICO,SERVIDOR ,CPF,DTNASCIMENTO FROM PREFADM_MOVA.VW_APP_VERIFICA_SERVIDORES_GS
			 WHERE IDPESSOA_JURIDICA= ".$_POST['idPessoa_Juridica']." AND ESCOLA IS NOT NULL ORDER BY SERVIDOR";
//	echo $db ['sql'];exit;
	$db ['ret'] = "xml";
	$rs = $sql->pesquisar ( $db );
}

function consultaProfMova() {
	$sql = new cmd_SQL ();
	$db ['sql'] = "SELECT IDPESSOA_JURIDICA, IDTRABALHO FROM AKONI_MOVA
			 WHERE IDTRABALHO= ".$_POST['IdTrabalho'];
//	echo $db ['sql'];
	$db ['ret'] = "xml";
	$rs = $sql->pesquisar ( $db );
}

function carregarProf(){
	$sql = new cmd_SQL();
	$bd['sql'] = " SELECT * FROM AKONI_EDUCADOR	WHERE IDTRABALHO=".$_POST ['IdTrabalho']. "ORDER BY IDEDUCADOR";
	$bd['ret'] = "xml";
	$sql->pesquisar($bd);
	
}

function excluirProf(){
		
	    $sql = new cmd_SQL ();
	    $db ['tab'] = "AKONI_EDUCADOR";
	    $db ['cond'] = "IDEDUCADOR = ".$_POST ['IdProf'];
	    
	    if ($sql->excluir($db) == 'exclusão efetuada com sucesso') {
	        echo true;
	    } else {
	        echo false;
	    }
	}

	
function carregarDescTrabalho(){
	$sql = new cmd_SQL();
	$bd['sql'] = " SELECT * FROM AKONI_DESC_TRABALHO WHERE IDTRABALHO=".$_POST ['IdTrabalho'];
	$bd['ret'] = "xml";
	$sql->pesquisar($bd);
}	

function finalizar(){
	
	$sql = new cmd_SQL ();
	$db ['sql'] = "UPDATE AKONI_INSCRICAO SET STATUS = 1 WHERE IDINSCRICAO = " . $_POST ['IdInscricao'];
//	echo $db ['sql'];
	if ($sql->alterar($db)) {
		echo true;
	} else {
		echo false;
	}
}

	
function entregaTrabalho(){
	$sql = new cmd_SQL ();
	$db ['sql'] = "UPDATE AKONI_INSCRICAO SET STATUS = ". $_POST ['status']." WHERE IDINSCRICAO = " . $_POST ['IdInscricao'];
	//	echo $db ['sql'];
	if ($sql->alterar($db)) {
		echo true;
	} else {
		echo false;}
}

function salvarJustificativa(){
	$sql = new cmd_SQL ();
	$db ['tab'] = "AKONI_JUSTIFICATIVA";
	$db ['campos'] = "IDINSCRICAO,JUSTIFICATIVA";
	$db ['values'] = $_POST['idInscricao'].",'".$_POST['justificativa']."'";
	//echo "INSERT INTO ". $db['tab']."(".$db['campos'].") VALUES (".$db['values'].")";
	if ($sql->incluir($db)) {
		echo dadosUltimaJustificativa();
	} else {
		echo false;}
}	

function upDateJustificativa(){
	$sql = new cmd_SQL ();
	$db ['sql'] = "UPDATE AKONI_JUSTIFICATIVA SET JUSTIFICATIVA= '". $_POST ['justificativa']."' WHERE IDJUSTIFICATIVA = " . $_POST ['idJustificativa'];
	//echo $db ['sql'];
	if ($sql->alterar($db)) {
		echo
			dadosJustificativa($_POST ['idJustificativa']);
	} else {
		echo false;}
}

function excluirJustificativa(){
	$sql = new cmd_SQL ();
	$db ['tab'] = "AKONI_JUSTIFICATIVA";
	$db ['cond'] = "IDINSCRICAO = " . $_POST ['IdInscricao'];
	if ($sql->excluir($db) == 'exclusão efetuada com sucesso') {
		echo true;
	} else {
		echo false;
	}
}

function dadosUltimaJustificativa(){
	$sql = new cmd_SQL();
	$bd['sql'] = "SELECT IDJUSTIFICATIVA, IDINSCRICAO, JUSTIFICATIVA FROM AKONI_JUSTIFICATIVA A
					INNER JOIN (SELECT MAX(IDJUSTIFICATIVA) AS IDJUST
					FROM AKONI_JUSTIFICATIVA) B
					ON A.IDJUSTIFICATIVA=B.IDJUST";
	$bd['ret'] = "xml";
	$sql->pesquisar($bd);
}

function dadosJustificativa($idJustificativa){
	$sql = new cmd_SQL();
	$bd['sql'] = "SELECT IDJUSTIFICATIVA, IDINSCRICAO, JUSTIFICATIVA FROM AKONI_JUSTIFICATIVA 
						WHERE IDJUSTIFICATIVA=".$idJustificativa;
	$bd['ret'] = "xml";
	$sql->pesquisar($bd);
}

//sql 1 --> CONTA INSCRIÇOES DA ESCOLA NAQUELA CATEGORIA PARA VERIFICAR SE ATINGIU O LIMITE DE (5).:	
function qtdInscricaoCategoria(){
	$bd['sql'] ="select count(distinct ai.idinscricao) QTD,at.idpj,AC.IDCATEGORIA from akoni_inscricao ai";
	$bd['sql'].=" LEFT JOIN AKONI_TRABALHO AT ON (AT.IDINSCRICAO=AI.IDINSCRICAO)";
	$bd['sql'].=" LEFT JOIN AKONI_CATEGORIA AC ON (AC.IDCATEGORIA=AT.IDCATEGORIA)";
	$bd['sql'].=" LEFT JOIN (SELECT AT.IDPJ,VM.NOME FROM PREFADM_MOVA.VW_APP_CONSULTA_ESCOLAS VM INNER JOIN AKONI_TRABALHO AT";
	$bd['sql'].=" ON AT.IDPJ=VM.IDPESSOA_JURIDICA)MOVA";
	$bd['sql'].=" ON MOVA.IDPJ=AT.IDPJ";
	$bd['sql'].=" where at.idpj = ".$_POST['txtIdPJ']." and ai.status=1 and at.idcategoria = " .$_POST['txtIdCategoria'];
	$bd['sql'].=" group by at.idpj,AC.IDCATEGORIA";
	$bd['ret'] = "xml";
	$cmdSql = new cmd_SQL ();
	$cmdSql->pesquisar($bd);
}

//sql 2 --> CONTA INSCRIÇOES DO PROFESSOR DA CELULA DO MOVA NAQUELA CATEGORIA PARA VERIFICAR SE ATINGIU O LIMITE DE (5).:	
function qtdInscricaoCategoriaMova(){
	$bd['sql'] ="SELECT count(idservidor_PUBLICO) QTD,gs.idpessoa_juridica from akoni_trabalho at";
	$bd['sql'].=" inner JOIN AKONI_INSCRICAO ai on ai.idinscricao = at.idinscricao";
	$bd['sql'].=" inner JOIN (SELECT DISTINCT idservidor_PUBLICO,idpessoa_juridica FROM PREFADM_MOVA.VW_APP_VERIFICA_SERVIDORES_GS) gs";
	$bd['sql'].=" on at.IDPJ = gs.idpessoa_juridica";
	$bd['sql'].=" where gs.idservidor_PUBLICO IN(".$_POST['txtIdProfessor'].") and ai.status=1 and at.idcategoria = ".$_POST['txtIdCategoria'];//$_POST
	$bd['sql'].=" group by gs.idpessoa_juridica ";
	//echo $bd['sql'];exit;
	$bd['ret'] = "xml";
	$cmdSql = new cmd_SQL ();
	$cmdSql->pesquisar($bd);
}
	
?>