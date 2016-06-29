<?php session_start(); ?>
<!doctype html>
<html lang=''>
<head>
   <meta charset='utf-8'>
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <script src="../lib/js/jquery-1.10.2.js"></script>
   <script type="text/javascript" src="../lib/js/ajax.js"></script>
   <script type="text/javascript" src="../lib/js/select.js"></script>
   <script type="text/javascript" src="../lib/js/objeto.js"></script>
   <link rel="stylesheet" href="css/estilomenu.css">
   <script src="../lib/js/script.js"></script>
   <title>Processo Seletivo Simplificado 2015</title>
</head>
<body>
<label id="menu" onClick="startAnimation()"><center>MENU</center></label>
<br />
<div id='menuInteiro'>
	<div id='cssmenu'>
	<ul>
	   <li><a href="ola.html" target="mainFrame"><span>Início</span></a></li>
	   <li class='has-sub'><a href='#'><span>Administrador</span></a>
	   	  <ul>
	   	  	<li><a href="formularios/lstNoticias.php" target="mainFrame">Informações</a></li>
	   	  	<li><a href="formularios/lstArquivos.php" target="mainFrame">Arquivos</a></li>
	   	  	<li><a href="formularios/travar.php" target="mainFrame">Travas</a></li>
	   	  </ul>
	   </li>
	   <li class='has-sub'><a href='#'><span>Inscrições</span></a>
	   	  <ul>
	   	  	<li><a href="formularios/entregaTrabalho.php" target="mainFrame">Entrega de Trabalhos</a></li>
	   	  	<li class='last'><a href="formularios/analiseTrabalho.php" target="mainFrame">Análise dos Trabalhos</a></li>
	   	  </ul>
	   </li>
	   <li class='has-sub'><a href='#'><span>Relatórios</span></a>
	   	  <ul>
	   	  	<li><a href="relatorios/relQtdeInscritos.php" target="mainFrame">Qtde. de inscritos</a></li>
	   	  	<li><a href="relatorios/relListaFinalizado.php" target="mainFrame">Lista de inscrições Finalizadas (ON LINE)</a></li>
	   	  	<li><a href="relatorios/relListaAnalise.php" target="mainFrame">Lista de inscrições EM ANALISE</a></li>
	   	  	<li><a href="relatorios/relListaDeferido.php" target="mainFrame">Lista inscrições DEFERIDAS</a></li>
	   	  	<li><a href="relatorios/relListaIndeferido.php" target="mainFrame">Lista de inscrições INDEFERIDAS</a></li>
	   	  </ul>
	   </li>
	   <li class='last'><a href="javascript:sair()"><span>Sair</span></a></li>
	</ul>
	</div>
</div>
</body>
<html>

<script type="text/javascript">
function sair(){
	chamar_ajax('php/define.php', 'filtro=DestroiSessao', false, null, null);
	parent.location.href = "index.php"
}
</script>
<SCRIPT>
$("#accordion > li").click(function(){

	if(false == $(this).next().is(':visible')) {
		$('#accordion > ul').slideUp(300);
	}
	$(this).next().slideToggle(300);
});

$('#accordion > ul:eq(0)').show();

var anima;

function startAnimation() { 
	var tinicio=220;
	var tfim=70;
	var	tamanho;
	var tmenu = parseInt(window.parent.document.getElementById('fraCorpo').cols);
	if (tmenu>=tinicio){
		tamanho = tfim;
		pace=-10;
		document.getElementById('menuInteiro').style.visibility = 'hidden';
		//document.getElementById('menuInteiro').style.width = '1px';
		//document.getElementById('cssmenu').style.width = '1px';
	}else{
		tamanho = tinicio;
		pace=10;
		document.getElementById('menuInteiro').style.visibility = 'visible';
	}
	
	anima = setInterval(function(){animation(tamanho,pace)},2);
}

function animation(x,pace){
	var menu = window.parent.document.getElementById('fraCorpo');
	var tmenu = parseInt(window.parent.document.getElementById('fraCorpo').cols);
	if (tmenu == x){
		clearInterval(anima);
	}
	
	menu.cols = " " + (tmenu + pace) + ",*";
}

</SCRIPT>
