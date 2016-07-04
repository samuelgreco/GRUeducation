$().ready(function() {
	if($("#cadastro").length > 0){
		$("#cadastro").dialog({
			autoOpen: false,
			width: 550,
			height: 450,
			modal: true
		});
	}
	
	/*$("#imgHostname").click(function(){
		$("#hostname").dialog("open");
	});*/
});

function editarInscricao() {
	idinscricao = $("#txtIDInscricao").val();
	idhorario = $("#txtIDHorario").val();
	onibus = $("#txtOnibus").val();
	tipo = $("#txtTipo").val();
	//alert("TIPO: "+tipo+" - IDHORARIO: "+idhorario+" - IDINSCRICAO: "+idinscricao);
	
	var vagasatuais = parseInt(document.getElementById("txtTotalAnt").value);
	var vagas = parseInt(document.getElementById("txtTotal").value);//N�mero de vagas atualizado
	
	//alert("VAGAS DIGITADO: "+vagas+" - VAGAS HIDDEN: "+vagasatuais);
	if(vagas==""){
		alert("Campo de quantidade de vagas n\u00e3o pode ficar em branco!");
		document.getElementById("txtEstagioI").focus();
		return false;
	}
	if(vagas > 45){
		alert("Quantidade de vagas do ônibus foi excedida!");
		document.getElementById("txtEstagioI").focus();
		return false;
	}
	if(tipo<2){
		if(vagas < vagasatuais){
			alert("A quantidade de vagas deve ser maior que o inscrito anteriormente!");
			document.getElementById("txtEstagioI").focus();
			return false;
		}
	}
	
	var dados = "";
	dados = "idinscricao=" + idinscricao;
	dados = dados + "&vagas=" + vagas;
	dados = dados + "&tipo=" + tipo;
	dados = dados + "&estagio1=" + $("#txtEstagioI").val();
	dados = dados + "&estagio2=" + $("#txtEstagioII").val();
	dados = dados + "&ano1=" + $("#txtAno1").val();
	dados = dados + "&ano2=" + $("#txtAno2").val();
	dados = dados + "&ano3=" + $("#txtAno3").val();
	dados = dados + "&ano4=" + $("#txtAno4").val();
	dados = dados + "&ano5=" + $("#txtAno5").val();
	dados = dados + "&acao=editar";

	var varResposta = chamar_ajax('php/cadInscricao.php', dados, false, 'txt', null);
	if (varResposta){
		alert ("Salvo com sucesso!");
		location.reload();
	}else{
		alert ("Ocorreu um erro. Verifique junto a administração!");
	}
}

function editarInscricaoEst(idhorario,idinscricao){
	//alert("TIPO: "+tipo+" - IDHORARIO: "+idhorario+" - IDINSCRICAO: "+idinscricao);
	
	var vagasatuais = parseInt(document.getElementById("txtVagasAtuais"+idhorario).value);
	var vagas = parseInt(document.getElementById("txtVagas"+idhorario).value);//N�mero de vagas atualizado
	var xml = chamar_ajax('php/sql.php', 'filtro=VerificaVagas&txtID='+idhorario, false, 'xml', null);
	var qtde = parseInt(valor_xml(xml,'vagas', 0));
	var disponivel = parseInt(valor_xml(xml,'disponivel', 0));
	var diferenca = vagas - vagasatuais;
	
	//alert("DISPONIVEL: "+disponivel+" - QTDE: "+qtde+" - VAGAS: "+vagas+" - DIFEREN�A: "+diferenca);
	if(vagas==""||isNaN(vagas)){
		alert("Campo de quantidade de vagas n\u00e3o pode ficar em branco!");
		document.getElementById("txtVagas"+idhorario).focus();
		return false;
	}
	
	if(diferenca>0){
		if(diferenca > disponivel){
			if(disponivel){
				alert("Quantidade de vagas para o hor\u00e1rio excedidas!\nQuantidade de vagas ainda dispon\u00edveis: "+disponivel);
			}else{
				alert("Vagas encerradas!");
			}
			document.getElementById("txtVagas"+idhorario).value=vagasatuais;
			document.getElementById("txtVagas"+idhorario).focus();
			return false;
		}
	}
	
	var dados = "";
	dados = "idinscricao=" + idinscricao;
	dados = dados + "&vagas=" + vagas;
	dados = dados + "&acao=editar";

	var varResposta = chamar_ajax('php/cadInscricao.php', dados, false, 'txt', null);
	if (varResposta){
		alert ("Salvo com sucesso!");
		location.reload();
	}else{
		alert ("Ocorreu um erro. Verifique junto a administração!");
	}
}

function editarInscricaoEja(tipo,idhorario,idinscricao){
	//alert("TIPO: "+tipo+" - IDHORARIO: "+idhorario+" - IDINSCRICAO: "+idinscricao);
	
	var vagasatuais = parseInt(document.getElementById("txtVagasAtuais"+idhorario).value);
	var vagas = parseInt(document.getElementById("txtVagas"+idhorario).value);//N�mero de vagas atualizado
	
	//alert("VAGAS DIGITADO: "+vagas+" - VAGAS HIDDEN: "+vagasatuais);
	if(vagas==""){
		alert("Campo de quantidade de vagas n\u00e3o pode ficar em branco!");
		document.getElementById("txtVagas"+idhorario).focus();
		return false;
	}
	if(vagas > 45){
		alert("Quantidade de vagas do ônibus foi excedida!");
		document.getElementById("txtVagas"+idhorario).focus();
		return false;
	}
	if(tipo<2){
		if(vagas < vagasatuais){
			alert("A quantidade de vagas deve ser maior que o inscrito anteriormente!");
			document.getElementById("txtVagas"+idhorario).focus();
			return false;
		}
	}
	
	var dados = "";
	dados = "idinscricao=" + idinscricao;
	dados = dados + "&vagas=" + vagas;
	dados = dados + "&acao=editar";

	var varResposta = chamar_ajax('php/cadInscricao.php', dados, false, 'txt', null);
	if (varResposta){
		alert ("Salvo com sucesso!");
		location.reload();
	}else{
		alert ("Ocorreu um erro. Verifique junto a administração!");
	}
}

function inscrever(id) {
	$("#txtIDHorario").val(id);
	$("#txtEstagioI").val(0);
	$("#txtEstagioII").val(0);
	$("#txtAno1").val(0);
	$("#txtAno2").val(0);
	$("#txtAno3").val(0);
	$("#txtAno4").val(0);
	$("#txtAno5").val(0);
	$("#txtTotal").val(0);
	$("#cadastro").dialog("open");
}

function inscreverEst(id) {
	document.getElementById('imgInscrever'+id).style.visibility="hidden";
	document.getElementById('imgInscrever'+id).style.display="none";
	
	document.getElementById('escondido'+id).style.visibility="visible";
	document.getElementById('escondido'+id).style.display="block";
}

function editar(idhorario, idinscricao) {
	var varXML = chamar_ajax('php/sql.php','filtro=VerificaInscricao&idinscricao='+idinscricao, false, 'xml', null);
	$("#txtEstagioI").val(valor_xml(varXML, 'estagio_1', 0));
	$("#txtEstagioII").val(valor_xml(varXML, 'estagio_2', 0));
	$("#txtAno1").val(valor_xml(varXML, 'ano_1', 0));
	$("#txtAno2").val(valor_xml(varXML, 'ano_2', 0));
	$("#txtAno3").val(valor_xml(varXML, 'ano_3', 0));
	$("#txtAno4").val(valor_xml(varXML, 'ano_4', 0));
	$("#txtAno5").val(valor_xml(varXML, 'ano_5', 0));
	$("#txtTotal").val(valor_xml(varXML, 'vagas', 0));
	$("#txtTotalAnt").val(valor_xml(varXML, 'vagas', 0));
	
	$("#txtIDInscricao").val(idinscricao);
	$("#txtIDHorario").val(idhorario);
	$("#cadastro").dialog("open");
}

function cancelar() {
	$("#txtEstagioI").val(0);
	$("#txtEstagioII").val(0);
	$("#txtAno1").val(0);
	$("#txtAno2").val(0);
	$("#txtAno3").val(0);
	$("#txtAno4").val(0);
	$("#txtAno5").val(0);
	$("#txtTotal").val(0);
	$("#cadastro").dialog("close");
}

function contar(){
	estagio1 = parseInt($("#txtEstagioI").val());
	estagio2 = parseInt($("#txtEstagioII").val());
	ano1 = parseInt($("#txtAno1").val());
	ano2 = parseInt($("#txtAno2").val());
	ano3 = parseInt($("#txtAno3").val());
	ano4 = parseInt($("#txtAno4").val());
	ano5 = parseInt($("#txtAno5").val());
	
	total = estagio1+estagio2+ano1+ano2+ano3+ano4+ano5;
	document.getElementById("txtTotal").value = total;
	
	if (total>45){
		alert("Quantidade de vagas totais do ônibus foi excedida!")
	}
}

function salvar() {
	if($("#txtIDInscricao").val()>0) {
		editarInscricao();
	} else {
		salvarInscricao();
	}
}

function salvarInscricao(){
	idhorario = $("#txtIDHorario").val();
	onibus = $("#txtOnibus").val();
	tipo = $("#txtTipo").val();
	//alert("HORARIO: "+idhorario+" - ONIBUS: "+onibus+" - TIPO ONIBUS: "+tipo);
	
	var xml = chamar_ajax('php/sql.php', 'filtro=VerificaVagasOnibus&txtID='+idhorario, false, 'xml', null);
	var qtde = parseInt(valor_xml(xml,'vagas', 0));
	var disponivel = parseInt(valor_xml(xml,'disponivel', 0));
	
	if(disponivel==0){
		alert("Hor\u00e1rio encerrado!\nEscolha um novo hor\u00e1rio.");
		location.reload();
		return false;
	}
	
	var vagas = parseInt(document.getElementById("txtTotal").value);//N�mero de vagas atualizado
	//alert(vagas);
	
	if(vagas==0){
		alert("A quantidade total de vagas n\u00e3o pode ser zero!");
		document.getElementById("txtEstagioI").focus();
		return false;
	}
	if(vagas==""||isNaN(vagas)){
		alert("A quantidade total de vagas n\u00e3o pode ficar em branco!");
		document.getElementById("txtEstagioI").focus();
		return false;
	}
	if(vagas > 45){
		alert("Quantidade de vagas totais do ônibus foi excedida!");
		document.getElementById("txtEstagioI").focus();
		return false;
	}
	
	resposta = confirm("Voc\u00ea deseja se inscrever neste dia e hor\u00e1rio?\nA a\u00e7\u00e3o n\u00e3o poder\u00e1 ser desfeita.");
	if (resposta){
		var dados = "";
		dados = "idhorario=" + idhorario;
		dados = dados + "&onibus=" + onibus;
		dados = dados + "&tipo=" + tipo;
		dados = dados + "&vagas=" + vagas;
		dados = dados + "&estagio1=" + $("#txtEstagioI").val();
		dados = dados + "&estagio2=" + $("#txtEstagioII").val();
		dados = dados + "&ano1=" + $("#txtAno1").val();
		dados = dados + "&ano2=" + $("#txtAno2").val();
		dados = dados + "&ano3=" + $("#txtAno3").val();
		dados = dados + "&ano4=" + $("#txtAno4").val();
		dados = dados + "&ano5=" + $("#txtAno5").val();
		dados = dados + "&acao=salvar";

		//alert(dados);
		var varResposta = chamar_ajax('php/cadInscricao.php', dados, false, 'txt', null);
		if (varResposta){
			alert ("Salvo com sucesso!");
			location.href='inicial.php';
		}else{
			alert ("Ocorreu um erro. Verifique junto a administração!");
		}
	}else{
		//location.reload();
	}
}

function salvarInscricaoEst(idhorario,onibus,tipo){
	//alert("ONIBUS: "+onibus+" - TIPO ONIBUS: "+tipo);
	
	var vagas = document.getElementById("txtVagas"+idhorario).value;//N�mero de vagas atualizado
	var xml = chamar_ajax('php/sql.php', 'filtro=VerificaVagas&txtID='+idhorario, false, 'xml', null);
	var qtde = parseInt(valor_xml(xml,'vagas', 0));
	var disponivel = parseInt(valor_xml(xml,'disponivel', 0));
	
	//alert("DISPONIVEL: "+disponivel+" - QTDE: "+qtde+" - VAGAS: "+vagas);
	if(vagas==""||isNaN(vagas)){
		alert("Campo de quantidade de vagas n\u00e3o pode ficar em branco!");
		document.getElementById("txtVagas"+idhorario).focus();
		return false;
	}
	if(vagas > disponivel){
		alert("Quantidade de vagas para o hor\u00e1rio excedidas!\nQuantidade de vagas ainda dispon\u00edveis: "+disponivel);
		document.getElementById("txtVagas"+idhorario).value="";
		document.getElementById("txtVagas"+idhorario).focus();
		return false;
	}
	
	resposta = confirm("Voc\u00ea deseja se inscrever neste dia e hor\u00e1rio?");
	if (resposta){
		var dados = "";
		dados = "idhorario=" + idhorario;
		dados = dados + "&onibus=0";
		dados = dados + "&tipo=3";
		dados = dados + "&vagas=" + vagas;
		dados = dados + "&acao=salvar";

		var varResposta = chamar_ajax('php/cadInscricao.php', dados, false, 'txt', null);
		if (varResposta){
			alert ("Salvo com sucesso!");
			location.reload();
		}else{
			alert ("Ocorreu um erro. Verifique junto a administração!");
		}
	}else{
		location.reload();
	}
}

function salvarInscricaoEja(idhorario,onibus,tipo){
	//alert("ONIBUS: "+onibus+" - TIPO ONIBUS: "+tipo);
	
	var xml = chamar_ajax('php/sql.php', 'filtro=VerificaVagasOnibus&txtID='+idhorario, false, 'xml', null);
	var qtde = parseInt(valor_xml(xml,'vagas', 0));
	var disponivel = parseInt(valor_xml(xml,'disponivel', 0));
	
	if(disponivel==0){
		alert("Hor\u00e1rio encerrado!\nEscolha um novo hor\u00e1rio.");
		location.reload();
		return false;
	}
	
	var vagas = parseInt(document.getElementById("txtVagas"+idhorario).value);//N�mero de vagas atualizado
	
	if(vagas==""||isNaN(vagas)){
		alert("Campo de quantidade de vagas n\u00e3o pode ficar em branco!");
		document.getElementById("txtVagas"+idhorario).focus();
		return false;
	}
	if(vagas > 45){
		alert("Quantidade de vagas do ônibus foi excedida!");
		document.getElementById("txtVagas"+idhorario).focus();
		return false;
	}
	
	resposta = confirm("Voc\u00ea deseja se inscrever neste dia e hor\u00e1rio?\nA a\u00e7\u00e3o n\u00e3o poder\u00e1 ser desfeita.");
	if (resposta){
		var dados = "";
		dados = "idhorario=" + idhorario;
		dados = dados + "&onibus=" + onibus;
		dados = dados + "&tipo=" + tipo;
		dados = dados + "&vagas=" + vagas;
		dados = dados + "&acao=salvar";

		var varResposta = chamar_ajax('php/cadInscricao.php', dados, false, 'txt', null);
		if (varResposta){
			alert ("Salvo com sucesso!");
			location.href='inicial.php';
		}else{
			alert ("Ocorreu um erro. Verifique junto a administração!");
		}
	}else{
		location.reload();
	}
}

function excluirInscricao(id){
	//alert(id);
	
	resposta = confirm("Voc\u00ea deseja excluir esta inscri\u00e7\u00e3o?\nA a\u00e7\u00e3o n\u00e3o poder\u00e1 ser desfeita.");
	if (resposta){
		var dados = "";
		dados = "idinscricao=" + id;
		dados = dados + "&acao=excluir";

		var varResposta = chamar_ajax('../php/cadInscricao.php', dados, false, 'txt', null);
		if (varResposta){
			alert ("Removido com sucesso!");
			mostraInscricao();
		}else{
			alert ("Ocorreu um erro. Verifique junto a administração!");
		}
	}else{
		return false;
	}
}

function carregaEscolaCombo(){
	var varXML = chamar_ajax('../php/sql.php','filtro=CarregaEscolaCombo', false, 'xml', null);
	carregar_combo(varXML, 'cboEscola', 'nome', 'idEscola'); 
}

function mostraInscricao(){
	$('#lblEscolaInscricao').fadeOut();
	var varXML = chamar_ajax('../php/sql.php','filtro=CarregaInscricao&cboEscola='+document.getElementById('cboEscola').value, false, 'xml', null);
	var n_reg = valor_xml(varXML,'n_reg',0);
	
	if(n_reg>0){
		var tipodep = valor_xml(varXML, 'idtipo_dependencia', 0);
		if(tipodep==1){
			tabela = "<center><table class='tabela' id='tabela'>" +
			"<tr><td>Data</td><td>Hora</td><td># &Ocirc;nibus</td><td>N&uacute;mero de<br/>Alunos no &Ocirc;nibus</td><td>Tipo</td><td>Remover</td></tr>";			
		}else{
			tabela = "<center><table class='tabela' id='tabela'>" +
			"<tr><td>Data</td><td>Hora</td><td>N&uacute;mero de<br/>Alunos Inscritos</td><td>Remover</td></tr>";	
		}
		var i=0; var data=""; var hora=""; var vagas=""; var id="";
		for(i=0;i<n_reg;i++){
			data = valor_xml(varXML, 'data', i);
			hora = valor_xml(varXML, 'horaInicio', i);
			vagas = valor_xml(varXML, 'vagas', i);
			var tipo="";var onibus="";
			if(tipodep==1){
				onibus = "<td>" + valor_xml(varXML, 'onibus', i) + "</td>";
				tipo = valor_xml(varXML, 'tipo', i);
				if(tipo=='1'){
					tipo = "<td>Educa&ccedil;&atilde;o Infantil/Fudamental</td>";
				}else{
					tipo = "<td>Educa&ccedil;&atilde;o EJA/MOVA</td>";
				}
			}
			
			id = valor_xml(varXML, 'idinscricao', i);
			tabela += "<tr><td>"+data+"</td><td>"+hora+"</td>"+onibus+"<td>"+vagas+"</td>"+tipo+"<td width='100'><a onclick='excluirInscricao("+id+")'><img src='../../lib/images/icones/excluir-24.png'></a></td></tr>";
		}
		tabela += "</table><br /></center>";
		
		document.getElementById('lblEscolaInscricao').innerHTML = tabela;
	}else{
		document.getElementById('lblEscolaInscricao').innerHTML = "<center>N&atilde;o h&aacute; dados a serem mostrados.</center>";
	}
	$('#lblEscolaInscricao').fadeIn();
}