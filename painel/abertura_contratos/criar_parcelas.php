<?php 
@session_start();
$id_usuario = @$_SESSION['id'];
$tabela = 'receber';
require_once("../../../conexao.php");

$parcelas = $_POST['parcelas'];
$frequencia = $_POST['frequencia'];
$valor = $_POST['valor'];
$valor = str_replace(',', '.', $valor);
$entrada = $_POST['entrada'];
$entrada = str_replace(',', '.', $entrada);
$tipo_servico = $_POST['tipo_servico'];
$data_venc = $_POST['data_venc'];
$cliente = $_POST['cliente'];
$forma_pgto = $_POST['forma_pgto'];
$id = $_POST['id'];

$dias_frequencia = $_POST['frequencia'];

//numeracao contrato para parcelas

$query = $pdo->query("SELECT * FROM abertura_contratos");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_registros = @count($res);
$somar_num = $total_registros + 1;
$nova_numeracao = '00'.$somar_num.'/'.date('Y');

if($id != ""){
	//buscar o valor_entrada antigo
$query = $pdo->query("SELECT * FROM abertura_contratos where id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$valor_entrada_antigo = @$res[0]['valor_entrada'];
$valor_antigo = @$res[0]['valor'];
$frequencia_antiga = @$res[0]['frequencia'];
$parcelas_antiga = @$res[0]['parcelas'];
$data_venc_antiga = @$res[0]['data_venc'];


$query = $pdo->query("SELECT * FROM receber where id_ref = '$id' and referencia = 'Abertura Contrato' and parcela is not null");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_contas = @count($res);

	if($valor_antigo != $valor or $valor_entrada_antigo != $entrada or $parcelas_antiga != $parcelas or $frequencia_antiga != $frequencia or $data_venc_antiga != $data_venc or $total_contas == '0'){
	$pdo->query("DELETE FROM receber WHERE referencia = 'Abertura Contrato' and id_ref = '$id' and pago != 'Sim' and parcela is not null");
	}else{
		exit();
	}
}



$pdo->query("DELETE FROM $tabela WHERE referencia = 'Abertura Contrato' and id_ref = '0' and usuario_lanc = '$id_usuario'");

if($valor == ''){
	$valor = 0;
}

if($entrada == ''){
	$entrada = 0;
}

$valor_final = $valor - $entrada;


$query = $pdo->query("SELECT * FROM tipos_servicos where id = '$tipo_servico'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$descricao = $res[0]['nome'];


for($i=1; $i <= $parcelas; $i++){

	if($parcelas == '1'){
		$nova_descricao = $nova_numeracao;
	}else{
		$nova_descricao = $nova_numeracao.' - Parcela '.$i;
	}
	
	$novo_valor = $valor_final / $parcelas;
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
		$resto_conta = $valor_final - $novo_valor * $parcelas;
		$resto_conta = number_format($resto_conta, 2);
		
		if($i == $parcelas){
			$novo_valor = $novo_valor + $resto_conta;
		}


	$pdo->query("INSERT INTO $tabela set descricao = '$nova_descricao', cliente = '$cliente', valor = '$novo_valor', usuario_lanc = '$id_usuario', data_lanc = curDate(), vencimento = '$novo_vencimento', frequencia = '0', forma_pgto = '$forma_pgto', arquivo = 'sem-foto.png', pago = 'Não', referencia = 'Abertura Contrato', id_ref = '0', subtotal = '$novo_valor', parcela = '$i', financeiro = 'Não'");

}


?>