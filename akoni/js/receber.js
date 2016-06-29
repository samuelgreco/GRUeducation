$().ready(function(){
	$("#frmAprovacao").validationEngine();

	$("#cmdSalvar").click(function() {
		if ($("#frmAprovacao").validationEngine("validate")) {
			aprovar();
		}
	});
});

function aprovar() {
	var dados = "txtID=" + document.getElementById('txtID').value;
	dados = dados + "&cboAprovacao=" + document.getElementById('cboAprovacao').value;
	dados = dados + "&txtJustificativa=" + document.getElementById('txtJustificativa').value;
	dados = dados + "&acao=aprovacao";

	var varResposta = chamar_ajax('../php/cadInscricao.php', dados, false, 'txt', null);
	if (varResposta == ' true') {
		alert("Salvo com sucesso!");
		location.reload();
	} else {
		alert("Ocorreu um erro. Verifique junto a administração!");
	}
}

function mudaTipo(valor){
	document.getElementById('txtValor').value="";
	if(valor=='CPF'){
		$('#txtValor').mask('000.000.000-00');
	}else{
		$('#txtValor').mask('000000000');
	}
	
	$("#dados").fadeOut(500);
	$("#aprovar").fadeOut(500);
	document.getElementById("dados").innerHTML = "";
}

function PesqInscricaoReceber(){
	bloquear(0);
	$("#justificativa").fadeOut(500);
	$("#aprovar").fadeOut(500);
	document.getElementById('cboAprovacao').value = "";
	document.getElementById('txtJustificativa').value = "";
	document.getElementById('editar').style.display = "none";
	document.getElementById('cmdSalvar').style.display = "block";
	
	$("#dados").fadeOut(500);
	tipo = document.getElementById('cboTipo').value;
	valor = document.getElementById('txtValor').value;
	
	if(valor==""){
		alert("O campo de pesquisa não pode ficar vazio!");
		return false;
	}
	
	
	varXML = chamar_ajax('../php/sql.php', 'filtro=PesqInscricaoReceber&tipo='+tipo+'&valor='+valor, false, 'xml', null);
	n_reg = parseInt(valor_xml(varXML, "n_reg", 0));
	
	if(n_reg==0){
		alert("Nenhum candidato encontrado! Verifique os valores informados!");
		return false;
	}
	
	texto = "<h2 style='padding:0px;font-size:16px;'>Dados do candidato</h2>" +
			"<input type='hidden' id='txtID' name='txtID' value='"+valor_xml(varXML, 'IDCANDIDATO', 0)+"'/>" +
			"<table style='width:700px;'>" +
				"<tr>" +
					"<td>N° da inscrição:<br /><b>"+valor_xml(varXML, 'IDCANDIDATO', 0)+"</b></td>" +
					"<td>Nome:<br /><b>"+valor_xml(varXML, 'NOME', 0)+"</b></td>" +
					"<td>CPF:<br /><b>"+valor_xml(varXML, 'CPF', 0)+"</b></td>" +
					"<td>Data de nascimento:<br /><b>"+valor_xml(varXML, 'DATANASC', 0)+"</b></td>" +
				"</tr>" +
				"<tr><td colspan='4' style='text-align:center;'><a href='../relatorios/ficha.php?id="+valor_xml(varXML, 'IDCANDIDATO', 0)+"' target='_blank' class='Status'>Visualizar ficha completa</a></td></tr>" +
			"</table>";
	
	document.getElementById("dados").innerHTML = texto;
	$("#dados").fadeIn(500);
	$("#aprovar").fadeIn(500);
	
	if(valor_xml(varXML, 'STATUS', 0)>1){
		if(valor_xml(varXML, 'STATUS', 0)==3){
			aprovacao=0;
			justificativa(0);
		}else{
			aprovacao=1;
			justificativa(1);
		}
		document.getElementById('txtJustificativa').value = valor_xml(varXML, 'JUSTIFICATIVA', 0);
		document.getElementById('cboAprovacao').value = aprovacao;
		document.getElementById('editar').style.display = "block";
		document.getElementById('cmdSalvar').style.display = "none";
		bloquear(1);
	}
}

function editar(){
	/*VALIDAR EDITAR APROVAÇÃO PARA QUEM TIVER PONTUAÇÃO DEFINIDA*/
	id = document.getElementById('txtID').value;
	varXML = chamar_ajax('../php/sql.php', 'filtro=PesqPontuacao&idcandidato='+id, false, 'xml', null);
	n_reg = parseInt(valor_xml(varXML, "n_reg", 0));
	
	if(n_reg>0){
		alert("Não é possível editar deferimento de inscrição para candidatos com pontuação atribuída!");
	}else{
		document.getElementById('editar').style.display='none';
		document.getElementById('cmdSalvar').style.display='block';
		bloquear(0);
	}
}

function justificativa(aux) {
	if(aux == '0'){
		$('#justificativa').fadeIn(500);
	}else{
		$('#justificativa').fadeOut(500);
		document.getElementById('txtJustificativa').value = "";
	}
}

function bloquear(flag) {
	if (flag == 1) {
		document.getElementById('cboAprovacao').disabled = "disabled";
		document.getElementById('cboAprovacao').readonly = true;
		document.getElementById('txtJustificativa').disabled = "disabled";
		document.getElementById('txtJustificativa').readonly = true;
	} else {
		document.getElementById('cboAprovacao').disabled = false;
		document.getElementById('cboAprovacao').readonly = false;
		document.getElementById('txtJustificativa').disabled = false;
		document.getElementById('txtJustificativa').readonly = false;
	}
}

function ValidaCPF(cpf){
	//Verifica se o CPF informado é válido
	x = testaCPF(cpf.replace(/\.|\-/g,""));
	if(x){
		return true;
	}else{
		alert("O CPF informado é inválido!");
		return false;
	}
}

function Enter(event) {
    if(event.keyCode==13){
    	PesqCandidato();
    	return false;
    }
}