<?php
$qtd_registros = null;
require_once("bd_pdo.php");
require_once("dadosconectabanco.php");

class cmd_SQL
{

	//||||||||||||| COMANDOS DE SQL PARA OPERAÇÕES B�?SICAS |||||||||||||||||||||
	//++++++++++++++++++++++++++ PESQUISAR ++++++++++++++++++++++++++
	public function pesquisar($db){
		$msg=false;$retorno="";
		$banco = new Banco();
		$con = $banco->conectar($db);




    if ($con)
    {try
    {
    	// variável $sql recebe a montagem (string sql) da função prepara_sql
    	//$sql = $this->$db[sql];
    	// prepara a string $sql na PDO
    	//$rs= new PDOStatement();

    	$rs=$con->prepare($db['sql'], array());
    	$rs->execute();
    	// variável $res recebe o resultado PDO da execução sql, em forma de matriz
    	$res = $rs->fetchAll();
    	// confirma se $res é uma matriz mesmo

    	if (is_array($res)){
    		// escolhe o tipo de retorno solicitado (txt/xml/pdf/email)
    		// A instrução switch decide qual a função de retorno montará a resposta
    		switch ($db['ret']) {
    			case 'txt':
    				$retorno = $this->extrai_array_txt($res);
    				break;
    			case 'xml':
    				$retorno = $this->extrai_array_xml($res,$rs->rowCount());
    				break;
    			case 'php':
    				return $res;
    				break;
    			case 'recordset':
    				return $rs;
    				break;
    		}
    	}
    	else
    	{
    		//Mensagem alertando que não se trata de um array
    		$msg = "o recordset não é array";
    		// se o retorno solicitado é xml, montar a msg como xml
    		//if ($db['ret']=='xml')$msg .= "<reg> $msg </reg>";
    	}
    	//Se o retorno solicitado for xml, montar o delimitador xml de linha
    	/*if ($db['ret']=='xml'){$retorno .= "<reg> $linha </reg>";}else {
    	 //Senão, montar o delimitador txt de linha
    	 $retorno .= "|| $linha ||";}*/
    }
    catch (Exception $e)
    {
    	$msg = "Erro: Código: " . $e->getCode() . "Mensagem " . $e->getMessage();
    	//if ($db['ret']=='xml')$msg .= "<reg> $msg </reg>";
    }
    }else{
    	// se o retorno estiver nulo, retorno será a mensagem capturada
    	if (!$retorno) $retorno = $msg;
    }
    // se o retorno solicitado foi xml, codificar o charset_xml e abrir como como utf-8
    if ($db['ret']=='xml'){
    	$retorno = "<?xml version='1.0' encoding='utf-8' ?>"."<reg>".$retorno."</reg>";
    	header("Content-type: application/xml;charset=UTF-8");}
    	echo $retorno;
    	$con=null;
	}
	//++++++++++++++++++++++++++ INCLUIR ++++++++++++++++++++++++++
	public function incluir($db){

		$banco = new Banco();$retorno="";
		$con = $banco->conectar($db);

		if ($con != false)
		{
			try {
				$sql = "INSERT INTO ". $db['tab']."(".$db['campos'].") VALUES (".$db['values'].")";
				//echo $sql; exit;
				$res = $con->prepare($sql);
				$res->execute();
				return true ;
			}
			catch (Exception $e)
			{
				$msg = "Erro de inclusão: Código: " . $e->getCode() . "Mensagem " . $e->getMessage();
				$msg .= "<reg> $msg </reg>";
			}
		}else{
			if (!$retorno) $retorno = $msg;
		}
		$con=null;
		echo $retorno;
	}
	//++++++++++++++++++++++++++ ALTERAR ++++++++++++++++++++++++++
	public function alterar($db){

		$banco = new Banco();$sql="";
		$con = $banco->conectar($db);

		if ($con){
			try{
				$sql = $db['sql'];
				$res = $con->prepare($sql);
				$res->execute();
				unset($con);
				return true ;
			}
			catch (Exception $e)
			{
				$msg = "Erro: Código: " . $e->getCode() . "Mensagem " . $e->getMessage();
				$msg .= "<reg> $msg </reg>";
			}
		}else{
			if (!$retorno) $retorno = $msg;
		}
		$con=null;
		echo $retorno;		}
		//++++++++++++++++++++++++++ EXCLUIR ++++++++++++++++++++++++++
		public function excluir($db){
			$banco = new Banco();
			$con = $banco->conectar($db);
			if ($con)
			{
				try {
					$sql = "DELETE FROM ". $db['tab']." WHERE ".$db['cond'];
					$res = $con->prepare($sql);
					$res->execute();
					$retorno = 'exclusão efetuada com sucesso"';
					$con=null;
					return $retorno;}
					catch (Exception $e)
		   {
		   	$msg = "Erro: Código: " . $e->getCode() . "Mensagem " . $e->getMessage();
		   	$msg .= "<reg> $msg </reg>";
		   }
			}else{
				if (!$retorno) $retorno = $msg;
			}
			$retorno = "<?xml version='1.0' encoding='utf-8' ?>". $retorno;
			header("Content-type: application/xml;charset=UTF-8");
			echo $retorno;		}
			//++++++++++++++++++++++++++ PREPARA DADOS P/ A PESQUISA ++++++++++++++++++++++++++

			public function extrai_array_xml($res,$nreg)
			{
				$linha="";$col="";
				// conta a qtde de elementos da matriz
				$n_el   = count($res);
				$el_atual = 0;
				// EXTRAI A MATRIZ DA DIMENSÃO 0 P/ A DIMENSÃO 1
				foreach ($res as $k1=>$v1) //
				{

					if (is_array($v1))
					{
						$n_elem = count($v1);$elem_atual = 0;$mod=0;
						// EXTRAI A MATRIZ DA DIMENSÃO 1 P/ A DIMENSÃO 2
						foreach ($v1 as $k2=>$v2)
						{

							if (($mod%2)==0)
							{
								$v2 = utf8_encode($v2);
								$col .= "<$k2>$v2</$k2>";
							}
							$elem_atual++; $mod++; if ($elem_atual>$n_elem)break;
						}
					}
					else
					{
						echo $k1 . "<br>";
						$v1= utf8_encode($v1);
						$col .= "<$k1>$v1</$k1>";
					}
					$linha .= "<linha>$col</linha>";$col=null;
					$el_atual++;
					//$n = $res->rowCount(); echo $n; exit;
					//	echo $linha."<br>"; //LINHA SÓ P/ TESTE
					if ($el_atual>$n_el){break;}
				}
				//teste_xml($linha); //LINHA SÓ PARA TESTE
				$linha .="<n_reg>$el_atual</n_reg>";
				return $linha;
				$con=null;
			}

			public function extrai_array_txt($res)
			{
				$n_el = count($res);$el_atual = 0;
				foreach ($res as $k1=>$v1)
				{
					if (is_array($v1))
					{
						$n_elem = count($v1);$elem_atual = 0;$mod=0;
						foreach ($v1 as $k2=>$v2)
						{
							if (($mod%2)==0)
							{

								$col .= "�ci".$k2."�cf".$v2."�ci".$k2."�cf";
							}
							$elem_atual++; $mod++; if ($elem_atual>$n_elem)break;
						}
					}
					else
					{
						$col .= "�li".$k1."�lf".$v1."�li".$k1."�lf";
					}
					$linha .= "�d_i".$col."�d_f";$col=null;
					$el_atual++;
					if ($el_atual>$n_el){break;}
				}
				//echo $linha; exit;
				return $linha;
				$con=null;
			}

}

