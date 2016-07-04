$().ready(function() {
	$('#tabela').dataTable({
	    "bProcessing": true,
	    "bJQueryUI": true,
	    "sPaginationType": "full_numbers"
	});
} );

function editar(id){
	var x = chamar_ajax('../php/define.php','filtro=IDPesquisa&varID=' + id, false, 'texto', null);
	window.location.href = "horario.html";
}

function Iniciar() {
	varXML = chamar_ajax('../php/sql.php', 'filtro=CarregaHorario', false,	'xml', null);
	
	if (varXML != null) {
		CarregaCampos(varXML);
	}
}

function descreveVaga(tipo){
	if(tipo>1){
		document.getElementById('lblVagas').innerHTML=" (N&uacute;mero de alunos)";
	}else{
		document.getElementById('lblVagas').innerHTML=" (N&uacute;mero de &ocirc;nibus)";
	}
}

function submitForm(){
	var dados = "";
	
	dados = "cboTipo=" + document.getElementById('cboTipo').value;
	dados = dados + "&txtVagas=" + document.getElementById('txtVagas').value;
	dados = dados + "&txtData=" + document.getElementById('txtData').value;
	dados = dados + "&cboHoraInicio=" + document.getElementById('cboHoraInicio').value;
	dados = dados + "&cboHoraFim=" + document.getElementById('cboHoraFim').value;
	dados = dados + "&txtID=" + document.getElementById('txtID').value;
	dados = dados + "&acao=salvar";

	var varResposta = chamar_ajax('../php/cadHorario.php', dados, false, 'txt', null);
	if (varResposta){
		alert ("Salvo com sucesso!");
		window.location.href = "consultaHorario.php";
	}else{
		alert ("Ocorreu um erro. Verifique junto a administração!");
	}
}


function Numero(e)
{
  navegador = /msie/i.test(navigator.userAgent);
  if (navegador)
   var tecla = event.keyCode;
  else
   var tecla = e.which;
  
  if(tecla > 47 && tecla < 58) // numeros de 0 a 9
    return true;
  else
    {
      if (tecla <= 8) // backspace
        return true;
      else
        return false;
    }
}

function CarregaCampos(varXML) {
	document.getElementById('txtID').value = valor_xml(varXML, 'idHorario', 0);
	descreveVaga(valor_xml(varXML, 'idtipo_dependencia', 0));
	document.getElementById('cboTipo').value = valor_xml(varXML, 'idtipo_dependencia', 0);
	document.getElementById('txtVagas').value = valor_xml(varXML, 'vagas', 0);
	document.getElementById('txtData').value = valor_xml(varXML, 'data', 0);
	document.getElementById('cboHoraInicio').value = valor_xml(varXML, 'horaInicio', 0);
	document.getElementById('cboHoraFim').value = valor_xml(varXML, 'horaFim', 0);
}