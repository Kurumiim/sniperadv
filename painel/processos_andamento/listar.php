<?php 
@session_start();
$mostrar_registros = @$_SESSION['registros'];
$id_usuario = @$_SESSION['id'];
$tabela = 'processos';
require_once("../../../conexao.php");
require_once("../../verificar.php");


if($mostrar_registros == 'Não'){	
	$sql_usuario_lanc = " and (usuario_lanc = '$id_usuario' or  advogado1 = '$id_usuario' or advogado2 = '$id_usuario' or advogado3 = '$id_usuario' or advogado4 = '$id_usuario')";
}else{	
	$sql_usuario_lanc = " ";
}


if($mostrar_registros == 'Não'){
	
		$query = $pdo->query("SELECT * from $tabela where status = 'Andamento' and (usuario_lanc = '$id_usuario' or  advogado1 = '$id_usuario' or advogado2 = '$id_usuario' or advogado3 = '$id_usuario' or advogado4 = '$id_usuario' ) order by id desc");
	
	
}else{	
		$query = $pdo->query("SELECT * from $tabela where status = 'Andamento'  order by id desc");
		
}
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
echo <<<HTML

	<table class="table text-nowrap border-bottom dt-responsive" id="tabela" >
	<thead> 
	<tr class="bg-primary"> 
	
	<th>Cliente</th>	
	<th class="esc">Número</th>	
	<th class="esc">Tipo Ação</th>	
	<th class="esc">Data</th>	
	<th class="esc">Último Andamento</th>	
	<th>Ações</th>
	
		
	</tr> 
	</thead> 
	<tbody>	
HTML;

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

	$texto_completo_processo = 'Número do Processo Inválido ou Tribunal não encontrado!';
	
	$dataMovimentacao = '';
	//buscar na api a ultima movimentacao do processo
	require("api/exec_api.php");
	

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

	$ultimos_pro = substr($num_processo, -5);
	$num_processoF = str_replace($ultimos_pro, '******', $num_processo);
	
	
$obs = str_replace('"', "**", $obs);


echo <<<HTML
<input type="text" id="obs_{$id}" value="{$obs}" style="display:none">

<tr >

<td style="font-size: 12px !important">{$nome_cliente}</td>
<td style="font-size: 12px !important">{$num_processoF} <span style="display:none">{$num_processo}</span></td>
<td style="font-size: 12px !important">{$nome_servico}</td>
<td style="font-size: 12px !important">{$dataMovimentacao}</td>
<td style="font-size: 12px !important">{$texto_completo_processo}</td>

<td>
	
	<big><a class="btn btn-primary btn-sm" href="#" onclick="arquivo('{$id}', '{$nome_servico}')" title="Inserir / Ver Arquivos"><i class="fa fa-file-o " ></i></a></big>


	<big><a class="btn btn-success btn-sm" href="#" onclick="movimentacoes('{$id}', '{$nome_servico}')" title="Histórico do Processo"><i class="fa fa-server " ></i></a></big>

	
	<form   method="POST" action="rel/detalhamento_processo_class.php" target="_blank" style="display:inline-block">
					<input type="hidden" name="id" value="{$id}">
					<big><button class="btn btn-danger btn-sm" title="PDF do Detalhamento"><i class="fa fa-file-pdf-o "></i></button></big>
					</form>


	<big><a class="btn btn-primary btn-sm" href="#" onclick="movimentacoesApi('{$id}', '{$nome_servico}', '{$num_processo}')" title="Movimentações do Processo na API"><i class="fa fa-server " ></i></a></big>

	<big><a class="btn btn-success btn-sm" href="#" onclick="valor('{$id}')" title="Lançar valor"><i class="fa fa-money " ></i></a></big>

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
	

	function arquivo(id, nome){
    $('#id-arquivo').val(id);    
    $('#nome-arquivo').text(nome);
    $('#modalArquivos').modal('show');
    $('#mensagem-arquivo').text(''); 
    $('#arquivo_conta').val('');
    listarArquivos();   
}



function movimentacoes(id, nome){
    $('#id-movimentacoes').val(id);    
    $('#nome-movimentacoes').text(nome);
    $('#modalMovimentacoes').modal('show');
    $('#mensagem-movimentacoes').text('');
    
    listarMovimentacoes();   
}




function movimentacoesApi(id, nome, numero){
    $('#id-movimentacoes-api').val(id);    
    $('#nome-movimentacoes-api').text(nome);
    $('#modalMovimentacoesApi').modal('show');
    $('#mensagem-movimentacoes-api').text('');
    $('#numero-api').val(numero);
    
    processoApi();   
}


	function valor(id){
    $('#id-valor').val(id);     
    $('#modalValor').modal('show');
    $('#mensagem-valor').text('');    
    listarValores();   
}



</script>