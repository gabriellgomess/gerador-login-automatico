<?php
// Este script tem como função criar um hash criptografado com os dados do cliente e o sale_id da venda.
// O hash criptografado é enviado como parâmetro GET chamado "data" para o script recebe_requisicao.php.
// O script recebe_requisicao.php descriptografa os dados e retorna os dados do cliente em formato JSON.


// dados a serem enviados
$data = array("sale_id" => $row['vendas_id'], "cpf" => $row['cliente_cpf']);
$data_string = json_encode($data);

// chave secreta
$secret_key = "update2023";

// criptografia
$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
$encrypted_data = openssl_encrypt($data_string, 'aes-256-cbc', $secret_key, 0, $iv);
$encrypted_data = base64_encode($encrypted_data . '::' . $iv);

// enviando os dados criptografados
$link = "https://site.com.br/portal/?" . http_build_query(array("data" => $encrypted_data));

echo $link;

?>
