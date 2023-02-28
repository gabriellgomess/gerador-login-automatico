<?php
class PortalCobranca {
    private $con;

    public function __construct($con) {
        $this->con = $con;
    }

    public function consultar($sale_id, $cpf) {
        $query = "SELECT *
        FROM sys_vendas_seguros
        INNER JOIN sys_inss_clientes ON sys_vendas_seguros.cliente_cpf = sys_inss_clientes.cliente_cpf
        INNER JOIN sys_vendas_apolices ON sys_vendas_seguros.vendas_apolice = sys_vendas_apolices.apolice_id
        WHERE sys_inss_clientes.cliente_cpf = '".$cpf."' AND sys_vendas_seguros.vendas_id = '".$sale_id."'
        ORDER BY sys_vendas_seguros.vendas_id DESC 
        LIMIT 100;";       
     
        $result = mysqli_query($this->con, $query);
        $rows = array();
        while($r = mysqli_fetch_assoc($result)) {
            $rows[] = $r;
        }
        $json = json_encode($rows);
        return $json;
   
    }

    public function consultaFinanceiro($sale_id){
        $query = "SELECT * FROM sys_vendas_transacoes_boleto WHERE vendas_id = $sale_id";
        $result = mysqli_query($this->con, $query);
        $rows = array();
        while($r = mysqli_fetch_assoc($result)) {
            $rows[] = $r;
        }
        $json = json_encode($rows);
        return $json;
    }

    public function consultaFinanceiroParcelas($sale_id){
        $query = "SELECT * 
        FROM sys_vendas_transacoes_seg
        INNER JOIN sys_vendas_seguros ON sys_vendas_transacoes_seg.transacao_id_venda = sys_vendas_seguros.vendas_id
        WHERE transacao_id_venda = $sale_id";
        $result = mysqli_query($this->con, $query);
        $rows = array();
        while($r = mysqli_fetch_assoc($result)) {
            $rows[] = $r;
        }
        $json = json_encode($rows);
        return $json;
    }

    public function consultarAsaas($cpf){        
        $query = "SELECT * FROM sys_vendas_transacoes_boleto
                    JOIN sys_inss_clientes
                    ON sys_vendas_transacoes_boleto.cliente_cpf = sys_inss_clientes.cliente_cpf
                    WHERE sys_vendas_transacoes_boleto.cliente_cpf = '$cpf'
                    LIMIT 1;";
        $result = mysqli_query($this->con, $query);
        $rows = array();
        while($r = mysqli_fetch_assoc($result)) {
            $rows[] = $r;
        }
        $json = json_encode($rows);
        return $json;               
    }

    function criarCobrancaBoleto($data, $key){
        $url = "https://www.asaas.com/api/v3/payments";
        $data_string = json_encode($data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'access_token: '.$key,
            'Content-Length: ' . strlen($data_string))
        );
        $result = curl_exec($ch);
        // Se a cobrança for criada, salva no banco de dados
        // if($result){
        //     $this->salvarCobranca($data);
        // }

        // function salvarCobranca(){
        //     $query = "INSERT INTO sys_vendas_transacoes_boleto (vendas_id, boleto_id, boleto_url, cliente_cpf) VALUES ('$sale_id', '$boleto->id', '$boleto->boletoUrl', '$cpf')";
        //     mysqli_query($this->con, $query);
        
        // }

        return $result;

        // return $data;
    }

    function cadastrarCliente($data, $key){
        // $url = "https://www.asaas.com/api/v3/customers";
        // $data_string = json_encode($data);
        // $ch = curl_init($url);
        // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        //     'Content-Type: application/json',
        //     'access_token: '.$key,
        //     'Content-Length: ' . strlen($data_string))
        // );
        // $result = curl_exec($ch);
        return $data;
        
    }

}
?>

