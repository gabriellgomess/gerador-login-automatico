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


}
?>

