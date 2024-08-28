<?php 
$tabela = 'pagar';
require_once("../../../conexao.php");

@session_start();
$id_usuario = $_SESSION['id'];

$id = $_POST['id-parcelar'];
$nome = $_POST['nome-parcelar'];
$dias_frequencia = $_POST['frequencia'];
$qtd_parcelas = $_POST['qtd-parcelar'];

$query = $pdo->query("SELECT * FROM $tabela where id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

$descricao = $res[0]['descricao'];
$fornecedor = $res[0]['fornecedor'];
$funcionario = $res[0]['funcionario'];
$valor = $res[0]['valor'];
$data_lanc = $res[0]['data_lanc'];
$data_venc = $res[0]['vencimento'];
$data_pgto = $res[0]['data_pgto'];
$usuario_lanc = $res[0]['usuario_lanc'];
$usuario_pgto = $res[0]['usuario_pgto'];
$frequencia = $res[0]['frequencia'];
$saida = $res[0]['forma_pgto'];
$arquivo = $res[0]['arquivo'];
$pago = $res[0]['pago'];
$referencia = $res[0]['referencia'];
$id_ref = $res[0]['id_ref'];

if($id_ref == ""){
	$id_ref = 0;
}

if($fornecedor == ""){
	$fornecedor = 0;
}


if($funcionario == ""){
	$funcionario = 0;
}

if($usuario_pgto == ""){
	$usuario_pgto = 0;
}


for($i=1; $i <= $qtd_parcelas; $i++){

	$nova_descricao = $descricao . ' - Parcela '.$i;
	$novo_valor = $valor / $qtd_parcelas;
	$dias_parcela = $i - 1;
	$dias_parcela_2 = ($i - 1) * $dias_frequencia;

	if($i == 1){
		$novo_vencimento = $data_venc;
	}else{

		if($dias_frequencia == 30 || $dias_frequencia == 31){
			
			$novo_vencimento = date('Y/m/d', strtotime("+$dias_parcela month",strtotime($data_venc)));

		}else if($dias_frequencia == 90){ 
			$dias_parcela = $dias_parcela * 3;
			$novo_vencimento = date('Y/m/d', strtotime("+$dias_parcela month",strtotime($data_venc)));

		}else if($dias_frequencia == 180){ 

			$dias_parcela = $dias_parcela * 6;
			$novo_vencimento = date('Y/m/d', strtotime("+$dias_parcela month",strtotime($data_venc)));

		}else if($dias_frequencia == 360 || $dias_frequencia == 365){ 

			$dias_parcela = $dias_parcela * 12;
			$novo_vencimento = date('Y/m/d', strtotime("+$dias_parcela month",strtotime($data_venc)));

		}else{
			
			$novo_vencimento = date('Y/m/d', strtotime("+$dias_parcela_2 days",strtotime($data_venc)));
		}
		
	}

				
		$novo_valor = number_format($novo_valor, 2, ',', '.');
		$novo_valor = str_replace('.', '', $novo_valor);
		$novo_valor = str_replace(',', '.', $novo_valor);
		$resto_conta = $valor - $novo_valor * $qtd_parcelas;
		$resto_conta = number_format($resto_conta, 2);
		
		if($i == $qtd_parcelas){
			$novo_valor = $novo_valor + $resto_conta;
		}


	$pdo->query("INSERT INTO $tabela set descricao = '$nova_descricao', fornecedor = '$fornecedor', funcionario = '$funcionario', valor = '$novo_valor', usuario_lanc = '$id_usuario', data_lanc = curDate(), vencimento = '$novo_vencimento', frequencia = '$frequencia', forma_pgto = '$saida', arquivo = '$arquivo', pago = 'Não', referencia = '$referencia', id_ref = '$id_ref', subtotal = '$novo_valor'");

}

$pdo->query("DELETE from $tabela where id = '$id'");

echo 'Parcelado com Sucesso';


?>