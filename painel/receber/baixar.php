<?php 
$tabela = 'receber';
require_once("../../../conexao.php");
@session_start();
$id_usuario = $_SESSION['id'];

$id = $_POST['id-baixar'];
$data_atual = date('Y-m-d');
	$dia = date('d');
	$mes = date('m');
	$ano = date('Y');

$valor = $_POST['valor-baixar'];
$valor = str_replace(',', '.', $valor);

$taxa = $_POST['valor-taxa'];
$taxa = str_replace(',', '.', $taxa);

$multa = $_POST['valor-multa'];
$multa = str_replace(',', '.', $multa);

$desconto = $_POST['valor-desconto'];
$desconto = str_replace(',', '.', $desconto);

$juros = $_POST['valor-juros'];
$juros = str_replace(',', '.', $juros);

$valor = $_POST['valor-baixar'];
$valor = str_replace(',', '.', $valor);
$valor_padrao = $valor;

$subtotal = $_POST['subtotal'];
$subtotal = str_replace(',', '.', $subtotal);

$saida = $_POST['saida-baixar'];
$data_baixar = $_POST['data-baixar'];

if($juros == ""){
	$juros = 0;
}

if($multa == ""){
	$multa = 0;
}
if($taxa == ""){
	$taxa = 0;
}
if($desconto == ""){
	$desconto = 0;
}


$query = $pdo->query("SELECT * FROM $tabela where id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

$descricao = $res[0]['descricao'];
$cliente = $res[0]['cliente'];
$valor_antigo = $res[0]['valor'];
$data_lanc = $res[0]['data_lanc'];
$data_venc = $res[0]['vencimento'];
$data_pgto = $res[0]['data_pgto'];
$usuario_lanc = $res[0]['usuario_lanc'];
$usuario_pgto = $res[0]['usuario_pgto'];
$frequencia = $res[0]['frequencia'];
$saida_antiga = $res[0]['forma_pgto'];
$arquivo = $res[0]['arquivo'];
$pago = $res[0]['pago'];
$referencia = $res[0]['referencia'];
$hash = $res[0]['hash'];
$vencimento = $res[0]['vencimento'];
$id_ref = $res[0]['id_ref'];
$parcela = $res[0]['parcela'];

if($hash != ""){	
	require("../../apis/cancelar_agendamento.php");
}

if($cliente == ""){
	$cliente = 0;
}

$query2 = $pdo->query("SELECT * FROM clientes where id = '$cliente'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
if(@count($res2) > 0){
	$nome_cliente = $res2[0]['nome'];
	$telefone_cliente = $res2[0]['telefone'];
}else{
	$nome_cliente = 'Sem Registro';
	$telefone_cliente = "";
}

if($usuario_pgto == ""){
	$usuario_pgto = 0;
}


if($valor > $valor_antigo){
	echo 'O valor a ser pago não pode ser superior ao valor da conta! O valor da conta é de R$ '.$valor_antigo;
	exit();
}

if($valor <= 0){
	echo 'O precisa ser maior que 0 ';
	exit();
}


//verificar caixa aberto
$query1 = $pdo->query("SELECT * from caixas where operador = '$id_usuario' and data_fechamento is null order by id desc limit 1");
$res1 = $query1->fetchAll(PDO::FETCH_ASSOC);
if(@count($res1) > 0){
	$id_caixa = @$res1[0]['id'];
}else{
	$id_caixa = 0;
}


//baixa da conta de abertura de contrato
if($referencia == 'Abertura Contrato'){
	$query = $pdo->query("SELECT * FROM abertura_contratos where id = '$id_ref'");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$valor_entrada = @$res[0]['valor_entrada'];
	$valor = @$res[0]['valor'];	
	$valor_advogado1 = @$res[0]['valor_advogado1'];
	$valor_advogado2 = @$res[0]['valor_advogado2'];
	$valor_advogado3 = @$res[0]['valor_advogado3'];
	$valor_indicacao = @$res[0]['valor_indicacao'];
	$valor_marketing = @$res[0]['valor_marketing'];
	$valor_pessoa1 = @$res[0]['valor_pessoa1'];
	$valor_pessoa2 = @$res[0]['valor_pessoa2'];
	$valor_escritorio = @$res[0]['valor_escritorio'];

	$advogado1 = @$res[0]['advogado1'];
	$advogado2 = @$res[0]['advogado2'];
	$advogado3 = @$res[0]['advogado3'];
	$indicacao = @$res[0]['indicacao'];
	$marketing = @$res[0]['marketing'];
	$pessoa1 = @$res[0]['pessoa1'];
	$pessoa2 = @$res[0]['pessoa2'];

	$numeracao = @$res[0]['numeracao'];

	$tipo_servico = @$res[0]['tipo_servico'];

	$query = $pdo->query("SELECT * FROM tipos_servicos where id = '$tipo_servico'");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$nome_servico = @$res[0]['nome'];

	//verificar as comissões
	$total_comissoes = $valor_escritorio + $valor_advogado1 + $valor_advogado2 + $valor_advogado3 + $valor_marketing + $valor_indicacao + $valor_pessoa1 + $valor_pessoa2;

	if($total_comissoes > 0){	


		$nova_numeracao = $numeracao;

		$pdo->query("UPDATE receber SET forma_pgto = '$saida', usuario_pgto = '$id_usuario', pago = 'Sim', subtotal = '$subtotal', taxa = '$taxa', juros = '$juros', multa = '$multa', desconto = '$desconto', data_pgto = '$data_baixar', caixa = '$id_caixa', hora = curTime(), financeiro = 'Não' WHERE id = '$id'");
		$valor_entrada = $subtotal;
		$forma_pgto = $saida;
		$ult_id = $id_ref;

		$pdo->query("DELETE FROM receber where referencia = 'Abertura Contrato' and id_ref = '$id_ref' and parcela = '$parcela' and financeiro is null");

		$sql_usuario_pgto = ", usuario_pgto = '$id_usuario' ";
		$sql_data_pgto = ", data_pgto = '$data_baixar' ";
		$data_do_venc = $data_atual;
		$esta_pago = 'Sim';
		$sql_parcela = ", parcela = '$parcela' ";	

		require_once("../abertura_contratos/lancar_comissoes.php");
		
		
	}else{
		$pdo->query("UPDATE receber SET forma_pgto = '$saida', usuario_pgto = '$id_usuario', pago = 'Sim', subtotal = '$subtotal', taxa = '$taxa', juros = '$juros', multa = '$multa', desconto = '$desconto', data_pgto = '$data_baixar', caixa = '$id_caixa', hora = curTime() WHERE id = '$id'");
	}
	echo 'Baixado com Sucesso';
	exit();
}
 

if($valor == $valor_antigo){

	$pdo->query("UPDATE $tabela set forma_pgto = '$saida', usuario_pgto = '$id_usuario', pago = 'Sim', subtotal = '$subtotal', taxa = '$taxa', juros = '$juros', multa = '$multa', desconto = '$desconto', data_pgto = '$data_baixar', caixa = '$id_caixa', hora = curTime() where id = '$id'");

	//CRIAR A PRÓXIMA CONTA A PAGAR
	$dias_frequencia = $frequencia;

	if($dias_frequencia == 30 || $dias_frequencia == 31){		
		$nova_data_vencimento = date('Y/m/d', strtotime("+1 month",strtotime($data_venc)));

	}else if($dias_frequencia == 90){
		$nova_data_vencimento = date('Y/m/d', strtotime("+3 month",strtotime($data_venc)));

	}else if($dias_frequencia == 180){ 
		$nova_data_vencimento = date('Y/m/d', strtotime("+6 month",strtotime($data_venc)));

	}else if($dias_frequencia == 360 || $dias_frequencia == 365){
		$nova_data_vencimento = date('Y/m/d', strtotime("+1 year",strtotime($data_venc)));

	}else{		
		$nova_data_vencimento = date('Y/m/d', strtotime("+$dias_frequencia days",strtotime($data_venc))); 
	}


	if(@$dias_frequencia > 0){
		$pdo->query("INSERT INTO $tabela set descricao = '$descricao', cliente = '$cliente', valor = '$valor_antigo', data_lanc = curDate(), vencimento = '$nova_data_vencimento', frequencia = '$frequencia', forma_pgto = '$saida_antiga', arquivo = '$arquivo', pago = 'Não', referencia = '$referencia', usuario_lanc = '$id_usuario', caixa = '$id_caixa', hora = curTime()");
				$id_ult_registro = $pdo->lastInsertId();	


					if($api_whatsapp != 'Não' and $telefone_cliente != ''){

					$valorF = @number_format($valor, 2, ',', '.');

	$telefone_envio = '55'.preg_replace('/[ ()-]+/' , '' , $telefone_cliente);
	$mensagem_whatsapp = '💰 *'.$nome_sistema.'*%0A';
	$mensagem_whatsapp .= '_Conta Vencendo Hoje_ %0A';
	$mensagem_whatsapp .= '*Descrição:* '.$descricao.' %0A';
	$mensagem_whatsapp .= '*Valor:* '.$valorF.' %0A';

	if($dados_pagamento != ""){
				$mensagem_whatsapp .= '*Dados para o Pagamento:* %0A';
				$mensagem_whatsapp .= $dados_pagamento;
			}	
	
	$data_agd = $nova_data_vencimento.' 08:00:00';
	require('../../apis/agendar.php');

	$pdo->query("UPDATE $tabela SET hash = '$hash' where id = '$id_ult_registro'");
	
}				
	}

	

}else{

	$descricao = '(Resíduo) ' .$descricao;
	//PEGAR RESIDUOS DA CONTA
	$total_resid = 0;
	$query = $pdo->query("SELECT * FROM receber WHERE id_ref = '$id' and residuo = 'Sim'");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	if(@count($res) > 0){
	
		for($i=0; $i < @count($res); $i++){
		foreach ($res[$i] as $key => $value){} 
			$valor_resid = $res[$i]['valor'];
			$total_resid += $valor_resid;
		}
	}

	$valor_antigo = $valor_antigo - ($subtotal - $taxa - $multa - $juros);

	$pdo->query("INSERT INTO receber set id_ref = '$id', referencia = '$referencia', valor = '$valor_padrao', data_pgto = curDate(), vencimento = curDate(), data_lanc = curDate(), descricao = '$descricao', usuario_lanc = '$id_usuario', usuario_pgto = '$id_usuario', cliente = '$cliente', forma_pgto = '$saida', frequencia = '$frequencia', arquivo = '$arquivo', subtotal = '$subtotal', pago = 'Sim', taxa = '$taxa', multa = '$multa', juros = '$juros', desconto = '$desconto', residuo = 'Sim', caixa = '$id_caixa', hora = curTime()");

	$pdo->query("UPDATE $tabela set forma_pgto = '$saida', usuario_pgto = '$id_usuario', valor = '$valor_antigo', data_pgto = curDate() where id = '$id'");


	if($api_whatsapp != 'Não' and $telefone_cliente != ''){

					$valorF = @number_format($valor_antigo, 2, ',', '.');

			$telefone_envio = '55'.preg_replace('/[ ()-]+/' , '' , $telefone_cliente);
			$mensagem_whatsapp = '💰 *'.$nome_sistema.'*%0A';
			$mensagem_whatsapp .= '_Conta Vencendo Hoje_ %0A';
			$mensagem_whatsapp .= '*Descrição:* '.$descricao.' %0A';
			$mensagem_whatsapp .= '*Valor:* '.$valorF.' %0A';	

			if($dados_pagamento != ""){
				$mensagem_whatsapp .= '*Dados para o Pagamento:* %0A';
				$mensagem_whatsapp .= $dados_pagamento;
			}
			
			$data_agd = $vencimento.' 08:00:00';
			require('../../apis/agendar.php');

			$pdo->query("UPDATE $tabela SET hash = '$hash' where id = '$id'");
			
		}	


}

echo 'Baixado com Sucesso';

?>

