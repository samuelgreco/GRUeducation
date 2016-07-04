function iniciar(){
	var varXML = chamar_ajax('php/define.php', 'filtro=GetLogin', false, 'text', null);
	//alert(varXML);
	if (varXML<=0){
		parent.location.href = "index.html"
	}
}