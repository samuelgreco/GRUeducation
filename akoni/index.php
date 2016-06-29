<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <title>Akoni</title>
        <link href="css/estilo.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="css/style.css" />
        <link rel="stylesheet" type="text/css" href="../lib/css/estilo.css" />

        <script src="../lib/js/jquery-1.9.1.js" type="text/javascript"></script>
        <script type="text/javascript" src="../lib/js/ajax.js"></script>
        <script type="text/javascript" src="../lib/js/select.js"></script>
        <script type="text/javascript" src="../lib/js/objeto.js"></script>
        <script type="text/javascript" src="../lib/js/funcoes.js"></script>
        <script type="text/javascript" src="js/informacoes.js"></script>
    </head>
    <body onload="iniciar()">
        <div id="tela">
            <div id="banner"></div>

            <div class="barra_menu">
                <div class="menu">
                    <ul>
                        <li><a href="index.php">Início</a></li>
                        <?php
                        require_once ("../lib/php/cmd_sql.php");

                        $varTravas = ConsultaTravas();

                        if ($varTravas[0]["INSCRICAO"] == 1) {
                            echo '<li><a href="formularios/inscricao.php">Inscrição</a></li>';
                        }
                        if ($varTravas[0]["SITUACAO"] == 1) {
                            echo '<li><a href="formularios/situacao.php">Situação da inscrição</a></li>';
                        }
                        if ($varTravas[0]["PUBLICACAO"] == 1) {
                            echo '<li><a href="formularios/publicacao.php">Editais e publicações</a></li>';
                        }

                        function ConsultaTravas() {
                            $sql = new cmd_SQL();
                            $bd['sql'] = "SELECT * FROM AKONI_TRAVA";
                            $bd['ret'] = "php";
                            $rs = $sql->pesquisar($bd);

                            return $rs;
                        }
                        ?>
                        <li style="float: right;font-size:9px;"><a href="login.html"><img src="images/lock.png" style="width: 10px;" />&nbsp;Acesso restrito</a></li>
                    </ul>
                </div>
            </div>

            <div id="tela_camp">
                <div id="cabeçario">
                    <h1 style="padding:0px;font-size:22px;">Bem-vindo ao sistema do 5º Prêmio AKONI de Promoção da Igualdade Racial</h1>
                </div>

                <div id="tela_ajuda">
                    <h2 style="padding:0px;font-size:18px;">Últimas informações</h2>

                    <div id="lstNoticias"></div>

                    <br /><br />
                    <p style="text-align: center;font-family: Arial;color: #000;">
                        Para mais informações, ligue para a Secretaria de Educação de Guarulhos<br />
                        Telefone (D&uacute;vidas sobre documenta&ccedil;&atilde;o): 2475-7300 - Ramal: ----<br />
                        Telefone (Problemas t&eacute;cnicos): 2475-7393 <br /> ou mande e-mail para: ----
                    </p>
                </div>
            </div>

            <div id="rodape">
                <div id="rodape_texto">Secretaria Municipal de Educação de Guarulhos</div>
            </div>
        </div>
    </body>
</html>
