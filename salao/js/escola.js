$().ready(function() {
	$('#tabela').dataTable({
	    "bProcessing": true,
	    "bJQueryUI": true,
	    "sPaginationType": "full_numbers"
	});
} );

function editar(id){
	var x = chamar_ajax('../php/define.php','filtro=IDPesquisa&varID=' + id, false, 'texto', null);
	window.location.href = "escola.html";
}

function Iniciar(){
	carregaTipoDependencia();
	
	var varXML = chamar_ajax('../php/sql.php', 'filtro=CarregaEscola', false, 'xml', null);

	if (varXML != null) {
		CarregaCampos(varXML);
	}
}

function verificaOnibus(vagas,tipo){
	var id = document.getElementById('txtID').value;
	if (id){
		if(tipo==1){
			var xml = chamar_ajax('../php/sql.php', 'filtro=VerificaOnibus&txtID='+id+'&txtTipo=1', false, 'xml', null);
			var vagasatuais = valor_xml(xml,'qtde',0);
			
			if(vagas<vagasatuais){
				alert("A quantidade de \u00f4nibus digitada \u00e9 menor do que a quantidade de \u00f4nibus que j\u00e1 est\u00e3o inscritos.");
				document.getElementById('txtOnibusDia').value = vagasatuais;
			}
		}else{
			var xml = chamar_ajax('../php/sql.php', 'filtro=VerificaOnibus&txtID='+id+'&txtTipo=2', false, 'xml', null);
			var vagasatuais = valor_xml(xml,'qtde',0);
			
			if(vagas<vagasatuais){
				alert("A quantidade de \u00f4nibus digitada \u00e9 menor do que a quantidade de \u00f4nibus que j\u00e1 est\u00e3o inscritos.");
				document.getElementById('txtOnibusEJA').value = vagasatuais;
			}
		}
	}
}

function escondeOnibus(tipo){
	if(tipo>1){
		document.getElementById('txtOnibusDia').value="";
		document.getElementById('txtOnibusEJA').value="";
		document.getElementById('lblOnibus').style.visibility="hidden";
		document.getElementById('lblOnibus').style.display="none";
		document.getElementById('lblIdentifica').style.visibility="visible";
		document.getElementById('lblIdentifica').style.display="block";
	}else{
		document.getElementById('txtResponsavel').value="";
		document.getElementById('txtTelefone').value="";
		document.getElementById('txtEmail').value="";
		document.getElementById('lblOnibus').style.visibility="visible";
		document.getElementById('lblOnibus').style.display="block";
		document.getElementById('lblIdentifica').style.visibility="hidden";
		document.getElementById('lblIdentifica').style.display="none";
	}
}

function submitForm(){
	var varXML = chamar_ajax('../php/sql.php', 'filtro=CarregaEscolaNome&txtNome='+document.getElementById('txtEscola').value, false, 'xml', null);
	if(valor_xml(varXML,'n_reg', 0)>0&&document.getElementById('txtID').value<0){
		alert("Esta escola j\u00e1 est\u00e1 cadastrada no sistema!");
		document.getElementById('txtEscola').focus();
		return false;
	}
	
	var onibusdia=parseInt(document.getElementById('txtOnibusDia').value);
	var onibuseja=parseInt(document.getElementById('txtOnibusEJA').value);
	if(isNaN(onibusdia)){
		onibusdia = 0;
	}
	if(isNaN(onibuseja)){
		onibuseja = 0;
	}
	
	var dados = "";
	
	dados = "txtEscola=" + document.getElementById('txtEscola').value;
	dados = dados + "&txtResponsavel=" + document.getElementById('txtResponsavel').value;
	dados = dados + "&txtTelefone=" + document.getElementById('txtTelefone').value;
	dados = dados + "&txtEmail=" + document.getElementById('txtEmail').value;
	dados = dados + "&txtOnibusDia=" + onibusdia;
	dados = dados + "&txtOnibusEJA=" + onibuseja;
	dados = dados + "&cboTipo=" + document.getElementById('cboTipo').value;
	dados = dados + "&txtLogin=" + document.getElementById('txtLogin').value;
	dados = dados + "&txtSenha=" + document.getElementById('txtSenha').value;
	dados = dados + "&txtID=" + document.getElementById('txtID').value;
	dados = dados + "&acao=salvar";

	var varResposta = chamar_ajax('../php/cadEscola.php', dados, false, 'txt', null);
	if (varResposta){
		alert ("Salvo com sucesso!");
		window.location.href = "consultaEscola.php";
	}else{
		alert ("Ocorreu um erro. Verifique junto a administração!");
	}
}

function carregaTipoDependencia(){
	var varXML = chamar_ajax('../php/sql.php','filtro=CarregaTipoDependencia', false, 'xml', null);
	carregar_combo(varXML, 'cboTipo', 'descricao', 'idtipo_dependencia' ); 
}

function carregaEscolaCombo(){
	var varXML = chamar_ajax('../php/sql.php','filtro=CarregaEscolaCombo', false, 'xml', null);
	carregar_combo(varXML, 'cboEscola', 'nome', 'idEscola'); 
}

function CarregaCampos(varXML) {
	document.getElementById('txtID').value = valor_xml(varXML,'idEscola', 0);
	document.getElementById('txtEscola').value = valor_xml(varXML, 'nome', 0);
	escondeOnibus(valor_xml(varXML,'idtipo_dependencia', 0));
	document.getElementById('cboTipo').value = valor_xml(varXML,'idtipo_dependencia', 0);
	document.getElementById('txtOnibusDia').value = valor_xml(varXML, 'onibusdia',	0);
	document.getElementById('txtOnibusEJA').value = valor_xml(varXML,'onibuseja', 0);
	document.getElementById('txtResponsavel').value = valor_xml(varXML, 'responsavel', 0);
	document.getElementById('txtTelefone').value = valor_xml(varXML, 'telefone',	0);
	document.getElementById('txtEmail').value = valor_xml(varXML,'email', 0);
	document.getElementById('txtLogin').value = valor_xml(varXML,'login', 0);
	document.getElementById('txtSenha').value = valor_xml(varXML,'senha', 0);
}