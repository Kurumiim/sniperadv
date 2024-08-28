<?php 

include('../../conexao.php');
require_once("data_formatada.php");

$token_rel = @$_GET['token'];
if($token_rel != 'A5030'){
echo '<script>window.location="../../"</script>';
exit();
}


$id = $_GET['id'];

$data_atual = date('Y-m-d');


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
	$numeracao = $res[0]['numeracao'];

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

?>

<!DOCTYPE html>

<html>

<head>



<style>



@import url('https://fonts.cdnfonts.com/css/tw-cen-mt-condensed');

@page { margin: 145px 20px 25px 20px; }

#header { position: fixed; left: 0px; top: -110px; bottom: 100px; right: 0px; height: 35px; text-align: center; padding-bottom: 100px; }

#content {margin-top: 0px;}

#footer { position: fixed; left: 0px; bottom: -60px; right: 0px; height: 80px; }

#footer .page:after {content: counter(page, my-sec-counter);}

body {font-family: 'Tw Cen MT', sans-serif;}



.marca{

	position:fixed;

	left:50;

	top:100;

	width:80%;

	opacity:8%;

}



</style>



</head>

<body>

<?php 

if($marca_dagua == 'Sim'){ ?>

<img class="marca" src="<?php echo $url_sistema ?>img/logo.jpg">	

<?php } ?>





<div id="header" >



	<div style="border-style: solid; font-size: 10px; height: 50px;">

		<table style="width: 100%; border: 0px solid #ccc;">

			<tr>

				<td style="border: 1px; solid #000; width: 40%; text-align: left;">

					<img style="margin-top: 7px; margin-left: 7px;" id="imag" src="<?php echo $url_sistema ?>img/logo.jpg" width="130px">

				</td>

				

				<td style="width: 5%; text-align: center; font-size: 13px;">

				

				</td>

				<td style="width: 40%; text-align: right; font-size: 9px;padding-right: 10px;">

						<b><big>DETALHAMENTO CONTRATO <?php echo $numeracao ?></big></b><br> <b>CLIENTE: </b><?php echo @mb_strtoupper($nome_cliente) ?> <br> <?php echo @mb_strtoupper($data_hoje) ?>

				</td>

			</tr>		

		</table>

	</div>



<br>





		<table id="cabecalhotabela" style="border-bottom-style: solid; font-size: 12px; margin-bottom:10px; width: 100%; table-layout: fixed;">

			<thead>

				

				<tr id="cabeca" style="margin-left: 0px; background-color:#CCC; font-weight: bold">

					<td style="width:12%">VALOR</td>

					<td style="width:31%">SERVIÇO</td>

					<td style="width:12%">DATA</td>

					<td style="width:15%">R$ ENTRADA</td>

					<td style="width:15%">PARCELAS</td>

					<td style="width:15%">FREQUÊNCIA</td>

					

				</tr>



				<tr id="cabeca" style="margin-left: 0px;">

					<td style="width:12%">R$ <?php echo $valorF ?> </td>

					<td style="width:31%"><?php echo $nome_servico ?></td>

					<td style="width:12%"><?php echo $dataF ?></td>

					<td style="width:15%">R$ <?php echo $valor_entradaF ?></td>

					<td style="width:15%; "><?php echo $parcelas ?></td>

					<td style="width:15%; "><?php echo $nome_frequencia ?></td>

					

				</tr>

			</thead>

		</table>




		<table id="" style="border-style: solid; font-size: 9px; margin-bottom:10px; width: 100%; table-layout: fixed; margin-top:10px;">
			<thead>		
				<tr id="cabeca" style="margin-left: 0px; background-color:#f2f0f0">
					<td colspan="8" style="width:100%; font-size: 10px"><b>DADOS DO CLIENTE</b> </td>
				</tr>
				<tr >
					<td style="width:5%; border-right: 1px solid #000;border-bottom: : 1px solid #000;">NOME: </td>
					<td style="width:27%; border-right: : 1px solid #000; border-bottom: : 1px solid #000;">
						<?php echo @mb_strtoupper($nome_cliente) ?>
					</td>					

					<td style="width:6%; border-right: 1px solid #000;border-bottom: : 1px solid #000;">CPF: </td>
					<td style="width:13%; border-bottom: : 1px solid #000; border-right: 1px solid #000;">
						<?php echo @mb_strtoupper($cpf_cliente) ?>
					</td>

					<td style="width:9%; border-right: 1px solid #000;border-bottom: : 1px solid #000;">TELEFONE: </td>
					<td style="width:13%; border-bottom: : 1px solid #000; border-right: 1px solid #000;">
						<?php echo @mb_strtoupper($telefone_cliente) ?>
					</td>

					<td style="width:4%; border-right: 1px solid #000;border-bottom: : 1px solid #000;">RG: </td>
					<td style="width:13%; border-bottom: : 1px solid #000;">
						<?php echo @mb_strtoupper($rg_cliente) ?>
					</td>
    			</tr>


    			<tr >
					<td style="width:5%; border-right: 1px solid #000;border-bottom: : 1px solid #000;">NASC: </td>
					<td style="width:27%; border-right: : 1px solid #000; border-bottom: : 1px solid #000;">
						<?php echo @mb_strtoupper($data_nasc_clienteF) ?>
					</td>					

					<td style="width:6%; border-right: 1px solid #000;border-bottom: : 1px solid #000;">PESSOA: </td>
					<td style="width:13%; border-bottom: : 1px solid #000; border-right: 1px solid #000;">
						<?php echo @mb_strtoupper($tipo_pessoa_cliente) ?>
					</td>

					<td style="width:9%; border-right: 1px solid #000;border-bottom: : 1px solid #000;">ENDEREÇO: </td>
					<td colspan="3" style="width:31%; border-bottom: : 1px solid #000; border-right: 1px solid #000;">
						<?php echo @mb_strtoupper($endereco_cliente) ?> <?php echo @mb_strtoupper($numero_cliente) ?>  <?php echo @mb_strtoupper($cidade_cliente) ?> 
					</td>

					
    			</tr>


    			
    			

			</thead>

		</table>




		


	


			<?php if($total_comissoes > 0){ ?>
			<div style="border-bottom: 1px solid #000; margin-top: 30px">

				<div style="font-size: 11px; margin-bottom: 7px"><b>DETALHAMENTO DE COMISSÕES <span style="color:green">R$ <?php echo $valorF ?></span></b></div>

			</div>	

			<table id="cabecalhotabela" style="border-bottom-style: solid; font-size: 11px; margin-bottom:10px; width: 100%; table-layout: fixed; margin-top: 5px">

			<thead>				

				<tr id="cabeca" style="margin-left: 0px; background-color:#CCC; font-weight: bold">
					

					<?php if($valor_escritorio > 0){ ?>
						<td style="width:20%">ESCRITÓRIO</td>							
					<?php } ?>

					<?php if($valor_advogado1 > 0){ ?>
						<td style="width:20%">ADVOGADO</td>							
					<?php } ?>

					<?php if($valor_advogado2 > 0){ ?>
						<td style="width:20%">ADVOGADO</td>							
					<?php } ?>

					<?php if($valor_advogado3 > 0){ ?>
						<td style="width:20%">ADVOGADO</td>							
					<?php } ?>

					<?php if($valor_marketing > 0){ ?>
						<td style="width:20%">MARKETING</td>							
					<?php } ?>

					<?php if($valor_indicacao > 0){ ?>
						<td style="width:20%">INDICAÇÃO</td>							
					<?php } ?>

					<?php if($valor_pessoa1 > 0){ ?>
						<td style="width:20%"><?php echo @mb_strtoupper($motivo1); ?></td>						
					<?php } ?>

					<?php if($valor_pessoa2 > 0){ ?>
						<td style="width:20%"><?php echo @mb_strtoupper($motivo2); ?></td>						
					<?php } ?>
				</tr>



				<tr id="cabeca" style="margin-left: 0px;">
					

					<?php if($valor_escritorio > 0){ ?>
						<td style="width:20%"><small><small></td>							
					<?php } ?>

					<?php if($valor_advogado1 > 0){ ?>
						<td style="width:20%"><small><?php echo $nome_advogado1 ?><small></td>					
					<?php } ?>

					<?php if($valor_advogado2 > 0){ ?>
						<td style="width:20%"><small><?php echo $nome_advogado2 ?><small></td>			
					<?php } ?>

					<?php if($valor_advogado3 > 0){ ?>
						<td style="width:20%"><small><?php echo $nome_advogado3 ?><small></td>			
					<?php } ?>

					<?php if($valor_marketing > 0){ ?>
						<td style="width:20%"><small><?php echo $nome_marketing ?><small></td>							
					<?php } ?>

					<?php if($valor_indicacao > 0){ ?>
						<td style="width:20%"><small><?php echo $nome_indicacao ?><small></td>						
					<?php } ?>

					<?php if($valor_pessoa1 > 0){ ?>
						<td style="width:20%"><small><?php echo $nome_pessoa1 ?><small></td>						
					<?php } ?>

					<?php if($valor_pessoa2 > 0){ ?>
						<td style="width:20%"><small><?php echo $nome_pessoa2 ?><small></td>						
					<?php } ?>
				</tr>


				<tr id="cabeca" style="margin-left: 0px;">										
					
					<?php if($valor_escritorio > 0){ ?>
						<td style="width:20%"><?php echo $valor_escritorioF ?>%</td>							
					<?php } ?>

					<?php if($valor_advogado1 > 0){ ?>
						<td style="width:20%"><?php echo $valor_advogado1F ?>%</td>							
					<?php } ?>

					<?php if($valor_advogado2 > 0){ ?>
						<td style="width:20%"><?php echo $valor_advogado2F ?>%</td>							
					<?php } ?>

					<?php if($valor_advogado3 > 0){ ?>
						<td style="width:20%"><?php echo $valor_advogado3F ?>%</td>							
					<?php } ?>


					<?php if($valor_marketing > 0){ ?>
						<td style="width:20%"><?php echo $valor_marketingF ?>%</td>							
					<?php } ?>

					<?php if($valor_indicacao > 0){ ?>
						<td style="width:20%"><?php echo $valor_indicacaoF ?>%</td>							
					<?php } ?>

					<?php if($valor_pessoa1 > 0){ ?>
						<td style="width:20%"><?php echo $valor_pessoa1F ?>%</td>							
					<?php } ?>

					<?php if($valor_pessoa2 > 0){ ?>
						<td style="width:20%"><?php echo $valor_pessoa2F ?>%</td>							
					<?php } ?>
				</tr>

			</thead>

		</table>
	<?php } ?>





		<?php if($valor_entrada > 0 and $total_comissoes > 0){ ?>
		<div style="border-bottom: 1px solid #000; margin-top: 30px">

				<div style="font-size: 11px; margin-bottom: 7px"><b>DETALHAMENTO DA ENTRADA <span style="color:green">R$ <?php echo $valor_entradaF ?>  </span> <small>(<?php echo $nome_forma_pgto ?>)</small></b></div>

			</div>	

			<table id="cabecalhotabela" style="border-bottom-style: solid; font-size: 11px; margin-bottom:10px; width: 100%; table-layout: fixed; margin-top: 5px">

			<thead>				

				<tr id="cabeca" style="margin-left: 0px; background-color:#CCC; font-weight: bold">
					

					<?php if($valor_escritorio > 0){ ?>
						<td style="width:20%">ESCRITÓRIO</td>							
					<?php } ?>

					<?php if($valor_advogado1 > 0){ ?>
						<td style="width:20%">ADVOGADO</td>							
					<?php } ?>

					<?php if($valor_advogado2 > 0){ ?>
						<td style="width:20%">ADVOGADO</td>							
					<?php } ?>

					<?php if($valor_advogado3 > 0){ ?>
						<td style="width:20%">ADVOGADO</td>							
					<?php } ?>

					<?php if($valor_marketing > 0){ ?>
						<td style="width:20%">MARKETING</td>							
					<?php } ?>

					<?php if($valor_indicacao > 0){ ?>
						<td style="width:20%">INDICAÇÃO</td>							
					<?php } ?>

					<?php if($valor_pessoa1 > 0){ ?>
						<td style="width:20%"><?php echo @mb_strtoupper($motivo1); ?></td>						
					<?php } ?>

					<?php if($valor_pessoa2 > 0){ ?>
						<td style="width:20%"><?php echo @mb_strtoupper($motivo2); ?></td>						
					<?php } ?>
				</tr>


				<tr id="cabeca" style="margin-left: 0px;">
					

					<?php if($valor_escritorio > 0){ ?>
						<td style="width:20%"><small><small></td>							
					<?php } ?>

					<?php if($valor_advogado1 > 0){ ?>
						<td style="width:20%"><small><?php echo $nome_advogado1 ?><small></td>					
					<?php } ?>

					<?php if($valor_advogado2 > 0){ ?>
						<td style="width:20%"><small><?php echo $nome_advogado2 ?><small></td>			
					<?php } ?>

					<?php if($valor_advogado3 > 0){ ?>
						<td style="width:20%"><small><?php echo $nome_advogado3 ?><small></td>			
					<?php } ?>

					<?php if($valor_marketing > 0){ ?>
						<td style="width:20%"><small><?php echo $nome_marketing ?><small></td>							
					<?php } ?>

					<?php if($valor_indicacao > 0){ ?>
						<td style="width:20%"><small><?php echo $nome_indicacao ?><small></td>						
					<?php } ?>

					<?php if($valor_pessoa1 > 0){ ?>
						<td style="width:20%"><small><?php echo $nome_pessoa1 ?><small></td>						
					<?php } ?>

					<?php if($valor_pessoa2 > 0){ ?>
						<td style="width:20%"><small><?php echo $nome_pessoa2 ?><small></td>						
					<?php } ?>
				</tr>


				<tr id="cabeca" style="margin-left: 0px;">										
					
					<?php if($valor_escritorio > 0){ ?>
						<td style="width:20%">R$ <?php echo $valor_comissao_escritorioF ?></td>					
					<?php } ?>

					<?php if($valor_advogado1 > 0){ ?>
						<td style="width:20%">R$ <?php echo $valor_comissao_advogado1F ?></td>					
					<?php } ?>

					<?php if($valor_advogado2 > 0){ ?>
						<td style="width:20%">R$ <?php echo $valor_comissao_advogado2F ?></td>						
					<?php } ?>

					<?php if($valor_advogado3 > 0){ ?>
						<td style="width:20%">R$ <?php echo $valor_comissao_advogado3 ?></td>							
					<?php } ?>


					<?php if($valor_marketing > 0){ ?>
						<td style="width:20%">R$ <?php echo $valor_comissao_marketingF ?></td>					
					<?php } ?>

					<?php if($valor_indicacao > 0){ ?>
						<td style="width:20%">R$ <?php echo $valor_comissao_indicacaoF ?></td>						
					<?php } ?>

					<?php if($valor_pessoa1 > 0){ ?>
						<td style="width:20%">R$ <?php echo $valor_comissao_pessoa1 ?></td>						
					<?php } ?>

					<?php if($valor_pessoa2 > 0){ ?>
						<td style="width:20%">R$ <?php echo $valor_comissao_pessoa2 ?></td>							
					<?php } ?>
				</tr>

			</thead>

		</table>
	<?php } ?>



	



		<div style="border-bottom: 1px solid #000; margin-top: 30px">

				<div style="font-size: 11px; margin-bottom: 7px"><b>DETALHAMENTO DAS PARCELAS</b></div>

			</div>	
		<table id="cabecalhotabela" style="width: 100%; table-layout: fixed; font-size:9px; text-transform: uppercase;">

			<thead>



				<tr id="cabeca" style="margin-left: 0px; background-color:#CCC; font-weight: bold">

					<td style="width:40%">DESCRIÇÃO</td>
					<td style="width:15%">VALOR</td>
					<td style="width:15%">VENCIMENTO</td>
					<td style="width:15%">PAGAMENTO</td>	
					<td style="width:15%">FORMA PGTO</td>

				</tr>

				

					<?php 
$parcelas_pagas = 0;
$query = $pdo->query("SELECT * from receber where referencia = 'Abertura Contrato' and id_ref = '$id' and parcela is not null and financeiro = 'Não' ORDER BY ID ASC");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
for($i=0; $i<$linhas; $i++){	

$descricao = $res[$i]['descricao'];
$data_venc_parcela = $res[$i]['vencimento'];
$valor_parcela = $res[$i]['valor'];
$pago = $res[$i]['pago'];
$forma_pgto_parcela = $res[$i]['forma_pgto'];
$data_pgto_parcela = $res[$i]['data_pgto'];

if($pago == 'Sim'){
	$parcelas_pagas += $valor_parcela;
	$classe_pago = 'verde.jpg';	
	$texto_pg = 'green';
}else{	
	$classe_pago = 'vermelho.jpg';	
	$texto_pg = 'red';
}



$data_venc_parcelaF = implode('/', array_reverse(@explode('-', $data_venc_parcela)));
$data_pgto_parcelaF = implode('/', array_reverse(@explode('-', $data_pgto_parcela)));
$valor_parcelaF = @number_format($valor_parcela, 2, ',', '.');

$query2 = $pdo->query("SELECT * FROM formas_pgto where id = '$forma_pgto_parcela'");
	$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
	if(@count($res2) > 0){
		$nome_forma_pgto_parcela = $res2[0]['nome'];
	}else{
		$nome_forma_pgto_parcela = '';
	}
  	 ?>



  	 

      <tr>

<td style="width:40%"><img style="margin-top: 0px" src="<?php echo $url_sistema ?>painel/images/<?php echo $classe_pago ?>" width="8px">
	<?php echo $descricao ?></td>

<td style="width:15%; color:<?php echo $texto_pg ?>">R$<?php echo $valor_parcelaF ?> </td>

<td style="width:15%"><?php echo $data_venc_parcelaF ?></td>

<td style="width:15%; "><?php echo $data_pgto_parcelaF ?></td>

<td style="width:15%">
	<?php if($pago == 'Sim'){ 
		echo $nome_forma_pgto_parcela; 
	}
	?>
		
</td>



    </tr>



<?php }  ?>

				

	

			</thead>

		</table>


<?php
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
  ?>







<?php if($total_comissoes > 0){ ?>
	<div style="border-bottom: 1px solid #000; margin-top: 30px">

				<div style="font-size: 11px; margin-bottom: 7px"><b>PROJEÇÃO DE RECEBIMENTOS PARCELAS RESTANTES <span style="color:green">R$ <?php echo $valor_restanteF ?></span></b></div>

			</div>	

			<table id="cabecalhotabela" style="border-bottom-style: solid; font-size: 11px; margin-bottom:10px; width: 100%; table-layout: fixed; margin-top: 5px">

			<thead>				

				<tr id="cabeca" style="margin-left: 0px; background-color:#CCC; font-weight: bold">
					

					<?php if($valor_escritorio > 0){ ?>
						<td style="width:20%">ESCRITÓRIO</td>							
					<?php } ?>

					<?php if($valor_advogado1 > 0){ ?>
						<td style="width:20%">ADVOGADO</td>							
					<?php } ?>

					<?php if($valor_advogado2 > 0){ ?>
						<td style="width:20%">ADVOGADO</td>							
					<?php } ?>

					<?php if($valor_advogado3 > 0){ ?>
						<td style="width:20%">ADVOGADO</td>							
					<?php } ?>

					<?php if($valor_marketing > 0){ ?>
						<td style="width:20%">MARKETING</td>							
					<?php } ?>

					<?php if($valor_indicacao > 0){ ?>
						<td style="width:20%">INDICAÇÃO</td>							
					<?php } ?>

					<?php if($valor_pessoa1 > 0){ ?>
						<td style="width:20%"><?php echo @mb_strtoupper($motivo1); ?></td>						
					<?php } ?>

					<?php if($valor_pessoa2 > 0){ ?>
						<td style="width:20%"><?php echo @mb_strtoupper($motivo2); ?></td>						
					<?php } ?>
				</tr>


				<tr id="cabeca" style="margin-left: 0px;">
					

					<?php if($valor_escritorio > 0){ ?>
						<td style="width:20%"><small><small></td>							
					<?php } ?>

					<?php if($valor_advogado1 > 0){ ?>
						<td style="width:20%"><small><?php echo $nome_advogado1 ?><small></td>					
					<?php } ?>

					<?php if($valor_advogado2 > 0){ ?>
						<td style="width:20%"><small><?php echo $nome_advogado2 ?><small></td>			
					<?php } ?>

					<?php if($valor_advogado3 > 0){ ?>
						<td style="width:20%"><small><?php echo $nome_advogado3 ?><small></td>			
					<?php } ?>

					<?php if($valor_marketing > 0){ ?>
						<td style="width:20%"><small><?php echo $nome_marketing ?><small></td>							
					<?php } ?>

					<?php if($valor_indicacao > 0){ ?>
						<td style="width:20%"><small><?php echo $nome_indicacao ?><small></td>						
					<?php } ?>

					<?php if($valor_pessoa1 > 0){ ?>
						<td style="width:20%"><small><?php echo $nome_pessoa1 ?><small></td>						
					<?php } ?>

					<?php if($valor_pessoa2 > 0){ ?>
						<td style="width:20%"><small><?php echo $nome_pessoa2 ?><small></td>						
					<?php } ?>
				</tr>


				<tr id="cabeca" style="margin-left: 0px;">
					

					<?php if($valor_escritorio > 0){ ?>
						<td style="width:20%"><small>Recebido / Pendente</small></td>							
					<?php } ?>

					<?php if($valor_advogado1 > 0){ ?>
						<td style="width:20%"><small>Recebido / Pendente</small></td>							
					<?php } ?>

					<?php if($valor_advogado2 > 0){ ?>
						<td style="width:20%"><small>Recebido / Pendente</small></td>				
					<?php } ?>

					<?php if($valor_advogado3 > 0){ ?>
						<td style="width:20%"><small>Recebido / Pendente</small></td>						
					<?php } ?>

					<?php if($valor_marketing > 0){ ?>
						<td style="width:20%"><small>Recebido / Pendente</small></td>						
					<?php } ?>

					<?php if($valor_indicacao > 0){ ?>
						<td style="width:20%"><small>Recebido / Pendente</small></td>			
					<?php } ?>

					<?php if($valor_pessoa1 > 0){ ?>
						<td style="width:20%"><small>Recebido / Pendente</small></td>			
					<?php } ?>

					<?php if($valor_pessoa2 > 0){ ?>
						<td style="width:20%"><small>Recebido / Pendente</small></td>						
					<?php } ?>
				</tr>


				<tr id="cabeca" style="margin-left: 0px;">										
					
					<?php if($valor_escritorio > 0){ ?>
						<td style="width:20%"><small><span style="color:green">R$ <?php echo $valor_pago_escritorioF ?></span> / <span style="color:red">R$ <?php echo $valor_restante_escritorioF ?></span></small></td>	
										
					<?php } ?>

					<?php if($valor_advogado1 > 0){ ?>
						<td style="width:20%"><small><span style="color:green">R$ <?php echo $valor_pago_advogado1F ?></span> / <span style="color:red">R$ <?php echo $valor_restante_advogado1F ?></span></small></td>				
					<?php } ?>

					<?php if($valor_advogado2 > 0){ ?>
						<td style="width:20%"><small><span style="color:green">R$ <?php echo $valor_pago_advogado2F ?></span> / <span style="color:red">R$ <?php echo $valor_restante_advogado2F ?></span></small></td>	
					<?php } ?>

					<?php if($valor_advogado3 > 0){ ?>
						<td style="width:20%"><small><span style="color:green">R$ <?php echo $valor_pago_advogado3F ?></span> / <span style="color:red">R$ <?php echo $valor_restante_advogado3F ?></span></small></td>	
					<?php } ?>


					<?php if($valor_marketing > 0){ ?>
						<td style="width:20%"><small><span style="color:green">R$ <?php echo $valor_pago_marketingF ?></span> / <span style="color:red">R$ <?php echo $valor_restante_marketingF ?></span></small></td>					
					<?php } ?>

					<?php if($valor_indicacao > 0){ ?>
						<td style="width:20%"><small><span style="color:green">R$ <?php echo $valor_pago_indicacaoF ?></span> / <span style="color:red">R$ <?php echo $valor_restante_indicacaoF ?></span></small></td>	
					<?php } ?>

					<?php if($valor_pessoa1 > 0){ ?>
						<td style="width:20%"><small><span style="color:green">R$ <?php echo $valor_pago_pessoa1F ?></span> / <span style="color:red">R$ <?php echo $valor_restante_pessoa1F ?></span></small></td>					
					<?php } ?>

					<?php if($valor_pessoa2 > 0){ ?>
						<td style="width:20%"><small><span style="color:green">R$ <?php echo $valor_pago_pessoa2F ?></span> / <span style="color:red">R$ <?php echo $valor_restante_pessoa2F ?></span></small></td>	
					<?php } ?>
				</tr>

			</thead>

		</table>
	<?php } ?>





<?php if($obs != ""){ ?>
		<table>

			<thead>
				<tbody>
					<tr>
						<td style="font-size: 10px; text-align: left;"><b>Observações:</b> <?php echo $obs ?></td>					

					</tr>
				</tbody>
			</thead>
		</table>

	<?php } ?>



</div>




<div id="footer" class="row">

<hr style="margin-bottom: 0;">

	<table style="width:100%;">

		<tr style="width:100%;">

			<td style="width:50%; font-size: 10px; text-align: left;"><?php echo $nome_sistema ?> Telefone: <?php echo $telefone_sistema ?></td>



			<td style="width:50%; font-size: 10px; text-align: right;"> Endereço: <?php echo $endereco_sistema ?></td>

			

		</tr>

	</table>

</div>






</body>



</html>





