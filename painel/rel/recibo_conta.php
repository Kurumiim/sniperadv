<?php 
require_once("../../conexao.php");
require_once("../funcoes/extenso.php");
$id = $_GET['id'];

$token_rel = @$_GET['token'];
if($token_rel != 'A5030'){
echo '<script>window.location="../../"</script>';
exit();
}

$query = $pdo->query("SELECT * from receber where id = '$id' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
if(@count($res) > 0){
$descricao = $res[0]['descricao'];
$pessoa = $res[0]['cliente'];
$valor = $res[0]['subtotal'];
$data_pgto = $res[0]['data_pgto'];

$nome_pessoa = 'Sem Registro';

$query2 = $pdo->query("SELECT * FROM clientes where id = '$pessoa'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
if(@count($res2) > 0){
	$nome_pessoa = $res2[0]['nome'];
	
}


$valorF = @number_format($valor, 2, ',', '.');
$data_pgtoF = implode('/', array_reverse(@explode('-', $data_pgto)));
$valor_extenso = explode(".", $valor);
$valor_extenso1 = $valor_extenso[0].' reais';
if($valor_extenso[1] > 0){
  $valor_extenso2 = ' e '.$valor_extenso[1].' centavos';
}else{
  $valor_extenso2 = '';
}
}

?>




<!DOCTYPE html>
<html>
<head>
	<title>Recibo de Conta</title>

	
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">


	<style>

		@page {
			margin: 0px;

		}

		body {
  padding: 10px;
}

* {
  box-sizing: border-box;
}

.receipt-main {  
  width: 95%;
  padding: 15px;
  font-size: 12px;
  border: 1px solid #000;
}

.receipt-title {
  text-align: center;
  text-transform: uppercase;
  font-size: 20px;
  font-weight: 600;
  margin: 0;
}
  
.receipt-label {
  font-weight: 600;
}

.text-large {
  font-size: 16px;
}

.receipt-section {
  margin-top: 10px;
}

.receipt-footer {
  text-align: center;
  background: #ff0000;
}

.receipt-signature {
  height: 80px;
  margin: 50px 0;
  padding: 0 50px;
  background: #fff;
  
  .receipt-line {
    margin-bottom: 10px;
    border-bottom: 1px solid #000;
  }
  
  p {
    text-align: center;
    margin: 0;
  }

  .direita{
  	position:absolute;
  	right:30px;
  }


  .imagem {
			width: 160px;
			position:absolute;
			left:15px;
			top:20px;
			height:40px;
		}


	</style>


</head>
<body>	



<div class="receipt-main">

							<img class="imagem" src="<?php echo $url_sistema ?>img/logo.jpg" >
						

  
  <p class="receipt-title">Recibo de Pagamento</p>
  <br>
  
  <div class="receipt-section pull-left">
    <span class="receipt-label text-large">Número:</span>
    <span class="text-large"><?php echo date('Y/m') ?></span>

    <span class="text-large receipt-label direita">VALOR R$ <?php echo $valorF ?></span>
    
  </div>
  

  
  <div class="clearfix"></div>
  <br>
  
  <div class="receipt-section">
    <span><big>
      Recebi(emos) de <b><?php echo $nome_pessoa ?></b> a quantia de R$ <b><?php echo $valorF ?> </b> (<?php echo valor_por_extenso($valor_extenso1)?> <?php echo $valor_extenso2 ?>) na data <b><?php echo $data_pgtoF ?></b> correspondente a(ao) <?php echo $descricao ?>. 
    
  </big></span>
        
  </div>
  
  <br><br>
	<div align="center">

  <?php if($assinatura_recibo != 'Sim'){
  	echo '<br><br>';
  }else{
  	?>
  	<img src="<?php echo $url_sistema ?>/img/assinatura.jpg" width="" height=""><br>
  <?php } ?>
    
  	
    ______________________________________________________________________<br>
    (<b>ASSINATURA DO RESPONSÁVEL</b>)

  </div>
  <br>

   <div align="center">
    <?php echo mb_strtoupper($nome_sistema) ?> 
     - <?php echo $telefone_sistema ?>
  </div>

</div>




</body>
</html>