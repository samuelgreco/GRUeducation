$().ready(function(){
	if ($("#lst").length){
		$("#lst").dataTable( {
	        "bJQueryUI" : true,
	        "sPaginationType" : "full_numbers",
	        "iDisplayLength": 10
		});
	}
	
	if($("#frmArquivo").length){
		$("#frmArquivo").validationEngine();
		
		$("#cmdSalvar").click(function() {
			if ($("#frmArquivo").validationEngine("validate")) {
				x = Validate(frmArquivo);
				if(x){
					document.frmArquivo.submit();
				}
			}
		});
	}
});

var _validFileExtensions = [".pdf"]; 

function Validate(oForm) {
    var arrInputs = oForm.getElementsByTagName("input");
    for (var i = 0; i < arrInputs.length; i++) {
        var oInput = arrInputs[i];
        if (oInput.type == "file") {
            var sFileName = oInput.value;
            if (sFileName.length > 0) {
                var blnValid = false;
                for (var j = 0; j < _validFileExtensions.length; j++) {
                    var sCurExtension = _validFileExtensions[j];
                    if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                        blnValid = true;
                        break;
                    }
                }
                
                if (!blnValid) {
                    alert("O arquivo " + sFileName + " é inválido, as extenções aceitas são: " + _validFileExtensions.join(", "));
                    return false;
                }
            }
        }
    }
  
    return true;
}

function iniciar(){
	varXML = chamar_ajax('../php/sql.php', 'filtro=PesqTrava', false, 'xml', null);
	pub = parseInt(valor_xml(varXML, "PUBLICACAO", 0));
	
	if(pub==0){
		alert("Publicações travadas!");
		location.href="../index.php";
	}
}

function novo(){
	window.location.href = "arquivos.html";
}

function ativarVisibilidade(id) {
	var varXML = chamar_ajax('../php/cadVisibilidade.php', 'tipo=arquivo&acao=visivel&valor=1&id='+ id, false, 'txt', null);
	if(varXML == 1){
		document.getElementById('tdVisivel' + id).innerHTML = "<center><img src='../../lib/images/icones/valid-24.png' onclick='desativarVisibilidade(" + id + ")' style='cursor: pointer;' ></center>";
	}else{
		alert('Ocorreu um erro. Entre em contato com a administra��o!');
	}
}

function desativarVisibilidade(id) {
	
	var varXML = chamar_ajax('../php/cadVisibilidade.php', 'tipo=arquivo&acao=visivel&valor=0&id='+ id, false, 'txt', null);
	if(varXML == 1){
		document.getElementById('tdVisivel' + id).innerHTML = "<center><img src='../../lib/images/icones/delete-24.png' onclick='ativarVisibilidade(" + id + ")' style='cursor: pointer;' ></center>";
	}else{
		alert('Ocorreu um erro. Entre em contato com a administra��o!');
	}
}

function excluir(id) {
	
	var varXML = chamar_ajax('../php/cadVisibilidade.php', 'tipo=arquivo&acao=excluir&id='+ id, false, 'txt', null);
	if(varXML == 1){
		location.reload();
	}else{
		alert('Ocorreu um erro. Entre em contato com a administra��o!');
	}
}