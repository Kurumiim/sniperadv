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


$query = $pdo->query("SELECT * from caixas where id = '$id'");

$res = $query->fetchAll(PDO::FETCH_ASSOC);

$linhas = @count($res);

if($linhas == 0){

	echo 'Caixa não encontrado!';

	exit();

}else{

$operador = $res[0]['operador'];
$data_abertura = $res[0]['data_abertura'];
$data_fechamento = $res[0]['data_fechamento'];
$valor_abertura = $res[0]['valor_abertura'];
$valor_fechamento = $res[0]['valor_fechamento'];
$quebra = $res[0]['quebra'];
$usuario_abertura = $res[0]['usuario_abertura'];
$usuario_fechamento = $res[0]['usuario_fechamento'];
$obs = $res[0]['obs'];

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
}else{
	$classe_quebra = 'green';
}



if($data_fechamento == ""){
	$data_fechamento_consulta = $data_atual;
}else{
	$data_fechamento_consulta = $data_fechamento;
}


//buscar total movimentado pelo caixa
//totalizar recebimentos
$total_recebido = 0;
$query2 = $pdo->query("SELECT * FROM receber where usuario_pgto = '$operador' and data_pgto >= '$data_abertura' and data_pgto <= '$data_fechamento_consulta' and caixa = '$id' and financeiro is null");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
if(@count($res2) > 0){
	for($i2=0; $i2 < @count($res2); $i2++){
		$valor_rec = $res2[$i2]['valor'];
		$total_recebido += $valor_rec;
	}
}

//totalizar saidas
$total_saidas = 0;
$query2 = $pdo->query("SELECT * FROM pagar where usuario_pgto = '$operador' and data_pgto >= '$data_abertura' and data_pgto <= '$data_fechamento_consulta' and caixa = '$id'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
if(@count($res2) > 0){
	for($i2=0; $i2 < @count($res2); $i2++){
		$valor_sai = $res2[$i2]['valor'];
		$total_saidas += $valor_sai;
	}
}


$total_caixa = $total_recebido - $total_saidas + $valor_abertura;

$total_caixaF = @number_format($total_caixa, 2, ',', '.');
$total_saidasF = @number_format($total_saidas, 2, ',', '.');
$total_recebidoF = @number_format($total_recebido, 2, ',', '.');	

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



$texto_filtro = 'OPERADOR: '.$nome_operador;


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

						<b><big>DETALHAMENTO CAIXA</big></b><br> <b>OPERADOR: </b><?php echo mb_strtoupper($nome_operador) ?> <br> <?php echo mb_strtoupper($data_hoje) ?>

				</td>

			</tr>		

		</table>

	</div>



<br>





		<table id="cabecalhotabela" style="border-bottom-style: solid; font-size: 12px; margin-bottom:10px; width: 100%; table-layout: fixed;">

			<thead>

				

				<tr id="cabeca" style="margin-left: 0px; background-color:#CCC; font-weight: bold">

					<td style="width:27%">ABERTURA</td>

					<td style="width:27%">FECHAMENTO</td>

					<td style="width:16%">R$ ABERTURA</td>

					<td style="width:16%">R$ FECHAMENTO</td>

					<td style="width:14%">QUEBRA</td>

					

				</tr>



				<tr id="cabeca" style="margin-left: 0px;">

					<td style="width:27%"><?php echo $data_aberturaF ?> <small>(<?php echo $nome_usu_abertura ?>)</small></td>

					<td style="width:27%"><?php echo $data_fechamentoF ?> <small>(<?php echo $nome_usu_abertura ?>)</small></td>

					<td style="width:16%">R$ <?php echo $valor_aberturaF ?></td>

					<td style="width:16%">R$ <?php echo $valor_fechamentoF ?></td>

					<td style="width:14%; color:<?php echo $classe_quebra ?>">R$ <?php echo $quebraF ?></td>

					

				</tr>

			</thead>

		</table>




		<?php if($obs != ""){ ?>
		<table>

			<thead>
				<tbody>
					<tr>
						<td style="font-size: 10px; width:332px; text-align: left;"><b>Observações:</b> <?php echo $obs ?></td>					

					</tr>
				</tbody>
			</thead>
		</table>

	<?php } ?>












	<?php if($total_recebido > 0 || $total_saidas > 0){ ?>



			<div style="border-bottom: 1px solid #000; margin-top: 30px">

				<div style="font-size: 11px; margin-bottom: 7px"><b>DETALHAMENTO DE ENTRADAS / TOTAL <span style="color:green">R$ <?php echo $total_recebidoF ?></span></b></div>

			</div>	

			<table id="cabecalhotabela" style="border-bottom-style: solid; font-size: 11px; margin-bottom:10px; width: 100%; table-layout: fixed; margin-top: 5px">

			<thead>

				

				<tr id="cabeca" style="margin-left: 0px; background-color:#CCC; font-weight: bold">

					<?php 
						$query2 = $pdo->query("SELECT * FROM formas_pgto order by id asc");
						$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
						if(@count($res2) > 0){
							for($i2=0; $i2 < @count($res2); $i2++){
								$nome_pgto = $res2[$i2]['nome'];								

								echo '<td style="width:20%">'.$nome_pgto.'</td>';
							}
						}
					 ?>									

				</tr>



				<tr id="cabeca" style="margin-left: 0px;">		

					<?php 
						$query2 = $pdo->query("SELECT * FROM formas_pgto order by id asc");
						$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
						if(@count($res2) > 0){
							for($i2=0; $i2 < @count($res2); $i2++){
								$id_pgto = $res2[$i2]['id'];	

								//total de entradas por essa forma de pgto	
								$total_recebido_pgto = 0;
								$query3 = $pdo->query("SELECT * FROM receber where usuario_pgto = '$operador' and data_pgto >= '$data_abertura' and data_pgto <= '$data_fechamento_consulta' and forma_pgto = '$id_pgto' and caixa = '$id' and financeiro is null");
								$res3 = $query3->fetchAll(PDO::FETCH_ASSOC);
								if(@count($res3) > 0){
									for($i3=0; $i3 < @count($res3); $i3++){
										$valor_rec_pgto = $res3[$i3]['valor'];
										$total_recebido_pgto += $valor_rec_pgto;
									}
								}

								$total_recebido_pgtoF = @number_format($total_recebido_pgto, 2, ',', '.');

								echo '<td style="width:20%; color:green">R$ '.$total_recebido_pgtoF.'</td>';
							}
						}
					 ?>				
					

				</tr>

			</thead>

		</table>





		<table id="cabecalhotabela" style="width: 100%; table-layout: fixed; font-size:9px; text-transform: uppercase;">

			<thead>



				<tr id="cabeca" style="margin-left: 0px; background-color:#CCC; font-weight: bold">

					<td style="width:25%">DESCRIÇÃO</td>

					<td style="width:9%">REFERÊNCIA</td>

					<td style="width:10%">VALOR</td>

					<td style="width:9%">DATA</td>

					<td style="width:9%">HORA</td>

					<td style="width:20%">PESSOA</td>

					<td style="width:17%">FORMA PGTO</td>

					

					

				</tr>

				

					<?php 

$total_servicos = 0;

$total_consumo = 0;

$total_final = 0;

$total_servicosF = 0;

$total_consumoF = 0;

$total_finalF = 0;

$query = $pdo->query("SELECT * from receber where usuario_pgto = '$operador' and data_pgto >= '$data_abertura' and data_pgto <= '$data_fechamento_consulta' and caixa = '$id' and financeiro is null ORDER BY ID ASC");

$res = $query->fetchAll(PDO::FETCH_ASSOC);

$linhas = @count($res);

if($linhas > 0){

for($i=0; $i<$linhas; $i++){

	

$descricao = $res[$i]['descricao'];

$valor = $res[$i]['valor'];

$data_lanc = $res[$i]['data_lanc'];

$data_venc = $res[$i]['vencimento'];

$data_pgto = $res[$i]['data_pgto'];

$usuario_lanc = $res[$i]['usuario_lanc'];

$usuario_pgto = $res[$i]['usuario_pgto'];

$arquivo = $res[$i]['arquivo'];

$pago = $res[$i]['pago'];

$obs = $res[$i]['obs'];

$cliente = $res[$i]['cliente'];

$hora = $res[$i]['hora'];

$referencia = $res[$i]['referencia'];

$forma_pgto = $res[$i]['forma_pgto'];


$query2 = $pdo->query("SELECT * FROM formas_pgto where id = '$forma_pgto'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$forma_pgtoF = @$res2[0]['nome'];	




$data_lancF = implode('/', array_reverse(@explode('-', $data_lanc)));

$data_vencF = implode('/', array_reverse(@explode('-', $data_venc)));

$data_pgtoF = implode('/', array_reverse(@explode('-', $data_pgto)));

$valorF = @number_format($valor, 2, ',', '.');


$horaF = date("H:i", @strtotime($hora));



$query2 = $pdo->query("SELECT * FROM usuarios where id = '$usuario_lanc'");

$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);

if(@count($res2) > 0){

	$nome_usu_lanc = $res2[0]['nome'];

}else{

	$nome_usu_lanc = 'Sem Usuário';

}



$query2 = $pdo->query("SELECT * FROM clientes where id = '$cliente'");

$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);

if(@count($res2) > 0){

	$nome_cliente = $res2[0]['nome'];

}else{

	$nome_cliente = '';

}



if($referencia == 'Venda'){

	$total_consumo += $valor;

}else{

	$total_servicos += $valor;

}



$total_final = $total_consumo + $total_servicos;



$total_consumoF = @number_format($total_consumo, 2, ',', '.');

$total_servicosF = @number_format($total_servicos, 2, ',', '.');

$total_finalF = @number_format($total_final, 2, ',', '.');


if($referencia == 'Venda' || $referencia == 'Serviço'){
	$texto_ref = 'VENDA';
}else{
	$texto_ref = '';
}

if($referencia == 'Entrada' || $referencia == 'Restante'){
	$texto_ref2 = 'RESERVA';
}else{
	$texto_ref2 = '';
}


  	 ?>



  	 

      <tr>

<td style="width:25%"><?php echo $descricao ?></td>

<td style="width:9%;"><?php echo $texto_ref2  ?><?php echo $texto_ref ?> </td>

<td style="width:10%; color:green">R$ <?php echo $valorF ?></td>

<td style="width:9%"><?php echo $data_pgtoF ?></td>

<td style="width:9%; "><?php echo $horaF ?></td>

<td style="width:20%; "><?php echo $nome_cliente ?></td>

<td style="width:17%"><?php echo $forma_pgtoF ?></td>



    </tr>



<?php } } ?>

				

	

			</thead>

		</table>












<div style="border-bottom: 1px solid #000; margin-top: 30px">

				<div style="font-size: 11px; margin-bottom: 7px"><b>DETALHAMENTO DE SAÍDAS / TOTAL <span style="color:red">R$ <?php echo $total_saidasF ?></span></b></div>

			</div>	

			<table id="cabecalhotabela" style="border-bottom-style: solid; font-size: 11px; margin-bottom:10px; width: 100%; table-layout: fixed; margin-top: 5px">

			<thead>

				

				<tr id="cabeca" style="margin-left: 0px; background-color:#CCC; font-weight: bold">

					<?php 
						$query2 = $pdo->query("SELECT * FROM formas_pgto order by id asc");
						$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
						if(@count($res2) > 0){
							for($i2=0; $i2 < @count($res2); $i2++){
								$nome_pgto = $res2[$i2]['nome'];								

								echo '<td style="width:20%">'.$nome_pgto.'</td>';
							}
						}
					 ?>									

				</tr>



				<tr id="cabeca" style="margin-left: 0px;">		

					<?php 
						$query2 = $pdo->query("SELECT * FROM formas_pgto order by id asc");
						$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
						if(@count($res2) > 0){
							for($i2=0; $i2 < @count($res2); $i2++){
								$id_pgto = $res2[$i2]['id'];	

								//total de entradas por essa forma de pgto	
								$total_recebido_pgto = 0;
								$query3 = $pdo->query("SELECT * FROM pagar where usuario_pgto = '$operador' and data_pgto >= '$data_abertura' and data_pgto <= '$data_fechamento_consulta' and forma_pgto = '$id_pgto' and caixa = '$id'");
								$res3 = $query3->fetchAll(PDO::FETCH_ASSOC);
								if(@count($res3) > 0){
									for($i3=0; $i3 < @count($res3); $i3++){
										$valor_rec_pgto = $res3[$i3]['valor'];
										$total_recebido_pgto += $valor_rec_pgto;
									}
								}

								$total_recebido_pgtoF = @number_format($total_recebido_pgto, 2, ',', '.');



								echo '<td style="width:20%; color:red">R$ '.$total_recebido_pgtoF.'</td>';
							}
						}
					 ?>				
					

				</tr>

			</thead>

		</table>





		<table id="cabecalhotabela" style="width: 100%; table-layout: fixed; font-size:9px; text-transform: uppercase;">

			<thead>



				<tr id="cabeca" style="margin-left: 0px; background-color:#CCC; font-weight: bold">

					<td style="width:25%">DESCRIÇÃO</td>

					<td style="width:9%">REFERÊNCIA</td>

					<td style="width:10%">VALOR</td>

					<td style="width:9%">DATA</td>

					<td style="width:9%">HORA</td>

					<td style="width:20%">PESSOA</td>

					<td style="width:17%">FORMA PGTO</td>

					

					

				</tr>

				

					<?php 

$total_servicos = 0;

$total_consumo = 0;

$total_final = 0;

$total_servicosF = 0;

$total_consumoF = 0;

$total_finalF = 0;

$query = $pdo->query("SELECT * from pagar where usuario_pgto = '$operador' and data_pgto >= '$data_abertura' and data_pgto <= '$data_fechamento_consulta' and caixa = '$id' ORDER BY ID ASC");

$res = $query->fetchAll(PDO::FETCH_ASSOC);

$linhas = @count($res);

if($linhas > 0){

for($i=0; $i<$linhas; $i++){

	

$descricao = $res[$i]['descricao'];

$valor = $res[$i]['valor'];

$data_lanc = $res[$i]['data_lanc'];

$data_venc = $res[$i]['vencimento'];

$data_pgto = $res[$i]['data_pgto'];

$usuario_lanc = $res[$i]['usuario_lanc'];

$usuario_pgto = $res[$i]['usuario_pgto'];

$arquivo = $res[$i]['arquivo'];

$pago = $res[$i]['pago'];

$obs = $res[$i]['obs'];


$funcionario = $res[$i]['funcionario'];
$fornecedor = $res[$i]['fornecedor'];

$hora = $res[$i]['hora'];

$referencia = $res[$i]['referencia'];

$forma_pgto = $res[$i]['forma_pgto'];


$query2 = $pdo->query("SELECT * FROM formas_pgto where id = '$forma_pgto'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$forma_pgtoF = @$res2[0]['nome'];	




$data_lancF = implode('/', array_reverse(@explode('-', $data_lanc)));

$data_vencF = implode('/', array_reverse(@explode('-', $data_venc)));

$data_pgtoF = implode('/', array_reverse(@explode('-', $data_pgto)));

$valorF = @number_format($valor, 2, ',', '.');


$horaF = date("H:i", @strtotime($hora));



$query2 = $pdo->query("SELECT * FROM usuarios where id = '$usuario_lanc'");

$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);

if(@count($res2) > 0){

	$nome_usu_lanc = $res2[0]['nome'];

}else{

	$nome_usu_lanc = 'Sem Usuário';

}



if($referencia == 'Venda'){

	$total_consumo += $valor;

}else{

	$total_servicos += $valor;

}



$total_final = $total_consumo + $total_servicos;



$total_consumoF = @number_format($total_consumo, 2, ',', '.');

$total_servicosF = @number_format($total_servicos, 2, ',', '.');

$total_finalF = @number_format($total_final, 2, ',', '.');





$nome_pessoa = 'Sem Registro';

$tipo_pessoa = 'Pessoa';

$pix_pessoa = 'Sem Registro';





$query2 = $pdo->query("SELECT * FROM fornecedores where id = '$fornecedor'");

$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);

if(@count($res2) > 0){

	$nome_pessoa = $res2[0]['nome'];	

	$pix_pessoa = $res2[0]['chave_pix'];

	$tipo_pessoa = 'Fornecedor';

}



$query2 = $pdo->query("SELECT * FROM usuarios where id = '$funcionario'");

$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);

if(@count($res2) > 0){

	$nome_pessoa = $res2[0]['nome'];	

	$pix_pessoa = $res2[0]['chave_pix'];

	$tipo_pessoa = 'Funcionário';

}










  	 ?>



  	 

      <tr>

<td style="width:25%"><?php echo $descricao ?></td>

<td style="width:9%;"><?php echo $referencia  ?> </td>

<td style="width:10%; color:red">R$ <?php echo $valorF ?></td>

<td style="width:9%"><?php echo $data_pgtoF ?></td>

<td style="width:9%; "><?php echo $horaF ?></td>

<td style="width:20%; "><?php echo $nome_pessoa ?></td>

<td style="width:17%"><?php echo $forma_pgtoF ?></td>



    </tr>



<?php } } ?>

				

	

			</thead>

		</table>
	



	<?php } ?>









<?php if($total_sangrias > 0){ ?>

<div style="border-bottom: 1px solid #000; margin-top: 30px">

				<div style="font-size: 11px; margin-bottom: 7px"><b>DETALHAMENTO DE SANGRIAS / TOTAL <span style="color:red">R$ <?php echo $total_sangriasF ?></span></b></div>

			</div>	

			


		<table id="cabecalhotabela" style="width: 100%; table-layout: fixed; font-size:9px; text-transform: uppercase;">

			<thead>



				<tr id="cabeca" style="margin-left: 0px; background-color:#CCC; font-weight: bold">

					<td style="width:20%">VALOR</td>

					<td style="width:40%">FEITA POR</td>

					<td style="width:20%">DATA</td>

					<td style="width:20%">HORA</td>			
					

					

				</tr>

				

					<?php 


$query = $pdo->query("SELECT * from sangrias where caixa = '$id' ORDER BY ID ASC");

$res = $query->fetchAll(PDO::FETCH_ASSOC);

$linhas = @count($res);

if($linhas > 0){

for($i=0; $i<$linhas; $i++){


$valor = $res[$i]['valor'];
$usuario = $res[$i]['usuario'];
$data = $res[$i]['data'];
$hora = $res[$i]['hora'];




$dataF = implode('/', array_reverse(@explode('-', $data)));
$valorF = @number_format($valor, 2, ',', '.');
$horaF = date("H:i", @strtotime($hora));


$query2 = $pdo->query("SELECT * FROM usuarios where id = '$usuario'");

$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);

if(@count($res2) > 0){

	$nome_usu_lanc = $res2[0]['nome'];

}else{

	$nome_usu_lanc = 'Sem Usuário';

}


  	 ?>



  	 

      <tr>

<td style="width:20%; color:red">R$ <?php echo $valorF ?></td>
<td style="width:40%"><?php echo $nome_usu_lanc ?></td>
<td style="width:20%; "><?php echo $dataF ?></td>
<td style="width:20%; "><?php echo $horaF ?></td>





    </tr>



<?php } } ?>

				

	

			</thead>

		</table>




<?php } ?>







<hr>
<br><br>
<div align="center">
	_____________________________________________________________<br>
	<small><small>(Assinatura)</small></small>
</div>


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





