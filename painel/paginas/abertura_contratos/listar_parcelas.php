<?php 
@session_start();
$id_usuario = @$_SESSION['id'];
require_once("../../../conexao.php");
require_once("../../verificar.php");
$pagina = 'receber';
$id = $_POST['id'];

echo <<<HTML
<small>
HTML;

$query = $pdo->query("SELECT * FROM $pagina where referencia = 'Abertura Contrato' and financeiro = 'Não' and (id_ref = '$id' and parcela is not null) or (id_ref = '0' and usuario_lanc = '$id_usuario') and parcela is not null order by id desc");


$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

if($total_reg > 0){
echo <<<HTML
	<small>
	<table class="table table-hover" id="tabela_arquivos">
		<thead> 
			<tr style="background: #f2f0f0; padding:2px"> 				
				<th>Descrição</th>
				<th>Data Venc</th>				
				<th>Valor</th>			
				<th>Editar</th>
			</tr> 
		</thead> 
		<tbody> 
HTML;
for($i=0; $i < $total_reg; $i++){
	foreach ($res[$i] as $key => $value){}
$id = $res[$i]['id'];
$descricao = $res[$i]['descricao'];
$data_venc = $res[$i]['vencimento'];
$valor = $res[$i]['valor'];
$pago = $res[$i]['pago'];

if($pago == 'Sim'){
	$texto_pago = '<small><span style="color:green">(Pago)</span></small>';
	$classe_pago = 'readonly';
}else{
	$texto_pago = '';
	$classe_pago = '';
}

$data_vencF = implode('/', array_reverse(@explode('-', $data_venc)));
$valorF = @number_format($valor, 2, ',', '.');

echo <<<HTML
			<tr>					
				<td class=""><input {$classe_pago} type="text"  value="{$descricao} " id="descricao_parcela_{$id}" style="background: transparent; border: none; border-bottom: 1px solid #000; outline: 0"> {$texto_pago}</td>
				<td class="esc"><input {$classe_pago} type="date" value="{$data_venc}" id="data_parcela_{$id}" style="background: transparent; border: none; border-bottom: 1px solid #000; outline: 0"></td>				
				<td class="esc">R$ <input {$classe_pago} type="text" value="{$valor}" id="valor_parcela_{$id}" style="background: transparent; border: none; border-bottom: 1px solid #000; width:80px; outline: 0"></td>
				<td>
					<big><a class="icones_mobile" href="#" onclick="editarParcela('{$id}')" title="Confirmar Edição"><i class="fa fa-check-square " style="color:#079934"></i></a></big>
				</td>
				
			</tr> 
HTML;
}
echo <<<HTML
		</tbody> 
	</table>
	<small>
</small>
HTML;
}

?>




<script type="text/javascript">
	function editarParcela(id){
		var valor = $("#valor_parcela_"+id).val();
		var data_venc = $("#data_parcela_"+id).val();
		var descricao = $("#descricao_parcela_"+id).val();
		
		$.ajax({
					url: 'paginas/' + pag + "/editar_parcelas.php",
					method: 'POST',
					data: {id, valor, descricao, data_venc},
					dataType: "text",

					success:function(result){						
						listarParcelas();
					}
				});
	}
</script>