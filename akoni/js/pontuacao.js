$().ready(function(){
	$("#frmPontuacao").validationEngine();

	$("#cmdSalvar").click(function() {
		if ($("#frmPontuacao").validationEngine("validate")) {
			salvar();
		}
	});
});

function menos(id){
	valor = parseInt(document.getElementById("lblQtde"+id).value);
	
	if(valor==0){
		alert("Não é possível diminuir a quantidade. Quantidade não pode ser menor que 0 (zero)!");
		return false;
	}
	
	valor--;
	document.getElementById("lblQtde"+id).value = valor;
	
	pontos(id);
}

function mais(id){
	valor = parseInt(document.getElementById("lblQtde"+id).value);
	
	valor++;
	document.getElementById("lblQtde"+id).value = valor;
	
	pontos(id);
}

function pontos(id){
	valor = parseInt(document.getElementById("lblQtde"+id).value);
	
	switch(id){
		case 'Doutor':
			if(valor==0){
				document.getElementById("txt"+id).value = 0;
			}else if(valor>0){
				document.getElementById("txt"+id).value = 35;
			}
			break;
		case 'Mestre':
			if(valor==0){
				document.getElementById("txt"+id).value = 0;
			}else if(valor>0){
				document.getElementById("txt"+id).value = 25;
			}
			break;
		case 'Pos':
			if(valor==0){
				document.getElementById("txt"+id).value = 0;
			}else if(valor==1){
				document.getElementById("txt"+id).value = 5;
			} if(valor>1){
				document.getElementById("txt"+id).value = 10;
			}
			break;
		case 'Superior':
			if(valor==0){
				document.getElementById("txt"+id).value = 0;
			}else if(valor>0){
				document.getElementById("txt"+id).value = 10;
			}
			break;
		case 'Magisterio':
			if(valor==0){
				document.getElementById("txt"+id).value = 0;
			}else if(valor>0){
				document.getElementById("txt"+id).value = 5;
			}
			break;
		case 'Pedagogia':
			if(valor==0){
				document.getElementById("txt"+id).value = 0;
			}else if(valor>0){
				document.getElementById("txt"+id).value = 5;
			}
			break;
		case 'Docente':
			if(valor==0){
				document.getElementById("txt"+id).value = 0;
			}else if(valor==1){
				document.getElementById("txt"+id).value = 5;
			} if(valor>1){
				document.getElementById("txt"+id).value = 10;
			}
			break;
		default:break;
	}
	
	contar();
}

function contar(){
	doutor = parseInt(document.getElementById("txtDoutor").value);
	mestre = parseInt(document.getElementById("txtMestre").value);
	pos = parseInt(document.getElementById("txtPos").value);
	superior = parseInt(document.getElementById("txtSuperior").value);
	magisterio = parseInt(document.getElementById("txtMagisterio").value);
	pedagogia = parseInt(document.getElementById("txtPedagogia").value);
	docente = parseInt(document.getElementById("txtDocente").value);
	
	total = doutor+mestre+pos+superior+magisterio+pedagogia+docente;
	document.getElementById("txtTotal").value = total;
}

function zerar(){
	document.getElementById("lblQtdeDoutor").value=0;
	document.getElementById("txtDoutor").value=0;
	document.getElementById("lblQtdeMestre").value=0;
	document.getElementById("txtMestre").value=0;
	document.getElementById("lblQtdePos").value=0;
	document.getElementById("txtPos").value=0;
	document.getElementById("lblQtdeSuperior").value=0;
	document.getElementById("txtSuperior").value=0;
	document.getElementById("lblQtdeMagisterio").value=0;
	document.getElementById("txtMagisterio").value=0;
	document.getElementById("lblQtdePedagogia").value=0;
	document.getElementById("txtPedagogia").value=0;
	document.getElementById("lblQtdeDocente").value=0;
	document.getElementById("txtDocente").value=0;
	
	contar();
}

function PesqCandidato(){
	$("#pontos").fadeOut(500);
	$("#dados").fadeOut(500);
	document.getElementById('txtID').value = "";
	document.getElementById('txtIDPontuacao').value = "";
	zerar();
	
	tipo = document.getElementById('cboTipo').value;
	valor = document.getElementById('txtValor').value;
	
	if(valor==""){
		alert("O campo de pesquisa não pode ficar vazio!");
		return false;
	}
	
	if(tipo=="CPF"){
		x = ValidaCPF(valor);
		if(!x){
			return false;
		}
	}
	
	varXML = chamar_ajax('../php/sql.php', 'filtro=PesqCandidatoPontos&tipo='+tipo+'&valor='+valor, false, 'xml', null);
	n_reg = parseInt(valor_xml(varXML, "n_reg", 0));
	
	if(n_reg==0){
		alert("Nenhum candidato encontrado! Verifique os valores informados e se o candidato teve a inscrição deferida!");
		return false;
	}
	
	document.getElementById('txtID').value = valor_xml(varXML, 'IDCANDIDATO', 0);
	document.getElementById('txtIDPontuacao').value = valor_xml(varXML, 'IDPONTUACAO', 0);
	texto = "<h2 style='padding:0px;font-size:16px;'>Dados do candidato</h2>" +
			"<table style='width:700px;'>" +
				"<tr>" +
					"<td>N° da inscrição:<br /><b>"+valor_xml(varXML, 'IDCANDIDATO', 0)+"</b></td>" +
					"<td>Nome:<br /><b>"+valor_xml(varXML, 'NOME', 0)+"</b></td>" +
					"<td>CPF:<br /><b>"+valor_xml(varXML, 'CPF', 0)+"</b></td>" +
					"<td>Data de nascimento:<br /><b>"+valor_xml(varXML, 'DATANASC', 0)+"</b></td>" +
				"</tr>" +
			"</table>";
	
	if(valor_xml(varXML, 'IDPONTUACAO', 0)!=""){
		document.getElementById('lblQtdeDoutor').value = valor_xml(varXML, 'DOUTORADO', 0);
		pontos('Doutor');
		document.getElementById('lblQtdeMestre').value = valor_xml(varXML, 'MESTRADO', 0);
		pontos('Mestre');
		document.getElementById('lblQtdePos').value = valor_xml(varXML, 'POSGRADUACAO', 0);
		pontos('Pos');
		document.getElementById('lblQtdeSuperior').value = valor_xml(varXML, 'SUPERIOR', 0);
		pontos('Superior');
		document.getElementById('lblQtdeMagisterio').value = valor_xml(varXML, 'MAGISTERIO', 0);
		pontos('Magisterio');
		document.getElementById('lblQtdePedagogia').value = valor_xml(varXML, 'PEDAGOGIA', 0);
		pontos('Pedagogia');
		document.getElementById('lblQtdeDocente').value = valor_xml(varXML, 'EXPERIENCIA', 0);
		pontos('Docente');
	}
	
	document.getElementById("dados").innerHTML = texto;
	$("#dados").fadeIn(500);
	$("#pontos").fadeIn(500);
}

function salvar(){
	var dados = "txtID=" + document.getElementById('txtID').value;
	dados = dados + "&txtIDPontuacao=" + document.getElementById('txtIDPontuacao').value;
	dados = dados + "&lblQtdeDoutor=" + document.getElementById('lblQtdeDoutor').value;
	dados = dados + "&lblQtdeMestre=" + document.getElementById('lblQtdeMestre').value;
	dados = dados + "&lblQtdePos=" + document.getElementById('lblQtdePos').value;
	dados = dados + "&lblQtdeSuperior=" + document.getElementById('lblQtdeSuperior').value;
	dados = dados + "&lblQtdeMagisterio=" + document.getElementById('lblQtdeMagisterio').value;
	dados = dados + "&lblQtdePedagogia=" + document.getElementById('lblQtdePedagogia').value;
	dados = dados + "&lblQtdeDocente=" + document.getElementById('lblQtdeDocente').value;
	dados = dados + "&txtTotal=" + document.getElementById('txtTotal').value;
	dados = dados + "&acao=pontuacao";
	
	var varResposta = parseInt(chamar_ajax('../php/cadInscricao.php', dados, false, 'txt', null));
	//alert(varResposta);
	if (varResposta>0) {
		alert("Salvo com sucesso!");
		location.reload();
	} else {
		alert("Ocorreu um erro. Verifique junto a administração!");
	}
}

/*function aprovar() {
	var dados = "txtID=" + document.getElementById('txtID').value;
	dados = dados + "&cboAprovacao=" + document.getElementById('cboAprovacao').value;
	dados = dados + "&txtJustificativa=" + document.getElementById('txtJustificativa').value;
	dados = dados + "&acao=aprovacao";

	var varResposta = chamar_ajax('../php/cadInscricao.php', dados, false, 'txt', null);
	if (varResposta == 'true') {
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

function PesqCandidato(){
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
	
	if(tipo=="CPF"){
		x = ValidaCPF(valor);
		if(!x){
			return false;
		}
	}
	
	varXML = chamar_ajax('../php/sql.php', 'filtro=PesqCandidatoAprovar&tipo='+tipo+'&valor='+valor, false, 'xml', null);
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
	VALIDAR EDITAR APROVAÇÃO PARA QUEM TIVER PONTUAÇÃO DEFINIDA
	
	document.getElementById('editar').style.display='none';
	document.getElementById('cmdSalvar').style.display='block';
	bloquear(0);
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
}*/

function mudaTipo(valor){
	document.getElementById('txtValor').value="";
	if(valor=='CPF'){
		$('#txtValor').mask('000.000.000-00');
	}else{
		$('#txtValor').mask('000000000');
	}
	
	$("#dados").fadeOut(500);
	$("#pontos").fadeOut(500);
	document.getElementById("dados").innerHTML = "";
	document.getElementById("txtID").innerHTML = "";
	document.getElementById("txtIDPontuacao").innerHTML = "";
	zerar();
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