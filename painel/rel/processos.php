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
if($status == 'Preparação'){
	$texto_status = ' EM PREPARAÇÃO';
}

if($status == 'Andamento'){
	$texto_status = ' EM ANDAMENTO';
}	

if($status == 'Finalizado'){
	$texto_status = ' FINALIZADOS';
}	

if($status == 'Cancelado'){
	$texto_status = ' CANCELADOS';
}	

if($status == 'Arquivado'){
	$texto_status = ' ARQUIVADOS';
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
						<b><big>RELATÓRIO DE PROCESSOS <?php echo $texto_status ?></big></b>
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
					<td style="width:22%">CLIENTE</td>
					<td style="width:14%">NÚMERO PROCESSO</td>
					<td style="width:14%">TIPO AÇÃO</td>
					<td style="width:12%">VALOR</td>
					<td style="width:14%">STATUS</td>
					<td style="width:12%">DATA ABERTURA</td>
					<td style="width:12%">DATA FECHAMENTO</td>
					
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



		<table style="width: 100%; table-layout: fixed; font-size:8px; text-transform: uppercase;">
			<thead>
				<tbody>
					<?php



if($mostrar_registros == 'Não'){
	$query = $pdo->query("SELECT * from processos where status like '%$status%' and data_abertura >= '$dataInicial' and data_abertura <= '$dataFinal' and (usuario_lanc = '$id_usuario' or  advogado1 = '$id_usuario' or advogado2 = '$id_usuario' or advogado3 = '$id_usuario' or advogado4 = '$id_usuario') order by id desc");
}else{
	$query = $pdo->query("SELECT * from processos where status like '%$status%' and data_abertura >= '$dataInicial' and data_abertura <= '$dataFinal' order by id desc");
}

$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
for($i=0; $i<$linhas; $i++){
	$id = $res[$i]['id'];
	$cliente = $res[$i]['cliente'];
	$valor = $res[$i]['valor'];
	$num_processo = $res[$i]['num_processo'];
	$tipo_acao = $res[$i]['tipo_acao'];
	$jurisdicao = $res[$i]['jurisdicao'];
	$vara = $res[$i]['vara'];	
	$comarca = $res[$i]['comarca'];
	$segredo = $res[$i]['segredo'];	
	$justica_gratuita = $res[$i]['justica_gratuita'];
	$advogado1 = $res[$i]['advogado1'];
	$advogado2 = $res[$i]['advogado2'];
	$advogado3 = $res[$i]['advogado3'];
	$advogado4 = $res[$i]['advogado4'];
	$orgao_julgador = $res[$i]['orgao_julgador'];
	$status = $res[$i]['status'];
	$data_abertura = $res[$i]['data_abertura'];
	$data_fechamento = $res[$i]['data_fechamento'];
	$usuario_lanc = $res[$i]['usuario_lanc'];
	$obs = $res[$i]['obs'];
	$data_cad = $res[$i]['data_cad'];

	$nome_contraria = $res[$i]['nome_contraria'];
	$telefone_contraria = $res[$i]['telefone_contraria'];
	$cpf_contraria = $res[$i]['cpf_contraria'];
	$rg_contraria = $res[$i]['rg_contraria'];
	$endereco_contraria = $res[$i]['endereco_contraria'];
	$estado_civil_contraria = $res[$i]['estado_civil_contraria'];
	$advogado_contraria = $res[$i]['advogado_contraria'];
	
	

	$data_cadF = implode('/', array_reverse(@explode('-', $data_cad)));
	$data_aberturaF = implode('/', array_reverse(@explode('-', $data_abertura)));
	$data_fechamentoF = implode('/', array_reverse(@explode('-', $data_fechamento)));
	$valorF = @number_format($valor, 2, ',', '.');
	
	$query2 = $pdo->query("SELECT * FROM clientes where id = '$cliente'");
	$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
	if(@count($res2) > 0){
		$nome_cliente = $res2[0]['nome'];
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



  	 ?>

  	 
      <tr>
<td style="width:22%"><?php echo $nome_cliente ?> </td>
					<td style="width:14%"><?php echo $num_processo ?></td>
					<td style="width:18%"><?php echo $nome_servico ?></td>
					<td style="width:12%">R$ <?php echo $valorF ?></td>
					<td style="width:14%; color:<?php echo $classe_status ?>"><?php echo $status ?></td>
					<td style="width:10%; "><?php echo $data_aberturaF ?></td>
					<td style="width:10%; "><?php echo $data_fechamentoF ?></td>


    </tr>

<?php } } ?>
				</tbody>
	
			</thead>
		</table>
	


</div>
<hr>


</body>

</html>




 