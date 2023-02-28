
# Criptografia e descriptografia de Dados

Este repositório contém um script em PHP para receber uma requisição HTTP e descriptografar os dados enviados como parâmetro GET chamado "data". Após descriptografar os dados, o script inclui o arquivo api-portal.php e chama a função consultar do objeto PortalCobranca. A função consultar recebe como parâmetro o sale_id e o CPF do cliente e retorna os dados do cliente em formato JSON. O script retorna a saída da função consultar.
Usei este sistema onde precisei gerar um link para o cliente acessar um portal sem precisar fazer login.

## Como usar
### Requisitos

- PHP 7.x ou superior
- OpenSSL

### Instruções

- Faça o download do arquivo recebe_requisiao.php e api-portal.php para o diretório do seu projeto.
- Inclua o arquivo connect_seguro.php no mesmo diretório do recebe_requisiao.php. Este arquivo deve conter os dados de conexão com o banco de dados.
- Execute o script pelo servidor web.

### Arquivos
- recebe_requisiao.php
Este script recebe uma requisição HTTP com um parâmetro GET chamado "data", descriptografa os dados utilizando a chave secreta e o algoritmo AES-256-CBC, e chama a função consultar do objeto PortalCobranca. A saída da função consultar é retornada como resposta à requisição.

- api-portal.php
Este arquivo contém a classe PortalCobranca, que representa a API para consulta de dados de clientes. A classe possui um método chamado consultar, que recebe como parâmetros o sale_id e o CPF do cliente e retorna os dados do cliente em formato JSON.

- connect_seguro.php
Este arquivo contém os dados de conexão com o banco de dados.

- create-hash.php
Este script cria um hash criptografado com os dados do cliente e o sale_id da venda. O hash criptografado é enviado como parâmetro GET chamado "data" para o script decrypt.php.




## Licença

Este projeto está sob a licença MIT. Para mais informações, consulte o arquivo LICENSE.

[MIT](https://choosealicense.com/licenses/mit/)

