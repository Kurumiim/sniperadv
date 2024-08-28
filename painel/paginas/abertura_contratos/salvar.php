<?php 
@session_start();
$id_usuario = @$_SESSION['id'];
$tabela = 'abertura_contratos';
require_once("../../../conexao.php");

$data_atual = date('Y-m-d');

$cliente = $_POST['cliente'];
$valor = $_POST['valor'];
$valor = str_replace(',', '.', $valor);
$valor_entrada = $_POST['valor_entrada'];
$valor_entrada = str_replace(',', '.', $valor_entrada);
$parcelas = $_POST['parcelas'];
$frequencia = $_POST['frequencia'];
$data_venc = $_POST['data_venc'];
$tipo_servico = $_POST['tipo_servico'];
$obs = $_POST['obs'];

$valor_escritorio = $_POST['valor_escritorio'];
$numero_processo = $_POST['numero_processo'];

$advogado1 = @$_POST['advogado1'];
$advogado2 = @$_POST['advogado2'];
$advogado3 = @$_POST['advogado3'];
$indicacao = @$_POST['indicacao'];
$marketing = @$_POST['marketing'];
$pessoa1 = @$_POST['pessoa1'];
$pessoa2 = @$_POST['pessoa2'];

$valor_advogado1 = $_POST['valor_advogado1'];
$valor_advogado1 = str_replace(',', '.', $valor_advogado1);
$valor_advogado2 = $_POST['valor_advogado2'];
$valor_advogado2 = str_replace(',', '.', $valor_advogado2);
$valor_advogado3 = $_POST['valor_advogado3'];
$valor_advogado3 = str_replace(',', '.', $valor_advogado3);
$valor_indicacao = $_POST['valor_indicacao'];
$valor_indicacao = str_replace(',', '.', $valor_indicacao);
$valor_marketing = $_POST['valor_marketing'];
$valor_marketing = str_replace(',', '.', $valor_marketing);
$valor_pessoa1 = $_POST['valor_pessoa1'];
$valor_pessoa1 = str_replace(',', '.', $valor_pessoa1);
$valor_pessoa2 = $_POST['valor_pessoa2'];
$valor_pessoa2 = str_replace(',', '.', $valor_pessoa2);

$motivo1 = $_POST['motivo1'];
$motivo2 = $_POST['motivo2'];
$forma_pgto = $_POST['forma_pgto'];

$id = $_POST['id'];

$query = $pdo->query("SELECT * FROM tipos_servicos where id = '$tipo_servico'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$nome_servico = @$res[0]['nome'];

//buscar o valor_entrada antigo
$query = $pdo->query("SELECT * FROM $tabela where id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

$valor_entrada_antigo = @$res[0]['valor_entrada'];
$valor_antigo = @$res[0]['valor'];
$frequencia_antiga = @$res[0]['frequencia'];
$parcelas_antiga = @$res[0]['parcelas'];
$data_venc_antiga = @$res[0]['data_venc'];



//buscar o total de reg
$query = $pdo->query("SELECT * FROM $tabela");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_registros = @count($res);

$valor_advogado1_antigo = @$res[0]['valor_advogado1'];
$valor_advogado2_antigo = @$res[0]['valor_advogado2'];
$valor_advogado3_antigo = @$res[0]['valor_advogado3'];
$valor_indicacao_antigo = @$res[0]['valor_indicacao'];
$valor_marketing_antigo = @$res[0]['valor_marketing'];
$valor_pessoa1_antigo = @$res[0]['valor_pessoa1'];
$valor_pessoa2_antigo = @$res[0]['valor_pessoa2'];
$valor_escritorio_antigo = @$res[0]['valor_escritorio'];

require_once("validacoes.php");

//verificar as comissões
$total_comissoes = $valor_escritorio + $valor_advogado1 + $valor_advogado2 + $valor_advogado3 + $valor_marketing + $valor_indicacao + $valor_pessoa1 + $valor_pessoa2;

if($total_comissoes > 0){
	if($total_comissoes != 100){
		echo 'O total de recebimentos / comissões não está dando 100%, ou retire todas ou coloque os 100% redondo!';
		exit();
	}
}


if($id == ""){
$somar_num = $total_registros + 1;
$nova_numeracao = '00'.$somar_num.'/'.date('Y');

$query = $pdo->prepare("INSERT INTO $tabela SET cliente = :cliente, valor = :valor, valor_entrada = :valor_entrada, parcelas = :parcelas, frequencia = :frequencia, data_venc = :data_venc, status = :status, tipo_servico = :tipo_servico, obs = :obs, valor_escritorio = :valor_escritorio, advogado1 = :advogado1, advogado2 = :advogado2, advogado3 = :advogado3, indicacao = :indicacao, marketing = :marketing, pessoa1 = :pessoa1, valor_advogado1 = :valor_advogado1, valor_advogado2 = :valor_advogado2, valor_advogado3 = :valor_advogado3, valor_marketing = :valor_marketing, valor_pessoa1 = :valor_pessoa1, valor_pessoa2 = :valor_pessoa1, pessoa2 = :pessoa2, valor_indicacao = :valor_indicacao, numero_processo = :numero_processo, motivo1 = :motivo1, motivo2 = :motivo2, usuario_lanc = :usuario_lanc, forma_pgto = :forma_pgto, data = curDate(), numeracao = '$nova_numeracao' ");
	
}else{
$query = $pdo->prepare("UPDATE $tabela SET cliente = :cliente, valor = :valor, valor_entrada = :valor_entrada, parcelas = :parcelas, frequencia = :frequencia, data_venc = :data_venc, status = :status, tipo_servico = :tipo_servico, obs = :obs, valor_escritorio = :valor_escritorio, advogado1 = :advogado1, advogado2 = :advogado2, advogado3 = :advogado3, indicacao = :indicacao, marketing = :marketing, pessoa1 = :pessoa1, valor_advogado1 = :valor_advogado1, valor_advogado2 = :valor_advogado2, valor_advogado3 = :valor_advogado3, valor_marketing = :valor_marketing, valor_pessoa1 = :valor_pessoa1, valor_pessoa2 = :valor_pessoa2, pessoa2 = :pessoa2, valor_indicacao = :valor_indicacao, numero_processo = :numero_processo, motivo1 = :motivo1, motivo2 = :motivo2, usuario_lanc = :usuario_lanc, forma_pgto = :forma_pgto where id = '$id'");
}

$query->bindValue(":cliente", "$cliente");
$query->bindValue(":valor", "$valor");
$query->bindValue(":valor_entrada", "$valor_entrada");
$query->bindValue(":parcelas", "$parcelas");
$query->bindValue(":frequencia", "$frequencia");
$query->bindValue(":data_venc", "$data_venc");
$query->bindValue(":status", "Aberto");
$query->bindValue(":tipo_servico", "$tipo_servico");
$query->bindValue(":obs", "$obs");
$query->bindValue(":valor_escritorio", "$valor_escritorio");
$query->bindValue(":advogado1", "$advogado1");
$query->bindValue(":advogado2", "$advogado2");
$query->bindValue(":advogado3", "$advogado3");
$query->bindValue(":indicacao", "$indicacao");
$query->bindValue(":marketing", "$marketing");
$query->bindValue(":pessoa1", "$pessoa1");
$query->bindValue(":valor_advogado1", "$valor_advogado1");
$query->bindValue(":valor_advogado2", "$valor_advogado2");
$query->bindValue(":valor_advogado3", "$valor_advogado3");
$query->bindValue(":valor_marketing", "$valor_marketing");
$query->bindValue(":valor_pessoa1", "$valor_pessoa1");
$query->bindValue(":valor_pessoa2", "$valor_pessoa2");
$query->bindValue(":pessoa2", "$pessoa2");
$query->bindValue(":valor_indicacao", "$valor_indicacao");
$query->bindValue(":numero_processo", "$numero_processo");
$query->bindValue(":motivo1", "$motivo1");
$query->bindValue(":motivo2", "$motivo2");
$query->bindValue(":usuario_lanc", "$id_usuario");
$query->bindValue(":forma_pgto", "$forma_pgto");

$query->execute();
$ult_id = $pdo->lastInsertId();



//verificar caixa aberto
$query1 = $pdo->query("SELECT * from caixas where operador = '$id_usuario' and data_fechamento is null order by id desc limit 1");
$res1 = $query1->fetchAll(PDO::FETCH_ASSOC);
if(@count($res1) > 0){
	$id_caixa = @$res1[0]['id'];
}else{
	$id_caixa = 0;
}

$desc_contrato = $nome_servico;

$desc_entrada = 'Entrada '.@$nova_numeracao;

//verificar se tem entrada
if($valor_entrada > 0){

	//inserir uma conta a receber com financeiro = nao, contendo valor da entreda
	$pdo->query("INSERT INTO receber set descricao = '$desc_entrada', cliente = '$cliente', valor = '$valor_entrada', usuario_lanc = '$id_usuario', data_lanc = curDate(), vencimento = curDate(), data_pgto = curDate(), frequencia = '0', forma_pgto = '$forma_pgto', arquivo = 'sem-foto.png', usuario_pgto = '$id_usuario', pago = 'Sim', referencia = 'Abertura Contrato', id_ref = '$ult_id', subtotal = '$valor_entrada', hora = curTime(), caixa = '$id_caixa', financeiro = 'Não'");

	if($id == "" or $valor_entrada_antigo != $valor_entrada or $valor_advogado1_antigo != $valor_advogado1 or $valor_advogado2_antigo != $valor_advogado2 or $valor_advogado3_antigo != $valor_advogado3 or $valor_marketing_antigo != $valor_marketing or $valor_indicacao_antigo != $valor_indicacao or $valor_pessoa1_antigo != $valor_pessoa1 or $valor_pessoa2_antigo != $valor_pessoa2 or $valor_escritorio_antigo != $valor_escritorio){

		if($id != "" and $id > 0){
			$pdo->query("DELETE FROM receber WHERE referencia = 'Abertura Contrato' and id_ref = '$id' and pago = 'Sim' and parcela is null");
		}
		

		if($total_comissoes == 0){
			$pdo->query("INSERT INTO receber set descricao = '$desc_contrato', cliente = '$cliente', valor = '$valor_entrada', usuario_lanc = '$id_usuario', data_lanc = curDate(), vencimento = curDate(), data_pgto = curDate(), frequencia = '0', forma_pgto = '$forma_pgto', arquivo = 'sem-foto.png', usuario_pgto = '$id_usuario', pago = 'Sim', referencia = 'Abertura Contrato', id_ref = '$ult_id', subtotal = '$valor_entrada', hora = curTime(), caixa = '$id_caixa'");
		}

		//separar os lançamentos feitos
		if($total_comissoes > 0){
			$sql_usuario_pgto = ", usuario_pgto = '$id_usuario' ";
			$sql_data_pgto = ', data_pgto = curDate() ';
			$data_do_venc = $data_atual;
			$esta_pago = 'Sim';
			$sql_parcela = ' ';	
			require_once("lancar_comissoes.php");
		}

	}
}



//lançar as demais contas pendentes
$query = $pdo->query("SELECT * FROM receber WHERE referencia = 'Abertura Contrato' and id_ref = '0' and usuario_lanc = '$id_usuario' and parcela is not null");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
	for($i=0; $i<$linhas; $i++){
	$data_venc = $res[$i]['vencimento'];
	$numero_parcela = $res[$i]['parcela'];
	$valor = $res[$i]['valor'];

	$sql_usuario_pgto = ' ';
	$sql_data_pgto = ' ';
	$data_do_venc = $data_venc;
	$esta_pago = 'Não';	
	$sql_parcela = ", parcela = '$numero_parcela' ";	
	$valor_entrada = $valor;
	require("lancar_comissoes.php");
	}
}


//associar as parcelas
$query = $pdo->query("UPDATE receber SET id_ref = '$ult_id' WHERE referencia = 'Abertura Contrato' and id_ref = '0' and usuario_lanc = '$id_usuario' and parcela is not null");

if($id != ""){
	if($valor_antigo != $valor or $valor_entrada_antigo != $valor_antigo or $parcelas_antiga != $parcelas or $frequencia_antiga != $frequencia or $data_venc_antiga != $data_venc){

		
		$pdo->query("UPDATE receber SET id_ref = '$id' WHERE referencia = 'Abertura Contrato' and id_ref = '0' and usuario_lanc = '$id_usuario' and parcela is not null");

	}
}

echo 'Salvo com Sucesso';


 ?>
