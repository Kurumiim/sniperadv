<?php 
@session_start();
$mostrar_registros = @$_SESSION['registros'];
$id_usuario = @$_SESSION['id'];
$tabela = 'abertura_contratos';
require_once("../../../conexao.php");
require_once("../../verificar.php");

$editar_ab = '';
$excluir_ab = '';
$finalizado_ab = '';
$arquivos_ab = '';
$contas_ab = '';
$pdf_ab = '';
$contrato_ab = '';
if(@$_SESSION['nivel'] != 'Administrador' and @$_SESSION['nivel'] != 'Escritório'){
	require_once("../../verificar_permissoes.php");
}

$dataInicial = @$_POST['p2'];
$dataFinal = @$_POST['p3'];
$status = '%'.@$_POST['p1'].'%';

$data_hoje = date('Y-m-d');
$data_atual = date('Y-m-d');
$mes_atual = Date('m');
$ano_atual = Date('Y');
$data_inicio_mes = $ano_atual."-".$mes_atual."-01";
$data_inicio_ano = $ano_atual."-01-01";

$data_ontem = date('Y-m-d', @strtotime("-1 days",@strtotime($data_atual)));
$data_amanha = date('Y-m-d', @strtotime("+1 days",@strtotime($data_atual)));


if($mes_atual == '04' || $mes_atual == '06' || $mes_atual == '07' || $mes_atual == '09'){
	$data_final_mes = $ano_atual.'-'.$mes_atual.'-30';
}else if($mes_atual == '02'){
	$bissexto = date('L', @mktime(0, 0, 0, 1, 1, $ano_atual));
	if($bissexto == 1){
		$data_final_mes = $ano_atual.'-'.$mes_atual.'-29';
	}else{
		$data_final_mes = $ano_atual.'-'.$mes_atual.'-28';
	}

}else{
	$data_final_mes = $ano_atual.'-'.$mes_atual.'-31';
}

if($dataInicial == ""){
	$dataInicial = $data_inicio_mes;
}

if($dataFinal == ""){
	$dataFinal = $data_final_mes;
}

if($mostrar_registros == 'Não'){
	$query = $pdo->query("SELECT * from $tabela where status like '$status' and data >= '$dataInicial' and data <= '$dataFinal' and (usuario_lanc = '$id_usuario' or  advogado1 = '$id_usuario' or advogado2 = '$id_usuario' or advogado3 = '$id_usuario' or marketing = '$id_usuario' or indicacao = '$id_usuario' or pessoa1 = '$id_usuario' or pessoa2 = '$id_usuario' ) order by id desc");
}else{
	$query = $pdo->query("SELECT * from $tabela where status like '$status' and data >= '$dataInicial' and data <= '$dataFinal' order by id desc");
}
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
echo <<<HTML

	<table class="table text-nowrap border-bottom dt-responsive" id="tabela">
	<thead> 
	<tr class="bg-primary"> 
	<th align="center" width="5%" class="text-center">Selecionar</th>
	<th>Cliente</th>	
	<th class="esc">Valor</th>	
	<th class="esc">Entrada</th>	
	<th class="esc">Parcelas</th>
	<th class="esc">Frequência</th>	
	<th class="esc">Serviço</th>
	<th class="esc">Data</th>	
	<th>Ações</th>
	</tr> 
	</thead> 
	<tbody>	
HTML;

for($i=0; $i<$linhas; $i++){
	$id = $res[$i]['id'];
	$cliente = $res[$i]['cliente'];
	$valor = $res[$i]['valor'];
	$valor_entrada = $res[$i]['valor_entrada'];
	$parcelas = $res[$i]['parcelas'];
	$frequencia = $res[$i]['frequencia'];
	$data_venc = $res[$i]['data_venc'];	
	$status = $res[$i]['status'];
	$tipo_servico = $res[$i]['tipo_servico'];	
	$valor_escritorio = $res[$i]['valor_escritorio'];
	$advogado1 = $res[$i]['advogado1'];
	$advogado2 = $res[$i]['advogado2'];
	$advogado3 = $res[$i]['advogado3'];
	$indicacao = $res[$i]['indicacao'];
	$marketing = $res[$i]['marketing'];
	$pessoa1 = $res[$i]['pessoa1'];
	$pessoa2 = $res[$i]['pessoa2'];
	$valor_advogado1 = $res[$i]['valor_advogado1'];
	$valor_advogado2 = $res[$i]['valor_advogado2'];
	$valor_advogado3 = $res[$i]['valor_advogado3'];
	$valor_marketing = $res[$i]['valor_marketing'];
	$valor_indicacao = $res[$i]['valor_indicacao'];
	$valor_pessoa1 = $res[$i]['valor_pessoa1'];
	$valor_pessoa2 = $res[$i]['valor_pessoa2'];
	$numero_processo = $res[$i]['numero_processo'];
	$motivo1 = $res[$i]['motivo1'];
	$motivo2 = $res[$i]['motivo2'];
	$usuario_lanc = $res[$i]['usuario_lanc'];
	$forma_pgto = $res[$i]['forma_pgto'];
	$data = $res[$i]['data'];
	$obs = $res[$i]['obs'];
	$numeracao = $res[$i]['numeracao'];

	$dataF = implode('/', array_reverse(@explode('-', $data)));
	$valorF = @number_format($valor, 2, ',', '.');
	$valor_entradaF = @number_format($valor_entrada, 2, ',', '.');

	$query2 = $pdo->query("SELECT * FROM clientes where id = '$cliente'");
	$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
	if(@count($res2) > 0){
		$nome_cliente = $res2[0]['nome'];
	}else{
		$nome_cliente = 'Sem Registro';
	}

	$query2 = $pdo->query("SELECT * FROM tipos_servicos where id = '$tipo_servico'");
	$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
	if(@count($res2) > 0){
		$nome_servico = $res2[0]['nome'];
	}else{
		$nome_servico = '';
	}

	$query2 = $pdo->query("SELECT * FROM frequencias where dias = '$frequencia'");
	$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
	if(@count($res2) > 0){
		$nome_frequencia = $res2[0]['frequencia'];
	}else{
		$nome_frequencia = 'Nenhuma';
	}


	if($status == 'Aberto'){
		$ocultar_botoes = '';
		$classe_pago = 'text-danger';	
		$icone = 'fa-square-o';
		$titulo_link = 'Deixar Finalizado';
		$acao = 'Finalizado';
		$classe_ativo = '';
	}else{
		$ocultar_botoes = 'ocultar';
		$classe_pago = 'verde';
		$icone = 'fa-check-square';
		$titulo_link = 'Deixar Aberto';
		$acao = 'Aberto';
		$classe_ativo = '#c4c4c4';		
	}

	



echo <<<HTML
<tr >
<td align="center">
<div class="custom-checkbox custom-control">
<input type="checkbox" class="custom-control-input" id="seletor-{$id}" onchange="selecionar('{$id}')">
<label for="seletor-{$id}" class="custom-control-label mt-1 text-dark"></label>
{$numeracao}
</div> 
</td>
<td><i class="fa fa-square {$classe_pago} mr-1"></i> {$nome_cliente}</td>
<td>R$ {$valorF}</td>
<td>R$ {$valor_entradaF}</td>
<td>{$parcelas}</td>
<td>{$nome_frequencia}</td>
<td>{$nome_servico}</td>
<td>{$dataF}</td>
<td>
	<big><a class="btn btn-info btn-sm $ocultar_botoes {$editar_ab}" href="#" onclick="editar('{$id}','{$cliente}','{$tipo_servico}','{$valor}','{$valor_entrada}','{$forma_pgto}','{$frequencia}','{$parcelas}','{$data_venc}','{$numero_processo}','{$valor_escritorio}','{$obs}','{$advogado1}','{$advogado2}','{$advogado3}','{$valor_advogado1}','{$valor_advogado2}','{$valor_advogado3}','{$marketing}','{$valor_marketing}','{$indicacao}','{$valor_indicacao}','{$pessoa1}','{$pessoa2}','{$valor_pessoa1}','{$valor_pessoa2}','{$motivo1}','{$motivo2}')" title="Editar Dados"><i class="fa fa-edit "></i></a></big>

	<div class="dropdown " style="display: inline-block;">                      
                        <a class="btn btn-danger btn-sm $ocultar_botoes {$excluir_ab}" href="#" aria-expanded="false" aria-haspopup="true" data-bs-toggle="dropdown" class="dropdown"><i class="fa fa-trash "></i> </a>
                        <div  class="dropdown-menu tx-13">
                        <div class="dropdown-item-text botao_excluir">
                        <p>Confirmar Exclusão? <a href="#" onclick="excluir('{$id}')"><span class="text-danger">Sim</span></a></p>
                        </div>
                        </div>
                        </div>


<big><a class="btn btn-success btn-sm {$finalizado_ab}" href="#" onclick="ativarProcesso('{$id}', '{$acao}')" title="{$titulo_link}"><i class="fa {$icone} "></i></a></big>


	<big><a class="btn btn-primary btn-sm {$arquivos_ab}" href="#" onclick="arquivo('{$id}', '{$nome_servico}')" title="Inserir / Ver Arquivos"><i class="fa fa-file-o " ></i></a></big>

	<a class="btn btn-success btn-sm {$contas_ab}" href="#" onclick="mostrarContas('{$nome_cliente}', '{$nome_servico}','{$id}')" title="Mostrar Contas"><i class="fa fa-money"></i></a>

	<form   method="POST" action="rel/detalhamento_contrato_class.php" target="_blank" style="display:inline-block">
					<input type="hidden" name="id" value="{$id}">
					<big><button class="btn btn-danger btn-sm {$pdf_ab}" title="PDF do Detalhamento"><i class="fa fa-file-pdf-o "></i></button></big>
					</form>


	<form   method="POST" action="rel_contratos.php" style="display:inline-block">
					<input type="hidden" name="id_contrato" value="{$id}">
					<big><button class="btn btn-primary btn-sm {$contrato_ab}" title="Gerar Contrato PDF"><i class="fa fa-file-pdf-o "></i></button></big>
					</form>

</td>
</tr>
HTML;

}

}else{
	echo 'Não possui nenhum cadastro!';
}


echo <<<HTML
</tbody>
<small><div align="center" id="mensagem-excluir"></div></small>
</table>
HTML;
?>



<script type="text/javascript">
	$(document).ready( function () {	
	var ordenar = "<?=$filtrar_colunas?>";
	
	if(ordenar.trim() === 'true'){
		 $('#tabela').DataTable({
    		"language" : {
            //"url" : '//cdn.datatables.net/plug-ins/1.13.2/i18n/pt-BR.json'
	        },
	        "ordering": true,
			"stateSave": true
	    });	
	}else{
		
		$('#tabela').DataTable({
    		"language" : {
            //"url" : '//cdn.datatables.net/plug-ins/1.13.2/i18n/pt-BR.json'
	        },
	        "ordering": false,
			"stateSave": true
	    });	
	}
   


} );
</script>

<script type="text/javascript">
	function editar(id, cliente,tipo_servico,valor,valor_entrada,forma_pgto,frequencia,parcelas,data_venc,numero_processo,valor_escritorio,obs,advogado1,advogado2,advogado3,valor_advogado1,valor_advogado2,valor_advogado3,marketing,valor_marketing,indicacao,valor_indicacao,pessoa1,pessoa2,valor_pessoa1,valor_pessoa2,motivo1,motivo2){
		$('#mensagem').text('');
    	$('#titulo_inserir').text('Editar Registro (Algumas informações de contas podem ser alteradas!!');

    	$('#id').val(id);
    	$('#frequencia').val(frequencia).change();
    	$('#parcelas').val(parcelas);
    	$('#cliente').val(cliente).change();
    	$('#valor').val(valor);
    	$('#valor_entrada').val(valor_entrada);
    	$('#forma_pgto').val(forma_pgto).change();
    	$('#tipo_servico').val(tipo_servico).change();
    	
    	
    	$('#data_venc').val(data_venc);
    	$('#numero_processo').val(numero_processo);
    	$('#valor_escritorio').val(valor_escritorio);
    	$('#obs').val(obs);


    	$('#advogado1').val(advogado1).change();
    	$('#advogado2').val(advogado2).change();
    	$('#advogado3').val(advogado3).change();
    	$('#marketing').val(marketing).change();
    	$('#indicacao').val(indicacao).change();
    	$('#pessoa1').val(pessoa1).change();
    	$('#pessoa2').val(pessoa2).change();


    	$('#valor_advogado1').val(valor_advogado1);
    	$('#valor_advogado2').val(valor_advogado2);
    	$('#valor_advogado3').val(valor_advogado3);
    	$('#valor_marketing').val(valor_marketing);
    	$('#valor_indicacao').val(valor_indicacao);
    	$('#valor_pessoa1').val(valor_pessoa1);
    	$('#valor_pessoa2').val(valor_pessoa2);

    	$('#motivo1').val(motivo1);
    	$('#motivo2').val(motivo2);    	
    	
    	setTimeout(function() {
		  listarParcelas()
		}, 500)

		$('#nav-home-tab').click();
    	
    	$('#modalForm').modal('show');
	}


	
	function limparCampos(){
		$('#id').val('');
    	$('#cliente').val('').change();
    	$('#valor').val('');
    	$('#valor_entrada').val('');
    	
    	$('#data_venc').val('<?=$data_atual?>');
    	$('#parcelas').val('1');
    	$('#frequencia').val('0').change();
    	$('#numero_processo').val('');
    	$('#valor_escritorio').val('0');
    	$('#obs').val('');

    	$('#motivo1').val('');
    	$('#motivo2').val('');


    	$('#advogado1').val('0').change();
    	$('#advogado2').val('0').change();
    	$('#advogado3').val('0').change();
    	$('#pessoa1').val('0').change();
    	$('#pessoa2').val('0').change();
    	$('#marketing').val('0').change();
    	$('#indicacao').val('0').change();

    	$('#valor_advogado1').val('0');
    	$('#valor_advogado2').val('0');
    	$('#valor_advogado3').val('0');
    	$('#valor_pessoa1').val('0');
    	$('#valor_pessoa2').val('0');
    	$('#valor_indicacao').val('0');
    	$('#valor_marketing').val('0');

    	$('#nav-home-tab').click();

    	limparParcelas();

    	$('#ids').val('');
    	$('#btn-deletar').hide();	
	}

	function selecionar(id){

		var ids = $('#ids').val();

		if($('#seletor-'+id).is(":checked") == true){
			var novo_id = ids + id + '-';
			$('#ids').val(novo_id);
		}else{
			var retirar = ids.replace(id + '-', '');
			$('#ids').val(retirar);
		}

		var ids_final = $('#ids').val();
		if(ids_final == ""){
			$('#btn-deletar').hide();
		}else{
			$('#btn-deletar').show();
		}
	}

	function deletarSel(){
		var ids = $('#ids').val();
		var id = ids.split("-");
		
		for(i=0; i<id.length-1; i++){
			excluirMultiplos(id[i]);			
		}

		setTimeout(() => {
		  	listar();	
		}, 1000);

		limparCampos();
	}


	function arquivo(id, nome){
    $('#id-arquivo').val(id);    
    $('#nome-arquivo').text(nome);
    $('#modalArquivos').modal('show');
    $('#mensagem-arquivo').text(''); 
    $('#arquivo_conta').val('');
    listarArquivos();   
}


function mostrarContas(nome, servico, id){
		    	
    	$('#titulo_contas').text(nome+' / '+servico); 
    	$('#id_contas').val(id); 	
    	    	
    	$('#modalContas').modal('show');
    	listarDebitos(id);
    	
	}



	function listarDebitos(id){

		 $.ajax({
        url: 'paginas/' + pag + "/listar_contas.php",
        method: 'POST',
        data: {id},
        dataType: "html",

        success:function(result){
            $("#listar_debitos").html(result);           
        }
    });
	}





</script>