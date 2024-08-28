<?php
$tabela = 'receber';
require_once("../../verificar.php");
require_once("../../../conexao.php");

$data_atual = date('Y-m-d');
$data_hoje = date('Y-m-d');

$id = @$_POST['id'];


$query = $pdo->query("SELECT * from abertura_contratos where id = '$id'");

$res = $query->fetchAll(PDO::FETCH_ASSOC);

$linhas = @count($res);

if($linhas == 0){

	echo 'Contrato não encontrado!';

	exit();

}else{

$id = $res[0]['id'];
	$cliente = $res[0]['cliente'];
	$valor = $res[0]['valor'];
	$valor_entrada = $res[0]['valor_entrada'];
	$parcelas = $res[0]['parcelas'];
	$frequencia = $res[0]['frequencia'];
	$data_venc = $res[0]['data_venc'];	
	$status = $res[0]['status'];
	$tipo_servico = $res[0]['tipo_servico'];	
	$valor_escritorio = $res[0]['valor_escritorio'];
	$advogado1 = $res[0]['advogado1'];
	$advogado2 = $res[0]['advogado2'];
	$advogado3 = $res[0]['advogado3'];
	$indicacao = $res[0]['indicacao'];
	$marketing = $res[0]['marketing'];
	$pessoa1 = $res[0]['pessoa1'];
	$pessoa2 = $res[0]['pessoa2'];
	$valor_advogado1 = $res[0]['valor_advogado1'];
	$valor_advogado2 = $res[0]['valor_advogado2'];
	$valor_advogado3 = $res[0]['valor_advogado3'];
	$valor_marketing = $res[0]['valor_marketing'];
	$valor_indicacao = $res[0]['valor_indicacao'];
	$valor_pessoa1 = $res[0]['valor_pessoa1'];
	$valor_pessoa2 = $res[0]['valor_pessoa2'];
	$numero_processo = $res[0]['numero_processo'];
	$motivo1 = $res[0]['motivo1'];
	$motivo2 = $res[0]['motivo2'];
	$usuario_lanc = $res[0]['usuario_lanc'];
	$forma_pgto = $res[0]['forma_pgto'];
	$data = $res[0]['data'];
	$obs = $res[0]['obs'];

	$total_comissoes = $valor_escritorio + $valor_advogado1 + $valor_advogado2 + $valor_advogado3 + $valor_marketing + $valor_indicacao + $valor_pessoa1 + $valor_pessoa2;

	$valor_restante = $valor - $valor_entrada;

	$valor_comissao_escritorio = $valor_entrada * $valor_escritorio / 100;
	$valor_comissao_advogado1 = $valor_entrada * $valor_advogado1 / 100;
	$valor_comissao_advogado2 = $valor_entrada * $valor_advogado2 / 100;
	$valor_comissao_advogado3 = $valor_entrada * $valor_advogado3 / 100;
	$valor_comissao_marketing = $valor_entrada * $valor_marketing / 100;
	$valor_comissao_indicacao = $valor_entrada * $valor_indicacao / 100;
	$valor_comissao_pessoa1 = $valor_entrada * $valor_pessoa1 / 100;
	$valor_comissao_pessoa2 = $valor_entrada * $valor_pessoa2 / 100;

	

	$dataF = implode('/', array_reverse(@explode('-', $data)));
	$data_vencF = implode('/', array_reverse(@explode('-', $data_venc)));
	$valorF = @number_format($valor, 2, ',', '.');
	$valor_entradaF = @number_format($valor_entrada, 2, ',', '.');
	$valor_restanteF = @number_format($valor_restante, 2, ',', '.');

	$valor_escritorioF = @number_format($valor_escritorio, 0, ',', '.');
	$valor_advogado1F = @number_format($valor_advogado1, 0, ',', '.');
	$valor_advogado2F = @number_format($valor_advogado2, 0, ',', '.');
	$valor_advogado3F = @number_format($valor_advogado3, 0, ',', '.');
	$valor_marketingF = @number_format($valor_marketing, 0, ',', '.');
	$valor_indicacaoF = @number_format($valor_indicacao, 0, ',', '.');
	$valor_pessoa2F = @number_format($valor_pessoa2, 0, ',', '.');
	$valor_pessoa1F = @number_format($valor_pessoa1, 0, ',', '.');

	$valor_comissao_escritorioF = @number_format($valor_comissao_escritorio, 2, ',', '.');
	$valor_comissao_advogado1F = @number_format($valor_comissao_advogado1, 2, ',', '.');
	$valor_comissao_advogado2F = @number_format($valor_comissao_advogado2, 2, ',', '.');
	$valor_comissao_advogado3F = @number_format($valor_comissao_advogado3, 2, ',', '.');
	$valor_comissao_marketingF = @number_format($valor_comissao_marketing, 2, ',', '.');
	$valor_comissao_indicacaoF = @number_format($valor_comissao_indicacao, 2, ',', '.');
	$valor_comissao_pessoa1F = @number_format($valor_comissao_pessoa1, 2, ',', '.');
	$valor_comissao_pessoa2F = @number_format($valor_comissao_pessoa2, 2, ',', '.');

	

	$query2 = $pdo->query("SELECT * FROM clientes where id = '$cliente'");
	$res = $query2->fetchAll(PDO::FETCH_ASSOC);
	if(@count($res) > 0){
		$nome_cliente = $res[0]['nome'];
		$telefone_cliente = $res[0]['telefone'];
		$email_cliente = $res[0]['email'];	
		$endereco_cliente = $res[0]['endereco'];
		$tipo_pessoa_cliente = $res[0]['tipo_pessoa'];
		$cpf_cliente = $res[0]['cpf'];

		$numero_cliente = $res[0]['numero'];
		$bairro_cliente = $res[0]['bairro'];
		$cidade_cliente = $res[0]['cidade'];
		$estado_cliente = $res[0]['estado'];
		$cep_cliente = $res[0]['cep'];

		$rg_cliente = $res[0]['rg'];
		$complemento_cliente = $res[0]['complemento'];
		$genitor_cliente = $res[0]['genitor'];
		$genitora_cliente = $res[0]['genitora'];		
		
		$data_nasc_cliente = $res[0]['data_nasc'];
		
		$data_nasc_clienteF = implode('/', array_reverse(@explode('-', $data_nasc_cliente)));
	}else{
		$nome_cliente = 'Sem Registro';
	}

	$query2 = $pdo->query("SELECT * FROM tipos_servicos where id = '$tipo_servico'");
	$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
	if(@count($res2) > 0){
		$nome_servico = $res2[0]['nome'];
	}else{
		$nome_servico = '';
	}

	$query2 = $pdo->query("SELECT * FROM frequencias where dias = '$frequencia'");
	$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
	if(@count($res2) > 0){
		$nome_frequencia = $res2[0]['frequencia'];
	}else{
		$nome_frequencia = 'Nenhuma';
	}


	$query2 = $pdo->query("SELECT * FROM usuarios where id = '$advogado1'");
	$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
	if(@count($res2) > 0){
		$nome_advogado1 = $res2[0]['nome'];
	}else{
		$nome_advogado1 = '';
	}


	$query2 = $pdo->query("SELECT * FROM usuarios where id = '$advogado2'");
	$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
	if(@count($res2) > 0){
		$nome_advogado2 = $res2[0]['nome'];
	}else{
		$nome_advogado2 = '';
	}


	$query2 = $pdo->query("SELECT * FROM usuarios where id = '$advogado3'");
	$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
	if(@count($res2) > 0){
		$nome_advogado3 = $res2[0]['nome'];
	}else{
		$nome_advogado3 = '';
	}


	$query2 = $pdo->query("SELECT * FROM usuarios where id = '$marketing'");
	$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
	if(@count($res2) > 0){
		$nome_marketing = $res2[0]['nome'];
	}else{
		$nome_marketing = '';
	}


	$query2 = $pdo->query("SELECT * FROM usuarios where id = '$indicacao'");
	$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
	if(@count($res2) > 0){
		$nome_indicacao = $res2[0]['nome'];
	}else{
		$nome_indicacao = '';
	}

	$query2 = $pdo->query("SELECT * FROM usuarios where id = '$pessoa1'");
	$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
	if(@count($res2) > 0){
		$nome_pessoa1 = $res2[0]['nome'];
	}else{
		$nome_pessoa1 = '';
	}

	$query2 = $pdo->query("SELECT * FROM usuarios where id = '$pessoa2'");
	$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
	if(@count($res2) > 0){
		$nome_pessoa2 = $res2[0]['nome'];
	}else{
		$nome_pessoa2 = '';
	}


	$query2 = $pdo->query("SELECT * FROM usuarios where id = '$usuario_lanc'");
	$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
	if(@count($res2) > 0){
		$nome_usuario_lanc = $res2[0]['nome'];
	}else{
		$nome_usuario_lanc = '';
	}


	$query2 = $pdo->query("SELECT * FROM formas_pgto where id = '$forma_pgto'");
	$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
	if(@count($res2) > 0){
		$nome_forma_pgto = $res2[0]['nome'];
	}else{
		$nome_forma_pgto = '';
	}


	if($status == 'Aberto'){		
		$classe_pago = 'red';
	
	}else{		
		$classe_pago = 'green';
			
	}

}






			if($total_comissoes > 0){
			echo '<div style="border-bottom: 1px solid #000; margin-top: 30px">
				<div style="font-size: 13px; margin-bottom: 7px"><b>DETALHAMENTO DE COMISSÕES <span style="color:green">R$ '.$valorF.'</span></b></div>
			</div>	
			<table id="cabecalhotabela" style="border-bottom-style: solid; font-size: 12px; margin-bottom:10px; width: 100%; table-layout: fixed; margin-top: 5px">
			<thead>	
			<tr id="cabeca" style="margin-left: 0px; background-color:#CCC; font-weight: bold">';
					

					if($valor_escritorio > 0){
						echo '<td style="width:20%">ESCRITÓRIO</td>';					
					}

					if($valor_advogado1 > 0){
						echo '<td style="width:20%">ADVOGADO</td>';	
					}

					if($valor_advogado2 > 0){
						echo '<td style="width:20%">ADVOGADO</td>';
					}

					if($valor_advogado3 > 0){
						echo '<td style="width:20%">ADVOGADO</td>';						
					}

					if($valor_marketing > 0){
						echo '<td style="width:20%">MARKETING</td>';				
					}

					if($valor_indicacao > 0){
						echo '<td style="width:20%">INDICAÇÃO</td>';							
					}

					if($valor_pessoa1 > 0){
						echo '<td style="width:20%">'.@mb_strtoupper($motivo1).'</td>';						
					}

					if($valor_pessoa2 > 0){
						echo '<td style="width:20%">'.@mb_strtoupper($motivo2).'</td>';						
					}
				echo '</tr>';

				echo '<tr id="cabeca" style="margin-left: 0px;">';
					

					if($valor_escritorio > 0){
						echo '<td style="width:20%"><small><small></td>';								
					}

					if($valor_advogado1 > 0){
						echo '<td style="width:20%"><small>'. $nome_advogado1.'<small></td>';						
					}

					if($valor_advogado2 > 0){
						echo '<td style="width:20%"><small>'. $nome_advogado2.'<small></td>';				
					}

					if($valor_advogado3 > 0){
						echo '<td style="width:20%"><small>'. $nome_advogado3.'<small></td>	';			
					}

					if($valor_marketing > 0){
						echo '<td style="width:20%"><small>'. $nome_marketing.'<small></td>';								
					}

					if($valor_indicacao > 0){
						echo '<td style="width:20%"><small>'. $nome_indicacao.'<small></td>';							
					}

					if($valor_pessoa1 > 0){
						echo '<td style="width:20%"><small>'. $nome_pessoa1.'<small></td>';							
					}

					if($valor_pessoa2 > 0){
						echo '<td style="width:20%"><small>'. $nome_pessoa2.'<small></td>';							
					}
				echo '</tr>';	


				echo '<tr id="cabeca" style="margin-left: 0px;">';											
					
					if($valor_escritorio > 0){
						echo '<td style="width:20%">'. $valor_escritorioF.'%</td>';								
					}

					if($valor_advogado1 > 0){
						echo '<td style="width:20%">'. $valor_advogado1F.'%</td>';								
					}

					if($valor_advogado2 > 0){
						echo '<td style="width:20%">'. $valor_advogado2F.'%</td>';								
					}

					if($valor_advogado3 > 0){
						echo '<td style="width:20%">'. $valor_advogado3F.'%</td>';								
					}


					if($valor_marketing > 0){
						echo '<td style="width:20%">'. $valor_marketingF.'%</td>';								
					}

					if($valor_indicacao > 0){
						echo '<td style="width:20%">'. $valor_indicacaoF.'%</td>';								
					}

					if($valor_pessoa1 > 0){
						echo '<td style="width:20%">'. $valor_pessoa1F.'%</td>';								
					}

					if($valor_pessoa2 > 0){
						echo '<td style="width:20%">'. $valor_pessoa2F.'%</td>';								
					}
				echo '</tr>';	

			echo '</thead>';	

		echo '</table>';	
	}

	if($valor_entrada > 0){
		$query = $pdo->query("SELECT * from receber where id_ref = '$id' and referencia = 'Abertura Contrato' and parcela is null and financeiro = 'Não'");
		$res = $query->fetchAll(PDO::FETCH_ASSOC);
		$id_da_conta_entrada = $res[0]['id'];
	}


		if($valor_entrada > 0 and $total_comissoes == 0){
		echo '<div style="font-size: 13px; margin-bottom: 7px"><b>DETALHAMENTO DA ENTRADA <span style="color:green">R$ '.$valor_entradaF.'</span> <small>('.$nome_forma_pgto.')</small></b>

				<form   method="POST" action="rel/recibo_conta_class.php" target="_blank" style="display:inline-block">
					<input type="hidden" name="id" value="'.$id_da_conta_entrada.'">
					<big><button class="" icones_mobile" title="PDF do Recibo Conta" style="background:transparent; border:none; margin:0; padding:0"><i class="fa fa-file-pdf-o " style="color:red"></i></button></big>
					</form>

		</div>';
		}


	if($valor_entrada > 0 and $total_comissoes > 0){
			echo '<div style="border-bottom: 1px solid #000; margin-top: 30px">
				<div style="font-size: 13px; margin-bottom: 7px"><b>DETALHAMENTO DA ENTRADA <span style="color:green">R$ '.$valor_entradaF.'<small>('.$nome_forma_pgto.')</small></b>

				<form   method="POST" action="rel/recibo_conta_class.php" target="_blank" style="display:inline-block">
					<input type="hidden" name="id" value="'.$id_da_conta_entrada.'">
					<big><button class="" icones_mobile" title="PDF do Recibo Conta" style="background:transparent; border:none; margin:0; padding:0"><i class="fa fa-file-pdf-o " style="color:red"></i></button></big>
					</form>

				</div>
			</div>	
			<table id="cabecalhotabela" style="border-bottom-style: solid; font-size: 12px; margin-bottom:10px; width: 100%; table-layout: fixed; margin-top: 5px">
			<thead>	
			<tr id="cabeca" style="margin-left: 0px; background-color:#CCC; font-weight: bold">';
					

					if($valor_escritorio > 0){
						echo '<td style="width:20%">ESCRITÓRIO</td>';					
					}

					if($valor_advogado1 > 0){
						echo '<td style="width:20%">ADVOGADO</td>';	
					}

					if($valor_advogado2 > 0){
						echo '<td style="width:20%">ADVOGADO</td>';
					}

					if($valor_advogado3 > 0){
						echo '<td style="width:20%">ADVOGADO</td>';						
					}

					if($valor_marketing > 0){
						echo '<td style="width:20%">MARKETING</td>';				
					}

					if($valor_indicacao > 0){
						echo '<td style="width:20%">INDICAÇÃO</td>';							
					}

					if($valor_pessoa1 > 0){
						echo '<td style="width:20%">'.@mb_strtoupper($motivo1).'</td>';						
					}

					if($valor_pessoa2 > 0){
						echo '<td style="width:20%">'.@mb_strtoupper($motivo2).'</td>';						
					}
				echo '</tr>';

				echo '<tr id="cabeca" style="margin-left: 0px;">';
					

					if($valor_escritorio > 0){
						echo '<td style="width:20%"><small><small></td>';								
					}

					if($valor_advogado1 > 0){
						echo '<td style="width:20%"><small>'. $nome_advogado1.'<small></td>';						
					}

					if($valor_advogado2 > 0){
						echo '<td style="width:20%"><small>'. $nome_advogado2.'<small></td>';				
					}

					if($valor_advogado3 > 0){
						echo '<td style="width:20%"><small>'. $nome_advogado3.'<small></td>	';			
					}

					if($valor_marketing > 0){
						echo '<td style="width:20%"><small>'. $nome_marketing.'<small></td>';								
					}

					if($valor_indicacao > 0){
						echo '<td style="width:20%"><small>'. $nome_indicacao.'<small></td>';							
					}

					if($valor_pessoa1 > 0){
						echo '<td style="width:20%"><small>'. $nome_pessoa1.'<small></td>';							
					}

					if($valor_pessoa2 > 0){
						echo '<td style="width:20%"><small>'. $nome_pessoa2.'<small></td>';							
					}
				echo '</tr>';	


				echo '<tr id="cabeca" style="margin-left: 0px;">';											
					
					if($valor_escritorio > 0){
						echo '<td style="width:20%">R$ '. $valor_comissao_escritorioF.'</td>';								
					}

					if($valor_advogado1 > 0){
						echo '<td style="width:20%">R$ '. $valor_comissao_advogado1F.'</td>';								
					}

					if($valor_advogado2 > 0){
						echo '<td style="width:20%">R$ '. $valor_comissao_advogado2F.'</td>';								
					}

					if($valor_advogado3 > 0){
						echo '<td style="width:20%">R$ '. $valor_comissao_advogado3.'</td>';								
					}


					if($valor_marketing > 0){
						echo '<td style="width:20%">R$ '. $valor_comissao_marketingF.'</td>';								
					}

					if($valor_indicacao > 0){
						echo '<td style="width:20%">R$ '. $valor_comissao_indicacaoF.'</td>';								
					}

					if($valor_pessoa1 > 0){
						echo '<td style="width:20%">R$ '. $valor_comissao_pessoa1.'</td>';								
					}

					if($valor_pessoa2 > 0){
						echo '<td style="width:20%">R$ '. $valor_comissao_pessoa2.'</td>';								
					}
				echo '</tr>';	

			echo '</thead>';	

		echo '</table>';	
	}





		echo '<div style="border-bottom: 1px solid #000; margin-top: 30px">

				<div style="font-size: 13px; margin-bottom: 7px"><b>DETALHAMENTO DAS PARCELAS</b></div>

			</div>	
		<table id="cabecalhotabela" style="width: 100%; table-layout: fixed; font-size:11px; text-transform: uppercase;">

			<thead>
				<tr id="cabeca" style="margin-left: 0px; background-color:#CCC; font-weight: bold">

					<td style="width:40%">DESCRIÇÃO</td>
					<td style="width:15%">VALOR</td>
					<td style="width:10%">VENCIMENTO</td>
					<td style="width:10%">PAGAMENTO</td>	
					<td style="width:15%">FORMA PGTO</td>
					<td style="width:10%">BAIXA</td>
				</tr>';				

$total_pago = 0;
$total_pendentes = 0;
$total_vencidas = 0;
$total_pendentesF = 0;
$total_vencidasF = 0;
$total_pagoF = 0;				
$parcelas_pagas = 0;
$query = $pdo->query("SELECT * from receber where referencia = 'Abertura Contrato' and id_ref = '$id' and parcela is not null and financeiro = 'Não' ORDER BY ID ASC");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
for($i=0; $i<$linhas; $i++){	
$id_da_conta = $res[$i]['id'];
$descricao = $res[$i]['descricao'];
$data_venc_parcela = $res[$i]['vencimento'];
$valor_parcela = $res[$i]['valor'];
$pago = $res[$i]['pago'];
$forma_pgto_parcela = $res[$i]['forma_pgto'];
$data_pgto_parcela = $res[$i]['data_pgto'];

$descricao = $res[$i]['descricao'];
	$cliente = $res[$i]['cliente'];
	$valor = $res[$i]['valor'];
	$vencimento = $res[$i]['vencimento'];
	$data_pgto = $res[$i]['data_pgto'];
	$data_lanc = $res[$i]['data_lanc'];
	$forma_pgto = $res[$i]['forma_pgto'];
	$frequencia = $res[$i]['frequencia'];
	$obs = $res[$i]['obs'];
	$arquivo = $res[$i]['arquivo'];
	$referencia = $res[$i]['referencia'];
	$id_ref = $res[$i]['id_ref'];
	$multa = $res[$i]['multa'];
	$juros = $res[$i]['juros'];
	$desconto = $res[$i]['desconto'];
	$taxa = $res[$i]['taxa'];
	$subtotal = $res[$i]['subtotal'];
	$usuario_lanc = $res[$i]['usuario_lanc'];
	$usuario_pgto = $res[$i]['usuario_pgto'];
	$pago = $res[$i]['pago'];
	$usuario_receb = $res[$i]['usuario_receb'];
	$financeiro = $res[$i]['financeiro'];

if($pago == 'Sim'){
	$parcelas_pagas += $valor_parcela;
	$classe_pago = 'verde.jpg';	
	$texto_pg = 'green';
	$classe_ocultar_baixar = 'ocultar';
	$classe_ocultar_recibo = '';
	$valor_parcela = $subtotal;
}else{	
	$classe_pago = 'vermelho.jpg';	
	$texto_pg = 'red';
	$classe_ocultar_baixar = '';
	$classe_ocultar_recibo = 'ocultar';
}


$valor_multa = 0;
$valor_juros = 0;
$classe_venc = '';
if(@strtotime($vencimento) < @strtotime($data_hoje)){
	$classe_venc = 'text-danger';
	$valor_multa = $multa_atraso;

	//pegar a quantidade de dias que o pagamento está atrasado
	$dif = @strtotime($data_hoje) - @strtotime($vencimento);
	$dias_vencidos = floor($dif / (60*60*24));

	$valor_juros = ($valor * $juros_atraso / 100) * $dias_vencidos;
	$total_vencidas += $valor;
}


$query2 = $pdo->query("SELECT * FROM formas_pgto where id = '$forma_pgto_parcela'");
	$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
	if(@count($res2) > 0){
		$nome_forma_pgto_parcela = $res2[0]['nome'];
		$taxa_pgto = $res2[0]['taxa'];
	}else{
		$nome_forma_pgto_parcela = '';
		$taxa_pgto = $res2[0]['taxa'];
	}


$total_pendentesF = @number_format($total_pendentes, 2, ',', '.');
$total_vencidasF = @number_format($total_vencidas, 2, ',', '.');
$total_pagoF = @number_format($total_pago, 2, ',', '.');

$taxa_conta = $taxa_pgto * $valor / 100;




$data_venc_parcelaF = implode('/', array_reverse(@explode('-', $data_venc_parcela)));
$data_pgto_parcelaF = implode('/', array_reverse(@explode('-', $data_pgto_parcela)));
$valor_parcelaF = @number_format($valor_parcela, 2, ',', '.');



      echo '<tr>

<td style="width:40%"><img style="margin-top: 0px" src="'.$url_sistema.'painel/images/'.$classe_pago.'" width="8px">
	'.$descricao.'</td>

<td style="width:15%; color:'.$texto_pg.'">R$'.$valor_parcelaF.' 

	

</td>

<td style="width:10%">'.$data_venc_parcelaF.'</td>

<td style="width:10%; ">'.$data_pgto_parcelaF.'</td>

<td style="width:15%">';
	if($pago == 'Sim'){ 
		echo $nome_forma_pgto_parcela; 
	}
	
		
echo '</td>

<td style="width:10%">

<input id="descricao_'.$id_da_conta.'" type="hidden" value="'.$id.'">
<input id="forma_pgto_'.$id_da_conta.'" type="hidden" value="'.$forma_pgto_parcela.'">
<input id="referencia_'.$id_da_conta.'" type="hidden" value="'.$referencia.'">

<big><a class="'.$classe_ocultar_baixar.'" href="#" onclick="baixar('.$id_da_conta.', '.$valor_parcela.',  '.$taxa_conta.', '.$valor_multa.', '.$valor_juros.')" title="Baixar Conta"><i class="fa fa-check-square " style="color:#079934"></i></a></big>

<big><a class="'.$classe_ocultar_baixar.'" icones_mobile" href="#" onclick="cobrar('.$id.')" title="Gerar Cobrança"><i class="fa fa-whatsapp " style="color:green"></i></a></big>


<form   method="POST" action="rel/recibo_conta_class.php" target="_blank" style="display:inline-block">
					<input type="hidden" name="id" value="'.$id_da_conta.'">
					<big><button class="'.$classe_ocultar_recibo.'" icones_mobile" title="PDF do Recibo Conta" style="background:transparent; border:none; margin:0; padding:0"><i class="fa fa-file-pdf-o " style="color:green"></i></button></big>
					</form>


</td>

    </tr>';



 }  
		echo '</thead>

		</table>';


$total_pendente = $valor_restante - $parcelas_pagas;

$valor_restante_escritorio = $total_pendente * $valor_escritorio / 100;
$valor_restante_advogado1 = $total_pendente * $valor_advogado1 / 100;
$valor_restante_advogado2 = $total_pendente * $valor_advogado2 / 100;
$valor_restante_advogado3 = $total_pendente * $valor_advogado3 / 100;
$valor_restante_marketing = $total_pendente * $valor_marketing / 100;
$valor_restante_indicacao = $total_pendente * $valor_indicacao / 100;
$valor_restante_pessoa1 = $total_pendente * $valor_pessoa1 / 100;
$valor_restante_pessoa2 = $total_pendente * $valor_pessoa2 / 100;

$valor_pago_escritorio = $parcelas_pagas * $valor_escritorio / 100;
$valor_pago_advogado1 = $parcelas_pagas * $valor_advogado1 / 100;
$valor_pago_advogado2 = $parcelas_pagas * $valor_advogado2 / 100;
$valor_pago_advogado3 = $parcelas_pagas * $valor_advogado3 / 100;
$valor_pago_marketing = $parcelas_pagas * $valor_marketing / 100;
$valor_pago_indicacao = $parcelas_pagas * $valor_indicacao / 100;
$valor_pago_pessoa1 = $parcelas_pagas * $valor_pessoa1 / 100;
$valor_pago_pessoa2 = $parcelas_pagas * $valor_pessoa2 / 100;


$valor_restante_escritorioF = @number_format($valor_restante_escritorio, 2, ',', '.');
	$valor_restante_advogado1F = @number_format($valor_restante_advogado1, 2, ',', '.');
	$valor_restante_advogado2F = @number_format($valor_restante_advogado2, 2, ',', '.');
	$valor_restante_advogado3F = @number_format($valor_restante_advogado3, 2, ',', '.');
	$valor_restante_marketingF = @number_format($valor_restante_marketing, 2, ',', '.');
	$valor_restante_indicacaoF = @number_format($valor_restante_indicacao, 2, ',', '.');
	$valor_restante_pessoa1F = @number_format($valor_restante_pessoa1, 2, ',', '.');
	$valor_restante_pessoa2F = @number_format($valor_restante_pessoa2, 2, ',', '.');


	$valor_pago_escritorioF = @number_format($valor_pago_escritorio, 2, ',', '.');
	$valor_pago_advogado1F = @number_format($valor_pago_advogado1, 2, ',', '.');
	$valor_pago_advogado2F = @number_format($valor_pago_advogado2, 2, ',', '.');
	$valor_pago_advogado3F = @number_format($valor_pago_advogado3, 2, ',', '.');
	$valor_pago_marketingF = @number_format($valor_pago_marketing, 2, ',', '.');
	$valor_pago_indicacaoF = @number_format($valor_pago_indicacao, 2, ',', '.');
	$valor_pago_pessoa1F = @number_format($valor_pago_pessoa1, 2, ',', '.');
	$valor_pago_pessoa2F = @number_format($valor_pago_pessoa2, 2, ',', '.');


 }






 if($valor_entrada > 0 and $total_comissoes > 0){
			echo '<div style="border-bottom: 1px solid #000; margin-top: 30px">
				<div style="font-size: 13px; margin-bottom: 7px"><b>PROJEÇÃO DE RECEBIMENTOS PARCELAS RESTANTES <span style="color:green">R$ '.$valor_restanteF.'</b></div>
			</div>	
			<table id="cabecalhotabela" style="border-bottom-style: solid; font-size: 12px; margin-bottom:10px; width: 100%; table-layout: fixed; margin-top: 5px">
			<thead>	
			<tr id="cabeca" style="margin-left: 0px; background-color:#CCC; font-weight: bold">';
					

					if($valor_escritorio > 0){
						echo '<td style="width:20%">ESCRITÓRIO</td>';					
					}

					if($valor_advogado1 > 0){
						echo '<td style="width:20%">ADVOGADO</td>';	
					}

					if($valor_advogado2 > 0){
						echo '<td style="width:20%">ADVOGADO</td>';
					}

					if($valor_advogado3 > 0){
						echo '<td style="width:20%">ADVOGADO</td>';						
					}

					if($valor_marketing > 0){
						echo '<td style="width:20%">MARKETING</td>';				
					}

					if($valor_indicacao > 0){
						echo '<td style="width:20%">INDICAÇÃO</td>';							
					}

					if($valor_pessoa1 > 0){
						echo '<td style="width:20%">'.@mb_strtoupper($motivo1).'</td>';						
					}

					if($valor_pessoa2 > 0){
						echo '<td style="width:20%">'.@mb_strtoupper($motivo2).'</td>';						
					}
				echo '</tr>';

				echo '<tr id="cabeca" style="margin-left: 0px;">';
					

					if($valor_escritorio > 0){
						echo '<td style="width:20%"><small><small></td>';								
					}

					if($valor_advogado1 > 0){
						echo '<td style="width:20%"><small>'. $nome_advogado1.'<small></td>';						
					}

					if($valor_advogado2 > 0){
						echo '<td style="width:20%"><small>'. $nome_advogado2.'<small></td>';				
					}

					if($valor_advogado3 > 0){
						echo '<td style="width:20%"><small>'. $nome_advogado3.'<small></td>	';			
					}

					if($valor_marketing > 0){
						echo '<td style="width:20%"><small>'. $nome_marketing.'<small></td>';								
					}

					if($valor_indicacao > 0){
						echo '<td style="width:20%"><small>'. $nome_indicacao.'<small></td>';							
					}

					if($valor_pessoa1 > 0){
						echo '<td style="width:20%"><small>'. $nome_pessoa1.'<small></td>';							
					}

					if($valor_pessoa2 > 0){
						echo '<td style="width:20%"><small>'. $nome_pessoa2.'<small></td>';							
					}
				echo '</tr>';	



				echo '<tr  style="margin-left: 0px;">';
					

					if($valor_escritorio > 0){
						echo '<small><td style="width:20%; font-size:10px">Recebido / Pendente</td></small>';					
					}

					if($valor_advogado1 > 0){
						echo '<small><td style="width:20%; font-size:10px">Recebido / Pendente</td></small>';	
					}

					if($valor_advogado2 > 0){
						echo '<small><td style="width:20%; font-size:10px">Recebido / Pendente</td></small>';
					}

					if($valor_advogado3 > 0){
						echo '<small><td style="width:20%; font-size:10px">Recebido / Pendente</td></small>';						
					}

					if($valor_marketing > 0){
						echo '<small><td style="width:20%; font-size:10px">Recebido / Pendente</td></small>';				
					}

					if($valor_indicacao > 0){
						echo '<small><td style="width:20%; font-size:10px">Recebido / Pendente</td></small>';							
					}

					if($valor_pessoa1 > 0){
						echo '<small><td style="width:20%; font-size:10px">Recebido / Pendente</td></small>';					
					}

					if($valor_pessoa2 > 0){
						echo '<small><td style="width:20%; font-size:10px">Recebido / Pendente</td></small>';							
					}
				echo '</tr>';



				echo '<tr id="cabeca" style="margin-left: 0px;">';											
					
					if($valor_escritorio > 0){
						echo '<small><td style="width:20%; font-size:10px">
						<span style="color:green"> R$ '.$valor_pago_escritorioF.'</span> / 
						<span style="color:red">R$ '.$valor_restante_escritorioF.'</span>
						</td></small>';						
					}

					if($valor_advogado1 > 0){
						echo '<small><td style="width:20%; font-size:10px">
						<span style="color:green"> R$ '.$valor_pago_advogado1F.'</span> / 
						<span style="color:red">R$ '.$valor_restante_advogado1F.'</span>
						</td></small>';		
					}

					if($valor_advogado2 > 0){
						echo '<small><td style="width:20%; font-size:10px">
						<span style="color:green"> R$ '.$valor_pago_advogado2F.'</span> / 
						<span style="color:red">R$ '.$valor_restante_advogado2F.'</span>
						</td></small>';				
					}

					if($valor_advogado3 > 0){
						echo '<small><td style="width:20%; font-size:10px">
						<span style="color:green"> R$ '.$valor_pago_advogado3F.'</span> / 
						<span style="color:red">R$ '.$valor_restante_advogado3F.'</span>
						</td></small>';									
					}


					if($valor_marketing > 0){
						echo '<small><td style="width:20%; font-size:10px">
						<span style="color:green"> R$ '.$valor_pago_marketingF.'</span> / 
						<span style="color:red">R$ '.$valor_restante_marketingF.'</span>
						</td></small>';							
					}

					if($valor_indicacao > 0){
						echo '<small><td style="width:20%; font-size:10px">
						<span style="color:green"> R$ '.$valor_pago_indicacaoF.'</span> / 
						<span style="color:red">R$ '.$valor_restante_indicacaoF.'</span>
						</td></small>';									
					}

					if($valor_pessoa1 > 0){
						echo '<small><td style="width:20%; font-size:10px">
						<span style="color:green"> R$ '.$valor_pago_pessoa1F.'</span> / 
						<span style="color:red">R$ '.$valor_restante_pessoa1F.'</span>
						</td></small>';									
					}

					if($valor_pessoa2 > 0){
						echo '<small><td style="width:20%; font-size:10px">
						<span style="color:green"> R$ '.$valor_pago_pessoa2F.'</span> / 
						<span style="color:red">R$ '.$valor_restante_pessoa2F.'</span>
						</td></small>';							
					}
				echo '</tr>';	

			echo '</thead>';	

		echo '</table>';	
	}


?>


<script type="text/javascript">
	$(document).ready( function () {		
    $('#tabela3').DataTable({
    	"language" : {
            //"url" : '//cdn.datatables.net/plug-ins/1.13.2/i18n/pt-BR.json'
        },
        "ordering": false,
		"stateSave": true
    });
} );


	function baixar(id, valor, taxa, multa, juros){

		var descricao = $('#descricao_'+id).val();
		var pgto = $('#forma_pgto_'+id).val();
		var referencia = $('#referencia_'+id).val();

		if(referencia == 'Abertura Contrato'){
			$('#valor-baixar').attr('readonly', true);
		}else{
			$('#valor-baixar').attr('readonly', false);
		}

	$('#id-baixar').val(id);
	$('#descricao-baixar').text(descricao);
	$('#valor-baixar').val(valor);
	$('#saida-baixar').val(pgto).change();
	$('#subtotal').val(valor);

	
	$('#valor-juros').val(juros);
	$('#valor-desconto').val('');
	$('#valor-multa').val(multa);
	$('#valor-taxa').val(taxa);

	totalizar()

	$('#modalBaixar').modal('show');
	$('#mensagem-baixar').text('');
}


function cobrar(id){
	$.ajax({
		url: 'paginas/receber/cobrar.php',
		method: 'POST',
		data: {id},
		dataType: "html",

		success:function(result){
			alert(result);
		}
	});
}

</script>