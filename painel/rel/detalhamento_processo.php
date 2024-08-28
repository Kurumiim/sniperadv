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


$query = $pdo->query("SELECT * from processos where id = '$id'");

$res = $query->fetchAll(PDO::FETCH_ASSOC);

$linhas = @count($res);

if($linhas == 0){

	echo 'Contrato não encontrado!';

	exit();

}else{

$id = $res[0]['id'];
	$cliente = $res[0]['cliente'];
	$valor = $res[0]['valor'];
	$num_processo = $res[0]['num_processo'];
	$tipo_acao = $res[0]['tipo_acao'];
	$jurisdicao = $res[0]['jurisdicao'];
	$vara = $res[0]['vara'];	
	$comarca = $res[0]['comarca'];
	$segredo = $res[0]['segredo'];	
	$justica_gratuita = $res[0]['justica_gratuita'];
	$advogado1 = $res[0]['advogado1'];
	$advogado2 = $res[0]['advogado2'];
	$advogado3 = $res[0]['advogado3'];
	$advogado4 = $res[0]['advogado4'];
	$orgao_julgador = $res[0]['orgao_julgador'];
	$status = $res[0]['status'];
	$data_abertura = $res[0]['data_abertura'];
	$data_fechamento = $res[0]['data_fechamento'];
	$usuario_lanc = $res[0]['usuario_lanc'];
	$obs = $res[0]['obs'];
	$data_cad = $res[0]['data_cad'];

	$nome_contraria = $res[0]['nome_contraria'];
	$telefone_contraria = $res[0]['telefone_contraria'];
	$cpf_contraria = $res[0]['cpf_contraria'];
	$rg_contraria = $res[0]['rg_contraria'];
	$endereco_contraria = $res[0]['endereco_contraria'];
	$estado_civil_contraria = $res[0]['estado_civil_contraria'];
	$advogado_contraria = $res[0]['advogado_contraria'];

	$data_cadF = implode('/', array_reverse(@explode('-', $data_cad)));
	$data_aberturaF = implode('/', array_reverse(@explode('-', $data_abertura)));
	$data_fechamentoF = implode('/', array_reverse(@explode('-', $data_fechamento)));
	$valorF = @number_format($valor, 2, ',', '.');
	
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

	$query2 = $pdo->query("SELECT * FROM tipos_servicos where id = '$tipo_acao'");
	$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
	if(@count($res2) > 0){
		$nome_servico = $res2[0]['nome'];
	}else{
		$nome_servico = '';
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


	$query2 = $pdo->query("SELECT * FROM usuarios where id = '$advogado4'");
	$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
	if(@count($res2) > 0){
		$nome_advogado4 = $res2[0]['nome'];
	}else{
		$nome_advogado4 = '';
	}

	if($status == 'Cancelado'){
		$ocultar_botoes = '';
		$classe_status = '#91180d';			
	}else if ($status == 'Arquivado'){
		$ocultar_botoes = '';
		$classe_status = '#bf4b1d';	
	}else if ($status == 'Preparação'){
		$ocultar_botoes = '';
		$classe_status = '#8f8f8f';	
	}else if ($status == 'Finalizado'){
		$ocultar_botoes = 'ocultar';
		$classe_status = '#2b7a00';	
	}else if ($status == 'Andamento'){
		$ocultar_botoes = '';
		$classe_status = '#1c6cad';	
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

						<b><big>DETALHAMENTO PROCESSO </big></b><br> <b>CLIENTE: </b><?php echo @mb_strtoupper($nome_cliente) ?> <br> <?php echo @mb_strtoupper($data_hoje) ?>

				</td>

			</tr>		

		</table>

	</div>

</div>


<br>





		<table id="cabecalhotabela" style="border-bottom-style: solid; font-size: 11px; margin-bottom:10px; width: 100%; table-layout: fixed; margin-top: -50px">

			<thead>

				

				<tr id="cabeca" style="margin-left: 0px; background-color:#CCC; font-weight: bold">

					<td style="width:20%">PROCESSO</td>

					<td style="width:30%">CLIENTE</td>

					<td style="width:15%">ABERTO EM</td>

					<td style="width:15%">FECHADO EM</td>

					<td style="width:20%">TIPO AÇÃO</td>

					

					

				</tr>



				<tr id="cabeca" style="margin-left: 0px;">

					<td style="width:20%"><b><?php echo $num_processo ?></b></td>

					<td style="width:30%"><?php echo $nome_cliente ?></td>

					<td style="width:15%"><?php echo $data_aberturaF ?></td>

					<td style="width:15%"><?php echo $data_fechamentoF ?></td>

					<td style="width:15%; "><?php echo $nome_servico ?></td>

					

					

				</tr>


				<tr id="cabeca" style="margin-left: 0px; background-color:#CCC; font-weight: bold">

					<td style="width:20%">STATUS</td>

					<td style="width:30%">ORGÃO JULGADOR</td>

					<td style="width:15%">SEGREDO ESTADO</td>

					<td style="width:15%">JUSTIÇA GRATUITA</td>

					<td style="width:20%">VALOR CAUSA</td>

					

					

				</tr>



				<tr id="cabeca" style="margin-left: 0px;">

					<td style="width:20%; color:<?php echo $classe_status ?>"><?php echo $status ?> </td>

					<td style="width:30%"><?php echo $orgao_julgador ?></td>

					<td style="width:15%"><?php echo $segredo ?></td>

					<td style="width:15%"><?php echo $justica_gratuita ?></td>

					<td style="width:15%; ">R$ <?php echo $valorF ?></td>

					

					

				</tr>

			</thead>

		</table>




		<table id="cabecalhotabela" style="border-bottom-style: solid; font-size: 11px; margin-bottom:10px; width: 100%; table-layout: fixed;">

			<thead>

				

				<tr id="cabeca" style="margin-left: 0px; background-color:#CCC; font-weight: bold">

					<td style="width:33%">VARA</td>

					<td style="width:33%">COMARCA</td>

					<td style="width:34%">JURISDIÇÃO</td>						

				</tr>



				<tr id="cabeca" style="margin-left: 0px;">

					<td style="width:33%"><?php echo $vara ?></td>

					<td style="width:33%"><?php echo $comarca ?></td>

					<td style="width:34%"><?php echo $jurisdicao ?></td>					

					

				</tr>				

			</thead>

		</table>





		<table id="cabecalhotabela" style="border-bottom-style: solid; font-size: 11px; margin-bottom:10px; width: 100%; table-layout: fixed;">

			<thead>

				

				<tr id="cabeca" style="margin-left: 0px; background-color:#CCC; font-weight: bold">

					<td style="width:25%">ADVOGADO 1</td>

					<td style="width:25%">ADVOGADO 2</td>

					<td style="width:25%">ADVOGADO 3</td>	

					<td style="width:25%">ADVOGADO 4</td>							

				</tr>



				<tr id="cabeca" style="margin-left: 0px;">

					<td style="width:25%"><?php echo $nome_advogado1 ?></td>

					<td style="width:25%"><?php echo $nome_advogado2 ?></td>

					<td style="width:25%"><?php echo $nome_advogado3 ?></td>

					<td style="width:25%"><?php echo $nome_advogado4 ?></td>					

					

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








		<table id="" style="border-style: solid; font-size: 9px; margin-bottom:10px; width: 100%; table-layout: fixed; margin-top:10px;">
			<thead>		
				<tr id="cabeca" style="margin-left: 0px; background-color:#f2f0f0">
					<td colspan="8" style="width:100%; font-size: 10px"><b>DADOS DA PARTE CONTRÁRIA</b> </td>
				</tr>
				<tr >
					<td style="width:10%; border-right: 1px solid #000;border-bottom: : 1px solid #000;">NOME: </td>
					<td style="width:22%; border-right: : 1px solid #000; border-bottom: : 1px solid #000;">
						<?php echo @mb_strtoupper($nome_contraria) ?>
					</td>					

					<td style="width:6%; border-right: 1px solid #000;border-bottom: : 1px solid #000;">CPF: </td>
					<td style="width:13%; border-bottom: : 1px solid #000; border-right: 1px solid #000;">
						<?php echo @mb_strtoupper($cpf_contraria) ?>
					</td>

					<td style="width:9%; border-right: 1px solid #000;border-bottom: : 1px solid #000;">TELEFONE: </td>
					<td style="width:13%; border-bottom: : 1px solid #000; border-right: 1px solid #000;">
						<?php echo @mb_strtoupper($telefone_contraria) ?>
					</td>

					<td style="width:4%; border-right: 1px solid #000;border-bottom: : 1px solid #000;">RG: </td>
					<td style="width:13%; border-bottom: : 1px solid #000;">
						<?php echo @mb_strtoupper($rg_contraria) ?>
					</td>
    			</tr>


    			<tr >
					<td style="width:10%; border-right: 1px solid #000;border-bottom: : 1px solid #000;">ADVOGADO </td>
					<td  style="width:22%; border-right: : 1px solid #000; border-bottom: : 1px solid #000;">
						<?php echo @mb_strtoupper($advogado_contraria) ?>
					</td>					
					
					<td style="width:9%; border-right: 1px solid #000;border-bottom: : 1px solid #000;">ENDEREÇO: </td>
					<td colspan="5" style="width:50%; border-bottom: : 1px solid #000; border-right: 1px solid #000;">
						<?php echo @mb_strtoupper($endereco_cliente) ?> <?php echo @mb_strtoupper($numero_cliente) ?>  <?php echo @mb_strtoupper($cidade_cliente) ?> 
					</td>

					
    			</tr>


    			
    			

			</thead>

		</table>



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
		<hr>
	<?php } ?>


<div align="left" style="margin-top: 15px">
<?php 
$query = $pdo->query("SELECT * FROM movimentacao_processo where processo = '$id' and visivel_cliente = 'Sim' order by id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
	echo '<div style="font-size:11px; margin-bottom:5px"><b><u>MOVIMENTAÇÕES DO PROCESSO</u></b></div>';
for($i=0; $i < $total_reg; $i++){
$id = $res[$i]['id'];
$titulo = $res[$i]['titulo'];
$descricao = $res[$i]['descricao'];
$data = $res[$i]['data'];
$dataF = implode('/', array_reverse(@explode('-', $data)));
 ?>


<div style="border-bottom: 1px solid #757575; margin-bottom: 3px; padding-bottom:1px">	
				<span style="font-size: 9px;"><i>Data: <?php echo $dataF ?></i></span><br>				
				<span style="font-size: 10px"><b><?php echo $titulo ?> : </b>	</span> 
				<span style="font-size: 9px;"><?php echo $descricao ?></span>				
				
			</div> 
		

<?php } } ?>
	
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





