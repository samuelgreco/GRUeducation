function destravar(acao){
	var dados = "";
	var conteudoCelula = "";
	var campo = "";
	
	switch (acao) {
		case 'inscricao':
			campo = "inscricao=1";
			break;
		case 'situacao':
			campo = "situacao=1";
			break;
		case 'publicacao':
			campo = "publicacao=1";
			break;
		default:
			break;
	}
	
	dados ="campo=" + campo;
	dados += "&acao=" + acao;
	
	var varResposta = chamar_ajax('../php/cadTrava.php', dados, false, 'txt', null);
	if (varResposta == 1){
		conteudoCelula = "<center><img width='32' src='../../lib/images/icones/aberto.png' title='Destravada' style='cursor: pointer;' onclick='travar(\""+acao+"\")'></center>";
		document.getElementById(acao).innerHTML = conteudoCelula;
	}else{
		alert ("Ocorreu um erro. Verifique junto a administração!");
	}
}

function travar(acao){
	var dados = "";
	var conteudoCelula = "";
	
	switch (acao) {
		case 'inscricao':
			campo = "inscricao=0";
			break;
		case 'situacao':
			campo = "situacao=0";
			break;
		case 'publicacao':
			campo = "publicacao=0";
			break;
		default:
			break;
	}

	dados ="campo=" + campo;
	dados += "&acao=" + acao;
	
	var varResposta = chamar_ajax('../php/cadTrava.php', dados, false, 'txt', null);
	if (varResposta == 1){
		conteudoCelula = "<center><img width='32' src='../../lib/images/icones/fechado.png' style='cursor: pointer;' title='Travada' onclick='destravar(\""+acao+"\")'></center>";
		document.getElementById(acao).innerHTML = conteudoCelula;
	}else{
		alert ("Ocorreu um erro. Verifique junto a administração!");
	}
}