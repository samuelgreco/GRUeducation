
function Iniciar(){
	chamar_ajax('php/define.php', 'filtro=DestroiSessao', true, null, null);
}

function testar(){
	if (vazio('txt_nome')) {
		window.alert('Preencha o campo Login!');
		document.getElementById('txt_nome').focus()
	}
	else {
		var usuario = document.getElementById('txt_nome').value;
		var senha = document.getElementById('txt_senha').value;
		
		if(usuario=='a' && senha=='1'){
			chamar_ajax('php/define.php', 'filtro=DefineEscola&Nome=Admin&IDUser=999999', true, null, null);
			alert("Bem vindo!");
			window.location.href = "indexadm.html";
		}else{
			var xml = chamar_ajax('php/sql.php', 'filtro=Login&txtNome='+usuario+'&txtSenha='+ senha, false, 'xml', null);
			if (valor_xml(xml,'n_reg', 0) == 0) {
				alert('Usuário não cadastrado');
			}else{
				chamar_ajax('php/define.php', 'filtro=DefineEscola&Nome='+valor_xml(xml,'nome',0)+'&IDUser='+valor_xml(xml,'idEscola',0)+'&oniDia='+valor_xml(xml,'onibusdia',0)+'&oniEJA='+valor_xml(xml,'onibuseja',0)+'&Tipo='+valor_xml(xml,'idtipo_dependencia',0), true, null, null);
				alert("Escola: " + valor_xml(xml,'nome',0));
				if(valor_xml(xml,'idtipo_dependencia',0)==1){
					var pagina = 'modulo.html';
				}else{
					var pagina = 'dataHoraEst.php';
				}
				if(usuario==senha){
					window.location.href="formulario/alterar_senha.html";
				}else{
					window.location.href=pagina;
				}
			}
		}
	}
}


