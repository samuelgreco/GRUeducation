<?php
header("Content-type: application/xml;charset=UTF-8");

$cep = $_POST['cep'];
$num = $_POST['num'];

switch($_POST['filtro']){
	case 'CarregaEndereco':
		$retorno = CarregaEndereco($cep);
		break;
	case 'CarregaCoordenadas':
		$retorno = CarregaCoordenadas($cep, $num);
		break;
	default:
		break;
}

//print_r($retorno);
$xml = new SimpleXMLElement("<?xml version=\"1.0\"?><linha></linha>");
array_to_xml($retorno,$xml);
print $xml->asXML();

function CarregaEndereco($cep){
	try {
		$client = new SoapClient(null, array(
				'uri' =>"http://webgeo.guarulhos.sp.gov.br/WebService/Geo.php",
				'location' =>"http://webgeo.guarulhos.sp.gov.br/WebService/Geo.php"
		));
		$retorno = $client->consultarEndereco($cep);
		$retorno['n_reg']=1;
	} catch (Exception $e) {
		$retorno['n_reg']=0;
	}
	
	return $retorno;
}

function CarregaCoordenadas($cep, $num){
	try {
		$client = new SoapClient(null, array(
				'uri' =>"http://webgeo.guarulhos.sp.gov.br/WebService/Geo.php",
				'location' =>"http://webgeo.guarulhos.sp.gov.br/WebService/Geo.php"
		));
		$retorno = $client->consultarDadosGeo($cep, $num);
		$retorno['uf']="SP";
		$retorno['n_reg']=1;
		
		try {
			$client = new SoapClient(null, array(
					'uri' =>"http://webgeo.guarulhos.sp.gov.br/WebService/Geo.php",
					'location' =>"http://webgeo.guarulhos.sp.gov.br/WebService/Geo.php"
			));
			$res = $client->consultarEndereco($cep);
			$retorno['cidade']=$res['cidade'];
		} catch (Exception $e) {
			$retorno['n_reg']=0;
		}
	} catch (Exception $e) {
		$retorno['n_reg']=0;
	}
	
	return $retorno;
}

function array_to_xml($retorno, &$xml) {
	foreach($retorno as $key => $value) {
		if(is_array($value)) {
			$key = is_numeric($key) ? "item$key" : $key;
			$subnode = $xml->addChild("$key");
			array_to_xml($value, $subnode);
		}else{
			$key = is_numeric($key) ? "item$key" : $key;
			$xml->addChild(trim("$key"),trim("$value"));
		}
	}
}
?>