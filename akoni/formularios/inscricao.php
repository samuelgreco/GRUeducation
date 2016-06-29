<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <title>Akoni</title>
        <link href="../css/estilo.css" rel="stylesheet" type="text/css" />
        <link href="../css/estiloTabela.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="../css/style.css" />
        <link rel="stylesheet" type="text/css" href="../../lib/css/estilo.css" />
        <link rel="stylesheet" type="text/css" href="../../lib/css/jquery.validationEngine.css" />


        <script src="../../lib/js/jquery-1.9.1.js" type="text/javascript"></script>
        <script type="text/javascript" charset="utf-8" src="../../lib/js/jquery-1.10.2.js"></script>
        <script type="text/javascript" charset="utf-8" src="../../lib/js/jquery-1.11.1.min.js"></script>
        <script type="text/javascript" charset="utf-8" src="../../lib/js/jquery-ui-1.10.3.custom.min.js"></script>
        <script type="text/javascript" src="../../lib/js/jquery.validationEngine-ptBr.js"></script>
        <script type="text/javascript" src="../../lib/js/jquery.validationEngine.js"></script>
        
        <script type="text/javascript" src="../../lib/js/ajax.js"></script>
        <script type="text/javascript" src="../../lib/js/select.js"></script>
        <script type="text/javascript" src="../../lib/js/objeto.js"></script>
        <script type="text/javascript" src="../../lib/js/funcoes.js"></script>
        <script type="text/javascript" src="../js/jquery.mask.js"></script>
        <script type="text/javascript" src="../js/inscricao.js"></script>

        <style>

            .botaotopo {
                display:scroll;
                position:fixed !important;
                float: left;
                display: inline;
                /* bottom:6px; */
                right:18%;
                bottom:54%;
                z-index: 9;
            }

            .caract{
                float: right;
                margin-right:11%;
            }
            
            
            #btnCont{
            background-color:#74DF00; 
            color:white;
            padding:5px;
           cursor:pointer}
           
            #btnExcl{
            background-color:#FF0040; 
            color:white;
            padding:5px;
           cursor:pointer}
           
            #btnImpr{
            background-color:#5858FA; 
            color:white;
            padding:5px;
           cursor:pointer}

        </style>





    </head>
    <body>
        <div id="tela">
            <div id="banner"></div>

            <div class="barra_menu">
                <div class="menu">
                    <ul>
                        <li><a href="../index.php">Início</a></li>
                        <?php
                        require_once ("../../lib/php/cmd_sql.php");

                        $varTravas = ConsultaTravas();

                        if ($varTravas[0]["INSCRICAO"] == 1) {
                            echo '<li><a href="inscricao.php">Inscri&ccedil;&atilde;o</a></li>';
                        }
                        if ($varTravas[0]["SITUACAO"] == 1) {
                            echo '<li><a href="situacao.php">Situa&ccedil;&atilde;o da inscri&ccedil;&atilde;o</a></li>';
                        }
                        if ($varTravas[0]["PUBLICACAO"] == 1) {
                            echo '<li><a href="publicacao.php">Editais e publicações</a></li>';
                        }

                        function ConsultaTravas() {
                            $sql = new cmd_SQL();
                            $bd['sql'] = "SELECT * FROM AKONI_TRAVA";
                            $bd['ret'] = "php";
                            $rs = $sql->pesquisar($bd);

                            return $rs;
                        }
                        ?>
                        <li style="float: right;font-size:9px;"><a href="../login.html"><img src="../images/lock.png" style="width: 10px;" />&nbsp;Acesso restrito</a></li>
                    </ul>
                </div>              
            </div>

            <input type="hidden" id="hdnCPF" name="hdnCPF"  value="<?php echo $_GET['txtCPFResponsavel'] ?>"/>	
            <input type="hidden" id="hdnIdInscricao" value=""/>	
            <input type="hidden" id="hdnIdTrabalho" value=""/>
            <input type="hidden" id="hdnIdTrabEducando" value=""/>
            <input type="hidden" id="hdnIdTrabTurma" value=""/>


            <div id="tela_camp">
                <div>
                    <h1 style="padding:0px;font-size:22px;">Inscrições</h1>
                </div>

                <div id="divResponsavel">
                    <table border="0" CELLSPACING=2 CELLPADDING=6>
                        <tr width=100>
                            <td colspan="4" align="center">
                                Digite o CPF da Pessoa responsável pela Inscri&ccedil;&atilde;o
                            </td>
                        </tr>
                        <tr>	
                            <td colspan="4" align="center">
                                <input id="txtCPFResponsavel" name="txtCPFResponsavel" maxlength="11" onkeypress="return Enter(event)">
                            </td>
                        </tr>

                        <tr align="center">
                            <td></td>

                            <td align=right width=100%>
                                <input class="Proximo" align="middle" type="button" value="Proximo" onclick="verificaCPF()" />
                            </td>
                        </tr>			
                    </table>
                </div>

                <div id="divInscricoes" style="display:none">

                    <h4>Suas Inscrições</h4>
                    <table id="tabAssunto" width="100%" style="font-size: 12px;" border="1" >
                        <thead>
                            <tr>
                                <th>Inscricao</th>
                                <th>Educando/Turma</th>
                                <th>Categoria</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            require_once ('../../lib/php/cmd_sql.php');

                            $varConsultaInscricao = listaInscricoes();

                            foreach ($varConsultaInscricao as $k => $v) {
                                ?>
                                <tr>
                                    <td>
                                        <?= $v['IDINSCRICAO'] ?>
                                    </td>
                                    <td>
                                        <?= utf8_encode($v['EDUCANDO_TURMA']) ?>
                                    </td>
                                    <td>
                                        <?= utf8_encode($v['CATEGORIA']) ?>
                                    </td>
                                    <td><?php
                                        if ($v['STATUS'] == 0) {
                                            ?>
                                            <table border="0">
                                                <tr>
                                                    <td>PENDENTE</td>
                                                    <td>
                                                        <input type="button" value="Continuar" id="btnCont" onclick="editarInscricao(<?= $v['IDINSCRICAO'] ?>)"/>
                                                    </td>
                                                    <td>
                                                        <input type="button" value="Excluir" id="btnExcl" onclick="excluirInscricao(<?= $v['IDINSCRICAO'] ?>,<?= $v['CPF'] ?>)"/>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>                                    
                                    <?php
                                } else {
                                    ?>
                                    FINALIZADO 
                                    <input type="button" value=" Imprimir inscricao " id="btnImpr"  onclick="imprimirInscricao(<?= $v['IDINSCRICAO'] ?>)" />
                                    <?php
                                }
                            }
                            ?>

                        </tbody>
                    </table>
                    </br>		
                    <p align="right">
                        <input class="Novo" type="button" style="width:185px;background-color:#01A9DB;" value="Nova Inscri&ccedil;&atilde;o" onclick="CPFInscricao(<?php echo $_GET['txtCPFResponsavel'] ?>)"/>	
                    </p>
                </div>

                <!---------------------------- ETAPA 1  ------------------------------ --> 
                <div id="divEtapa1" style="display:none">
                    <h4>Etapa 1</h4>
                    <table border="0">
                        <tr>
                            <td colspan="2">
                                Selecione a Escola/ Entidade conveniada de Educa&ccedil;&atilde;o Infantil/ Entidade do Movimento de Alfabetiza&ccedil;&atilde;o (MOVA):
                            </td>
                        </tr>

                        <tr>	
                            <td colspan="2">
                                <input type="radio" name="rdoEscola" id="rdoEscola1" value="1" onclick="AbrirComboEscolaMunicipal()" >Escola da Rede Municipal Própria</br>
                            </td>
                        </tr>
                        <tr id="trEscolaMunicipal" style="display:none">
                            <td colspan="2">
                                <select  id="cboEscolaMunicipal" name="cboEscolaMunicipal"><option value=""></option></select>
                            </td>
                        </tr>
                        <tr>	
                            <td colspan="2">
                                <input type="radio" name="rdoEscola" id="rdoEscola2" value="2"  onclick="AbrirComboEscolaConveniada()">Escola da Rede Municipal Conveniada</br>
                            </td>
                        </tr>
                        <tr id="trEscolaConveniada" style="display:none">
                            <td colspan="2">
                                <select  id="cboEscolaConveniada" name="cboEscolaConveniada" ><option value=""></option></select>
                            </td>
                        </tr>
                        <tr>	
                            <td colspan="2">
                                <input type="radio" name="rdoEscola" id="rdoEscola3" value="3"  onclick="AbrirComboEscolaMova()">Entidade do Movimento de Alfabetiza&ccedil;&atilde;o (MOVA)</br>
                            </td>
                        </tr>
                        <tr id="trEscolaMova" style="display:none">
                            <td colspan="2">
                                <select  id="cboEscolaMova" name="cboEscolaMova" onchange="carregaProfMova()"><option value=""></option></select>
                            </td>
                        </tr>
                        <tr id="trProfMova" style="display:none">
                            <td colspan="2">
                                Selecione o nome do Professor: *</br>
                                <select id="cboProfMova" name="cboProfMova"></select>
                            </td>
                        </tr>

                        <tr>
                            <td></br></td>
                        </tr>

                        <tr>
                            <td>
                                Categoria
                            </td>
                        </tr>
                        <tr>	
                            <td colspan="2">
                                <input type="radio" name="rdoCategoria" class="rdoCategoria" id="rdoCategoria1" value="1">vídeo – de 0 a até 4 anos e 11 meses de idade</br>
                                    <input type="radio" name="rdoCategoria" class="rdoCategoria" id="rdoCategoria2" value="2">Desenho – de 5 anos até 07 anos e 11 meses de idade</br>
                                        <input type="radio" name="rdoCategoria" class="rdoCategoria" id="rdoCategoria3" value="3">História em Quadrinhos – de 08 anos a 14 anos e 11 meses de  idade</br>
                                            <input type="radio" name="rdoCategoria" class="rdoCategoria" id="rdoCategoria4" value="4">Slogan  – acima de 15 anos de idade</br>
                                                </td>
                                                </tr>
                                                <tr align="center">
                                                    <td></td>
                                                    <td align=right width=100%>
                                                        <input id="btnEtapa2" class="Proximo" align="middle" type="button" value="Proximo" onclick="abrirEtapa2(1)"/>
                                                    </td>
                                                </tr>			

                                                </table>
                                                </div>




                                                <!---------------------------- ETAPA 2  ------------------------------ --> 

                                                <div id="divEtapa2" style="display:none">
                                                    <div id="divTurma" style="display:none">
                                                        <h4>Etapa 2- Identifica&ccedil;&atilde;o da Turma</h4>
                                                        <table border="0">	
                                                            <tr>
                                                                <td>
                                                                    Ano: *</br>
                                                                    <select name='cboAnoTurma' id='cboAnoTurma' >
                                                                        <?php
                                                                        require_once ('../../lib/php/cmd_sql.php');

                                                                        $varConsultaTurma = lstTurma();

                                                                        foreach ($varConsultaTurma as $k => $v) {
                                                                            $varTURMA = $varConsultaTurma[$i]['IDSERIE'];
                                                                            $linha = '<option value="' . utf8_encode($v['IDSERIE']) . '">' . utf8_encode($v['SERIE']) . '</option>';
                                                                            echo $linha;
                                                                        }

                                                                        function lstTurma() {
                                                                            $sql = new cmd_SQL();
                                                                            $db ['sql'] = "SELECT * FROM AKONI_SERIE";
                                                                            $db['ret'] = "php";
                                                                            $rs = $sql->pesquisar($db);
                                                                            return $rs;
                                                                        }
                                                                        ?>												
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    Turma: *</br>
                                                                    <input type="text" id="txtNomeTurma" name="txtNomeTurma"/>	
                                                                </td>
                                                                <td>
                                                                    Qtd de Alunos: *</br>
                                                                    <input type="text" id="txtAlunosTurma" name="txtAlunosTurma"/>	
                                                                </td>
                                                            </tr>			

                                                            <tr align="center">
                                                                <td></td>
                                                                <td></td>
                                                                <td align=right width=100% colspan="1">
                                                                    <input class="Proximo" align="middle" type="button" value="Proximo" onclick="AbrirEtapa3Turma()"/>
                                                                </td>
                                                            </tr>			
                                                        </table>
                                                    </div>

                                                    <div id="divEducando" style="display:none">
                                                        <h4>Etapa 2- Identifica&ccedil;&atilde;o do(a) Educando(a)</h4>
                                                        <table border="0">
                                                            <tr>
                                                                <td>
                                                                    Nome (sem abreviaturas): *
                                                                </td>
                                                                <td colspan="2">
                                                                    <input type="text" id="txtNomeEducando" name="txtNomeEducando" style="width: 500px;"/>	
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td></br></td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    Data de Nascimento: *
                                                                </td>
                                                                <td>
                                                                    <input id="txtDtNasc" name="txtDtNasc">
                                                                </td>
                                                                <td>
                                                                    Sexo: *
                                                                    <select name="cboSexoEducando" id="cboSexoEducando" class="validate[required]">
                                                                            <option value="selecione">Selecione</option>
                                                                        <option value="0">MASCULINO</option>
                                                                        <option value="1">FEMININO</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td></br></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3">
                                                                    Como o(a) educando(a) se autodeclara: considerando as categorias do Instituto Brasileiro de Geografia e Estatística (IBGE), quanto à cor/raça/etnia, como segue:  *<br />
																			
                                                                    
                                                                    <select name="cboCorEducando" id="cboCorEducando" class="validate[required]">
                                                                        <option value="selecione">Selecione</option>
                                                                        <option value="1">BRANCO(A)</option>
                                                                        <option value="2">PRETO(A)</option>
                                                                        <option value="3">PARDO(A)</option>
                                                                        <option value="4">AMARELO(A)</option>
                                                                        <option value="5">INDIGENA</option>
                                                                    </select>
                                                                    <p><font color="#6E6E6E">Questionar o(a) educando(a) como ele(ela) se autodeclara em relação à sua cor/raça/etnia. No caso de educando(a), até 14 anos e 11 meses de idade, verificar a ficha de matrícula. </font> </p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td></br></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2">
                                                                    Cursando:* </br>
                                                                    <select name="cboCursando" id="cboCursando" class="validate[required]">
                                                                        <option value="selecione">Selecione</option>
                                                                        <option value="1">Educa&ccedil;&atilde;o Infantil</option>
                                                                        <option value="2">Ensino Fundamental</option>
                                                                        <option value="3">Educa&ccedil;&atilde;o de Jovens e Adultos</option>
                                                                        <option value="4">MOVA</option>
                                                                    </select>
                                                                </td>
                                                            </tr>					
                                                            <tr align="center">
                                                                <td align=right width=100% colspan="3">
                                                                    <input class="Proximo" align="middle" type="button" value="Proximo" onclick="AbrirEtapa3Educando()"/>
                                                                </td>
                                                            </tr>			
                                                        </table>
                                                    </div>	
                                                </div>







                                                <!---------------------------- ETAPA 3  ------------------------------ --> 
                                                <form id="frmEducador">
                                                    <div id="divEtapa3" style="display:none">
                                                        <h4>Etapa 3- Identifica&ccedil;&atilde;o do(a) Educador(a)</h4></br>
                                                        <div id="divEducador">	
                                                            <input type="hidden" id="hdnIdProf1" name="hdnIdProf[]" value=""/>

                                                            <table border="0">
                                                                <tr>
                                                                    <td>
                                                                        Nome (sem abreviaturas): *
                                                                    </td>
                                                                    <td colspan="2">
                                                                        <input type="text" id="txtNomeEducador1" name="txtNomeEducador[]" style="width: 500px;" class="validate[required]" />	
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td></br></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        Data de Nascimento: 
                                                                    </td>
                                                                    <td>
                                                                        <input id="txtDtNascEducador1" name="txtDtNascEducador[]">
                                                                    </td>	
                                                                    <td>
                                                                        Sexo: 
                                                                        <select name="cboSexoEducador[]" id="cboSexoEducador1" class="validate[required]">
                                                                            <option value='selecione'>Selecione</option>
                                                                            <option value="0">MASCULINO</option>
                                                                            <option value="1">FEMININO</option>
                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td></br></td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="3">
                                                                        Como o(a) educador(a) se autodeclara¹: considerando as categorias do Instituto Brasileiro de Geografia e Estatística (IBGE), quanto à cor/raça/etnia, como segue:  *<br />
                                                                        <select name="cboCorEducador[]" id="cboCorEducador1" class="validate[required]">
                                                                            <option value='selecione'>Selecione</option>
                                                                            <option value="1">BRANCO(A)</option>
                                                                            <option value="2">PRETO(A)</option>
                                                                            <option value="3">PARDO(A)</option>
                                                                            <option value="4">AMARELO(A)</option>
                                                                            <option value="5">INDIGENA</option>
                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>

                                                    <div id="divEtapa3Botao" style="display:none">
                                                        <table>
                                                            <tr align="center" id="trBtnEducador1">
                                                                <td align=right width=100% colspan="3">
                                                                    <input class="Mais" align="middle" type="button" value="Cadastrar outro Prof" onclick="AbrirEducador()"/>
                                                                </td>
                                                            </tr>	
                                                            <tr align="center">
                                                                <td align=right width=1000 colspan="3">
                                                                    <input class="Proximo" align="middle" type="button" value="Proximo" onclick="AbrirEtapa4()"/>
                                                                </td>
                                                            </tr>			
                                                        </table>
                                                    </div>		
                                                </form>	







                                                <!---------------------------- ETAPA 4  ------------------------------ --> 
                                                <form id="frmDescTrab" name="frmDescTrab">	
                                                    <div id="divEtapa4" style="display:none">
                                                        <h4>Etapa 4- Descri&ccedil;&atilde;o do Trabalho</h4>
                                                        <table border="0">
                                                            <tr>
                                                                <td width=20%>
                                                                    Data/ período de realiza&ccedil;&atilde;o: *
                                                                    <input type="hidden" id="hdnIdDescTrabalho" value=""/>
                                                                    <input id="txtDtRealizacao" name="txtDtRealizacao" onkeyup="contarCaract('txtDtRealizacao', 8)">
                                                                </td>
                                                                <td>
                                                                    <input class="botaotopo Mais" align="middle" type="button" value="Salvar Rascunhos" id="btnSalvarRascunho" onclick="upDateDesc()" style="display:none"/>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2">
                                                                    <h3 style="padding:0px;font-size:18px;">Objetivo: * </h3>
                                                                    <textarea id="txtObjetivo" maxlength="800" name="txtObjetivo" cols="1" rows="5" style="width:650px; height:100px;" onkeyup="contarCaract('txtObjetivo', 800)"></textarea>
                                                                    </br><p class="caract">Caracter(es):<span id="qtdtxtObjetivo">0</span>/800</p>
                                                                </td>
                                                                <td>

                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2">
                                                                    </br><h3 style="padding:0px;font-size:18px;">Ações desenvolvidas (teatro, dança, roda de conversa, pesquisa...): *  </h3>
                                                                    <textarea id="txtAcoes" name="txtAcoes" cols="1" rows="10" style="width:650px; height:100px;" onkeyup="contarCaract('txtAcoes', 800)"></textarea>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2">
                                                                    </br><h3 style="padding:0px;font-size:18px;">Recursos (livros, vídeos, músicas...): *  </h3>
                                                                    <textarea id="txtRecursos" maxlength="1500" name="txtRecursos" cols="1" rows="10" style="width:650px; height:100px;" onkeyup="contarCaract('txtRecursos', 1500)"></textarea>
                                                                    <p class="caract">Caracter(es):<span id="qtdtxtRecursos">0</span>/1500</p>
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td colspan="2">
                                                                    </br><h3 style="padding:0px;font-size:18px;">Material consultado (Referências Bibliográficas):  </h3>
                                                                    <textarea id="txtMaterial" maxlength="1500" name="txtMaterial" cols="1" rows="10" style="width:650px; height:100px;" onkeyup="contarCaract('txtMaterial', 1500)"></textarea>
                                                                    <p class="caract">Caracter(es):<span id="qtdtxtMaterial">0</span>/1500</p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2">
                                                                    </br><h3 style="padding:0px;font-size:18px;">Saberes construídos com os(as) educandos(as): *  </h3>
                                                                    <textarea id="txtSaberes" maxlength="2000" name="txtSaberes" cols="1" rows="10" style="width:650px; height:100px;" onkeyup="contarCaract('txtSaberes', 2000)"></textarea>
                                                                    <p class="caract">Caracter(es):<span id="qtdtxtSaberes">0</span>/2000</p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2"> 
                                                                    </br><h3 style="padding:0px;font-size:18px;">Impressões sobre o desenvolvimento do Trabalho [podendo incluir breve relatos dos(as) educandos(as) que revelem o processo: *  </h3>
                                                                    <textarea id="txtImpressao" name="txtImpressao" cols="1" rows="10" style="width:650px; height:100px;" onkeyup="contarCaract('txtImpressao', 800)"></textarea>
                                                                </td>
                                                            </tr>



                                                            <tr align="center">

                                                                <td align=right width=100% colspan="3" >
                                                                    <br/><input id="btnFinaliza" class="Proximo" align="middle" type="button" value="Finalizar" onclick="finalizar()"/>
                                                                </td>
                                                            </tr>			
                                                        </table>
                                                    </div>
                                                </form>


                                                </br></br>
                                                <p style="text-align: center;font-family: Arial;color: #000;">
                                                    Para mais informações, ligue para a Secretaria de Educa&ccedil;&atilde;o de Guarulhos<br /> 
                                                    Telefone (D&uacute;vidas sobre documenta&ccedil;&atilde;o): 2475-7300 - Ramal: ----<br /> 
                                                    Telefone (Problemas t&eacute;cnicos): 2475-7393 <br /> ou mande e-mail para: ----
                                                </p>
                                                </div>
                                                </div>	








                                                </body>
                                                </html>


                                                <?php

                                                function listaInscricoes() {
                                                    $sql = new cmd_SQL();
                                                    $db ['sql'] = "SELECT DISTINCT AI.CPF, AI.IDINSCRICAO,
																	(CASE WHEN AT.IDCATEGORIA=1 THEN ASE.SERIE||'-'||ATT.NOME_TURMA 
																	WHEN AT.IDCATEGORIA IN (2,3,4) THEN ATE.NOME ELSE ''END) AS EDUCANDO_TURMA,
																	AC.CATEGORIA,AI.STATUS
																	FROM AKONI_INSCRICAO AI
																	LEFT JOIN AKONI_TRABALHO AT
																	ON AT.IDINSCRICAO=AI.IDINSCRICAO
																	LEFT JOIN AKONI_TRAB_EDUCANDO ATE
																	ON ATE.IDTRABALHO=AT.IDTRABALHO
																	LEFT JOIN AKONI_TRAB_TURMA ATT
																	ON ATT.IDTRABALHO=AT.IDTRABALHO
																	LEFT JOIN AKONI_CATEGORIA AC
																	ON AC.IDCATEGORIA=AT.IDCATEGORIA
																	LEFT JOIN AKONI_SERIE ASE
																	ON ASE.IDSERIE=ATT.IDSERIE
																	WHERE AI.CPF= '" . $_GET['txtCPFResponsavel'] . "' ORDER BY AI.IDINSCRICAO";
                                                    $db['ret'] = "php";
                                                    return $sql->pesquisar($db);
                                                }
                                                ?>