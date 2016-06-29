$().ready(function(){
	$("#divJustificativa").hide();	


});





function entrega(IdInscricao,status){
		if(status==3){
			dados = 'IdInscricao='+IdInscricao;
			dados += '&status='+status;
			var varXML = chamar_ajax('../php/sql.php','filtro=entregaTrabalho&'+dados, false, 'txt', null);
			
			excluirJustificativa(IdInscricao);
			$('#btnSim'+IdInscricao).css({"background-color":"#0080FF"});
			$('#btnNao'+IdInscricao).css({"background-color":"#BDBDBD"});
			$('#btnSim'+IdInscricao).attr("onclick","");
			$('#btnNao'+IdInscricao).attr("onclick","entrega("+IdInscricao+",4)");
			$('#statusTrabalho'+IdInscricao).text("DEFERIDO");
		}else{
				justificativaTrabalho('',IdInscricao,'',status);
		}
}

		


function excluirJustificativa(IdInscricao){
	dados = 'IdInscricao='+IdInscricao;
	var varXML = chamar_ajax('../php/sql.php','filtro=excluirJustificativa&'+dados, false, 'txt', null);
}





function imprimirInscricao(idInscricao){
	window.open('../relatorios/ficha.php?idInscricao='+idInscricao);
}




function justificativaTrabalho(idJustificativa,idInscricao,justificativa,status) {

	if(idJustificativa!=''){
		$('#hdnIdJustificativa').val(idJustificativa);
		$('#hdnIdInscricao').val(idInscricao);
		$('#txtJustificativa').val(justificativa);
	
	}else{
		//alert('trabalho não possui justificativa')
		$('#hdnIdJustificativa').val('');
		$('#hdnIdInscricao').val('');
		$('#txtJustificativa').val('');
	};
	
	$("#divJustificativa").dialog({
		autoOpen : false,
		modal : true,
		show : {
			effect : "puff",
			duration : 1000
		},
		hide : {
			effect : "puff",
			duration : 1000
		},
		width : 900,
		height : 500,
		position:['middle',20],
	    buttons: {
	         "Cancelar": function() {
	           $( this ).dialog( "close" );
	          },
	          "Salvar": function() {
	        		if(idJustificativa==''){
	        			dados='filtro=salvarJustificativa&';
	        		}else{
	        			dados='filtro=upDateJustificativa&';
	        		};
	        	  
	        	  	dados += 'idInscricao='+idInscricao;
	        	  	dados += '&idJustificativa='+idJustificativa;
	        		dados += '&justificativa='+ $('#txtJustificativa').val();
	        		var varXML = chamar_ajax('../php/sql.php',dados, false, 'xml', null);
	        		if (varXML!=''){	        		
		        		$('#btnNao'+idInscricao).css({"background-color":"#FF0000"});
						$('#btnSim'+idInscricao).css({"background-color":"#BDBDBD"});
						$('#btnNao'+idInscricao).attr("onclick","");
						$('#btnSim'+idInscricao).attr("onclick","entrega("+idInscricao+",3)");
						$('#statusTrabalho'+idInscricao).html('INDEFERIDO (<a href="javascript:void(0)" onclick="justificativaTrabalho('+valor_xml(varXML,'IDJUSTIFICATIVA',0)+','+idInscricao+',\''+valor_xml(varXML,'JUSTIFICATIVA',0)+'\')">JUSTIFICATIVA</a>)');
					
					dados2 = 'IdInscricao='+idInscricao;
					dados2 += '&status='+status;
					var varXML2 = chamar_ajax('../php/sql.php','filtro=entregaTrabalho&'+dados2, false, 'txt', null);
						
	        		}else{
	        			alert('Falha ao gravar Justifivativa');
	        		}	
	            $( this ).dialog( "close" );
	          }
	        }
	});

	$("#divJustificativa").dialog("open");

}