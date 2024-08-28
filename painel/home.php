<?php 
require_once("verificar.php");
$pag = 'home';

if($nivel_usuario == 'Escritório'){
	$id_usuario = 0;
	$mostrar_registros = 'Não';
}

if($mostrar_registros == 'Não'){
	$sql_usuario = " and usuario = '$id_usuario '";
	$sql_usuario_lanc = " and (usuario_lanc = '$id_usuario' or usuario_receb = '$id_usuario') ";
	$sql_abertura_contratos = " and (usuario_lanc = '$id_usuario' or  advogado1 = '$id_usuario' or advogado2 = '$id_usuario' or advogado3 = '$id_usuario' or marketing = '$id_usuario' or indicacao = '$id_usuario' or pessoa1 = '$id_usuario' or pessoa2 = '$id_usuario' )";
	$sql_processos = " and (usuario_lanc = '$id_usuario' or  advogado1 = '$id_usuario' or advogado2 = '$id_usuario' or advogado3 = '$id_usuario' or advogado4 = '$id_usuario')";
	$sql_conta = " and usuario_receb = '$id_usuario' and financeiro is null";


}else{
	$sql_usuario = " ";
	$sql_usuario_lanc = " ";
	$sql_abertura_contratos = " ";
	$sql_processos = " ";
	$sql_conta = ' and financeiro is null';
}



//total clientes
if($mostrar_registros == 'Não'){
	$query = $pdo->query("SELECT * from clientes where usuario = '$id_usuario'");
}else{
	$query = $pdo->query("SELECT * from clientes");
}
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_clientes = @count($res);

//total clientes mes
$query = $pdo->query("SELECT * from clientes where data_cad >= '$data_inicio_mes' and data_cad <= '$data_final_mes' $sql_usuario");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_clientes_mes = @count($res);

$total_pagar_vencidas = 0;
$query = $pdo->query("SELECT * from pagar where vencimento < curDate() and pago != 'Sim' $sql_conta");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$contas_pagar_vencidas = @count($res);
for($i=0; $i<$contas_pagar_vencidas; $i++){
	$valor_1 = $res[$i]['valor'];	
	$total_pagar_vencidas += $valor_1;
}
$total_pagar_vencidasF = @number_format($total_pagar_vencidas, 2, ',', '.');	



$total_receber_vencidas = 0;
$query = $pdo->query("SELECT * from receber where vencimento < curDate() and pago != 'Sim' $sql_conta");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$contas_receber_vencidas = @count($res);
for($i=0; $i<$contas_receber_vencidas; $i++){
	$valor_2 = $res[$i]['valor'];	
	$total_receber_vencidas += $valor_2;
}
$total_receber_vencidasF = @number_format($total_receber_vencidas, 2, ',', '.');


//total recebidas mes
$total_recebidas_mes = 0;
$query = $pdo->query("SELECT * from receber where data_pgto >= '$data_inicio_mes' and data_pgto <= '$data_final_mes' and pago = 'Sim' $sql_conta");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$contas_recebidas_mes = @count($res);
for($i=0; $i<$contas_recebidas_mes; $i++){
	$valor_3 = $res[$i]['valor'];	
	$total_recebidas_mes += $valor_3;
}
$total_recebidas_mesF = @number_format($total_recebidas_mes, 2, ',', '.');

//total contas pagas mes
$total_pagas_mes = 0;
$query = $pdo->query("SELECT * from pagar where data_pgto >= '$data_inicio_mes' and data_pgto <= '$data_final_mes' and pago = 'Sim' $sql_conta");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$contas_pagas_mes = @count($res);
for($i=0; $i<$contas_pagas_mes; $i++){
	$valor_4 = $res[$i]['valor'];	
	$total_pagas_mes += $valor_4;
}
$total_pagas_mesF = @number_format($total_pagas_mes, 2, ',', '.');


$total_saldo_mes = $total_recebidas_mes - $total_pagas_mes;
$total_saldo_mesF = @number_format($total_saldo_mes, 2, ',', '.');
if($total_saldo_mes >= 0){
	$classe_saldo = 'text-success';
}else{
	$classe_saldo = 'text-danger';
}






//total recebidas dia
$total_recebidas_dia = 0;
$query = $pdo->query("SELECT * from receber where data_pgto = curDate() and pago = 'Sim' $sql_conta");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$contas_recebidas_dia = @count($res);
for($i=0; $i<$contas_recebidas_dia; $i++){
	$valor_3 = $res[$i]['valor'];	
	$total_recebidas_dia += $valor_3;
}
$total_recebidas_diaF = @number_format($total_recebidas_dia, 2, ',', '.');

//total contas pagas dia
$total_pagas_dia = 0;
$query = $pdo->query("SELECT * from pagar where data_pgto = curDate() and pago = 'Sim' $sql_conta");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$contas_pagas_dia = @count($res);
for($i=0; $i<$contas_pagas_dia; $i++){
	$valor_4 = $res[$i]['valor'];	
	$total_pagas_dia += $valor_4;
}
$total_pagas_diaF = @number_format($total_pagas_dia, 2, ',', '.');


$total_saldo_dia = $total_recebidas_dia - $total_pagas_dia;
$total_saldo_diaF = @number_format($total_saldo_dia, 2, ',', '.');
if($total_saldo_dia >= 0){
	$classe_saldo_dia = 'bg-success';
}else{
	$classe_saldo_dia = 'bg-danger';
}




//valores para o grafico de linhas (ano atual, despesas e recebimentos)
$total_meses_pagar_grafico = '';
$total_meses_receber_grafico = '';

for ($i=1; $i <= 12; $i++) { 
	if($i < 10){
		$mes_verificado = '0'.$i;
	}else{
		$mes_verificado = $i;
	}


	$data_inicio_mes_grafico = $ano_atual."-".$mes_verificado."-01";

	if($mes_verificado == '04' || $mes_verificado == '06' || $mes_verificado == '09' || $mes_verificado == '11'){
	$data_final_mes_grafico = $ano_atual.'-'.$mes_verificado.'-30';
	}else if($mes_verificado == '02'){
		$bissexto = date('L', @mktime(0, 0, 0, 1, 1, $mes_verificado));
		if($bissexto == 1){
			$data_final_mes_grafico = $ano_atual.'-'.$mes_verificado.'-29';
		}else{
			$data_final_mes_grafico = $ano_atual.'-'.$mes_verificado.'-28';
		}

	}else{
		$data_final_mes_grafico = $ano_atual.'-'.$mes_verificado.'-31';
	}




	//total recebidas mes
$total_recebidas_mes_grafico = 0;
$query2 = $pdo->query("SELECT * from receber where data_pgto >= '$data_inicio_mes_grafico' and data_pgto <= '$data_final_mes_grafico' and pago = 'Sim' $sql_conta");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$contas_recebidas_mes_grafico = @count($res2);
for($i2=0; $i2<$contas_recebidas_mes_grafico; $i2++){
	$valor_3 = $res2[$i2]['valor'];	
	$total_recebidas_mes_grafico += $valor_3;
}


//total contas pagas mes
$total_pagas_mes_grafico = 0;
$query2 = $pdo->query("SELECT * from pagar where data_pgto >= '$data_inicio_mes_grafico' and data_pgto <= '$data_final_mes_grafico' and pago = 'Sim' $sql_conta");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$contas_pagas_mes_grafico = @count($res2);
for($i2=0; $i2<$contas_pagas_mes_grafico; $i2++){
	$valor_4 = $res2[$i2]['valor'];	
	$total_pagas_mes_grafico += $valor_4;
}


$total_meses_pagar_grafico .= $total_pagas_mes_grafico.'-';
$total_meses_receber_grafico .= $total_recebidas_mes_grafico.'-';
	
}





//tarefas
$query = $pdo->query("SELECT * from tarefas where usuario = '$id_usuario' and status = 'Agendada' and data <= curDate() and hora < curTime() order by id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$tarefas_atrasadas = @count($res);

$query = $pdo->query("SELECT * from tarefas where usuario = '$id_usuario' and status = 'Agendada' order by id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_tarefas = @count($res);


$query = $pdo->query("SELECT * from tarefas where usuario = '$id_usuario' and status = 'Agendada' and data = curDate() order by id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$tarefas_agendadas_hoje = @count($res);




//abertura de contratos
$query = $pdo->query("SELECT * from abertura_contratos where data >= '$data_inicio_mes' and data <= '$data_final_mes' $sql_abertura_contratos order by id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$aberturas_mes = @count($res);

$query = $pdo->query("SELECT * from abertura_contratos where data = curDate() $sql_abertura_contratos order by id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$aberturas_hoje = @count($res);



$query = $pdo->query("SELECT * from processos where data_abertura >= '$data_inicio_mes' and data_abertura <= '$data_final_mes' $sql_processos order by id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$processos_mes = @count($res);

$query = $pdo->query("SELECT * from processos where data_abertura = curDate() $sql_processos order by id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$processos_hoje = @count($res);


//total a receber mes
$total_pendente_receber = 0;
$query = $pdo->query("SELECT * from receber where pago != 'Sim' $sql_conta");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$contas_pendentes_mes = @count($res);
for($i=0; $i<$contas_pendentes_mes; $i++){
	$valor_3 = $res[$i]['valor'];	
	$total_pendente_receber += $valor_3;
}
$total_pendente_receberF = @number_format($total_pendente_receber, 2, ',', '.');


//total a receber hoje
$total_pendente_receber_hoje = 0;
$query = $pdo->query("SELECT * from receber where vencimento = curDate() and pago != 'Sim' $sql_conta");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$contas_pendentes_mes = @count($res);
for($i=0; $i<$contas_pendentes_mes; $i++){
	$valor_3 = $res[$i]['valor'];	
	$total_pendente_receber_hoje += $valor_3;
}
$total_pendente_receber_hojeF = @number_format($total_pendente_receber_hoje, 2, ',', '.');


//verificar se ele tem a permissão de estar nessa página
	if(@$home == 'ocultar'){
		echo "<script>window.location='index'</script>";
		exit();
	}
	?>


	<div class="mt-4 justify-content-between">


	<?php if($ativo_sistema == ''){ ?>

<div style="background: #ffc341; color:#3e3e3e; padding:10px; font-size:14px; margin-bottom:10px">

<div><i class="fa fa-info-circle"></i> <b>Aviso: </b> Prezado Cliente, não identificamos o pagamento de sua última mensalidade, entre em contato conosco o mais rápido possivel para regularizar o pagamento, caso contário seu acesso ao sistema será desativado.</div>

</div>

<?php } ?>


		

						
							<div class="row mb-2 m-2">
								<div class="col-xl-3 col-lg-3 col-md-6 col-6" style="padding:5px; ">
									<a href="clientes">
									<div style="padding:6px;  box-shadow: 2px 2px 0px 0px rgba(0, 0, 0, 0.1);">
									<p class="mb-1 tx-12">Clientes Cadastrados</p>
									<h5 class="mb-1"><?php echo $total_clientes ?></h5>
									<p class="tx-11 text-muted">Este Mês<span class="text-success ms-2"><i class="fa fa-caret-up me-2"></i><span class="badge bg-success text-white tx-11"><?php echo $total_clientes_mes ?></span></span></p>
									</div>
									</a>
								</div>
								<div class="col-xl-3 col-lg-3 col-md-6 col-6" style="padding:5px;  ">
									<a href="pagar">
									<div style="padding:6px;  box-shadow: 2px 2px 0px 0px rgba(0, 0, 0, 0.1);">
									<p class=" mb-1">Despesas Vencidas</p>
									<h5 class="mb-1">R$ <?php echo $total_pagar_vencidasF ?></h5>
									<p class="tx-11 text-muted">Pagar Vencidas<span class="text-danger ms-2"><i class="fa fa-caret-down me-2"></i><span class="badge bg-danger text-white tx-11"><?php echo $contas_pagar_vencidas ?></span></span></p>
									</div>
									</a>
								</div>
								<div class="col-xl-3 col-lg-3 col-md-6 col-6" style="padding:5px">
									<a href="receber">
									<div style="padding:6px;  box-shadow: 2px 2px 0px 0px rgba(0, 0, 0, 0.1);">
									<p class=" mb-1">Receber Vencidas</p>
									<h5 class="mb-1">R$ <?php echo $total_receber_vencidasF ?></h5>
									<p class="tx-11 text-muted">Receber Vencidas<span class="text-success ms-2"><i class="fa fa-caret-up me-2"></i><span class="badge bg-success text-white tx-11"><?php echo $contas_receber_vencidas ?></span></span></p>
									</div>
									</a>
								</div>
								<div class="col-xl-3 col-lg-3 col-md-6 col-6" style="padding:5px">
									<div style="padding:6px; box-shadow: 2px 2px 0px 0px rgba(0, 0, 0, 0.1);">
									<p class=" mb-1">Saldo no Mês</p>
									<h5 class="mb-1 <?php echo $classe_saldo ?>">R$ <?php echo $total_saldo_mesF ?></h5>
									<p class="tx-11 text-muted">Saldo Hoje<span class="text-success ms-2"><i class="fa fa-caret-up me-2"></i><span class="badge <?php echo $classe_saldo_dia ?> text-white tx-11">R$ <?php echo $total_saldo_diaF ?></span></span></p>
									</div>
								</div>
							</div>
							<div id="statistics2"></div>
						
					

		<div class="card custom-card overflow-hidden ocultar_mobile">
			<div class="card-header border-bottom-0">
				<div>
					<h3 class="card-title mb-2 ">Recebimentos / Despesas <?php echo $ano_atual ?></h3> <span class="d-block tx-12 mb-0 text-muted"></span>
				</div>
			</div>
			<div class="card-body">
				<div id="statistics1"></div>
			</div>
		</div>


	</div>	




	<div class="row">


		<div class="col-xl-6 col-lg-12 col-md-6 col-xs-12">
			<a href="tarefas">
			<div class="card sales-card " style="box-shadow: 2px 2px 0px 0px rgba(0, 0, 0, 0.1);">
				<div class="row">

					<div class="col-8">
						<div class="ps-4 pt-4 pe-3 pb-4">
							<div class="">
								<h6 class="mb-2 tx-12 ">Total de Tarefas Pendentes</h6>
							</div>
							<div class="pb-0 mt-0">
								<div class="d-flex">
									<h4 class="tx-20 font-weight-semibold mb-2 text-danger"><?php echo $total_tarefas ?></h4>
								</div>
								<p class="mb-0 tx-12 text-muted">Pendentes Hoje<i class="fa fa-caret-up mx-2 text-success"></i>
									<span class="text-success font-weight-semibold"> <?php echo $tarefas_agendadas_hoje ?></span>

									<span style="margin-left: 20px">Tarefas Atrasadas<i class="fa fa-caret-up mx-2 text-success"></i>
									<span class="text-danger font-weight-semibold"> <?php echo $tarefas_atrasadas ?></span></span>
								</p>

							</div>
						</div>
					</div>

					<div class="col-4">
						<div class="circle-icon bg-primary-transparent text-center align-self-center overflow-hidden">
							<i class="fe fe-shopping-bag tx-16 text-primary"></i>
						</div>
					</div>
				</div>
			</div>
			</a>
		</div>
		


		<div class="col-xl-6 col-lg-12 col-md-6 col-xs-12">
			<a href="abertura_contratos">
			<div class="card sales-card" style="box-shadow: 2px 2px 0px 0px rgba(0, 0, 0, 0.1);">
				<div class="row">
					<div class="col-8">
						<div class="ps-4 pt-4 pe-3 pb-4">
							<div class="">
								<h6 class="mb-2 tx-12">Aberturas de Contratos Mês</h6>
							</div>
							<div class="pb-0 mt-0">
								<div class="d-flex">
									<h4 class="tx-20 font-weight-semibold mb-2"><?php echo $aberturas_mes ?></h4>
								</div>
								<p class="mb-0 tx-12 text-muted">Hoje<i class="fa fa-caret-down mx-2 text-danger"></i>
									<span class="font-weight-semibold text-danger"><?php echo $aberturas_hoje ?></span>
								</p>
							</div>
						</div>
					</div>
					<div class="col-4">
						<div class="circle-icon bg-info-transparent text-center align-self-center overflow-hidden">
							<i class="fe fe-dollar-sign tx-16 text-info"></i>
						</div>
					</div>
				</div>
			</div>
		</a>
		</div>
		<div class="col-xl-6 col-lg-12 col-md-6 col-xs-12">
			<a href="processos">
			<div class="card sales-card" style="box-shadow: 2px 2px 0px 0px rgba(0, 0, 0, 0.1);">
				<div class="row">
					<div class="col-8">
						<div class="ps-4 pt-4 pe-3 pb-4">
							<div class="">
								<h6 class="mb-2 tx-12">Processos iniciados este Mês</h6>
							</div>
							<div class="pb-0 mt-0">
								<div class="d-flex">
									<h4 class="tx-20 font-weight-semibold mb-2"><?php echo @$processos_mes ?></h4>
								</div>
								<p class="mb-0 tx-12 text-muted">Iniciados Hoje<i class="fa fa-caret-up mx-2 text-success"></i>
									<span class=" text-success font-weight-semibold"><?php echo @$processos_hoje ?></span>
								</p>
							</div>
						</div>
					</div>
					<div class="col-4">
						<div class="circle-icon bg-secondary-transparent text-center align-self-center overflow-hidden">
							<i class="fe fe-external-link tx-16 text-secondary"></i>
						</div>
					</div>
				</div>
			</div>
		</a>
		</div>
		<div class="col-xl-6 col-lg-12 col-md-6 col-xs-12">
			<a href="receber">
			<div class="card sales-card" style="box-shadow: 2px 2px 0px 0px rgba(0, 0, 0, 0.1);">
				<div class="row">
					<div class="col-8">
						<div class="ps-4 pt-4 pe-3 pb-4">
							<div class="">
								<h6 class="mb-2 tx-12">Total à Receber</h6>
							</div>
							<div class="pb-0 mt-0">
								<div class="d-flex">
									<h4 class="tx-22 font-weight-semibold mb-2"><?php echo @$total_pendente_receberF ?></h4>
								</div>
								<p class="mb-0 tx-12  text-muted">Hoje<i class="fa fa-caret-down mx-2 text-danger"></i>
									<span class="text-danger font-weight-semibold"><?php echo @$total_pendente_receber_hojeF ?></span>
								</p>
							</div>
						</div>
					</div>
					<div class="col-4">
						<div class="circle-icon bg-warning-transparent text-center align-self-center overflow-hidden">
							<i class="fe fe-credit-card tx-16 text-warning"></i>
						</div>
					</div>
				</div>
			</div>
		</a>
		</div>
	</div>







<script type="text/javascript">
	// GRAFICO DE BARRAS
function statistics1() {
	var total_pagar = "<?=$total_meses_pagar_grafico?>";
	var total_receber = "<?=$total_meses_receber_grafico?>";

	var split_pagar = total_pagar.split("-");
	var split_receber = total_receber.split("-");


	setTimeout(()=>{
		var options1 = {
			series: [{
				name: 'Total Recebido',
				data: [split_receber[0], split_receber[1], split_receber[2], split_receber[3], split_receber[4], split_receber[5], split_receber[6], split_receber[7], split_receber[8], split_receber[9], split_receber[10], split_receber[11]],
			},{
				name: 'Total Pago',
				data: [split_pagar[0], split_pagar[1], split_pagar[2], split_pagar[3], split_pagar[4], split_pagar[5], split_pagar[6], split_pagar[7], split_pagar[8], split_pagar[9], split_pagar[10], split_pagar[11]],
			}],
			chart: {
				type: 'bar',
				height: 280
			},
			grid: {
				borderColor: '#f2f6f7',
			},
			colors: ["#098522","#bf281d"],
			plotOptions: {
				bar: {
					colors: {
						ranges: [{
							from: -100,
							to: -46,
							color: '#098522'
						}, {
							from: -45,
							to: 0,
							color: '#bf281d'
			}]
			},
			columnWidth: '40%',
		}
	},
	dataLabels: {
		enabled: false,
	},
	stroke: {
		show: true,
		width: 4,
		colors: ['transparent']
	},
	legend: {
		show: true,
		position:'top',
	},
	yaxis: {
		title: {
			text: 'Valores',
			style: {
				color: '#adb5be',
				fontSize: '14px',
				fontFamily: 'poppins, sans-serif',
				fontWeight: 600,
				cssClass: 'apexcharts-yaxis-label',
			},
		},
		labels: {
			formatter: function (y) {
				return y.toFixed(0) + "";
			}
		}
	},
	xaxis: {
		type: 'month',
		categories: ['Jan','Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
		axisBorder: {
			show: true,
			color: 'rgba(119, 119, 142, 0.05)',
			offsetX: 0,
			offsetY: 0,
		},
		axisTicks: {
			show: true,
			borderType: 'solid',
			color: 'rgba(119, 119, 142, 0.05)',
			width: 6,
			offsetX: 0,
			offsetY: 0
		},
		labels: {
			rotate: -90
		}
	}
		};
		document.getElementById('statistics1').innerHTML = ''; 
		var chart1 = new ApexCharts(document.querySelector("#statistics1"), options1);
		chart1.render();
	}, 300);
}

</script>