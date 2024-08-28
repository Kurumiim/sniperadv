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

$id = $_GET['id'];
$cabecalho = $_GET['cabecalho'];

$query = $pdo->query("SELECT * FROM temp_texto WHERE id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$texto = $res[0]['texto'];

$pdo->query("DELETE FROM temp_texto WHERE id = '$id'");

?>

<!DOCTYPE html>
<html>
<head>
	<style type="text/css">	
<?php if($cabecalho != 'Não'){ ?>
@page { margin: 145px 20px 25px 20px; }
#header { position: fixed; left: 0px; top: -110px; bottom: 100px; right: 0px; height: 35px; text-align: center; padding-bottom: 100px; }
#content {margin-left: 113px; margin-right: 75px; margin-bottom: 50px}
#footer { position: fixed; left: 0px; bottom: -60px; right: 0px; height: 80px; }
#footer .page:after {content: counter(page, my-sec-counter);}
body {font-family: 'Tw Cen MT', sans-serif;}
<?php }else{ ?>
@page { margin: 113px 75px 75px 113px; }
<?php } ?>

	</style>
</head>
<body>

<?php if($cabecalho != 'Não'){ ?>
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
						<b><big><?php echo mb_strtoupper($nome_sistema) ?></big></b>	
						<br>CNPJ: <?php echo mb_strtoupper($cnpj_sistema) ?> Telefone: <?php echo $telefone_sistema ?> 						
							<br> <?php echo mb_strtoupper($data_hoje) ?>
				</td>
			</tr>		
		</table>
	</div>	
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

	<?php echo $texto ?>

</div>

<?php }else{ 
	echo $texto;
 } ?>

</body>

</html>




