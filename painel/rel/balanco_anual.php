<?php 
include('../../conexao.php');
include('data_formatada.php');

$token_rel = @$_GET['token'];
if($token_rel != 'A5030'){
echo '<script>window.location="../../"</script>';
exit();
}

$data_atual = date('Y-m-d');
$mes_atual = Date('m');
$ano_atual = Date('Y');
$data_inicio_mes = $ano_atual."-".$mes_atual."-01";
$data_inicio_ano = $ano_atual."-01-01";

$mostrar_registros = $_GET['mostrar_registros'];
$id_usuario = $_GET['id_usuario'];

if($mostrar_registros == 'Não'){	
	$sql_conta = " and usuario_receb = '$id_usuario' and financeiro is null";
}else{
	$sql_conta = ' and financeiro is null';
}


//PEGAR DADOS DO MES JANEIRO
$classe_janeiro = '#363636';
$pagar_janeiro = 0;
$receber_janeiro = 0;
$saldo_janeiro = 0;
$data_inicio_mes = $ano_atual."-01-01";
$data_final_mes = $ano_atual."-01-31";
$query = $pdo->query("SELECT * from receber where data_pgto >= '$data_inicio_mes' and data_pgto <= '$data_final_mes' and pago = 'Sim' $sql_conta");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
	for($i=0; $i<$linhas; $i++){
		$receber_janeiro += $res[$i]['subtotal'];
	}
}
$query = $pdo->query("SELECT * from pagar where data_pgto >= '$data_inicio_mes' and data_pgto <= '$data_final_mes' and pago = 'Sim' $sql_conta");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
	for($i=0; $i<$linhas; $i++){
		$pagar_janeiro += $res[$i]['subtotal'];
	}
}
$saldo_janeiro = $receber_janeiro - $pagar_janeiro;
$pagar_janeiroF = @number_format($pagar_janeiro, 2, ',', '.');
$receber_janeiroF = @number_format($receber_janeiro, 2, ',', '.');
$saldo_janeiroF = @number_format($saldo_janeiro, 2, ',', '.');
if($saldo_janeiro > 0){
	$classe_janeiro = 'green';
}else if($saldo_janeiro < 0){
	$classe_janeiro = 'red';
}




//PEGAR DADOS DO MES fevereiro
$classe_fevereiro = '#363636';
$pagar_fevereiro = 0;
$receber_fevereiro = 0;
$saldo_fevereiro = 0;
$data_inicio_mes = $ano_atual."-02-01";

$bissexto = date('L', @mktime(0, 0, 0, 1, 1, $ano_atual));
	if($bissexto == 1){
		$data_final_mes = $ano_atual.'-02-29';
	}else{
		$data_final_mes = $ano_atual.'-02-28';
	}

$query = $pdo->query("SELECT * from receber where data_pgto >= '$data_inicio_mes' and data_pgto <= '$data_final_mes' and pago = 'Sim' $sql_conta");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
	for($i=0; $i<$linhas; $i++){
		$receber_fevereiro += $res[$i]['subtotal'];
	}
}
$query = $pdo->query("SELECT * from pagar where data_pgto >= '$data_inicio_mes' and data_pgto <= '$data_final_mes' and pago = 'Sim' $sql_conta");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
	for($i=0; $i<$linhas; $i++){
		$pagar_fevereiro += $res[$i]['subtotal'];
	}
}
$saldo_fevereiro = $receber_fevereiro - $pagar_fevereiro;
$pagar_fevereiroF = @number_format($pagar_fevereiro, 2, ',', '.');
$receber_fevereiroF = @number_format($receber_fevereiro, 2, ',', '.');
$saldo_fevereiroF = @number_format($saldo_fevereiro, 2, ',', '.');
if($saldo_fevereiro > 0){
	$classe_fevereiro = 'green';
}else if($saldo_fevereiro < 0){
	$classe_fevereiro = 'red';
}




//PEGAR DADOS DO MES marco
$classe_marco = '#363636';
$pagar_marco = 0;
$receber_marco = 0;
$saldo_marco = 0;
$data_inicio_mes = $ano_atual."-03-01";
$data_final_mes = $ano_atual."-03-31";
$query = $pdo->query("SELECT * from receber where data_pgto >= '$data_inicio_mes' and data_pgto <= '$data_final_mes' and pago = 'Sim' $sql_conta");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
	for($i=0; $i<$linhas; $i++){
		$receber_marco += $res[$i]['subtotal'];
	}
}
$query = $pdo->query("SELECT * from pagar where data_pgto >= '$data_inicio_mes' and data_pgto <= '$data_final_mes' and pago = 'Sim' $sql_conta");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
	for($i=0; $i<$linhas; $i++){
		$pagar_marco += $res[$i]['subtotal'];
	}
}
$saldo_marco = $receber_marco - $pagar_marco;
$pagar_marcoF = @number_format($pagar_marco, 2, ',', '.');
$receber_marcoF = @number_format($receber_marco, 2, ',', '.');
$saldo_marcoF = @number_format($saldo_marco, 2, ',', '.');
if($saldo_marco > 0){
	$classe_marco = 'green';
}else if($saldo_marco < 0){
	$classe_marco = 'red';
}





//PEGAR DADOS DO MES abril
$classe_abril = '#363636';
$pagar_abril = 0;
$receber_abril = 0;
$saldo_abril = 0;
$data_inicio_mes = $ano_atual."-04-01";
$data_final_mes = $ano_atual."-04-30";
$query = $pdo->query("SELECT * from receber where data_pgto >= '$data_inicio_mes' and data_pgto <= '$data_final_mes' and pago = 'Sim' $sql_conta");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
	for($i=0; $i<$linhas; $i++){
		$receber_abril += $res[$i]['subtotal'];
	}
}
$query = $pdo->query("SELECT * from pagar where data_pgto >= '$data_inicio_mes' and data_pgto <= '$data_final_mes' and pago = 'Sim' $sql_conta");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
	for($i=0; $i<$linhas; $i++){
		$pagar_abril += $res[$i]['subtotal'];
	}
}
$saldo_abril = $receber_abril - $pagar_abril;
$pagar_abrilF = @number_format($pagar_abril, 2, ',', '.');
$receber_abrilF = @number_format($receber_abril, 2, ',', '.');
$saldo_abrilF = @number_format($saldo_abril, 2, ',', '.');
if($saldo_abril > 0){
	$classe_abril = 'green';
}else if($saldo_abril < 0){
	$classe_abril = 'red';
}




//PEGAR DADOS DO MES maio
$classe_maio = '#363636';
$pagar_maio = 0;
$receber_maio = 0;
$saldo_maio = 0;
$data_inicio_mes = $ano_atual."-05-01";
$data_final_mes = $ano_atual."-05-31";
$query = $pdo->query("SELECT * from receber where data_pgto >= '$data_inicio_mes' and data_pgto <= '$data_final_mes' and pago = 'Sim' $sql_conta");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
	for($i=0; $i<$linhas; $i++){
		$receber_maio += $res[$i]['subtotal'];
	}
}
$query = $pdo->query("SELECT * from pagar where data_pgto >= '$data_inicio_mes' and data_pgto <= '$data_final_mes' and pago = 'Sim' $sql_conta");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
	for($i=0; $i<$linhas; $i++){
		$pagar_maio += $res[$i]['subtotal'];
	}
}
$saldo_maio = $receber_maio - $pagar_maio;
$pagar_maioF = @number_format($pagar_maio, 2, ',', '.');
$receber_maioF = @number_format($receber_maio, 2, ',', '.');
$saldo_maioF = @number_format($saldo_maio, 2, ',', '.');
if($saldo_maio > 0){
	$classe_maio = 'green';
}else if($saldo_maio < 0){
	$classe_maio = 'red';
}




//PEGAR DADOS DO MES junho
$classe_junho = '#363636';
$pagar_junho = 0;
$receber_junho = 0;
$saldo_junho = 0;
$data_inicio_mes = $ano_atual."-06-01";
$data_final_mes = $ano_atual."-06-30";
$query = $pdo->query("SELECT * from receber where data_pgto >= '$data_inicio_mes' and data_pgto <= '$data_final_mes' and pago = 'Sim' $sql_conta");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
	for($i=0; $i<$linhas; $i++){
		$receber_junho += $res[$i]['subtotal'];
	}
}
$query = $pdo->query("SELECT * from pagar where data_pgto >= '$data_inicio_mes' and data_pgto <= '$data_final_mes' and pago = 'Sim' $sql_conta");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
	for($i=0; $i<$linhas; $i++){
		$pagar_junho += $res[$i]['subtotal'];
	}
}
$saldo_junho = $receber_junho - $pagar_junho;
$pagar_junhoF = @number_format($pagar_junho, 2, ',', '.');
$receber_junhoF = @number_format($receber_junho, 2, ',', '.');
$saldo_junhoF = @number_format($saldo_junho, 2, ',', '.');
if($saldo_junho > 0){
	$classe_junho = 'green';
}else if($saldo_junho < 0){
	$classe_junho = 'red';
}





//PEGAR DADOS DO MES julho
$classe_julho = '#363636';
$pagar_julho = 0;
$receber_julho = 0;
$saldo_julho = 0;
$data_inicio_mes = $ano_atual."-07-01";
$data_final_mes = $ano_atual."-07-31";
$query = $pdo->query("SELECT * from receber where data_pgto >= '$data_inicio_mes' and data_pgto <= '$data_final_mes' and pago = 'Sim' $sql_conta");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
	for($i=0; $i<$linhas; $i++){
		$receber_julho += $res[$i]['subtotal'];
	}
}
$query = $pdo->query("SELECT * from pagar where data_pgto >= '$data_inicio_mes' and data_pgto <= '$data_final_mes' and pago = 'Sim' $sql_conta");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
	for($i=0; $i<$linhas; $i++){
		$pagar_julho += $res[$i]['subtotal'];
	}
}
$saldo_julho = $receber_julho - $pagar_julho;
$pagar_julhoF = @number_format($pagar_julho, 2, ',', '.');
$receber_julhoF = @number_format($receber_julho, 2, ',', '.');
$saldo_julhoF = @number_format($saldo_julho, 2, ',', '.');
if($saldo_julho > 0){
	$classe_julho = 'green';
}else if($saldo_julho < 0){
	$classe_julho = 'red';
}




//PEGAR DADOS DO MES agosto
$classe_agosto = '#363636';
$pagar_agosto = 0;
$receber_agosto = 0;
$saldo_agosto = 0;
$data_inicio_mes = $ano_atual."-08-01";
$data_final_mes = $ano_atual."-08-31";
$query = $pdo->query("SELECT * from receber where data_pgto >= '$data_inicio_mes' and data_pgto <= '$data_final_mes' and pago = 'Sim' $sql_conta");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
	for($i=0; $i<$linhas; $i++){
		$receber_agosto += $res[$i]['subtotal'];
	}
}
$query = $pdo->query("SELECT * from pagar where data_pgto >= '$data_inicio_mes' and data_pgto <= '$data_final_mes' and pago = 'Sim' $sql_conta");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
	for($i=0; $i<$linhas; $i++){
		$pagar_agosto += $res[$i]['subtotal'];
	}
}
$saldo_agosto = $receber_agosto - $pagar_agosto;
$pagar_agostoF = @number_format($pagar_agosto, 2, ',', '.');
$receber_agostoF = @number_format($receber_agosto, 2, ',', '.');
$saldo_agostoF = @number_format($saldo_agosto, 2, ',', '.');
if($saldo_agosto > 0){
	$classe_agosto = 'green';
}else if($saldo_agosto < 0){
	$classe_agosto = 'red';
}




//PEGAR DADOS DO MES setembro
$classe_setembro = '#363636';
$pagar_setembro = 0;
$receber_setembro = 0;
$saldo_setembro = 0;
$data_inicio_mes = $ano_atual."-09-01";
$data_final_mes = $ano_atual."-09-30";
$query = $pdo->query("SELECT * from receber where data_pgto >= '$data_inicio_mes' and data_pgto <= '$data_final_mes' and pago = 'Sim' $sql_conta");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
	for($i=0; $i<$linhas; $i++){
		$receber_setembro += $res[$i]['subtotal'];
	}
}
$query = $pdo->query("SELECT * from pagar where data_pgto >= '$data_inicio_mes' and data_pgto <= '$data_final_mes' and pago = 'Sim' $sql_conta");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
	for($i=0; $i<$linhas; $i++){
		$pagar_setembro += $res[$i]['subtotal'];
	}
}
$saldo_setembro = $receber_setembro - $pagar_setembro;
$pagar_setembroF = @number_format($pagar_setembro, 2, ',', '.');
$receber_setembroF = @number_format($receber_setembro, 2, ',', '.');
$saldo_setembroF = @number_format($saldo_setembro, 2, ',', '.');
if($saldo_setembro > 0){
	$classe_setembro = 'green';
}else if($saldo_setembro < 0){
	$classe_setembro = 'red';
}




//PEGAR DADOS DO MES outubro
$classe_outubro = '#363636';
$pagar_outubro = 0;
$receber_outubro = 0;
$saldo_outubro = 0;
$data_inicio_mes = $ano_atual."-10-01";
$data_final_mes = $ano_atual."-10-31";
$query = $pdo->query("SELECT * from receber where data_pgto >= '$data_inicio_mes' and data_pgto <= '$data_final_mes' and pago = 'Sim' $sql_conta");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
	for($i=0; $i<$linhas; $i++){
		$receber_outubro += $res[$i]['subtotal'];
	}
}
$query = $pdo->query("SELECT * from pagar where data_pgto >= '$data_inicio_mes' and data_pgto <= '$data_final_mes' and pago = 'Sim' $sql_conta");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
	for($i=0; $i<$linhas; $i++){
		$pagar_outubro += $res[$i]['subtotal'];
	}
}
$saldo_outubro = $receber_outubro - $pagar_outubro;
$pagar_outubroF = @number_format($pagar_outubro, 2, ',', '.');
$receber_outubroF = @number_format($receber_outubro, 2, ',', '.');
$saldo_outubroF = @number_format($saldo_outubro, 2, ',', '.');
if($saldo_outubro > 0){
	$classe_outubro = 'green';
}else if($saldo_outubro < 0){
	$classe_outubro = 'red';
}




//PEGAR DADOS DO MES novembro
$classe_novembro = '#363636';
$pagar_novembro = 0;
$receber_novembro = 0;
$saldo_novembro = 0;
$data_inicio_mes = $ano_atual."-11-01";
$data_final_mes = $ano_atual."-11-30";
$query = $pdo->query("SELECT * from receber where data_pgto >= '$data_inicio_mes' and data_pgto <= '$data_final_mes' and pago = 'Sim' $sql_conta");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
	for($i=0; $i<$linhas; $i++){
		$receber_novembro += $res[$i]['subtotal'];
	}
}
$query = $pdo->query("SELECT * from pagar where data_pgto >= '$data_inicio_mes' and data_pgto <= '$data_final_mes' and pago = 'Sim' $sql_conta");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
	for($i=0; $i<$linhas; $i++){
		$pagar_novembro += $res[$i]['subtotal'];
	}
}
$saldo_novembro = $receber_novembro - $pagar_novembro;
$pagar_novembroF = @number_format($pagar_novembro, 2, ',', '.');
$receber_novembroF = @number_format($receber_novembro, 2, ',', '.');
$saldo_novembroF = @number_format($saldo_novembro, 2, ',', '.');
if($saldo_novembro > 0){
	$classe_novembro = 'green';
}else if($saldo_novembro < 0){
	$classe_novembro = 'red';
}




//PEGAR DADOS DO MES dezembro
$classe_dezembro = '#363636';
$pagar_dezembro = 0;
$receber_dezembro = 0;
$saldo_dezembro = 0;
$data_inicio_mes = $ano_atual."-12-01";
$data_final_mes = $ano_atual."-12-31";
$query = $pdo->query("SELECT * from receber where data_pgto >= '$data_inicio_mes' and data_pgto <= '$data_final_mes' and pago = 'Sim' $sql_conta");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
	for($i=0; $i<$linhas; $i++){
		$receber_dezembro += $res[$i]['subtotal'];
	}
}
$query = $pdo->query("SELECT * from pagar where data_pgto >= '$data_inicio_mes' and data_pgto <= '$data_final_mes' and pago = 'Sim' $sql_conta");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
	for($i=0; $i<$linhas; $i++){
		$pagar_dezembro += $res[$i]['subtotal'];
	}
}
$saldo_dezembro = $receber_dezembro - $pagar_dezembro;
$pagar_dezembroF = @number_format($pagar_dezembro, 2, ',', '.');
$receber_dezembroF = @number_format($receber_dezembro, 2, ',', '.');
$saldo_dezembroF = @number_format($saldo_dezembro, 2, ',', '.');
if($saldo_dezembro > 0){
	$classe_dezembro = 'green';
}else if($saldo_dezembro < 0){
	$classe_dezembro = 'red';
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
				<td style="border: 1px; solid #000; width: 7%; text-align: left;">
					<img style="margin-top: 7px; margin-left: 7px;" id="imag" src="<?php echo $url_sistema ?>img/logo.jpg" width="130px">
				</td>
				<td style="width: 30%; text-align: left; font-size: 13px;">
					
				</td>
				<td style="width: 1%; text-align: center; font-size: 13px;">
				
				</td>
				<td style="width: 47%; text-align: right; font-size: 9px;padding-right: 10px;">
						<b><big>RELATÓRIO DE BALANÇO ANUAL</big></b><br>  <br> <?php echo mb_strtoupper($data_hoje) ?>
				</td>
			</tr>		
		</table>
	</div>

<br>


		<table id="cabecalhotabela" style="border-bottom-style: solid; font-size: 11px; margin-bottom:10px; width: 100%; table-layout: fixed;">
			<thead>
				
				<tr id="cabeca" style="margin-left: 0px; background-color:#fff">
					<td style="width:20%; font-weight: bold; color:<?php echo $classe_janeiro ?>">JANEIRO</td>
					<td style="width:27%">RECEBIMENTOS R$ <?php echo $receber_janeiroF ?></td>
					<td style="width:27%">PAGAMENTOS R$ <?php echo $pagar_janeiroF ?></td>
					<td style="width:26%">SALDO <span style="color:<?php echo $classe_janeiro ?>"><b>R$ <?php echo $saldo_janeiroF ?></b></span></td>					
					
				</tr>

				<tr id="cabeca" style="margin-left: 0px; background-color:#fff">
					<td style="width:20%; font-weight: bold; color:<?php echo $classe_fevereiro ?>">FEVEREIRO</td>
					<td style="width:27%">RECEBIMENTOS R$ <?php echo $receber_fevereiroF ?></td>
					<td style="width:27%">PAGAMENTOS R$ <?php echo $pagar_fevereiroF ?></td>
					<td style="width:26%">SALDO <span style="color:<?php echo $classe_fevereiro ?>"><b>R$ <?php echo $saldo_fevereiroF ?></b></span></td>					
					
				</tr>



				<tr id="cabeca" style="margin-left: 0px; background-color:#fff">
					<td style="width:20%; font-weight: bold; color:<?php echo $classe_marco ?>">MARÇO</td>
					<td style="width:27%">RECEBIMENTOS R$ <?php echo $receber_marcoF ?></td>
					<td style="width:27%">PAGAMENTOS R$ <?php echo $pagar_marcoF ?></td>
					<td style="width:26%">SALDO <span style="color:<?php echo $classe_marco ?>"><b>R$ <?php echo $saldo_marcoF ?></b></span></td>					
					
				</tr>


				<tr id="cabeca" style="margin-left: 0px; background-color:#fff">
					<td style="width:20%; font-weight: bold; color:<?php echo $classe_abril ?>">ABRIL</td>
					<td style="width:27%">RECEBIMENTOS R$ <?php echo $receber_abrilF ?></td>
					<td style="width:27%">PAGAMENTOS R$ <?php echo $pagar_abrilF ?></td>
					<td style="width:26%">SALDO <span style="color:<?php echo $classe_abril ?>"><b>R$ <?php echo $saldo_abrilF ?></b></span></td>					
					
				</tr>


				<tr id="cabeca" style="margin-left: 0px; background-color:#fff">
					<td style="width:20%; font-weight: bold; color:<?php echo $classe_maio ?>">MAIO</td>
					<td style="width:27%">RECEBIMENTOS R$ <?php echo $receber_maioF ?></td>
					<td style="width:27%">PAGAMENTOS R$ <?php echo $pagar_maioF ?></td>
					<td style="width:26%">SALDO <span style="color:<?php echo $classe_maio ?>"><b>R$ <?php echo $saldo_maioF ?></b></span></td>					
					
				</tr>


					<tr id="cabeca" style="margin-left: 0px; background-color:#fff">
					<td style="width:20%; font-weight: bold; color:<?php echo $classe_junho ?>">JUNHO</td>
					<td style="width:27%">RECEBIMENTOS R$ <?php echo $receber_junhoF ?></td>
					<td style="width:27%">PAGAMENTOS R$ <?php echo $pagar_junhoF ?></td>
					<td style="width:26%">SALDO <span style="color:<?php echo $classe_junho ?>"><b>R$ <?php echo $saldo_junhoF ?></b></span></td>
				</tr>


					<tr id="cabeca" style="margin-left: 0px; background-color:#fff">
					<td style="width:20%; font-weight: bold; color:<?php echo $classe_julho ?>">JULHO</td>
					<td style="width:27%">RECEBIMENTOS R$ <?php echo $receber_julhoF ?></td>
					<td style="width:27%">PAGAMENTOS R$ <?php echo $pagar_julhoF ?></td>
					<td style="width:26%">SALDO <span style="color:<?php echo $classe_julho ?>"><b>R$ <?php echo $saldo_julhoF ?></b></span></td>
				</tr>



				<tr id="cabeca" style="margin-left: 0px; background-color:#fff">
					<td style="width:20%; font-weight: bold; color:<?php echo $classe_agosto ?>">AGOSTO</td>
					<td style="width:27%">RECEBIMENTOS R$ <?php echo $receber_agostoF ?></td>
					<td style="width:27%">PAGAMENTOS R$ <?php echo $pagar_agostoF ?></td>
					<td style="width:26%">SALDO <span style="color:<?php echo $classe_agosto ?>"><b>R$ <?php echo $saldo_agostoF ?></b></span></td>
				</tr>


				<tr id="cabeca" style="margin-left: 0px; background-color:#fff">
					<td style="width:20%; font-weight: bold; color:<?php echo $classe_setembro ?>">SETEMBRO</td>
					<td style="width:27%">RECEBIMENTOS R$ <?php echo $receber_setembroF ?></td>
					<td style="width:27%">PAGAMENTOS R$ <?php echo $pagar_setembroF ?></td>
					<td style="width:26%">SALDO <span style="color:<?php echo $classe_setembro ?>"><b>R$ <?php echo $saldo_setembroF ?></b></span></td>
				</tr>


				<tr id="cabeca" style="margin-left: 0px; background-color:#fff">
					<td style="width:20%; font-weight: bold; color:<?php echo $classe_outubro ?>">OUTUBRO</td>
					<td style="width:27%">RECEBIMENTOS R$ <?php echo $receber_outubroF ?></td>
					<td style="width:27%">PAGAMENTOS R$ <?php echo $pagar_outubroF ?></td>
					<td style="width:26%">SALDO <span style="color:<?php echo $classe_outubro ?>"><b>R$ <?php echo $saldo_outubroF ?></b></span></td>
				</tr>


				<tr id="cabeca" style="margin-left: 0px; background-color:#fff">
					<td style="width:20%; font-weight: bold; color:<?php echo $classe_novembro ?>">NOVEMBRO</td>
					<td style="width:27%">RECEBIMENTOS R$ <?php echo $receber_novembroF ?></td>
					<td style="width:27%">PAGAMENTOS R$ <?php echo $pagar_novembroF ?></td>
					<td style="width:26%">SALDO <span style="color:<?php echo $classe_novembro ?>"><b>R$ <?php echo $saldo_novembroF ?></b></span></td>
				</tr>


				<tr id="cabeca" style="margin-left: 0px; background-color:#fff">
					<td style="width:20%; font-weight: bold; color:<?php echo $classe_dezembro ?>">DEZEMBRO</td>
					<td style="width:27%">RECEBIMENTOS R$ <?php echo $receber_dezembroF ?></td>
					<td style="width:27%">PAGAMENTOS R$ <?php echo $pagar_dezembroF ?></td>
					<td style="width:26%">SALDO <span style="color:<?php echo $classe_dezembro ?>"><b>R$ <?php echo $saldo_dezembroF ?></b></span></td>
				</tr>


			</thead>
		</table>
</div>




<section id="stats-subtitle" style="margin-top: 200px">
			

			<style type="text/css">
				#principal{
					width:100%;
					height: 600px;
					margin-left:10px;
					font-family:Verdana, Helvetica, sans-serif;
					font-size:14px;

				}
				#barra{
					margin: 0 2px;
					vertical-align: bottom;
					display: inline-block;
					padding:2px;
					text-align:center;
					width:50px;


				}
				.cor1, .cor2, .cor3, .cor4, .cor5, .cor6, .cor7, .cor8, .cor9, .cor10, .cor11, .cor12{
					color:#FFF;
					padding: 5px;
				}
				.cor1{ background-color: <?php echo $classe_janeiro ?>; }
				.cor2{ background-color: <?php echo $classe_fevereiro ?>; }
				.cor3{ background-color: <?php echo $classe_marco ?>; }
				.cor4{ background-color: <?php echo $classe_abril ?>; }
				.cor5{ background-color: <?php echo $classe_maio ?>; }
				.cor6{ background-color: <?php echo $classe_junho ?>; }
				.cor7{ background-color: <?php echo $classe_julho ?>; }
				.cor8{ background-color: <?php echo $classe_agosto ?>; }
				.cor9{ background-color: <?php echo $classe_setembro ?>; }
				.cor10{ background-color: <?php echo $classe_outubro ?>; }
				.cor11{ background-color: <?php echo $classe_novembro ?>; }
				.cor12{ background-color: <?php echo $classe_dezembro ?>; }
			</style>

			<div id="principal">
				<p>Lucros no Ano de <?php echo $ano_atual ?></p>

				<?php 
					$divisao_barra = 1;
				 ?>
				
	<div id="barra">
		<div class="cor1" style="height:<?php echo $saldo_janeiro / $divisao_barra + 25 ?>px; font-size: 9px; max-height: 600px"><?php echo $saldo_janeiroF ?> </div>
		<div style="font-size: 10px">JANEIRO</div>
	</div>

	<div id="barra">
		<div class="cor2" style="height:<?php echo $saldo_fevereiro / $divisao_barra + 25 ?>px; font-size: 9px; max-height: 600px"><?php echo $saldo_fevereiroF ?> </div>
		<div style="font-size: 10px">FEVEREIRO</div>
	</div>

	<div id="barra">
		<div class="cor3" style="height:<?php echo $saldo_marco / $divisao_barra + 25 ?>px; font-size: 9px; max-height: 600px"><?php echo $saldo_marcoF ?> </div>
		<div style="font-size: 10px">MARÇO</div>
	</div>

		<div id="barra">
		<div class="cor4" style="height:<?php echo $saldo_abril / $divisao_barra + 25 ?>px; font-size: 9px; max-height: 600px"><?php echo $saldo_abrilF ?> </div>
		<div style="font-size: 10px">ABRIL</div>
	</div>


	<div id="barra">
		<div class="cor5" style="height:<?php echo $saldo_maio / $divisao_barra + 25 ?>px; font-size: 9px; max-height: 600px">R$ <?php echo $saldo_maioF ?> </div>
		<div style="font-size: 10px">MAIO</div>
	</div>


	<div id="barra">
		<div class="cor6" style="height:<?php echo $saldo_junho / $divisao_barra + 25 ?>px; font-size: 9px; max-height: 600px"><?php echo $saldo_junhoF ?> </div>
		<div style="font-size: 10px">JUNHO</div>
	</div>


	<div id="barra">
		<div class="cor7" style="height:<?php echo $saldo_julho / $divisao_barra + 25 ?>px; font-size: 9px; max-height: 600px"><?php echo $saldo_julhoF ?> </div>
		<div style="font-size: 10px">JULHO</div>
	</div>


	<div id="barra">
		<div class="cor8" style="height:<?php echo $saldo_agosto / $divisao_barra + 25 ?>px; font-size: 9px; max-height: 600px"><?php echo $saldo_agostoF ?> </div>
		<div style="font-size: 10px">AGOSTO</div>
	</div>


	<div id="barra">
		<div class="cor9" style="height:<?php echo $saldo_setembro / $divisao_barra + 25 ?>px; font-size: 9px; max-height: 600px"><?php echo $saldo_setembroF ?> </div>
		<div style="font-size: 10px">SETEMBRO</div>
	</div>



	<div id="barra">
		<div class="cor10" style="height:<?php echo $saldo_outubro / $divisao_barra + 25 ?>px; font-size: 9px; max-height: 600px"><?php echo $saldo_outubroF ?> </div>
		<div style="font-size: 10px">OUTUBRO</div>
	</div>


	<div id="barra">
		<div class="cor11" style="height:<?php echo $saldo_novembro / $divisao_barra + 25 ?>px; font-size: 9px; max-height: 600px"><?php echo $saldo_novembroF ?> </div>
		<div style="font-size: 10px">NOVEMBRO</div>
	</div>

	<div id="barra">
		<div class="cor12" style="height:<?php echo $saldo_dezembro / $divisao_barra + 25 ?>px; font-size: 9px; max-height: 600px"><?php echo $saldo_dezembroF ?> </div>
		<div style="font-size: 10px">DEZEMBRO</div>
	</div>



</div>



</section>



<div id="footer" class="row">
<hr style="margin-bottom: 0;">
	<table style="width:100%;">
		<tr style="width:100%;">
			<td style="width:60%; font-size: 10px; text-align: left;"><?php echo $nome_sistema ?> Telefone: <?php echo $telefone_sistema ?></td>
			<td style="width:40%; font-size: 10px; text-align: right;"><p class="page">Página  </p></td>
		</tr>
	</table>
</div>







</body>

</html>


