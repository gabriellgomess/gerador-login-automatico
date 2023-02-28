<?php

// Este script tem como função receber a requisição http e descriptografar os dados enviados como parâmetro GET chamado "data".
// Após descriptografar os dados, o script inclui o arquivo api-portal.php e chama a função consultar do objeto PortalCobranca.
// A função consultar recebe como parâmetro o sale_id e o cpf do cliente e retorna os dados do cliente em formato JSON.
// O script retorna a saída da função consultar.


//Permitir acesso de origens, métodos e cabeçalhos específicos
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//Define o caminho para o arquivo de conexão

include("/var/www/html/sistema/sistema/connect_seguro.php");

//Recebe os dados enviados como parâmetro GET chamado "data"
$received_data = $_GET['data'];


//Chave secreta utilizada para descriptografar os dados
$secret_key = "update2023";

//Descriptografa os dados usando a chave secreta e o algoritmo aes-256-cbc
list($encrypted_data, $iv) = explode('::', base64_decode($received_data), 2);
$data_string = openssl_decrypt($encrypted_data, 'aes-256-cbc', $secret_key, 0, $iv);

//Decodifica os dados descriptografados como JSON
$data = json_decode($data_string, true);

//Extrai o sale_id e cpf do objeto JSON
$sale_id = $data['sale_id'];
$cpf = $data['cpf'];

//Incluir arquivo api-portal.php
include('api-portal.php');

//Cria objeto PortalCobranca e chama a função consultar
$portalCobranca = new PortalCobranca($con);
$busca_dados_cliente = $portalCobranca->consultar($sale_id, $cpf);

//Exibe a saída da função consultar
echo $busca_dados_cliente;

?>