$().ready(function () {
    //$('#txtCPFResponsavel').mask('000.000.000-00');
    $('#txtDtNasc').mask('00/00/0000');
    $('input[name="txtDtNascEducador[]"]').mask('00/00/0000');
    $('#txtDtRealizacao').mask('00/00/0000');

    if ($('#hdnCPF').val() != '') {
        $("#divResponsavel").hide();
        $("#divInscricoes").show();
    }
});

var cont = 2;
var contProf = 2;

function verificaCPF() {
    var strCPF = $("#txtCPFResponsavel").val();
    var Soma; 
    var Resto; 
    var cboll = true; 
    Soma = 0;
    
    
    if (strCPF.length != 11 || 
    		strCPF == "00000000000" || 
    		strCPF == "11111111111" || 
    		strCPF == "22222222222" || 
    		strCPF == "33333333333" || 
    		strCPF == "44444444444" || 
    		strCPF == "55555555555" || 
    		strCPF == "66666666666" || 
    		strCPF == "77777777777" || 
    		strCPF == "88888888888" || 
    		strCPF == "99999999999") 
    	{
    		cboll = false; }
    
    
    for (i=1; i<=9; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (11 - i); 
    Resto = (Soma * 10) % 11; 

    if ((Resto == 10) || (Resto == 11)) Resto = 0; 
    if (Resto != parseInt(strCPF.substring(9, 10)) ) cboll = false; 

    Soma = 0; 
    for (i = 1; i <= 10; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (12 - i); 
    Resto = (Soma * 10) % 11; 

    if ((Resto == 10) || (Resto == 11)) Resto = 0; 
    if (Resto != parseInt(strCPF.substring(10, 11) ) ) cboll = false; 

    

    if (cboll) {
        consultaInscricao();
        return cboll;
    }
    else {
        alert('Por favor digite um CPF válido para prosseguir.')
        $('#txtCPFResponsavel').css('background-color','#FF7171'); 
        $('#txtCPFResponsavel').focus(); 
        
    }
}

function Enter(event) {
    if (event.keyCode == 10)
    {
        verificaCPF();
        return false;
    }
}

function consultaInscricao() {
    txtCPFResponsavel = $("#txtCPFResponsavel").val();
    dados = 'txtCPFResponsavel=' + txtCPFResponsavel;
    var varXML = chamar_ajax('../php/sql.php', 'filtro=consultaInscricao&' + dados, false, 'xml', null);
    if (valor_xml(varXML, 'n_reg', 0) > 0) {
        alert("já existem inscrições para esse CPF");
        window.open('inscricao.php?txtCPFResponsavel=' + txtCPFResponsavel, '_self');

    } else {
        CPFInscricao(txtCPFResponsavel);
    }
}

function excluirInscricao(IdInscricao, cpf) {
    dados = 'IdInscricao=' + IdInscricao;
    var varXML = chamar_ajax('../php/sql.php', 'filtro=excluirInscricao&' + dados, false, 'txt', null);
    if (varXML == 1) {
        window.open('inscricao.php?txtCPFResponsavel=' + cpf, '_self');
        alert("Excluido com sucesso!");
    }
}


function editarInscricao(IdInscricao) {
    $('#hdnIdInscricao').val(IdInscricao);
    dados = 'IdInscricao=' + IdInscricao;
    var varXML = chamar_ajax('../php/sql.php', 'filtro=editarInscricao&' + dados, false, 'xml', null);
    if (valor_xml(varXML, 'IDTRABALHO', 0) == '') {
        AbrirEtapa1(IdInscricao);
    }

    if (valor_xml(varXML, 'IDDEPENDENCIA', 0) == 1) {
        AbrirEtapa1(IdInscricao);
        AbrirComboEscolaMunicipal();
        $('#cboEscolaMunicipal').val(valor_xml(varXML, 'IDPJ', 0));
        $('#hdnIdTrabalho').val(valor_xml(varXML, 'IDTRABALHO', 0));
        $("#rdoCategoria" + valor_xml(varXML, 'IDCATEGORIA', 0)).attr("checked", true);
    } else {
        if (valor_xml(varXML, 'IDDEPENDENCIA', 0) == 2) {
            AbrirEtapa1(IdInscricao);
            AbrirComboEscolaConveniada();
            $('#cboEscolaConveniada').val(valor_xml(varXML, 'IDPJ', 0));
            $('#hdnIdTrabalho').val(valor_xml(varXML, 'IDTRABALHO', 0));
            $("#rdoCategoria" + valor_xml(varXML, 'IDCATEGORIA', 0)).attr("checked", true);
        } else {
            if (valor_xml(varXML, 'IDDEPENDENCIA', 0) == 3) {
                AbrirEtapa1(IdInscricao);
                AbrirComboEscolaMova();
                $('#cboEscolaMova').val(valor_xml(varXML, 'IDPJ', 0));
                $('#hdnIdTrabalho').val(valor_xml(varXML, 'IDTRABALHO', 0));
                $("#rdoCategoria" + valor_xml(varXML, 'IDCATEGORIA', 0)).attr("checked", true);
                carregaProfMova();
                $('#cboProfMova').val(valor_xml(varXML, 'IDSERVIDOR_PUBLICO', 0));
            }
        }
    }
//	alert(valor_xml(varXML,'IDTRABALHO', 0));
//	alert($('#hdnIdTrabalho').val());
}


function CPFInscricao(txtCPFResponsavel) {
    dados = 'txtCPFResponsavel=' + txtCPFResponsavel;
    var varXML = chamar_ajax('../php/sql.php', 'filtro=CPFInscricao&' + dados, false, 'txt', null);
    $('#hdnIdInscricao').val(varXML);
    $("#divInscricoes").hide();
    AbrirEtapa1($('#hdnIdInscricao').val());
}
;


function AbrirEtapa1(idInscricao) {
    $('#hdnIdInscricao').val(idInscricao);
    $("#divResponsavel").hide();
    $("#divInscricoes").hide();
    $("#divEtapa1").show();
}

/*function countQtdCategoria(){
 //CHECAR QTD INSCRICAO NESTA CATEGORIA
 // SE QTD MAHXIMA JAH ATINGIDA, DISABLE BTN PROXIMO
 var txtIdEscola = $('#cboescola').val();
 var txtIdCategoria = $('#cbocategoria').val();
 
 if (($("#rdoEscola1").prop('checked'))||($("#rdoEscola2").prop('checked'))||($("#rdoEscola3").prop('checked'))) {
 varXML = null;
 if (($("#rdoEscola1").prop('checked'))||($("#rdoEscola2").prop('checked'))) {		
 dados =  "filtro=qtdInscricaoCategoria&txtIdEscola="+txtIdEscola+"&txtIdCategoria="+txtIdCategoria; ///
 }
 if ($("#rdoEscola3").prop('checked')) {
 dados =  "filtro=qtdInscricaoCategoriaMova&txtIdProfessor="+txtIdProfessor+"&txtIdCategoria="+txtIdCategoria; ///
 }
 var varXML = chamar_ajax('../php/sql.php',dados, false, 'xml', null);
 if (valor_xml(varXML,'QTD',0)>=5) {
 // disabled btn proximo abrirEtapa2()
 document.getElementById("#btnEtapa2").disabled = true;
 document.getElementById("#btnFinaliza").disabled = true;
 alert ("Quantidade Máxima (5) excedida!");
 }		
 }
 }
 
 */


function AbrirComboEscolaMunicipal() {
    $("#rdoEscola1").attr("checked", true);
    $("#trEscolaMunicipal").show();
    $("#trEscolaConveniada").hide();
    $("#trEscolaMova").hide();
    $("#trProfMova").hide();
    if ($("#cboEscolaMunicipal").val() == '') {
        carregaEscolaMunicipal();
    }
}
;


function AbrirComboEscolaConveniada() {
    $("#rdoEscola2").attr("checked", true);
    $("#trEscolaConveniada").show();
    $("#trEscolaMunicipal").hide();
    $("#trEscolaMova").hide();
    $("#trProfMova").hide();
    if ($("#cboEscolaConveniada").val() == '') {
        carregaEscolaConveniada();
    }
}
;



function AbrirComboEscolaMova() {
    $("#rdoEscola3").attr("checked", true);
    $("#trEscolaMova").show();
    $("#trEscolaMunicipal").hide();
    $("#trEscolaConveniada").hide();
    if ($("#cboEscolaMova").val() == '') {
        carregaEscolaMova();
    }

}
;


function abrirEtapa2() {
    //alert("teste: "+validarEtapa(1));
    /*	if(!(validarEtapa(1))){
     return false;
     }
     return false;
     countQtdCategoria();
     
     */

    if (!verificarQtdInscricao()) {
        return false;
    }


    if ($('#hdnIdTrabalho').val() != '') {
        upDateTrabalho();
    } else {
        gravarTrabalho();
    }
    $("#divEtapa1").hide()
    if ($('input[name="rdoCategoria"]:checked').val() != 1) {
        $("#divEtapa2").show();
        $("#divEducando").show();
        $("#trBtnEducador1").hide();
    } else {
        $("#divEtapa2").show();
        $("#divTurma").show();

    }

}
;




function gravarTrabalho() {
    if ($('input[name="rdoEscola"]:checked').val() == 1) {
        IdEscola = $('#cboEscolaMunicipal').val();
        IdDependencia = 1;
    } else {
        if ($('input[name="rdoEscola"]:checked').val() == 2) {
            IdEscola = $('#cboEscolaConveniada').val();
            IdDependencia = 2;
        } else {
            if ($('input[name="rdoEscola"]:checked').val() == 3) {
                IdEscola = $('#cboEscolaMova').val();
                IdDependencia = 3;
            }
        }
    }
    ;

    dados = 'IdInscricao=' + $('#hdnIdInscricao').val();
    dados += '&IdEscola=' + IdEscola;
    dados += '&IdDependencia=' + IdDependencia;
    dados += '&IdCategoria=' + $('input[name="rdoCategoria"]:checked').val();
    var varXML = chamar_ajax('../php/sql.php', 'filtro=gravarTrabalho&' + dados, false, 'txt', null);
    $('#hdnIdTrabalho').val(varXML);
    if ($('input[name="rdoEscola"]:checked').val() == 3) {
        gravaProfMova();
    }
}


function upDateTrabalho() {
    if ($('input[name="rdoEscola"]:checked').val() == 1) {
        IdEscola = $('#cboEscolaMunicipal').val();
        IdDependencia = 1;
    } else {
        if ($('input[name="rdoEscola"]:checked').val() == 2) {
            IdEscola = $('#cboEscolaConveniada').val();
            IdDependencia = 2;
        } else {
            if ($('input[name="rdoEscola"]:checked').val() == 3) {
                IdEscola = $('#cboEscolaMova').val();
                IdDependencia = 3;
            }
        }
    }
    ;

    dados = 'IdTrabalho=' + $('#hdnIdTrabalho').val();
    dados += '&IdEscola=' + IdEscola;
    dados += '&IdDependencia=' + IdDependencia;
    dados += '&IdCategoria=' + $('input[name="rdoCategoria"]:checked').val();
    var varXML = chamar_ajax('../php/sql.php', 'filtro=upDateTrabalho&' + dados, false, 'txt', null);
    if ($('input[name="rdoEscola"]:checked').val() == 3) {
        dados2 = 'IdTrabalho=' + $('#hdnIdTrabalho').val();
        var varXML2 = chamar_ajax('../php/sql.php', 'filtro=consultaProfMova&' + dados2, false, 'xml', null);
        if (valor_xml(varXML2, 'n_reg', 0) == 0) {
            gravaProfMova();
        } else {
            upDateProfMova();
        }
    }
    editar_Trab($('#hdnIdTrabalho').val());
}



function editar_Trab(idTrabalho) {

    dados = 'IdTrabalho=' + idTrabalho;
    var varXML = chamar_ajax('../php/sql.php', 'filtro=editar_Trab&' + dados, false, 'xml', null);

    if (valor_xml(varXML, 'n_reg', 0) == 0) {
        if ($('input[name="rdoCategoria"]:checked').val() != 1) {
            $("#divEtapa2").show();
            $("#divEducando").show();
            $("#trBtnEducador1").hide();
        } else {
            $("#divEtapa2").show();
            $("#divTurma").show();

        }
        ;
    } else {
        $('#cboAnoTurma').val(valor_xml(varXML, 'IDSERIE', 0));
        $('#txtNomeTurma').val(valor_xml(varXML, 'NOME_TURMA', 0));
        $('#txtAlunosTurma').val(valor_xml(varXML, 'QTD_ALUNOS', 0));
        $('#txtNomeEducando').val(valor_xml(varXML, 'NOME', 0));
        $('#txtDtNasc').val(valor_xml(varXML, 'DTNASC', 0));
        $('#cboSexoEducando').val(valor_xml(varXML, 'SEXO', 0));
        $('#cboCorEducando').val(valor_xml(varXML, 'IDRACA', 0));
        $('#cboCursando').val(valor_xml(varXML, 'TIPO_ENSINO', 0));
        $('#hdnIdTrabEducando').val(valor_xml(varXML, 'IDTRAB_EDUCANDO', 0));
        $('#hdnIdTrabTurma').val(valor_xml(varXML, 'IDTRAB_TURMA', 0));
    }
}


function upDateProfMova() {
    dados = 'IdTrabalho=' + $('#hdnIdTrabalho').val();
    dados += '&IdServidor_Publico=' + $('#cboProfMova').val();
    var varXML = chamar_ajax('../php/sql.php', 'filtro=upDateProfMova&' + dados, false, 'txt', null);
}




function gravaProfMova() {

    dados = 'IdTrabalho=' + $('#hdnIdTrabalho').val();
    dados += '&IdServidor_Publico=' + $('#cboProfMova').val();
    var varXML = chamar_ajax('../php/sql.php', 'filtro=gravaProfMova&' + dados, false, 'txt', null);
}




//funções referentes ao botão PROXIMO da Etapa 2- Identificação do(a) Educando(a)--------------------------------

function AbrirEtapa3Educando() {
var nasc = $('#txtDtNasc').val();
var tamanho = nasc.length;
    if ($('#txtNomeEducando').val() != '' && tamanho == 10 && $('#cboSexoEducando').val() != 'selecione' && $('#cboCorEducando').val() != 'selecione' && $('#cboCursando').val() != 'selecione') {

        if ($('#hdnIdTrabEducando').val() != '') {
            upDataTrabEducando();
        } else {
            gravarTrabEducando();
        }
        $("#divEtapa2").hide();
        $("#divEtapa3").show();
        $("#divEtapa3Botao").show();
        carregarProf();
        $("#Remover2").hide();
        $("#Remover3").hide();


    }
    else {
        alert("Preencha todos campos obrigatórios (*) antes de prosseguir.")
    }
}

function upDataTrabEducando() {
    dados = 'IdTrabEducando=' + $('#hdnIdTrabEducando').val();
    dados += '&Nome=' + $('#txtNomeEducando').val();
    dados += '&DtNasc=' + $('#txtDtNasc').val();
    dados += '&Sexo=' + $('#cboSexoEducando').val();
    dados += '&Raca=' + $('#cboCorEducando').val();
    dados += '&TipoEnsino=' + $('#cboCursando').val();

    var varXML = chamar_ajax('../php/sql.php', 'filtro=upDateTrabEducando&' + dados, false, 'txt', null);
}

function gravarTrabEducando() {
    dados = 'IdTrabalho=' + $('#hdnIdTrabalho').val();
    dados += '&Nome=' + $('#txtNomeEducando').val();
    dados += '&DtNasc=' + $('#txtDtNasc').val();
    dados += '&Sexo=' + $('#cboSexoEducando').val();
    dados += '&Raca=' + $('#cboCorEducando').val();
    dados += '&TipoEnsino=' + $('#cboCursando').val();

    var varXML = chamar_ajax('../php/sql.php', 'filtro=gravarTrabEducando&' + dados, false, 'txt', null);
}

//---------------------------------------------------------------------------------------------------------------

//funções referentes ao botão PROXIMO da Etapa 2- Identificação da Turma-----------------------------------------

function AbrirEtapa3Turma() {

    if ($('#txtNomeTurma').val() != '' && $('#txtAlunosTurma').val() != '')
    {

        if ($('#hdnIdTrabTurma').val() != '') {
            upDataTrabTurma();
        } else {
            gravarTrabTurma();
        }
        $("#divEtapa2").hide();
        $("#divEtapa3").show();
        $("#divEtapa3Botao").show();
        carregarProf();
    }
    else {
        alert("Preencha todos campos obrigatórios (*) antes de prosseguir.")

    }

}

function upDataTrabTurma() {
    dados = 'IdTrabTuma=' + $('#hdnIdTrabTurma').val();
    dados += '&Ano=' + $('#cboAnoTurma').val();
    dados += '&NomeTurma=' + $('#txtNomeTurma').val();
    dados += '&QtdAlunos=' + $('#txtAlunosTurma').val();

    var varXML = chamar_ajax('../php/sql.php', 'filtro=upDateTrabTurma&' + dados, false, 'txt', null);
}

function gravarTrabTurma() {
    dados = 'IdTrabalho=' + $('#hdnIdTrabalho').val();
    dados += '&Ano=' + $('#cboAnoTurma').val();
    dados += '&NomeTurma=' + $('#txtNomeTurma').val();
    dados += '&QtdAlunos=' + $('#txtAlunosTurma').val();

    var varXML = chamar_ajax('../php/sql.php', 'filtro=gravarTrabTurma&' + dados, false, 'txt', null);
}
//---------------------------------------------------------------------------------------------------------------


function carregarProf() {
    dados = 'IdTrabalho=' + $('#hdnIdTrabalho').val();
    var varXML = chamar_ajax('../php/sql.php', 'filtro=carregarProf&' + dados, false, 'xml', null);
    if (valor_xml(varXML, 'n_reg', 0) == 0) {
    } else {
        if (valor_xml(varXML, 'n_reg', 0) == 1) {
            $('#txtNomeEducador1').val(valor_xml(varXML, 'NOME', 0));
            $('#txtDtNascEducador1').val(valor_xml(varXML, 'DTNASC', 0));
            $('#cboSexoEducador1').val(valor_xml(varXML, 'SEXO', 0));
            $('#cboCorEducador1').val(valor_xml(varXML, 'IDRACA', 0));
            $('#hdnIdProf1').val(valor_xml(varXML, 'IDEDUCADOR', 0));
        } else {
            if (valor_xml(varXML, 'n_reg', 0) > 1) {
                for (var i = 0; i < valor_xml(varXML, 'n_reg', 0); i++) {
                    if (i == 0) {
                        $('#txtNomeEducador' + (i + 1)).val(valor_xml(varXML, 'NOME', i));
                        $('#txtDtNascEducador' + (i + 1)).val(valor_xml(varXML, 'DTNASC', i));
                        $('#cboSexoEducador' + (i + 1)).val(valor_xml(varXML, 'SEXO', i));
                        $('#cboCorEducador' + (i + 1)).val(valor_xml(varXML, 'IDRACA', i));
                        $('#hdnIdProf' + (i + 1)).val(valor_xml(varXML, 'IDEDUCADOR', i));
                    } else {
                        AbrirEducador();
                        $('#Remover' + (parseInt(i) + parseInt(1)) + ' #txtNomeEducador' + (i + 1)).val(valor_xml(varXML, 'NOME', i));
                        $('#Remover' + (parseInt(i) + parseInt(1)) + ' #txtDtNascEducador' + (i + 1)).val(valor_xml(varXML, 'DTNASC', i));
                        $('#Remover' + (parseInt(i) + parseInt(1)) + ' #cboSexoEducador' + (i + 1)).val(valor_xml(varXML, 'SEXO', i));
                        $('#Remover' + (parseInt(i) + parseInt(1)) + ' #cboCorEducador' + (i + 1)).val(valor_xml(varXML, 'IDRACA', i));
                        $('#Remover' + (parseInt(i) + parseInt(1)) + ' #hdnIdProf' + (i + 1)).val(valor_xml(varXML, 'IDEDUCADOR', i));
                    }
                }
                if (valor_xml(varXML, 'n_reg', 0) > 0) {
                    contProf = (parseInt(1) + parseInt(valor_xml(varXML, 'n_reg', 0)));
                }
                ;
                if (contProf <= 3) {
                    $("#trBtnEducador1").show();
                } else {
                    $("#trBtnEducador1").hide();
                }
                ;
            }
        }
    }
}



function AbrirEducador() {
    
    var clone = $('#divEducador').html();    
    clone = clone.replace("txtNomeEducador1", "txtNomeEducador"+cont);// MODIFICA ID DE ELEMENTO INTERNO DA DIV
    clone = clone.replace("txtDtNascEducador1", "txtDtNascEducador"+cont);
    clone = clone.replace("cboSexoEducador1", "cboSexoEducador"+cont);
    clone = clone.replace("cboCorEducador1", "cboCorEducador"+cont);
    var div = '<div id="Remover' + cont + '"><h4>Educador(a) <span id="educ' + contProf + '">' + contProf + '</h4>';
    div += clone;
    div += '<input class="Mais" align="middle" type="button" id="btnRemove' + cont + '" value="Remover Prof" onclick="removerProf(\'Remover' + cont + '\')"/></div>';
    $("#divEtapa3").append(div);
    
    $('#btnRemove' + (parseInt(cont) - parseInt(1))).show();
    cont++
    contProf++
    $('input[name="txtDtNascEducador[]"]').mask('00/00/0000');
    if (contProf <= 3) {
        $("#trBtnEducador1").show();
    } else {
        $("#trBtnEducador1").hide();
    }
    ;
}

function removerProf(nomeDiv) {
    if ($('#' + nomeDiv + ' #hdnIdProf1').val() != '') {
        dados = 'IdProf=' + $('#' + nomeDiv + ' #hdnIdProf1').val();
        var varXML = chamar_ajax('../php/sql.php', 'filtro=excluirProf&' + dados, false, 'txt', null);
    }
    ;

    $('#' + nomeDiv).remove();
    contProf--;
    $('#educ' + contProf).html(parseInt(contProf) - parseInt(1));
    $('#btnRemove' + (parseInt(cont) - parseInt(1))).show();
    if (contProf <= 3) {
        $("#trBtnEducador1").show();
    } else {
        $("#trBtnEducador1").hide();
    }
    ;
}






function AbrirEtapa4() {
	var teste = true;
/////********Travar a partir da verificação de ID existente*********//////////////////
	for(x=1; (document.getElementById("txtNomeEducador"+x)); x++){
		if ($('#txtNomeEducador'+x).val() == ''){
			teste = false;
		} 
		if ($('#cboCorEducador'+x).val() == 'selecione'){
			teste = false;
		}
		/*		if ($('#txtDtNascEducador'+x).val() == ''){
			teste = false;
		} 
		if ($('#cboSexoEducador'+x).val() == 'selecione'){
			teste = false;
		} */
		//alert("txtNomeEducador "+$("#txtNomeEducador"+(x)));
	}
	
	if (teste){
	
        gravarProf();
        $("#divEtapa3").hide();
        $("#divEtapa3Botao").hide();
        $("#divEducador1").hide();
        $("#divEducador2").hide();
        $("#divEducador3").hide();
        $("#divEtapa4").show();
        carregarDescTrabalho();
    }else {
    	alert("Preencha todos campos obrigatórios (*) antes de prosseguir.")
    }
 }






function gravarProf() {
    dados = 'IdTrabalho=' + $('#hdnIdTrabalho').val();
    dados += '&' + $('#frmEducador').serialize();
    var varXML = chamar_ajax('../php/sql.php', 'filtro=gravarProf&' + dados, false, 'txt', null);
}


function contarCaract(nomeCampo, tamanho) {
    $('#btnSalvarRascunho').show();
    $('#btnSalvarRascunho2').show();

    $('#' + nomeCampo).keyup(function () {
        qtd = $('#' + nomeCampo).val().length;
        $('#qtd' + nomeCampo).html(qtd);
        if (qtd > (tamanho - 200)) {
            $('#qtd' + nomeCampo).css("color", "red");
        } else {
            $('#qtd' + nomeCampo).css("color", "");
        }
    });
    $('#' + nomeCampo).keyup(function () {
        //Get the value
        var text = $('#' + nomeCampo).val();
        //Get the maxlength
        var limit = $('#' + nomeCampo).attr('maxlength');
        //Check if the length exceeds what is permitted
        if (text.length > limit) {
            //Truncate the text if necessary
            $('#' + nomeCampo).val(text.substr(0, limit));
        }
    });
}





function finalizar() {
var realizacao = $('#txtDtRealizacao').val();
var tamanho = realizacao.length;
    if (!verificarQtdInscricao()) {
        return false;
    }

    if (tamanho == 10 && $('#txtImpressao').val() != '' && $('#txtSaberes').val() != '' && $('#txtRecursos').val() != '' && $('#txtAcoes').val() != '' && $('#txtObjetivo').val() != '')
    {

        if ($('#hdnIdDescTrabalho').val() == '') {
            gravarDesc();
            $('#btnSalvarRascunho').hide();
            $('#btnSalvarRascunho2').hide();

        } else {
            upDataDescTrab();
            $('#btnSalvarRascunho').hide();
            $('#btnSalvarRascunho2').hide();
        }

        dados = 'IdInscricao=' + $('#hdnIdInscricao').val();
        var varXML = chamar_ajax('../php/sql.php', 'filtro=finalizar&' + dados, false, 'txt', null);
        if (varXML == 1) {
            alert("Inscrição finalizada com sucesso!");
            window.open("inscricao.php?txtCPFResponsavel=" + $('#hdnCPF').val(), "_self")
        } else {
            alert("Inscrição não realizada!");
        }
    }
    else {
    	alert("Preencha todos campos obrigatórios (*) antes de prosseguir.")
        //alert("Preencha todos os campos!")
    }
}


function gravarDesc() {
    dados = 'IdTrabalho=' + $('#hdnIdTrabalho').val();
    dados += '&IdInscricao=' + $('#hdnIdInscricao').val();
    dados += '&' + $('#frmDescTrab').serialize();
    var varXML = chamar_ajax('../php/sql.php', 'filtro=gravarDescTrab&' + dados, false, 'txt', null);
    carregarDescTrabalho();
}

function upDataDescTrab() {
    dados = 'IdDescTrabalho=' + $('#hdnIdDescTrabalho').val();
    dados += '&' + $('#frmDescTrab').serialize();
    var varXML = chamar_ajax('../php/sql.php', 'filtro=upDateDescTrab&' + dados, false, 'txt', null);
    carregarDescTrabalho();
}


function upDateDesc() {
    if ($('#hdnIdDescTrabalho').val() == '') {
        gravarDesc();
        $('#btnSalvarRascunho').hide();
        $('#btnSalvarRascunho2').hide();

    } else {
        upDataDescTrab();
        $('#btnSalvarRascunho').hide();
        $('#btnSalvarRascunho2').hide();
    }
}


function carregarDescTrabalho() {

    dados = 'IdTrabalho=' + $('#hdnIdTrabalho').val();
    var varXML = chamar_ajax('../php/sql.php', 'filtro=carregarDescTrabalho&' + dados, false, 'xml', null);
    if (valor_xml(varXML, 'n_reg', 0) == 0) {
    } else {
        $('#txtDtRealizacao').val(valor_xml(varXML, 'DATA', 0));
        $('#txtObjetivo').val(valor_xml(varXML, 'OBJETIVO', 0));
        $('#txtAcoes').val(valor_xml(varXML, 'ACOES', 0));
        $('#txtRecursos').val(valor_xml(varXML, 'RECURSOS', 0));
        $('#txtMaterial').val(valor_xml(varXML, 'MATERIAL', 0));
        $('#txtSaberes').val(valor_xml(varXML, 'SABERES', 0));
        $('#txtImpressao').val(valor_xml(varXML, 'IMPRESSOES', 0));
        $('#hdnIdDescTrabalho').val(valor_xml(varXML, 'IDDESCTRABALHO', 0));
    }
}



function carregaEscolaMunicipal() {
    html = '<option value=""></option>';
    var varXML = chamar_ajax('../php/sql.php', 'filtro=carregaEscolaMunicipal', false, 'xml', null);
//	alert(varXML);exit;
    carregar_combo(varXML, 'cboEscolaMunicipal', 'NOME', 'IDPESSOA_JURIDICA');
}


function carregaEscolaConveniada() {
    html = '<option value=""></option>';
    var varXML = chamar_ajax('../php/sql.php', 'filtro=carregaEscolaConveniada', false, 'xml', null);
//	alert(varXML);exit;
    carregar_combo(varXML, 'cboEscolaConveniada', 'NOME', 'IDPESSOA_JURIDICA');
}


function carregaEscolaMova() {
    html = '<option value=""></option>';
    var varXML = chamar_ajax('../php/sql.php', 'filtro=carregaEscolaMova', false, 'xml', null);
//	alert(varXML);exit;
    carregar_combo(varXML, 'cboEscolaMova', 'NOME', 'IDPESSOA_JURIDICA');
}


function carregaProfMova() {
    html = '<option value=""></option>';
    $("#trProfMova").show();

    dados = 'idPessoa_Juridica=' + $('#cboEscolaMova').val();
    var varXML = chamar_ajax('../php/sql.php', 'filtro=carregaProfMova&' + dados, false, 'xml', null);
//	alert(varXML);exit;	
    carregar_combo(varXML, 'cboProfMova', 'SERVIDOR', 'IDSERVIDOR_PUBLICO');

}


function imprimirInscricao(idInscricao) {
    window.open('../relatorios/ficha.php?idInscricao=' + idInscricao);
}


function validarEtapa(etapa) {
    etapa = parseInt(etapa);
    //alert ("ETAPA "+etapa);
    var retorno = false;
    switch (etapa) {
        case 1:
            retorno = true;
            var rdoCategoria = false;
            var cboEscola = false;
            if (document.getElementById("rdoCategoria1").checked) {
                rdoCategoria = true;
            }
            if (document.getElementById("rdoCategoria2").checked) {
                rdoCategoria = true;
            }
            if (document.getElementById("rdoCategoria3").checked) {
                rdoCategoria = true;
            }
            if (document.getElementById("rdoCategoria4").checked) {
                rdoCategoria = true;
            }
            if (($("#cboEscolaMunicipal").val() > 0)) {
                cboEscola = true;
            }
            if (($("#cboEscolaConveniada").val() > 0)) {
                cboEscola = true;
            }
            if ((($("#cboEscolaMova").val() > 0) && ($("#cboProfMova").val() > 0))) {
                cboEscola = true;
            }
            if (!(cboEscola && rdoCategoria)) {
                retorno = false;
            }
            //alert("CBOESCOLA: "+cboEscola+" rdoCategoria: "+rdoCategoria+"\n retorno: "+retorno);
            /*if(!(($("#cboEscolaMunicipal").val()>0)||($("#cboEscolaConveniada").val()>0)||($("#cboEscolaMova").val()>0))){
             return false;
             }*/

            break;
        case 2:
            //if (){}
            break;
        case 3:
            //if (){}
            break;
        case 4:
            //if (){}
            break;

        default:
            //retorno = false;
            break;
    }
    return retorno;
}

function verificarQtdInscricao() {
    if (!(validarEtapa(1))) {
        alert("Selecione os campos para prosseguir.");
        return false;
    }

    var dados = "filtro=qtdInscricaoCategoria";

    if ($("#cboProfMova").val() > 0) {
        dados = "filtro=qtdInscricaoCategoriaMova";
        dados += "&txtIdProfessor=" + $("#cboProfMova").val();

    }

    if ($("#cboEscolaMunicipal").val() > 0) {
        dados += "&txtIdPJ=" + $("#cboEscolaMunicipal").val();
    }
    if ($("#cboEscolaConveniada").val() > 0) {
        dados += "&txtIdPJ=" + $("#cboEscolaConveniada").val();
    }
    if ($("#cboEscolaMova").val() > 0) {
        dados += "&txtIdPJ=" + $("#cboEscolaMova").val();
    }
    if (document.getElementById("rdoCategoria1").checked) {
        dados += "&txtIdCategoria=1";
    }
    if (document.getElementById("rdoCategoria2").checked) {
        dados += "&txtIdCategoria=2";
    }
    if (document.getElementById("rdoCategoria3").checked) {
        dados += "&txtIdCategoria=3";
    }
    if (document.getElementById("rdoCategoria4").checked) {
        dados += "&txtIdCategoria=4";
    }
    var varXML = chamar_ajax('../php/sql.php', dados, false, 'xml', null);

    //alert("Total Inscritos Categoria: " + valor_xml(varXML,'QTD',0));

    if (valor_xml(varXML, 'QTD', 0) > 5) {
        alert("Essa categoria atingiu seu limite de (5) inscrições.")
        //	alert("Total Inscritos Categoria: " + valor_xml(varXML,'QTD',0));
        return false;
    }
    return true;

}