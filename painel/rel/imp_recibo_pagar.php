<?php 
include('../../conexao.php');

$id = $_POST['id'];

$query = $pdo->query("SELECT * from pagar where id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$data = $res[0]['data_pgto'];
$funcionario = $res[0]['funcionario'];
$fornecedor = $res[0]['fornecedor'];
$subtotal = $res[0]['subtotal'];
$descricao = $res[0]['descricao'];
$valor = $res[0]['valor'];
$multa = $res[0]['multa'];
$juros = $res[0]['juros'];
$desconto = $res[0]['desconto'];
$taxa = $res[0]['taxa'];
$obs = $res[0]['obs'];

$dataF = implode('/', array_reverse(@explode('-', $data)));

$subtotalF = number_format($subtotal, 2, ',', '.');
$valorF = number_format($valor, 2, ',', '.');
$multaF = @number_format($multa, 2, ',', '.');
$jurosF = @number_format($juros, 2, ',', '.');
$descontoF = @number_format($desconto, 2, ',', '.');
$taxaF = @number_format($taxa, 2, ',', '.');


$nome_pessoa = '';
$telefone_pessoa = '';
$pix_pessoa = '';
$tipo_pessoa = 'Pessoa';
if($fornecedor != 0 || $funcionario != 0){
	if($fornecedor != 0){
		$tab = 'fornecedores';
		$id_pessoa = $fornecedor;
		$tipo_pessoa = 'Fornecedor';
	}

	if($funcionario != 0){
		$tab = 'usuarios';
		$id_pessoa = $funcionario;
		$tipo_pessoa = 'Funcionário';
	}

	//nome pessoa
	$query2 = $pdo->query("SELECT * FROM $tab where id = '$id_pessoa'");
	$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
	$total_reg2 = @count($res2);
	if($total_reg2 > 0){
		$nome_pessoa = $res2[0]['nome'];
		$telefone_pessoa = $res2[0]['telefone'];
		$pix_pessoa = $res2[0]['pix'];

	}else{
		$nome_pessoa = '';
		$telefone_pessoa = '';
		$pix_pessoa = '';
	}

	
}



?>


<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<?php if(@$impressao_automatica == 'Sim'){ ?>
<script type="text/javascript">
	$(document).ready(function() {    		
		window.print();
		window.close(); 
	} );
</script>
<?php } ?>


<style type="text/css">
	*{
	margin:0px;

	/*Espaçamento da margem da esquerda e da Direita*/
	padding:0px;
	background-color:#ffffff;
	
	font-color:#000;	
	font-family: TimesNewRoman, Geneva, sans-serif; 

}
.text {
	&-center { text-align: center; }
}
.ttu { text-transform: uppercase;
	font-weight: bold;
	font-size: 1.2em;
 }

.printer-ticket {
	display: table !important;
	width: 100%;

	/*largura do Campos que vai os textos*/
	max-width: 400px;
	font-weight: light;
	line-height: 1.3em;

	/*Espaçamento da margem da esquerda e da Direita*/
	padding: 0px;
	font-family: TimesNewRoman, Geneva, sans-serif; 

	/*tamanho da Fonte do Texto*/
	font-size: 12px; 
	font-color:#000;
	
	
	}
	
	th { 
		font-weight: inherit;

		/*Espaçamento entre as uma linha para outra*/
		padding:5px;
		text-align: center;

		/*largura dos tracinhos entre as linhas*/
		border-bottom: 1px dashed #000000;
	}


	

	
	
		
	.cor{
		color:#000000;
	}
	
	
	

	/*margem Superior entre as Linhas*/
	.margem-superior{
		padding-top:5px;
	}
	
	
}
</style>



<table class="printer-ticket">

	<tr>
		<th class="ttu" class="title" colspan="3"><?php echo $nome_sistema ?></th>

	</tr>
	<tr style="font-size: 10px">
		<th colspan="3">
			<?php echo $endereco_sistema ?> <br />
			Contato: <?php echo $telefone_sistema ?>  <?php if($cnpj_sistema != ""){ ?> / CNPJ <?php echo  $cnpj_sistema  ?><?php } ?>
		</th>
	</tr>

		
	<tr>
		<th class="ttu margem-superior" colspan="3">
			RECIBO DE PAGAMENTO Nº <?php echo $id ?> 
			
		</th>
	</tr>

	
	<tbody>
		
			<tr>
				
					<td colspan="2" width="70%"> Eu, <?php echo $nome_pessoa ?>, atesto que recebi da empresa <?php echo $nome_sistema ?> a quantia de <b>R$ <?php echo $subtotalF ?> </b> na data do dia <?php echo $dataF ?>.
					</td>	
				
			</tr>

		


				
	</tbody>
	<tfoot>

		<tfoot>

			


		<?php if($obs != ""){ ?>

			<tr >
		<th colspan="3">
		</th>
		</tr>

		<tr style="margin-top:2px; text-align:center">
			<td colspan="3"><small><b>OBS:</b> <?php echo $obs ?></small></td>
			
		</tr>
		<?php } ?>

		<tr >
		<th colspan="3">
		</th>
		</tr>
	
		


	</tfoot>
</table>




<br><br>
<div align="center">__________________________</div>
<div align="center"><small>Assinatura</small></div>
