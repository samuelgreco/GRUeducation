$().ready(function(){
	$('#txtCPF').mask('000.000.000-00');
});

function iniciar(){
	varXML = chamar_ajax('../php/sql.php', 'filtro=PesqTrava', false, 'xml', null);
	sit = parseInt(valor_xml(varXML, "SITUACAO", 0));
	
	if(sit==0){
		alert("Situação encerrada!");
		location.href="../index.php";
	}
}

function PesqInscricao(){

	cpf = document.getElementById("txtCPF").value;
	varXML = chamar_ajax('../php/sql.php', 'filtro=PesqInscricao&cpf='+cpf, false, 'xml', null);
	n_reg = valor_xml(varXML, "n_reg", 0);
	
	if(n_reg>0){
		for (var i=0;i<n_reg;i++){
		status = valor_xml(varXML, 'STATUS', i);
		switch(status){
			case '0':desc_status='INSCRIÇÃO NÃO FINALIZADA';break;
			case '1':desc_status='AGUARDANDO ENTREGA DO TRABALHO';break;
			case '2':desc_status='INSCRIÇÃO DEFERIDA';break;
			case '3':desc_status='INSCRIÇÃO INDEFERIDA';break;
			case '4':desc_status='CLASSIFICADO';break;
			default:break;
		}
		texto = "<div id='divInscricao"+i+"'>"+
					"<h4>Dados da Inscricao Nº "+valor_xml(varXML, 'IDINSCRICAO', i)+"</h4>" +
					"<table style='width:100%;' border='0'>" +
						"<tr>" +
							"<td colspan='2'>" +
								"Nome da Escola:<br /><b>"+valor_xml(varXML, 'ESCOLA', i)+"</b>" +
							"</td>" +
							"<td colspan='3'>" +
								"Categoria:<br /><b>"+valor_xml(varXML, 'CATEGORIA', i)+"</b>" +
								"</td>" +
						"</tr>" +
						"<tr>" +
							"<td>" +
								"Ano:<br /><b>"+valor_xml(varXML, 'SERIE', i)+"</b>" +
							"</td>" +
							"<td>" +
								"Turma:<br /><b>"+valor_xml(varXML, 'NOME_TURMA', i)+"</b>" +
							"</td>" +
							"<td>" +
								"Qtd Alunos:<br /><b>"+valor_xml(varXML, 'QTD_ALUNOS', i)+"</b>" +
							"</td>" +
						"</tr>" +
						"<tr>" +
							"<td colspan='3'>" +
								"Situação: <b><font color='red'>"+desc_status+"</font></b>" +
							"</td>" +
						"</tr>" +
					"</table>"+
				"</div><br/><br/>";
		$("#divInscricao").append(texto);
		}
	}else{
		texto="<table><tr><td><img src='../images/error.png' /></td><td style='color: #F22613'>Candidato não encontrado!<br />O CPF informado não está inscrito.</td></tr></table>";
	}
	$('#divInscricao').show();
	$('#divStatus').show();
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