$().ready(function() {
	// Validação de formulário de adicionar e editar produtos
	$("#frmCadHorario").validate({
		
		rules: {
			"cboTipo": { required: true},
			"txtVagas": { required: true, number: true },
			"txtData": { required: true},
			"cboHoraInicio": { required: true},
			"cboHoraFim": { required: true}
		},
		messages: {
			"cboTipo": "Selecione o tipo de vaga!",
			"txtVagas": {required: "Preecha a quantidade de vagas!", number: "Digite apenas n&uacute;meros!"},
			"txtData": "Selecione a data!",
			"cboHoraInicio": "Selecione a hora inicial!",
			"cboHoraFim": "Selecione a hora final!"
		}
	});
	
	$("#cmdSalvarHorario").click(function(){
	    if($("#frmCadHorario").valid()){ 
	    	submitForm();	
	    }
	});
	
	$("#frmCadEscola").validate({
		
		rules: {
			"txtEscola": { required: true},
			"txtLogin": { required: true},
			"txtSenha": { required: true},
			"cboTipo": {required: true}
		},
		messages: {
			"txtEscola": "Preencha a escola!",
			"txtLogin": "Preencha o login!",
			"txtSenha": "Preencha a senha!",
			"cboTipo": "Selecione o tipo de escola!"
		}
	});
	
	$("#cmdSalvarEscola").click(function(){
	    if($("#frmCadEscola").valid()){ 
	    	submitForm();	
	    }
	});
	
$("#frmSenha").validate({
		
		rules: {
			"txtSenhaAtual": { required: true},
			"txtNovaSenha": { required: true},
			"txtRepeteSenha": { required: true}
		},
		messages: {
			"txtSenhaAtual": "Preencha a senha atual!",
			"txtNovaSenha": "Preencha a nova senha!",
			"txtRepeteSenha": "Repita a nova senha!"
		}
	});
	
	$("#cmdSalvarSenha").click(function(){
	    if($("#frmSenha").valid()){ 
	    	submitForm();	
	    }
	});
	
});
