<?php 
@session_start();
$mostrar_registros = @$_SESSION['registros'];
$id_usuario = @$_SESSION['id'];
require_once("../../conexao.php");
require_once("data_formatada.php");

$token_rel = @$_GET['token'];
if($token_rel != 'A5030'){
echo '<script>window.location="../../"</script>';
exit();
}

$dataInicial = $_GET['dataInicial'];
$dataFinal = $_GET['dataFinal'];
$status = $_GET['status'];

$mostrar_registros = $_GET['mostrar_registros'];
$id_usuario = $_GET['id_usuario'];

$dataInicialF = implode('/', array_reverse(@explode('-', $dataInicial)));
$dataFinalF = implode('/', array_reverse(@explode('-', $dataFinal)));

$texto_status = "";
if($status == 'Finalizado'){
	$texto_status = ' FINALIZADOS';
}

if($status == 'Aberto'){
	$texto_status = ' PENDENTES';
}	


$datas = "";
if($dataInicial == $dataFinal){
	$datas = $dataInicialF;
}else{
	$datas = $dataInicialF.' à '.$dataFinalF;
}

$texto_filtro = $datas;

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
				<td style="border: 1px; solid #000; width: 7%; text-align: left;">
					<img style="margin-top: 7px; margin-left: 7px;" id="imag" src="<?php echo $url_sistema ?>img/logo.jpg" width="130px">
				</td>
				<td style="width: 30%; text-align: left; font-size: 13px;">
					
				</td>
				<td style="width: 1%; text-align: center; font-size: 13px;">
				
				</td>
				<td style="width: 47%; text-align: right; font-size: 9px;padding-right: 10px;">
						<b><big>RELATÓRIO DE ABERTURA DE CONTRATOS <?php echo $texto_status ?></big></b>
							<br>FILTRO: <?php echo mb_strtoupper($texto_filtro) ?> 
							<br> <?php echo mb_strtoupper($data_hoje) ?>
				</td>
			</tr>		
		</table>
	</div>

<br>


		<table id="cabecalhotabela" style="border-bottom-style: solid; font-size: 8px; margin-bottom:10px; width: 100%; table-layout: fixed;">
			<thead>
				
				<tr id="cabeca" style="margin-left: 0px; background-color:#CCC">
					<td style="width:8%">NUMERAÇÃO</td>
					<td style="width:24%">CLIENTE</td>
					<td style="width:10%">VALOR</td>
					<td style="width:10%">ENTRADA</td>
					<td style="width:8%">PARCELAS</td>
					<td style="width:12%">FREQUÊNCIA</td>
					<td style="width:20%">SERVIÇO</td>	
					<td style="width:8%">DATA</td>		
					
				</tr>
			</thead>
		</table>
</div>

<div id="footer" class="row">
<hr style="margin-bottom: 0;">
	<table style="width:100%;">
		<tr style="width:100%;">
			<td style="width:60%; font-size: 10px; text-align: left;"><?php echo $nome_sistema ?> Telefone: <?php echo $telefone_sistema ?></td>
			<td style="width:40%; font-size: 10px; text-align: right;"><p class="page">Página  </p></td>
		</tr>
	</table>
</div>

<div id="content" style="margin-top: 0;">



		<table style="width: 100%; table-layout: fixed; font-size:9px; text-transform: uppercase;">
			<thead>
				<tbody>
					<?php

$total_valor = 0;
$total_valorF = 0;
$total_pendentes = 0;
$total_pendentesF = 0;
$total_pagas = 0;
$total_pagasF = 0;
$pendentes = 0;
$pagas = 0;

if($mostrar_registros == 'Não'){
	$query = $pdo->query("SELECT * from abertura_contratos where status like '%$status%' and data >= '$dataInicial' and data <= '$dataFinal' and (usuario_lanc = '$id_usuario' or  advogado1 = '$id_usuario' or advogado2 = '$id_usuario' or advogado3 = '$id_usuario' or marketing = '$id_usuario' or indicacao = '$id_usuario' or pessoa1 = '$id_usuario' or pessoa2 = '$id_usuario' ) order by id desc");
}else{
	$query = $pdo->query("SELECT * from abertura_contratos where status like '%$status%' and data >= '$dataInicial' and data <= '$dataFinal' order by id desc");
}

$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
for($i=0; $i<$linhas; $i++){
	$id = $res[$i]['id'];
	$cliente = $res[$i]['cliente'];
	$valor = $res[$i]['valor'];
	$valor_entrada = $res[$i]['valor_entrada'];
	$parcelas = $res[$i]['parcelas'];
	$frequencia = $res[$i]['frequencia'];
	$data_venc = $res[$i]['data_venc'];	
	$status = $res[$i]['status'];
	$tipo_servico = $res[$i]['tipo_servico'];	
	$valor_escritorio = $res[$i]['valor_escritorio'];
	$advogado1 = $res[$i]['advogado1'];
	$advogado2 = $res[$i]['advogado2'];
	$advogado3 = $res[$i]['advogado3'];
	$indicacao = $res[$i]['indicacao'];
	$marketing = $res[$i]['marketing'];
	$pessoa1 = $res[$i]['pessoa1'];
	$pessoa2 = $res[$i]['pessoa2'];
	$valor_advogado1 = $res[$i]['valor_advogado1'];
	$valor_advogado2 = $res[$i]['valor_advogado2'];
	$valor_advogado3 = $res[$i]['valor_advogado3'];
	$valor_marketing = $res[$i]['valor_marketing'];
	$valor_indicacao = $res[$i]['valor_indicacao'];
	$valor_pessoa1 = $res[$i]['valor_pessoa1'];
	$valor_pessoa2 = $res[$i]['valor_pessoa2'];
	$numero_processo = $res[$i]['numero_processo'];
	$motivo1 = $res[$i]['motivo1'];
	$motivo2 = $res[$i]['motivo2'];
	$usuario_lanc = $res[$i]['usuario_lanc'];
	$forma_pgto = $res[$i]['forma_pgto'];
	$data = $res[$i]['data'];
	$obs = $res[$i]['obs'];
	$numeracao = $res[$i]['numeracao'];

	$dataF = implode('/', array_reverse(@explode('-', $data)));
	$valorF = @number_format($valor, 2, ',', '.');
	$valor_entradaF = @number_format($valor_entrada, 2, ',', '.');

	$query2 = $pdo->query("SELECT * FROM clientes where id = '$cliente'");
	$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
	if(@count($res2) > 0){
		$nome_cliente = $res2[0]['nome'];
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


	if($status == 'Aberto'){
		$ocultar_botoes = '';
		$classe_pago = 'vermelho.jpg';	
		$icone = 'fa-square-o';
		$titulo_link = 'Deixar Finalizado';
		$acao = 'Finalizado';
		$classe_ativo = '';
		$total_pendentes += 1;
	}else{
		$ocultar_botoes = 'ocultar';
		$classe_pago = 'verde.jpg';
		$icone = 'fa-check-square';
		$titulo_link = 'Deixar Aberto';
		$acao = 'Aberto';
		$classe_ativo = '#c4c4c4';	
		$total_pagas += 1;	
	}

	$total_valor += $valor;
	$total_valorF = @number_format($total_valor, 2, ',', '.');


  	 ?>

  	 
      <tr>
<td style="width:8%">
	<img style="margin-top: 0px" src="<?php echo $url_sistema ?>painel/images/<?php echo $classe_pago ?>" width="8px">
	<?php echo $numeracao ?>
<td style="width:24%"><?php echo $nome_cliente ?></td>
<td style="width:10%">R$ <?php echo $valorF ?></td>
<td style="width:10%">R$ <?php echo $valor_entradaF ?></td>
<td style="width:8%"><?php echo $parcelas ?></td>
<td style="width:12%"><?php echo $nome_frequencia ?></td>
<td style="width:20%"><?php echo $nome_servico ?></td>
<td style="width:8%"><?php echo $dataF ?></td>

    </tr>

<?php } } ?>
				</tbody>
	
			</thead>
		</table>
	


</div>
<hr>
		<table>
			<thead>
				<tbody>
					<tr>

						<td style="font-size: 10px; width:300px; text-align: right;"></td>

						<td style="font-size: 10px; width:120px; text-align: right;"></td>

						<td style="font-size: 10px; width:70px; text-align: right;"><b>Em Aberto: <span style="color:red"><?php echo $total_pendentes ?></span></td>

							<td style="font-size: 10px; width:70px; text-align: right;"><b>Finalizados: <span style="color:green"><?php echo $total_pagas ?></span></td>
								

									<td style="font-size: 10px; width:120px; text-align: right;"><b>Total: <span style="color:green">R$ <?php echo $total_valorF ?></span></td>
						
					</tr>
				</tbody>
			</thead>
		</table>

</body>

</html>




 