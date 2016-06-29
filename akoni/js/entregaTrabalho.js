$().ready(function(){
});


function entrega(IdInscricao,status){
	dados = 'IdInscricao='+IdInscricao;
	dados += '&status='+status;
	var varXML = chamar_ajax('../php/sql.php','filtro=entregaTrabalho&'+dados, false, 'txt', null);
	if(varXML==1){

		if(status==2){
			$('#btnStatusTrabalho'+IdInscricao+' input').css({"background-color":"#0080FF"});
			$('#btnStatusTrabalho'+IdInscricao+' input').val("Sim");
			$('#btnStatusTrabalho'+IdInscricao+' input').attr("onclick","entrega("+IdInscricao+",1)");
			$('#statusTrabalho'+IdInscricao).text("TRABALHO ENTREGUE (EM ANALISE)");
			
			}else{
				$('#btnStatusTrabalho'+IdInscricao+' input').css({"background-color":"#FF0000"});
				$('#btnStatusTrabalho'+IdInscricao+' input').val("Não");
				$('#btnStatusTrabalho'+IdInscricao+' input').attr("onclick","entrega("+IdInscricao+",2)");
				$('#statusTrabalho'+IdInscricao).text("INSCRIÇÃO ON LINE FINALIZADA");
			}
		}else{alert("falha em alterar");
	}
}



