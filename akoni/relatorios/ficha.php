<?php
require_once('../../lib/php/cmd_sql.php');
require('../../lib/mpdf-master/mpdf.php');

$mpdf=new mPDF('utf-8', 'A4', 0, 'Arial', 11, 11, 11, 18, 5, 5);

$mpdf->WriteHTML($stylesheet,1);

$id = $_GET["idInscricao"];

$html="";
	
$varConsulta = ConsultaFicha($id);

$varContEducador = count($varConsulta);


$numeroInscricao = vazio(utf8_encode($varConsulta[0]['IDINSCRICAO']));
$nomeEscola = vazio(utf8_encode($varConsulta[0]['ESCOLA']));
$telefoneEscola = vazio(utf8_encode($varConsulta[0]['TELEFONE']));
$emailEscola = vazio(utf8_encode($varConsulta[0]['EMAIL']));
$nomeEducando = vazio(utf8_encode($varConsulta[0]['EDUCANDO']));
$nascEducando = vazio(utf8_encode($varConsulta[0]['DTNASC_EDUCANDO']));
$idadeEducando = vazio(utf8_encode($varConsulta[0]['IDADE']));
$sexoEducando = vazio(utf8_encode($varConsulta[0]['IDSEXO_EDUCANDO']));
$racaEducando = vazio(utf8_encode($varConsulta[0]['IDRACA_EDUCANDO']));
$anoTuma = vazio(utf8_encode($varConsulta[0]['SERIE']));
$nomeTurma = vazio(utf8_encode($varConsulta[0]['NOME_TURMA']));
$qtdTurma = vazio(utf8_encode($varConsulta[0]['QTD_ALUNOS']));
$categoriaTrab = vazio(utf8_encode($varConsulta[0]['IDCATEGORIA']));
$nomeCategoriaTrab = vazio(utf8_encode($varConsulta[0]['CATEGORIA']));

$cursandoEducando = vazio(utf8_encode($varConsulta[0]['IDTIPO_ENSINO']));

$nomeEducador = vazio(utf8_encode($varConsulta[0]['EDUCADOR']));
$sexoEducador = vazio(utf8_encode($varConsulta[0]['IDSEXO_EDUCADOR']));
$nascEducador = vazio(utf8_encode($varConsulta[0]['DTNASC_EDUCADOR']));
$racaEducador = vazio(utf8_encode($varConsulta[0]['IDRACA_EDUCADOR']));


$dtrealizacao = vazio(utf8_encode($varConsulta[0]['DATA']));
$objetivo = vazio(utf8_encode($varConsulta[0]['OBJETIVO']));
$acao = vazio(utf8_encode($varConsulta[0]['ACOES']));
$recursos = vazio(utf8_encode($varConsulta[0]['RECURSOS']));
$material = vazio(utf8_encode($varConsulta[0]['MATERIAL']));
$saberes = vazio(utf8_encode($varConsulta[0]['SABERES']));
$impressoes = vazio(utf8_encode($varConsulta[0]['IMPRESSOES']));









/********************* ETAPA I- IDENTIFICAÇÃO DO EDUCANDO/TURMA *********************/
$html .= '<p align="center"><strong>FICHA  DE </strong><strong>INSCRI&Ccedil;&Atilde;O/ 2016</strong></p>

<p align="center"><strong>5&ordm; Pr&ecirc;mio  AKONI de Promo&ccedil;&atilde;o da Igualdade Racial</strong></p>

<p align="center"><strong>Inscrição Nº '.$numeroInscricao.'</strong></p>		
<p>&nbsp;</p>
<p><strong>ESCOLA/  ENTIDADE CONVENIADA DE EDUCA&Ccedil;&Atilde;O INFANTIL/ ENTIDADE DO MOVIMENTO DE  ALFABETIZA&Ccedil;&Atilde;O (MOVA):</strong></p>
<p>'.$nomeEscola.'</p>
<p>Telefone:'.$telefoneEscola.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;E-mail '.$emailEscola.'</p>'.

($categoriaTrab==1?
			'<p><strong>I)  IDENTIFICA&Ccedil;&Atilde;O DA TURMA<a href="#_ftn1" name="_ftnref1" title="" id="_ftnref1"> </a></strong></p>
			<p>Serie/Ano: '.$anoTuma.'&nbsp;&nbsp;  Turma:&nbsp; '.$nomeTurma.'&nbsp;&nbsp;&nbsp; Quantidade de Alunos: '.$qtdTurma.' </p>'
			:		
			'<p><strong>I)  IDENTIFICA&Ccedil;&Atilde;O DO(A) EDUCANDO(A)<a href="#_ftn1" name="_ftnref1" title="" id="_ftnref1"> </a></strong></p>
			<p>Nome: '.$nomeEducando.'</p>
			<p>Data de Nascimento: '.$nascEducando.'&nbsp;&nbsp;  Idade:&nbsp; '.$idadeEducando.'&nbsp;&nbsp;&nbsp; Sexo: ('.($sexoEducando==0?'X':' ').') Masculino&nbsp;&nbsp; &nbsp;( '.($sexoEducando==1?'X':' ').') Feminino&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;</p>
			<p><strong>Como  o(a) educando(a) se autodeclara;</strong>, considerando as categorias do  Instituto Brasileiro de Geografia e Estat&iacute;stica (IBGE), quanto &agrave; cor/ ra&ccedil;a/ etnia,  como segue:&nbsp; <br />
			  ('.($racaEducando==1?'X':' ').') branca ('.($racaEducando==2?'X':' ').') preta ('.($racaEducando==3?'X':' ').') parda ('.($racaEducando==4?'X':' ').') amarela ('.($racaEducando==5?'X':' ').') ind&iacute;gena</p>').

  		
'<p><strong>Categoria  de Inscri&ccedil;&atilde;o: </strong><br />
  ('.($categoriaTrab==1?'X':' ').') V&iacute;deo &ndash; de 0 (zero) &nbsp;&nbsp;a 04  anos e 11 meses de idade<br />
  ('.($categoriaTrab==2?'X':' ').') Desenho &ndash; de 05 anos  a 07 anos e 11 meses de idade<br />
  ('.($categoriaTrab==3?'X':' ').') Hist&oacute;ria em Quadrinhos  &ndash; de 08 anos a 14 anos e 11 meses de &nbsp;idade<br />
  ('.($categoriaTrab==4?'X':' ').') Slogan &nbsp;&ndash; acima de 15 anos de idade.</p>'.

  		
($categoriaTrab==1?"":'  		
<p>Cursando: ('.($cursandoEducando==1?'X':' ').') Educa&ccedil;&atilde;o  Infantil&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;('.($cursandoEducando==2?'X':' ').')  Ensino Fundamental&nbsp; <br />
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ('.($cursandoEducando==3?'X':' ').') Educa&ccedil;&atilde;o de Jovens e Adultos&nbsp;&nbsp; &nbsp;&nbsp;('.($cursandoEducando==4?'X':' ').')  MOVA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>');


/********************* ETAPA II- IDENTIFICAÇÃO DO(A)(S) EDUCADOR(ES)(AS) *********************/

$varContEducador = count($varConsulta);

for($i=0;$i<$varContEducador;$i++){
$html .= '<p><strong> IDENTIFICA&Ccedil;&Atilde;O DO(A) EDUCADOR(A) '.($i+1).'</strong></p>
<p>Nome:  '.vazio(utf8_encode($varConsulta[$i]['EDUCADOR'])).'</p>
<p>Sexo: ('.(vazio(utf8_encode($varConsulta[$i]['IDSEXO_EDUCADOR']))==0?'X':' ').') Masculino ('.(vazio(utf8_encode($varConsulta[$i]['IDSEXO_EDUCADOR']))==1?'X':' ').') Feminino&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Data de Nascimento: '.vazio(utf8_encode($varConsulta[$i]['DTNASC_EDUCADOR'])).'</p>
<p><strong>Como o(a)  educador(a) se autodeclara</strong>, considerando as categorias do Instituto  Brasileiro de Geografia e Estat&iacute;stica (IBGE), quanto &agrave; cor/ ra&ccedil;a/ etnia, como  segue:&nbsp; <br />
('.(vazio(utf8_encode($varConsulta[$i]['IDRACA_EDUCADOR']))==1?'X':' ').') branca ('.(vazio(utf8_encode($varConsulta[$i]['IDRACA_EDUCADOR']))==2?'X':' ').') preta ('.(vazio(utf8_encode($varConsulta[$i]['IDRACA_EDUCADOR']))==3?'X':' ').') parda ('.(vazio(utf8_encode($varConsulta[$i]['IDRACA_EDUCADOR']))==4?'X':' ').') amarela ('.(vazio(utf8_encode($varConsulta[$i]['IDRACA_EDUCADOR']))==5?'X':' ').') ind&iacute;gena</p>';
};

$html .= '<pagebreak />';




/************************** ETAPA III DESCRICAO DO TRABALHO **************************/
$html .= '<p><strong>III)  DESCRI&Ccedil;&Atilde;O DO TRABALHO</strong><br />
    <strong>Relatar  a proposta desenvolvida com os(as) educandos(as)&nbsp; preenchendo os seguintes itens :</strong></p>
<p><b>Data/  per&iacute;odo de realiza&ccedil;&atilde;o: </b>'.$dtrealizacao.'</p>
<p align="justify"><b>Objetivos: </b>'.nl2br($objetivo).'</p>
<p align="justify"><b>A&ccedil;&otilde;es  desenvolvidas (teatro, dan&ccedil;a, roda de conversa, pesquisa, etc): </b>'.nl2br($acao).'</p>
<p align="justify"><b>Recursos  (livros, v&iacute;deos, m&uacute;sicas, etc): </b>'.nl2br($recursos).'</p>
<p align="justify"><b>Material  consultado (Refer&ecirc;ncias Bibliogr&aacute;ficas ): </b>'.nl2br($material).'</p>
<p align="justify"><b>Saberes  constru&iacute;dos com os(as) educandos(as ): </b>'.nl2br($saberes).'</p>
<p align="justify"><b>Impress&otilde;es  sobre o desenvolvimento com a possibilidade de &nbsp;incluir breve relatos dos(as) educandos(as) que  revelem o processo: </b>'.nl2br($impressoes).'</p>
<p>&nbsp;</p>';

$html .= '<pagebreak />';	





/************************** AUTORIZAÇÃO DO USO DE IMAGEM **************************/
($cursandoEducando==1||$cursandoEducando==2||$idadeEducando<21?
						$html .=
						'<div style="text-align:center;border:1px solid #000;width:80%;margin-left:auto;margin-right:auto;padding:20px;">
							<p align="center"><strong>AUTORIZA&Ccedil;&Atilde;O  E USO DE IMAGEM DO EVENTO DE PREMIA&Ccedil;&Atilde;O</strong><br />
						<strong></strong></p>
						<p>&nbsp;</p>
						<p align="justify">Eu,_____________________________________________________________________	,  portador(a) do documento de identidade n&ordm; _________________________________, respons&aacute;vel pelo(a)  educando(a) '.($categoriaTrab==1?'_____________________________________________________':'<b>'.$nomeEducando.'</b>').' autorizo a utiliza&ccedil;&atilde;o da  imagem deste(a) para divulga&ccedil;&atilde;o do 5&ordm; Pr&ecirc;mio   AKONI de Promo&ccedil;&atilde;o da Igualdade Racial e o uso dessa imagem pela Secretaria Municipal de Educa&ccedil;&atilde;o de Guarulhos sem  fins lucrativos. </p>
						<p align="right">Sem mais, firmo o presente.</p>
						<p>&nbsp;</p>
						<p align="right">Guarulhos, _______,____________ de 2016.</p>
						<p align="right">__________________________________________<br />
						<p align="right">Assinatura</p>
						</div>'
						:
						$html .=
						'<div style="text-align:center;border:1px solid #000;width:80%;margin-left:auto;margin-right:auto;padding:20px;">
							<p align="center"><strong>AUTORIZA&Ccedil;&Atilde;O  E USO DE IMAGEM DO EVENTO DE PREMIA&Ccedil;&Atilde;O</strong><br />
						<strong>Educandos(as)  da Educa&ccedil;&atilde;o de jovens e Edultos e MOVA</strong></p>
						<p>&nbsp;</p>
						<p align="justify">Eu,_____________________________________________________________________	,  portador(a) do documento de identidade n&ordm; _________________________________, autorizo a utiliza&ccedil;&atilde;o da minha imagem para divulga&ccedil;&atilde;o do 5&ordm; Pr&ecirc;mio   AKONI de Promo&ccedil;&atilde;o da Igualdade Racial e o uso dessa imagem pela Secretaria Municipal de Educa&ccedil;&atilde;o de Guarulhos sem  fins lucrativos. </p>
						<p align="right">Sem mais, firmo o presente.</p>
						<p>&nbsp;</p>
						<p align="right">Guarulhos, _______,____________ de 2016.</p>
						<p align="right">__________________________________________<br />
						<p align="right">Assinatura</p>
						</div>');
						
($categoriaTrab==1?$html .='<p>Se o trabalho for da categoria VIDEO a AUTORIZAÇÃO DE USO DE IMAGEM deverá ser preenchida para todos os educandos envolvidos.</p>':$nomeEducando);
$html .= '<pagebreak />';


/************************** PROTOCOLO DE RECEBIMENTO **************************/


$html .='<div style="text-align:center;border:1px solid #000;width:80%;margin-left:auto;margin-right:auto;padding:20px;">
				<p align="center">Protocolo  de Inscri&ccedil;&atilde;o do Akoni/ 2016</p>
				<p align="center"><b>CATEGORIA: '.$nomeCategoriaTrab.'</b></p>
<p>Escola/ Entidade  Conveniada De Educa&ccedil;&atilde;o Infantil/ Entidade do Movimento de Alfabetiza&ccedil;&atilde;o  (Mova) <br /><b>'.$nomeEscola.'</b></p>'.


($categoriaTrab==1?
		'<p>Identifica&ccedil;&atilde;o da Turma: '.$anoTuma.'-'.$nomeTurma.'&nbsp;&nbsp;&nbsp;Quantidade de Alunos: '.$qtdTurma.'</p>'
		:
		'<p>Identifica&ccedil;&atilde;o do(a) Educando(a): '.$nomeEducando.'</p>').

		'<p>Data ___/___/_______  Hor&aacute;rio____:____N&uacute;mero da Inscricao: '.$numeroInscricao.'</p>
<p>Entregue por:_________________________________________________________________</p>
<p>Recebido por:_________________________________________________________________</p>
			</div>
		';


$html .='<br/><div style="text-align:center;border:1px solid #000;width:80%;margin-left:auto;margin-right:auto;padding:20px;">
				<p align="center">Protocolo  de Inscri&ccedil;&atilde;o do Akoni/ 2016</p>
				<p align="center"><b>CATEGORIA: '.$nomeCategoriaTrab.'</b></p>
<p>Escola/ Entidade  Conveniada De Educa&ccedil;&atilde;o Infantil/ Entidade do Movimento de Alfabetiza&ccedil;&atilde;o  (Mova) <br /><b>'.$nomeEscola.'</b></p>'.


($categoriaTrab==1?
		'<p>Identifica&ccedil;&atilde;o da Turma: '.$anoTuma.'-'.$nomeTurma.'&nbsp;&nbsp;&nbsp;Quantidade de Alunos: '.$qtdTurma.'</p>'
		:
		'<p>Identifica&ccedil;&atilde;o do(a) Educando(a): '.$nomeEducando.'</p>').

		'<p>Data ___/___/_______  Hor&aacute;rio____:____N&uacute;mero da Inscricao: '.$numeroInscricao.'</p>
<p>Entregue por:_________________________________________________________________</p>
<p>Recebido por:_________________________________________________________________</p>
			</div>
		';


$html .='<p>Obs.: O trabalho inscrito  dever&aacute; ser entregue entre os dias 19 a 23 de setembro/2016 na Central de  Atendimento da Secretaria de Educa&ccedil;&atilde;o &ndash; Rua Claudino Barbosa, 313 &ndash; T&eacute;rreo - das  8h &agrave;s 18h</p>';


//$html = utf8_encode($html);
$mpdf->WriteHTML($html);

//Imprime o rodap�
/* $footer = utf8_encode($footer);
$mpdf->SetHTMLFooter($footer); */

$mpdf->Output('fichas.pdf', I);

function vazio($texto){
	if($texto==null){
		return "----------------";
	}else{
		return $texto;
	}
}


function ConsultaFicha($id) {
	$sql = new cmd_SQL();
	$bd[sql] = "SELECT DISTINCT AI.IDINSCRICAO,AT.IDTRABALHO,
				CASE WHEN AT.IDDEPENDENCIA=3 THEN MOVA.NOME 
				WHEN AT.IDDEPENDENCIA IN (1,2) THEN REDE.NOME END ESCOLA,
				CASE WHEN AT.IDDEPENDENCIA=3 THEN MOVA.TEL 
				WHEN AT.IDDEPENDENCIA IN (1,2) THEN REDE.TEL END TELEFONE,
				CASE WHEN AT.IDDEPENDENCIA=3 THEN MOVA.EMAIL 
				WHEN AT.IDDEPENDENCIA IN (1,2) THEN REDE.EMAIL END EMAIL,
				ATE.NOME AS EDUCANDO,TO_CHAR(ATE.DTNASC,'DD/MM/YYYY') AS DTNASC_EDUCANDO,
				TRUNC((MONTHS_BETWEEN(SYSDATE,TO_CHAR(ATE.DTNASC,'dd/mm/yy')))/12) AS IDADE,
				ATE.SEXO AS SEXO_EDUCANDO,
				ATE.IDRACA AS IDRACA_EDUCANDO,AT.IDCATEGORIA, AC.CATEGORIA,
				ATE.TIPO_ENSINO AS IDTIPO_ENSINO,
				ASE.SERIE,ATT.NOME_TURMA,ATT.QTD_ALUNOS,
				(CASE WHEN AT.IDCATEGORIA=1 THEN AED.NOME ELSE AE.NOME END) AS EDUCADOR,
				(CASE WHEN AT.IDCATEGORIA=1 THEN AED.SEXO ELSE AE.SEXO END) AS IDSEXO_EDUCADOR,
				(CASE WHEN AT.IDCATEGORIA=1 THEN TO_CHAR(AED.DTNASC,'DD/MM/YYYY') ELSE TO_CHAR(AE.DTNASC,'DD/MM/YYYY') END) AS DTNASC_EDUCADOR,
				(CASE WHEN AT.IDCATEGORIA=1 THEN AED.IDRACA ELSE AE.IDRACA END) AS IDRACA_EDUCADOR,
				ADT.DATA,
				ADT.OBJETIVO,ADT.ACOES,ADT.RECURSOS,
				ADT.MATERIAL,ADT.SABERES,ADT.IMPRESSOES
				FROM AKONI_INSCRICAO AI
				LEFT JOIN AKONI_TRABALHO AT
				ON AT.IDINSCRICAO=AI.IDINSCRICAO
				LEFT JOIN AKONI_TRAB_EDUCANDO ATE
				ON ATE.IDTRABALHO=AT.IDTRABALHO
				LEFT JOIN AKONI_RACA AR
				ON AR.IDRACA=ATE.IDRACA
				LEFT JOIN AKONI_EDUCADOR AE
				ON AE.IDTRABALHO=AT.IDTRABALHO
				AND AE.IDRACA=AR.IDRACA
				LEFT JOIN AKONI_CATEGORIA AC
				ON AC.IDCATEGORIA=AT.IDCATEGORIA
				LEFT JOIN AKONI_DESC_TRABALHO ADT
				ON ADT.IDTRABALHO=AT.IDTRABALHO
				LEFT JOIN (SELECT AT.IDPJ,VW.NOME,VW.TEL,VW.EMAIL FROM VW_APP_CONSULTA_ESCOLAS VW INNER JOIN AKONI_TRABALHO AT 
				ON AT.IDPJ=VW.IDPESSOA_JURIDICA WHERE AT.IDDEPENDENCIA IN (1,2))REDE
				ON AT.IDPJ=REDE.IDPJ
				LEFT JOIN (SELECT AT.IDPJ,VM.NOME,VM.TEL,VM.EMAIL FROM PREFADM_MOVA.VW_APP_CONSULTA_ESCOLAS VM INNER JOIN AKONI_TRABALHO AT
				ON AT.IDPJ=VM.IDPESSOA_JURIDICA WHERE AT.IDDEPENDENCIA=3)MOVA
				ON MOVA.IDPJ=AT.IDPJ
				FULL JOIN
				AKONI_TRAB_TURMA ATT
				ON ATT.IDTRABALHO=AT.IDTRABALHO
				LEFT JOIN (SELECT AE.IDTRABALHO,NOME,sexo,DTNASC,IDRACA FROM AKONI_EDUCADOR AE LEFT JOIN AKONI_TRABALHO AT
				ON AT.IDTRABALHO=AE.IDTRABALHO WHERE IDCATEGORIA=1) AED
				ON AED.IDTRABALHO=ATT.IDTRABALHO
				LEFT JOIN AKONI_SERIE ASE
				ON ASE.IDSERIE=ATT.IDSERIE
				WHERE AI.IDINSCRICAO=".$id;
	$bd[ret] = "php";
	$rs = $sql->pesquisar($bd);
	return $rs;

}
?>