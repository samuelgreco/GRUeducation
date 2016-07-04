function iniciar(){
	var id = chamar_ajax('../php/define.php', 'filtro=GetLogin', false, 'texto', null);
	var xml = chamar_ajax('../php/sql.php', 'filtro=CarregaEscolaID&txtID='+id, false, 'xml', null);
	var tipo = chamar_ajax('../php/define.php', 'filtro=GetTipo', false, 'texto', null);

	document.getElementById('txtID').value = id;
	document.getElementById('txtTipo').value = tipo;
	document.getElementById('lblUsuario').innerHTML = valor_xml(xml,'nome', 0);
	
	if(tipo>1){
		document.getElementById('divParticular').style.visibility="visible";
		document.getElementById('divParticular').style.display="block";
	}else{
		document.getElementById('divParticular').style.visibility="hidden";
		document.getElementById('divParticular').style.display="none";
	}
}

function submitForm() {
	var id = document.getElementById('txtID').value;
	var xml = chamar_ajax('../php/sql.php', 'filtro=CarregaEscolaID&txtID='+id, false, 'xml', null);
	var senha_reg = valor_xml(xml,'senha', 0);
	document.getElementById('lblUsuario').innerHTML = valor_xml(xml,'nome', 0);
	
	atual = document.getElementById('txtSenhaAtual').value;
	nova = document.getElementById('txtNovaSenha').value;
	repete = document.getElementById('txtRepeteSenha').value;

	if(senha_reg!=atual){
		alert('Senha atual incorreta!');
		document.getElementById('txtSenhaAtual').focus();
		return false;
	}
	if(senha_reg==nova){
		alert('Nova senha precisa ser diferente de senha atual!');
		document.getElementById('txtSenhaAtual').focus();
		return false;
	}
	if(nova!=repete){
		alert('Nova senha n\u00e3o corresponde \u00e0 senha digitada novamente!');
		document.getElementById('txtNovaSenha').focus();
		return false;
	}
	if(document.getElementById('txtTipo').value>1){
		if(document.getElementById('txtResponsavel').value==""){
			alert('Respons\u00e1vel n\u00e3o pode ficar em branco!');
			document.getElementById('txtResponsavel').focus();
			return false;
		}
		if(document.getElementById('txtTelefone').value==""){
			alert('Telefone n\u00e3o pode ficar em branco!');
			document.getElementById('txtTelefone').focus();
			return false;
		}
		if(document.getElementById('txtEmail').value==""){
			alert('Email n\u00e3o pode ficar em branco!');
			document.getElementById('txtEmail').focus();
			return false;
		}
	}
	//ValidaÁ„o OK - Inserindo no banco
	var dados = "";
	
	dados = "txtSenha=" + document.getElementById('txtNovaSenha').value;
	dados = dados + "&txtID=" + document.getElementById('txtID').value;
	if(document.getElementById('txtTipo').value>1){
		dados = dados + "&txtResponsavel=" + document.getElementById('txtResponsavel').value;
		dados = dados + "&txtTelefone=" + document.getElementById('txtTelefone').value;
		dados = dados + "&txtEmail=" + document.getElementById('txtEmail').value;
		dados = dados + "&acao=alterardados";
		var pagina = '../dataHoraEst.php';
	}else{
		dados = dados + "&acao=alterarsenha";
		var pagina = '../modulo.html';
	}
	
	var varResposta = chamar_ajax('../php/cadEscola.php', dados, false, 'txt', null);
	if (varResposta){
		alert ("Dados alterados com sucesso!");
		window.location.href = pagina;
	}else{
		alert ("Ocorreu um erro. Verifique junto a administra√ß√£o!");
		window.location.href = "../index.html";
	}
}