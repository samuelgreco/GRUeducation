$().ready(function() {
	
    $("#txtDt").datepicker({
    	dateFormat: 'dd/mm/yy',
    	changeMonth: true,
    	changeYear: true,
    	dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado','Domingo'],
    	dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
    	dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
    	monthNames: [  'Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
    	monthNamesShort: [ 'Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
    	nextText: 'Próximo',
    	prevText: 'Anterior'
    });

    
	if ($("#frmMunicipalData").length){
		$("#frmMunicipalData").validationEngine();
		$("#cmdGerar").click(function(){
			if($("#frmMunicipalData").validationEngine("validate")){
				document.frmMunicipalData.submit();
			}
		});
	}
});
