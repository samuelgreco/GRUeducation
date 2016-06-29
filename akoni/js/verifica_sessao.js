function verificar(){
	var id = chamar_ajax('../php/define.php', 'filtro=GetLogin', false, 'text', null);
	
	if (id<=0){
		parent.location.href = "../index.php";
	}
}