<?php
session_start();
$class = new relListaGerencial ();
/*
 * $varConteudo = ConsultaConteudo ( $id ); $varDataPost = $_POST["txtDt"]; $varConteudo = ConsultaConteudo();
 */
?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
    <head>
        <meta http-equiv='Content-Type' content='text/html' charset='utf-8' />
        <meta name='keywords'
              content='fixed table header; non-scroll header; freeze header; print repeating headers'>


            <title>Relat&oacute;rio</title>
            <link type='text/css' rel='stylesheet' href='../../lib/css/estilo.css' />
            <link type='text/css' rel='stylesheet' href='../css/estiloTabela.css' />
            <link type='text/css' rel='stylesheet' href='../css/estilo(2).css' />
            <script type='text/javascript' src='../../lib/js/jquery-1.9.1.js'></script>
            <script type='text /javascript' src='../js /exportarexcel.js '> </script>
            <script type='text /javascript'
                    src='../js /src/jquery.table2excel.js 
            '> </script>
            <style type=text/css media='print'>
                #landscape {
                    writing-mode: tb-rl;
                    height: 80%;
                    margin: 10% 0%;
                }

                .Imprimir, .Voltar {
                    visibility: hidden;
                }

                .par {
                    background-color: #CCCCCC;
                    font: 12px verdana, arial, helvetica, sans-serif;
                    color: #666666;
                    border: 1px solid #000000;
                    border-bottom-style: outset;
                    margin-top: 7px;
                    margin-right: 15px;
                    height: 24px;
                    width: auto;
                }

                .impar {
                    background-color: white;
                    font: 12px verdana, arial, helvetica, sans-serif;
                    color: #666666;
                    border: 1px solid #000000;
                    border-bottom-style: outset;
                    margin-top: 7px;
                    margin-right: 15px;
                    height: 24px;
                    width: auto;
                }

                .tabela {
                    background-color: #CCCCCC;
                    font: 14px verdana, arial, helvetica, sans-serif;
                    color: black;
                    border: 1px solid #CCCCCC;
                    border-bottom-style: outset;
                    width: auto;
                }

                .corpo {
                    font: 12px verdana, arial, helvetica, sans-serif;
                    margin-top: 7px;
                    margin-right: 15px;
                    width: auto;
                }
            </style>

    </head>
    <body>
        <a href='javascript:history.back(1)' class='Voltar'>Voltar</a>
        <a href='#' onclick='window.print();' class='Imprimir' style='left: 85%; position: absolute;' title='Imprimir'>Imprimir</a>        
        <table width='90%'>
            <tr>
                <td width=140><div align=center>
                        <img src='../../lib/images/logo_sem_fundo.png' width="123%" />

                    </div></td>
                <td class=corpo width=1890 height=38><center>
                        <h1 style='text-align: center;'></h1>
                    </center>
                    <div style='margin-left: 28%'>
                        <h1>Quantidade de alunos inscritos por ano</h1>
                    </div>

            </tr>
        </table>
        <div id='tbGerencial' name='tbGerencial'>
            <table width='100%' id='listachamados' class='CSSTabela'>                
                <tbody>
                    <?php
                    $i = 0;
                    $cont = 0;

// $varConteudoR = ConsultaListaReserva($idTurma);
// $varConteudoD = ConsultaListaDesistente($idTurma);
                    $somasDoDia = array('estagio_1' => 0, 'estagio_2' => 0, 'ano_1' => 0, 'ano_2' => 0, 'ano_3' => 0, 'ano_4' => 0, 'ano_5' => 0, 'EJA' => 0);

                    foreach ($class->lst as $k => $v) {
                        /*
                          echo "<pre>";
                          print_r($somasDoDia);
                          echo "</pre>";
                         */
                        if ($dtAtual != $v ['data']) {
                            if ($k > 0) {
                                ?>
                                <!-- TOTAL DO DIA -->
                                <tr>
                                    <td class="tabela" style="background-color: #0057af;text-align:right;" colspan="2">
                                        <b style='color: white; font-size: 14px;'>
                                            Total/dia
                                        </b>
                                    </td>                                    
                                    <td class="tabela"><b><?= $somasDoDia['estagio_1'] ?></b></td>
                                    <td class="tabela"><b><?= $somasDoDia['estagio_2'] ?></b></td>
                                    <td class="tabela"><b><?= $somasDoDia['ano_1'] ?></b></td>
                                    <td class="tabela"><b><?= $somasDoDia['ano_2'] ?></b></td>
                                    <td class="tabela"><b><?= $somasDoDia['ano_3'] ?></b></td>
                                    <td class="tabela"><b><?= $somasDoDia['ano_4'] ?></b></td>
                                    <td class="tabela"><b><?= $somasDoDia['ano_5'] ?></b></td>
                                    <td class="tabela"><b><?= $somasDoDia['EJA'] ?></b></td>
                                    <td class="tabela" style="background-color:#F0FFFF;"><b><?= $class->getSomaDaHr($somasDoDia) ?></b></td>
                                </tr>
                                <?php
                                $somasDoDia = array('estagio_1' => 0, 'estagio_2' => 0, 'ano_1' => 0, 'ano_2' => 0, 'ano_3' => 0, 'ano_4' => 0, 'ano_5' => 0, 'EJA' => 0);
                                $varSomaDia = "0";
                            }
                            ?>

                            <!-- ==================================================== -->
                            <tr>
                                <th colspan="11"
                                    style="background: none; border: none; text-align: center;">
                                    <h1 style="text-align: center;"><?= $v['data'] ?></h1>
                                </th>
                            </tr>
                            <!-- CABECALHO DA LINHA -->
                            <tr>
                                <th class="tabela">Data</th>
                                <th class="tabela">Hora ini.</th>
                                <th class="tabela">Est&aacute;gio 1</th>
                                <th class="tabela">Est&aacute;gio 2</th>
                                <th class="tabela">1&ordm;ano</th>
                                <th class="tabela">2&ordm;ano</th>
                                <th class="tabela">3&ordm;ano</th>
                                <th class="tabela">4&ordm;ano</th>
                                <th class="tabela">5&ordm;ano</th>
                                <th class="tabela">EJA</th>
                                <th class="tabela">Total inscritos</th>
                            </tr>
                            <?php
                            //$somasDoDia = array('estagio_1' => 0,'estagio_2' => 0,'ano_1' => 0,'ano_2' => 0,'ano_3' => 0,'ano_4' => 0,'ano_5' => 0,'EJA' => 0);                                                
                        }
                        $somasDoDia = $class->getSomaDoDia($somasDoDia, $v);
                        $dtAtual = $v ['data'];
                        ?>
                        <!-- CONTEUDO -->
                        <tr>
                            <td class="<?= $cor ?>"><?= $v['data'] ?></td>
                            <td class="<?= $cor ?>"><?= $v['horainicio'] ?></td>
                            <td class="<?= $cor ?>"><?= $v['estagio_1'] ?></td>
                            <td class="<?= $cor ?>"><?= $v['estagio_2'] ?></td>
                            <td class="<?= $cor ?>"><?= $v['ano_1'] ?></td>
                            <td class="<?= $cor ?>"><?= $v['ano_2'] ?></td>
                            <td class="<?= $cor ?>"><?= $v['ano_3'] ?></td>
                            <td class="<?= $cor ?>"><?= $v['ano_4'] ?></td>
                            <td class="<?= $cor ?>"><?= $v['ano_5'] ?></td>
                            <td class="<?= $cor ?>"><?= $v['EJA'] ?></td>
                            <td class="<?= $cor ?>"><?= $class->getSomaDaHr($v) ?></td>
                        </tr>
                        <?php
                        /*
                          $varSomaDia = $somas['estagio_1'] + $somas['estagio_2'] + $somas['ano_1'] + $somas['ano_2'] + $somas['ano_3'] + $somas['ano_4'] + $somas['ano_5'] + $somas['EJA'];
                          $somatotal += $varSoma;
                          $varSomaDia = $somas['estagio_1'] + $somas['estagio_2'] + $somas['ano_1'] + $somas['ano_2'] + $somas['ano_3'] + $somas['ano_4'] + $somas['ano_5'] + $somas['EJA'];

                         */
                    }
                    ?>
                    <!-- TOTAL DO DIA -->
                    <tr>
                        <td class=tabela colspan='2' style='background-color: #0057af;text-align:right'>
                            <b style='color: white; font-size: 14px;'> Total/dia </b>
                        </td>                        
                        <td class="tabela"><b><?= $somasDoDia['estagio_1'] ?></b></td>
                        <td class="tabela"><b><?= $somasDoDia['estagio_2'] ?></b></td>
                        <td class="tabela"><b><?= $somasDoDia['ano_1'] ?></b></td>
                        <td class="tabela"><b><?= $somasDoDia['ano_2'] ?></b></td>
                        <td class="tabela"><b><?= $somasDoDia['ano_3'] ?></b></td>
                        <td class="tabela"><b><?= $somasDoDia['ano_4'] ?></b></td>
                        <td class="tabela"><b><?= $somasDoDia['ano_5'] ?></b></td>
                        <td class="tabela"><b><?= $somasDoDia['EJA'] ?></b></td>
                        <td class="tabela"><b><?= $class->getSomaDaHr($somasDoDia) ?> </b></td>
                    </tr>                    
                    <tr>

                        <th colspan="11" style="background: none; border: none;"><br /></th>
                    </tr>

                </tbody>
            </table>
        </div>

        <br />
        <br><br><div class="data" style='text-align: center'>Relat&oacute;rio gerado em <?php echo date("d/m/Y H:i:s") ?></div>

                </body>
                </html>

                <?php

                class relListaGerencial {

                    public $lst;
                    public $request;
                    public $sql;

                    public function __construct() {
                        /*
                         * echo "<hr /><pre>"; print_r($this->request); echo "</pre><HR />"; exit;
                         */
                        $this->iniciar($param);
                        $this->getDados($param);
                    }

                    public function getSomaDaHr($v) {
                        return $v['estagio_1'] + $v['estagio_2'] + $v['ano_1'] + $v['ano_2'] + $v['ano_3'] + $v['ano_4'] + $v['ano_5'] + $v['EJA'];
                    }

                    public function getSomaDoDia($somas, $v) {
                        $somas ['estagio_1'] += $v ['estagio_1'];
                        $somas ['estagio_2'] += $v ['estagio_2'];
                        $somas ['ano_1'] += $v ['ano_1'];
                        $somas ['ano_2'] += $v ['ano_2'];
                        $somas ['ano_3'] += $v ['ano_3'];
                        $somas ['ano_4'] += $v ['ano_4'];
                        $somas ['ano_5'] += $v ['ano_5'];
                        $somas ['EJA'] += $v ['EJA'];
                        return $somas;
                    }

                    private function getDados($param) {
                        $varDT = explode('/', $_POST ["txtDt"]);
                        $varDT = $varDT [2] . '-' . $varDT [1] . '-' . $varDT [0];
                        $varDTT = $varDT;
                        $campos = "DATE_FORMAT(data,'%d/%m/%Y') AS data,horainicio,hr.vagas,sum(estagio_1) AS estagio_1,sum(estagio_2) AS estagio_2,sum(ano_1) AS ano_1";
                        $campos .= ",sum(ano_2) AS ano_2,sum(ano_3) AS ano_3,sum(ano_4) AS ano_4,sum(ano_5) AS ano_5,idtipo_dependencia,case WHEN tipo=2 then sum(i.vagas) end as EJA";
                        $bd ['sql'] = "SELECT " . $campos . " FROM salaolivro.inscricao i inner join salaolivro.horario hr on (i.idHorario = hr.idHorario)";

                        if ($varDT == '--') {
                            $bd ['sql'] .= " group by data,horainicio";
                        } else {
                            $bd ['sql'] .= " where data = '" . $varDT . "' group by data,horainicio";
                        }
                        // echo $bd ['sql']; exit ();
                        require_once ("../php/cmd_sql.php");
                        // require_once ("../../lib/php/cmd_sql.php");
                        $bd ['ret'] = "php";
                        $sql = new cmd_SQL ();
                        $this->lst = $sql->pesquisar($bd);
                    }

                    private function iniciar($param) {
                        $this->request = $_POST;
                        if ($_SERVER ["REQUEST_METHOD"] == "GET") {
                            $this->request = $_GET;
                        }
                    }

                }
                ?>