<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: *');

require_once "vendor/econea/nusoap/src/nusoap.php";
$namespace = "miSoapService";
$server = new soap_server();
$server->configureWSDL("ServiceSOAP", $namespace);
$server->wsdl->schemaTargetNamespace = $namespace;

$server->wsdl->addComplexType(
    'ordenDeCompra',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'NumeroOrden' => array('name' => 'NumeroOrden', 'type' => 'xsd:string'),
        'Ordenante' => array('name' => 'Ordenante', 'type' => 'xsd:string')
    )
);
$server->wsdl->addComplexType(
    'helpers',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'FromCurrency' => array('name' => 'FromCurrency', 'type' => 'xsd:string'),
        'ToCurrency' => array('name' => 'ToCurrency', 'type' => 'xsd:string'),
        'Amount' => array('name' => 'Amount', 'type' => 'xsd:decimal')
    )
);

$server->wsdl->addComplexType(
    'response',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'status' => array('name' => 'Resultado', 'type' => 'xsd:boolean'),
        'response' => array('name' => 'NumeroDeAutorizacion', 'type' => 'xsd:string')
    )
);

$server->register(
    'guardarOrdenDeCompra',
    array('name' => 'tns:ordenDeCompra'),
    array('name' => 'tns:response'),
    $namespace,
    false,
    'rpc',
    'encoded',
    'Recibe una orden de compra y regresa un número de autorización'
);
$server->register(
    'priceDollar',
    array('name' => 'tns:helpers'),
    array('name' => 'tns:response'),
    $namespace,
    false,
    'rpc',
    'encoded',
    'returns the current price of the dollar'
);
function guardarOrdenDeCompra($request)
{
    return array(
        "status" => true,
        "response" => "La orden de compra " . $request["NumeroOrden"] . " ha sido autorizada con el número " . rand(10000, 100000),

    );
}
function priceDollar($request)
{
    $ToCurrency = $request["ToCurrency"];
    $FromCurrency = $request["FromCurrency"];
    $Amount = $request["Amount"];
    $url = "https://api.apilayer.com/exchangerates_data/convert?to=$ToCurrency&from=$FromCurrency&amount=$Amount";

    $opts = array(
        'http' => array(
            'method' => "GET",
            'header' => "apikey:giXiJDVeT1pV1ut0MJsdbSAIM480ZpMM"
        )
    );

    $context = stream_context_create($opts);
    $response = file_get_contents($url, false, $context);
    $json = json_decode($response);
    if (!$json->success) {
        return array(
            "status" => false,
            "response" => "Out of service"
        );
    }
    return array(
        "status" => true,
        "response" => $json->result
    );
}


$POST_DATA = file_get_contents("php://input");
$server->service($POST_DATA);
exit();
