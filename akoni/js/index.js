function Iniciar() {
	chamar_ajax('php/define.php', 'filtro=DestroiSessao', true, null, null);
}

function Enter(event) {
    if( event.keyCode==13 ) 
	  {
       testar();
       return false;
    }
 }

function testar() {
	if (vazio('txt_nome')) {
		window.alert('Preencha o campo Login:');
		document.getElementById('txt_nome').focus()
	} else {
		var usuario = document.getElementById('txt_nome').value;
		var senha = document.getElementById('txt_senha').value;
		var xml = chamar_ajax('php/sql.php', 'filtro=Login&txtNome=' + usuario
				+ '&txtSenha=' + senha, false, 'xml', null);
			
		if (valor_xml(xml, 'n_reg', 0) == 0) {
			alert('Usuário e/ou senha incorreto(s)!');
		} else {
			//alert(valor_xml(xml, 'IDUSUARIO', 0));
			chamar_ajax('php/define.php', 'filtro=DefineLogin&IDUser=' + valor_xml(xml, 'IDUSUARIO', 0), true, null, null);
			alert("Bem vindo!");

			window.location.href = "raiz.html";
		}
	}
}