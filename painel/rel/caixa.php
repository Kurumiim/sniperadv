<?php 

include('../../conexao.php');
include('data_formatada.php');

$token_rel = @$_GET['token'];
if($token_rel != 'A5030'){
echo '<script>window.location="../../"</script>';
exit();
}

$data_atual = date('Y-m-d');

$operador = $_GET['operador'];

$dataInicial = $_GET['dataInicial'];

$dataFinal = $_GET['dataFinal'];

$query = $pdo->query("SELECT * from usuarios where id = '$operador'");	
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$nome_operador = @$res[0]['nome'];


$dataInicialF = implode('/', array_reverse(@explode('-', $dataInicial)));

$dataFinalF = implode('/', array_reverse(@explode('-', $dataFinal)));	




$filtro_operador = "";

if($operador == ""){

	$filtro_operador = ''; 

}else{

	$filtro_operador = " / OPERADOR ".@mb_strtoupper($nome_operador);

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

				<td style="border: 1px; solid #000; width: 37%; text-align: left;">

					<img style="margin-top: 7px; margin-left: 7px;" id="imag" src="<?php echo $url_sistema ?>img/logo.jpg" width="130px">

				</td>

				
				<td style="width: 1%; text-align: center; font-size: 13px;">

				

				</td>

				<td style="width: 47%; text-align: right; font-size: 9px;padding-right: 10px;">

						<b><big>RELATÓRIO DE CAIXAS <?php echo $filtro_operador ?></big></b><br> <?php echo @mb_strtoupper($texto_filtro) ?> <br> <?php echo @mb_strtoupper($data_hoje) ?>

				</td>

			</tr>		

		</table>

	</div>



<br>





		<table id="cabecalhotabela" style="border-bottom-style: solid; font-size: 8px; margin-bottom:10px; width: 100%; table-layout: fixed;">

			<thead>

				

				<tr id="cabeca" style="margin-left: 0px; background-color:#CCC">

					<td style="width:20%">OPERADOR</td>

					<td style="width:10%">DATA ABERTURA</td>

					<td style="width:10%">R$ ABERTURA</td>

					<td style="width:10%">R$ FECHAMENTO</td>

					<td style="width:10%">SANGRIAS</td>

					<td style="width:10%">QUEBRA</td>	

					<td style="width:15%">ABERTO POR</td>	

					<td style="width:15%">FECHADO POR</td>		

					

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



$total_caixas = 0;
$total_quebras = 0;


if($operador == ""){
	$query = $pdo->query("SELECT * from caixas where data_abertura >= '$dataInicial' and data_abertura <= '$dataFinal' ");
}else{
	$query = $pdo->query("SELECT * from caixas where data_abertura >= '$dataInicial' and data_abertura <= '$dataFinal' and operador = '$operador' ");
}



$res = $query->fetchAll(PDO::FETCH_ASSOC);

$linhas = @count($res);

if($linhas > 0){

for($i=0; $i<$linhas; $i++){

	$id = $res[$i]['id'];

$operador = $res[$i]['operador'];

$data_abertura = $res[$i]['data_abertura'];

$data_fechamento = $res[$i]['data_fechamento'];

$valor_abertura = $res[$i]['valor_abertura'];

$valor_fechamento = $res[$i]['valor_fechamento'];

$quebra = $res[$i]['quebra'];

$usuario_abertura = $res[$i]['usuario_abertura'];

$usuario_fechamento = $res[$i]['usuario_fechamento'];

$obs = $res[$i]['obs'];

$data_aberturaF = @implode('/', array_reverse(@explode('-', $data_abertura)));

$data_fechamentoF = @implode('/', array_reverse(@explode('-', $data_fechamento)));

$valor_aberturaF = @number_format($valor_abertura, 2, ',', '.');
$valor_fechamentoF = @number_format($valor_fechamento, 2, ',', '.');
$quebraF = @number_format($quebra, 2, ',', '.');






$query2 = $pdo->query("SELECT * FROM usuarios where id = '$operador'");

$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);

if(@count($res2) > 0){

	$nome_operador = $res2[0]['nome'];

}else{

	$nome_operador = '';

}





$query2 = $pdo->query("SELECT * FROM usuarios where id = '$usuario_abertura'");

$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);

if(@count($res2) > 0){

	$nome_usu_abertura = $res2[0]['nome'];

}else{

	$nome_usu_abertura = '';

}




$query2 = $pdo->query("SELECT * FROM usuarios where id = '$usuario_fechamento'");

$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);

if(@count($res2) > 0){

	$nome_usu_fechamento = $res2[0]['nome'];

}else{

	$nome_usu_fechamento = '';

}



if($valor_fechamento == ''){
	$classe_aberto = 'red';
	$ocultar = '';	
}else{
	$classe_aberto = 'green';
	$ocultar = 'ocultar';	
}

if($quebra != 0){
	$classe_quebra = 'red';
	$total_quebras += 1;
}else{
	$classe_quebra = 'green';
}


if($data_fechamento == ""){
	$data_fechamento_consulta = $data_atual;
}else{
	$data_fechamento_consulta = $data_fechamento;
}

//pegar a forma de pagamento dinheiro
$query2 = $pdo->query("SELECT * FROM formas_pgto where nome LIKE '%Dinheiro%'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$pgto_dinheiro = $res2[0]['id'];

//buscar total movimentado pelo caixa
//totalizar recebimentos
$total_recebido = 0;
$query2 = $pdo->query("SELECT * FROM receber where usuario_pgto = '$operador' and data_pgto >= '$data_abertura' and data_pgto <= '$data_fechamento_consulta' and forma_pgto = '$pgto_dinheiro' and financeiro is null");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
if(@count($res2) > 0){
	for($i2=0; $i2 < @count($res2); $i2++){
		$valor_rec = $res2[$i2]['valor'];
		$total_recebido += $valor_rec;
	}
}

//totalizar saidas
$total_saidas = 0;
$query2 = $pdo->query("SELECT * FROM pagar where usuario_pgto = '$operador' and data_pgto >= '$data_abertura' and data_pgto <= '$data_fechamento_consulta' and forma_pgto = '$pgto_dinheiro'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
if(@count($res2) > 0){
	for($i2=0; $i2 < @count($res2); $i2++){
		$valor_sai = $res2[$i2]['valor'];
		$total_saidas += $valor_sai;
	}
}


//totalizar sangrias
$total_sangrias = 0;
$query2 = $pdo->query("SELECT * FROM sangrias where caixa = '$id'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
if(@count($res2) > 0){
	for($i2=0; $i2 < @count($res2); $i2++){
		$valor_s = $res2[$i2]['valor'];
		$total_sangrias += $valor_s;
	}
}
$total_sangriasF = @number_format($total_sangrias, 2, ',', '.');


$total_caixa = $total_recebido - $total_saidas + $valor_abertura - $total_sangrias;




  	 ?>



  	 

      <tr>

<td style="width:20%"><?php echo $nome_operador ?></td>

<td style="width:10%"><?php echo $data_aberturaF ?></td>

<td style="width:10%">R$ <?php echo $valor_aberturaF ?></td>

<td style="width:10%">R$ <?php echo $valor_fechamentoF ?></td>

<td style="width:10%">R$ <?php echo $total_sangriasF ?></td>

<td style="width:10%; color:<?php echo $classe_quebra ?>">R$ <?php echo $quebraF ?></td>

<td style="width:15%"><?php echo $nome_usu_abertura ?></td>

<td style="width:15%"><?php echo $nome_usu_fechamento ?></td>



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



						



						<td style="font-size: 10px; width:70px; text-align: right;"></td>



							<td style="font-size: 10px; width:70px; text-align: right;"></td>





								<td style="font-size: 10px; width:140px; text-align: right;"><b>Caixas: <span style="color:green"><?php echo $linhas ?></span></td>



									<td style="font-size: 10px; width:120px; text-align: right;"><b>Quebras: <span style="color:red"><?php echo $total_quebras ?></span></td>

						

					</tr>

				</tbody>

			</thead>

		</table>



</body>



</html>





