$().ready(function() {
	if ($("#lst").length){
		$("#lst").dataTable( {
	        "bJQueryUI" : true,
	        "sPaginationType" : "full_numbers",
	        "iDisplayLength": 10
		});
	}
	
	if ($("#frmCadNoticias").length){
		$("#frmCadNoticias").validationEngine();
		
		$("#cmdSalvarNoticias").click(function(){
			if($("#frmCadNoticias").validationEngine("validate")){
				nicEditors.findEditor('txtTexto').saveContent();
				document.getElementById('txtTexto').value = encodeHTML(document.getElementById('txtTexto').value);
				document.frmCadNoticias.submit();
			}
		});
	}
} );

function iniciar(){
	var varXML = chamar_ajax('../php/sql.php', 'filtro=CarregaNoticia', false, 'xml', null);
	
	if (valor_xml(varXML,'n_reg', 0) > 0) {
		CarregaCampos(varXML);
	}
	
	nicEditors.allTextAreas();
}

function editar(id){
	var x = chamar_ajax('../php/define.php','filtro=IDPesquisa&varID=' + id, false, 'texto', null);
	window.location.href = "noticias.html";
}

function novo(){
	window.location.href = "noticias.html";
}
 
function CarregaCampos(varXML) {
	document.getElementById('txtID').value = valor_xml(varXML,'IDINFORMACAO', 0);
	document.getElementById('txtTitulo').value = valor_xml(varXML,'TITULO', 0);
	document.getElementById('txtTexto').value = decodeHTML(valor_xml(varXML,'CORPO', 0));
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

function ativarVisibilidade(id) {
	
	var varXML = chamar_ajax('../php/cadVisibilidade.php', 'tipo=noticia&acao=visivel&valor=1&id='+ id, false, 'txt', null);
	if(varXML == 1){
		document.getElementById('tdVisivel' + id).innerHTML = "<center><img src='../../lib/images/icones/valid-24.png' onclick='desativarVisibilidade(" + id + ")' style='cursor: pointer;' ></center>";
	}else{
		alert('Ocorreu um erro. Entre em contato com a administra��o!');
	}
}

function desativarVisibilidade(id) {
	
	var varXML = chamar_ajax('../php/cadVisibilidade.php', 'tipo=noticia&acao=visivel&valor=0&id='+ id, false, 'txt', null);
	if(varXML == 1){
		document.getElementById('tdVisivel' + id).innerHTML = "<center><img src='../../lib/images/icones/delete-24.png' onclick='ativarVisibilidade(" + id + ")' style='cursor: pointer;' ></center>";
	}else{
		alert('Ocorreu um erro. Entre em contato com a administra��o!');
	}
}