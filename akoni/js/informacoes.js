function iniciar() {
	chamar_ajax('php/define.php', 'filtro=DestroiSessao', true, null, null);
	
	//verificaAcesso();
	
	CarregaUltimasNoticias();
}

function CarregaUltimasNoticias(){
	var varXML = chamar_ajax('php/sql.php', 'filtro=CarregaUltimasNoticias', false, 'xml', null);
	var n_reg = valor_xml(varXML,'n_reg', 0);
	
	if (n_reg > 0){
		conteudo="";
		
		for(i=0; i < n_reg; i++){
			conteudo += "<div class='noticia'>";
			conteudo += "<label class='publicado'>" + valor_xml(varXML,'DATASISTEMA', i) + "</label>";
			conteudo += "<h4>" + valor_xml(varXML,'TITULO', i) + "</h4>";
			conteudo += decodeHTML(valor_xml(varXML,'CORPO', i));
			conteudo += "</div>";
		}
		
		document.getElementById('lstNoticias').innerHTML = conteudo;
		conteudo += "<br />";
	}else{
		document.getElementById('lstNoticias').innerHTML = "<center><i>Não há informações a serem exibidas.</i></center>";
	}
}

function encodeHTML(texto){
	return texto.replace(/&/g, '&amp;')
			    .replace(/</g, '&lt;')
			    .replace(/>/g, '&gt;')
			    .replace(/"/g, '&quot;')
			    .replace(/'/g, '&apos;');
}

function decodeHTML(texto){
	return texto.replace(/&apos;/g, "'")
			    .replace(/&quot;/g, '"')
			    .replace(/&gt;/g, '>')
			    .replace(/&lt;/g, '<')
			    .replace(/&amp;/g, '&');
}