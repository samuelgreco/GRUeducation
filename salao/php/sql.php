<?php
session_start();

$qtde = (substr_count($_SERVER['SCRIPT_NAME'], '/') - 2);
$urlRaiz = "";
for ($i = 0; $i < $qtde; $i++) {
    $urlRaiz .= "../";
}

//require_once 'cmd_sql.php';

//require_once $urlRaiz . '../lib/php/cmd_sql.php';
/* echo "<pre>acsa";
  print_r($this->bd);
  echo "</pre>";
  exit; */
class sql {

    private $cmdSql;
    private $bd;
    private $conn;
    private $request;
    private $response;

    public function __construct() {
        $this->getConexao();        
        $this->bd['ret'] = "xml";

        if ($_SESSION['varID'] > 0) {
            $this->request['txtID'] = $_SESSION['varID'];
            $_SESSION['varID']=null;
        }
        switch ($this->request["filtro"]) {
            case "carregarArquivo":
                $this->response = $this->carregarArquivo();
                break;
            case 'CarregarInscricao' :
                $this->response = $this->CarregarInscricao();
                break;
            case 'VerificaInscricao' :
                $this->response = $this->VerificaInscricao();
                break;
            case 'VerificaVagas' :
                $this->response = $this->VerificaVagas();
                break;
            case 'VerificaVagasOnibus' :
                $this->response = $this->VerificaVagasOnibus();
                break;
            case 'VerificaOnibus' :
                $this->response = $this->VerificaOnibus();
                break;
            case 'CarregaHorario' :
                $this->response = $this->CarregaHorario();
                break;
            case 'CarregaTipoDependencia' :
                $this->response = $this->CarregaTipoDependencia();
                break;
            case 'CarregaEscolaCombo' :
                $this->response = $this->CarregaEscolaCombo();
                break;
            case 'CarregaEscola' :
                $this->response = $this->CarregaEscola();
                break;
            case 'CarregaEscolaID' :
                $this->response = $this->CarregaEscolaID();
                break;
            case 'CarregaEscolaNome' :
                $this->response = $this->CarregaEscolaNome();
                break;
            case 'Login' :
                $this->response = $this->Login();
                break;
            case 'IncricaoOnibus' :
                $this->response = $this->IncricaoOnibus();
                break;
            default:
                break;
        }
        
        unset($_SESSION['varID']);
    }

    public function CarregarInscricao() {
        $this->bd['sql'] = "SELECT i.idinscricao, i.vagas, date_format(h.data,'%d/%m/%Y') as data, data as dataPesquisa, h.horaInicio, h.horaFim, i.tipo, e.idtipo_dependencia, i.onibus 
					        FROM inscricao i INNER JOIN horario h USING (idHorario) 
					        INNER JOIN escola e ON e.idEscola=i.escola 
					        where i.escola = " . $this->request['cboEscola'] . " order by dataPesquisa, h.horaInicio, h.horaFim";
    
        return $this->cmdSql->pesquisar($this->bd);
    }

    public function VerificaInscricao() {
        $this->bd['sql'] = "SELECT i.idinscricao, i.vagas, i.estagio_1, i.estagio_2, i.ano_1, i.ano_2, i.ano_3, i.ano_4, i.ano_5, i.tipo, e.idtipo_dependencia, i.onibus 
					        FROM inscricao i 
					        INNER JOIN escola e ON e.idEscola=i.escola 
                            where idinscricao=" . $this->request['idinscricao'];
    
        return $this->cmdSql->pesquisar($this->bd);
    }

    public function VerificaVagas() {
        $this->bd['sql'] = "SELECT IF(SUM(i.vagas) IS NULL, 0, SUM(i.vagas)) as qtde, h.vagas, IF(h.vagas-sum(i.vagas) IS NULL, h.vagas, h.vagas-sum(i.vagas)) as disponivel FROM HORARIO h
					        LEFT JOIN INSCRICAO i ON(h.idhorario = i.idhorario)
					        WHERE h.idhorario = " . $this->request['txtID'] . " GROUP BY h.idhorario";
    
        return $this->cmdSql->pesquisar($this->bd);
    }

    public function VerificaVagasOnibus() {
        $this->bd['sql'] = "SELECT IF(COUNT(i.vagas) IS NULL, 0, COUNT(i.vagas)) as qtde, h.vagas, IF(h.vagas-COUNT(i.vagas) IS NULL, h.vagas, h.vagas-COUNT(i.vagas)) as disponivel FROM HORARIO h
					        LEFT JOIN INSCRICAO i ON(h.idhorario = i.idhorario)
					        WHERE h.idhorario = " . $this->request['txtID'] . " GROUP BY h.idhorario";
    
        return $this->cmdSql->pesquisar($this->bd);
    }

    public function VerificaOnibus() {
        $this->bd['sql'] = "SELECT count(i.vagas) as qtde
					        FROM inscricao i 
					        inner join horario h on h.idhorario=i.idhorario 
					        where i.escola=" . $this->request['txtID'] . " and i.tipo=" . $this->request['txtTipo'] . "
					        group by i.tipo";
    
        return $this->cmdSql->pesquisar($this->bd);
    }

    public function CarregaHorario() {
        $this->bd['sql'] = "SELECT idHorario, date_format(data,'%d/%m/%Y') as data, horaInicio, horaFim, idtipo_dependencia, vagas FROM horario where idHorario = " . $this->request['txtID'];
        //return $this->cmdSql->pesquisar($this->bd);
        return $this->cmdSql->pesquisar($this->bd);
    }

    public function CarregaEscolaCombo() {
        $this->bd['sql'] = "SELECT * FROM escola order by nome";
        return $this->cmdSql->pesquisar($this->bd);
    }

    public function CarregaTipoDependencia() {
        $this->bd['sql'] = "SELECT * FROM tipo_dependencia order by descricao";
        return $this->cmdSql->pesquisar($this->bd);
    }

    public function CarregaEscola() {
        $this->bd['sql'] = "SELECT * FROM escola where idEscola = " . $this->request['txtID'];
        return $this->cmdSql->pesquisar($this->bd);
    }

    public function CarregaEscolaID() {
        $this->bd['sql'] = "SELECT * FROM escola where idEscola = " . $this->request['txtID'];
        return $this->cmdSql->pesquisar($this->bd);
    }

    public function CarregaEscolaNome() {
        $this->bd['sql'] = "SELECT * FROM escola where nome = '" . mb_strtoupper(utf8_decode($this->request['txtNome'])) . "'";
        return $this->cmdSql->pesquisar($this->bd);
    }

    public function Login() {
        $this->bd['sql'] = "SELECT * FROM escola where login = '" . utf8_decode($this->request["txtNome"]) . "' and senha = '" . utf8_decode($this->request["txtSenha"]) . "'";
        return $this->cmdSql->pesquisar($this->bd);
    }

    public function IncricaoOnibus() {
        $this->bd['sql'] = "SELECT * FROM inscricao where onibus = " . $this->request["onibus"] . " and tipo = " . $this->request["tipo"] . " and escola = " . $_SESSION["ID"];
        return $this->cmdSql->pesquisar($this->bd);
    }
    
     public function getConexao() {
        $this->request = $_POST;
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $this->request = $_GET;
        }

        
        require_once("../../lib/php/cmd_sql.php");
        $this->cmdSql = new cmd_SQL();
        require_once("../../lib/php/bd_pdo.php");
        $banco = new Banco();
        $this->conn = $banco->conectar($bd);
//echo "<hr />aATTR_CONNECTION_STATUS: ".$this->conn."<hr />";exit;
    }

}
$sql = new sql();
?>