<?php 
@session_start();
$mostrar_registros = @$_SESSION['registros'];
$id_usuario = @$_SESSION['id'];
$tabela = 'processos';
require_once("../../../conexao.php");
require_once("../../verificar.php");

$inserir_processos = '';
$editar_processos = '';
$excluir_processos = '';
$arquivos_processos = '';
$historico_processos = '';
$mov_processos = '';
$detalhamento_processos = '';
$valores_processos = '';
if(@$_SESSION['nivel'] != 'Administrador' and @$_SESSION['nivel'] != 'Escritório'){
	require_once("../../verificar_permissoes.php");
}

$dataInicial = @$_POST['p2'];
$dataFinal = @$_POST['p3'];
$status = '%'.@$_POST['p1'].'%';
$status_filtro = @$_POST['p4'];

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
	$sql_usuario_lanc = " and (usuario_lanc = '$id_usuario' or  advogado1 = '$id_usuario' or advogado2 = '$id_usuario' or advogado3 = '$id_usuario' or advogado4 = '$id_usuario')";
}else{	
	$sql_usuario_lanc = " ";
}

$query = $pdo->query("SELECT * from $tabela where status = 'Cancelado' $sql_usuario_lanc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_cancelado = @count($res);

$query = $pdo->query("SELECT * from $tabela where status = 'Arquivado' $sql_usuario_lanc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_arquivado = @count($res);

$query = $pdo->query("SELECT * from $tabela where status = 'Preparação' $sql_usuario_lanc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_preparacao = @count($res);

$query = $pdo->query("SELECT * from $tabela where status = 'Finalizado' $sql_usuario_lanc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_finalizado = @count($res);

$query = $pdo->query("SELECT * from $tabela where status = 'Andamento' $sql_usuario_lanc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_andamento = @count($res);


if($mostrar_registros == 'Não'){
	if($status_filtro != ""){
		$query = $pdo->query("SELECT * from $tabela where status like '$status_filtro' and (usuario_lanc = '$id_usuario' or  advogado1 = '$id_usuario' or advogado2 = '$id_usuario' or advogado3 = '$id_usuario' or advogado4 = '$id_usuario') order by id desc");
	}else{
		$query = $pdo->query("SELECT * from $tabela where status like '$status' and data_abertura >= '$dataInicial' and data_abertura <= '$dataFinal' and (usuario_lanc = '$id_usuario' or  advogado1 = '$id_usuario' or advogado2 = '$id_usuario' or advogado3 = '$id_usuario' or advogado4 = '$id_usuario' ) order by id desc");
	}
	
}else{
	if($status_filtro != ""){
		$query = $pdo->query("SELECT * from $tabela where status like '$status_filtro' order by id desc");
	}else{
		$query = $pdo->query("SELECT * from $tabela where status like '$status' and data_abertura >= '$dataInicial' and data_abertura <= '$dataFinal' order by id desc");
	}
	
}
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
echo <<<HTML

	<table class="table text-nowrap border-bottom dt-responsive" id="tabela">
	<thead> 
	<tr class="bg-primary"> 
	
	<th>Cliente</th>	
	<th class="esc">Número</th>	
	<th class="esc">Tipo Ação</th>	
	<th class="esc">Valor</th>
	<th class="esc">Status</th>	
	<th class="esc">Abertura</th>	
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

<td>{$nome_cliente}</td>
<td>{$num_processoF} <span style="display:none">{$num_processo}</span></td>
<td>{$nome_servico}</td>
<td>R$ {$valorF}</td>
<td><i class="fa fa-square  mr-1" style="color:{$classe_status}"></i> {$status}</td>
<td>{$data_aberturaF}</td>

<td>
	<big><a class="btn btn-info btn-sm {$editar_processos}" href="#" onclick="editar('{$id}','{$cliente}','{$tipo_acao}','{$valor}','{$num_processo}','{$status}','{$segredo}','{$justica_gratuita}','{$orgao_julgador}','{$data_abertura}','{$advogado1}','{$advogado2}','{$advogado3}','{$advogado4}','{$jurisdicao}','{$vara}','{$comarca}','{$nome_contraria}','{$cpf_contraria}','{$rg_contraria}','{$telefone_contraria}','{$estado_civil_contraria}','{$advogado_contraria}','{$endereco_contraria}')" title="Editar Dados"><i class="fa fa-edit "></i></a></big>

	<div class="dropdown " style="display: inline-block;">                      
                        <a class="btn btn-danger btn-sm $ocultar_botoes {$excluir_processos}" href="#" aria-expanded="false" aria-haspopup="true" data-bs-toggle="dropdown" class="dropdown"><i class="fa fa-trash "></i> </a>
                        <div  class="dropdown-menu tx-13">
                        <div class="dropdown-item-text botao_excluir">
                        <p>Confirmar Exclusão? <a href="#" onclick="excluir('{$id}')"><span class="text-danger">Sim</span></a></p>
                        </div>
                        </div>
                        </div>


	<big><a class="btn btn-primary btn-sm {$arquivos_processos}" href="#" onclick="arquivo('{$id}', '{$nome_servico}')" title="Inserir / Ver Arquivos"><i class="fa fa-file-o " ></i></a></big>


	<big><a class="btn btn-success btn-sm {$historico_processos}" href="#" onclick="movimentacoes('{$id}', '{$nome_servico}')" title="Histórico do Processo"><i class="fa fa-server " ></i></a></big>

	
	<form   method="POST" action="rel/detalhamento_processo_class.php" target="_blank" style="display:inline-block">
					<input type="hidden" name="id" value="{$id}">
					<big><button class="btn btn-danger btn-sm {$detalhamento_processos}" title="PDF do Detalhamento"><i class="fa fa-file-pdf-o "></i></button></big>
					</form>


	<big><a class="btn btn-primary btn-sm {$mov_processos}" href="#" onclick="movimentacoesApi('{$id}', '{$nome_servico}', '{$num_processo}')" title="Movimentações do Processo na API"><i class="fa fa-server " ></i></a></big>

	<big><a class="btn btn-success btn-sm {$valores_processos}" href="#" onclick="valor('{$id}')" title="Lançar valor"><i class="fa fa-money " ></i></a></big>

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
	$(document).ready( function () {

		$('#total_cancelado').text('<?=$total_cancelado?>');
	    $('#total_arquivado').text('<?=$total_arquivado?>');
	    $('#total_preparacao').text('<?=$total_preparacao?>');
	    $('#total_finalizado').text('<?=$total_finalizado?>');
	    $('#total_andamento').text('<?=$total_andamento?>');
	  

  
} );
</script>

<script type="text/javascript">
	function editar(id, cliente,tipo_servico,valor,num_processo,status,segredo,justica_gratuita,orgao_julgador,data_abertura,advogado1,advogado2,advogado3,advogado4,jurisdicao,vara,comarca,nome_contraria,cpf_contraria,rg_contraria,telefone_contraria,estado_civil_contraria,advogado_contraria,endereco_contraria){

		var texto = $('#obs_'+id).val();	

		for (let letra of texto){  				
			if (letra === '*'){
				texto = texto.replace('**', '"');
			}			
		}	


		$('#mensagem').text('');
    	$('#titulo_inserir').text('Editar Registro');

    	$('#id').val(id);
    	$('#status').val(status).change();
    	$('#numero_processo').val(num_processo);
    	$('#cliente').val(cliente).change();
    	$('#valor').val(valor);
    	$('#segredo').val(segredo);
    	$('#justica_gratuita').val(justica_gratuita);
    	$('#tipo_acao').val(tipo_servico).change();
    	
    	
    	$('#orgao_julgador').val(orgao_julgador);
    	$('#data_abertura').val(data_abertura);
    	$('#jurisdicao').val(jurisdicao);
    	nicEditors.findEditor("area").setContent(texto);


    	$('#advogado1').val(advogado1).change();
    	$('#advogado2').val(advogado2).change();
    	$('#advogado3').val(advogado3).change();
    	$('#advogado4').val(advogado4).change();
    	


    	$('#vara').val(vara);
    	$('#comarca').val(comarca);
    	$('#nome_contraria').val(nome_contraria);
    	$('#cpf_contraria').val(cpf_contraria);
    	$('#rg_contraria').val(rg_contraria);
    	$('#telefone_contraria').val(telefone_contraria);
    	$('#estado_civil_contraria').val(estado_civil_contraria);
    	$('#advogado_contraria').val(advogado_contraria);
    	$('#endereco_contraria').val(endereco_contraria);
    	
    	
		$('#nav-home-tab').click();
    	
    	$('#modalForm').modal('show');
	}


	
	function limparCampos(){
		$('#id').val('');
    	$('#cliente').val('').change();
    	$('#valor').val('');
    	$('#status').val('Preparação').change();
    	
    	$('#data_abertura').val('<?=$data_atual?>');    	
    	$('#numero_processo').val('');
    	$('#segredo').val('Não').change();
    	$('#justica_gratuita').val('Sim').change();
    	$('#orgao_julgador').val('');   	


    	$('#advogado1').val('0').change();
    	$('#advogado2').val('0').change();
    	$('#advogado3').val('0').change();
    	$('#advogado4').val('0').change();
    	

    	$('#jurisdicao').val('');
    	$('#vara').val('');
    	$('#comarca').val('');

    	$('#nome_contraria').val('');
    	$('#cpf_contraria').val('');
    	$('#rg_contraria').val('');
    	$('#telefone_contraria').val('');
    	$('#estado_civil_contraria').val('Solteiro(a)');
    	$('#advogado_contraria').val('');
    	$('#endereco_contraria').val('');

    	nicEditors.findEditor("area").setContent('');

    	$('#nav-home-tab').click();    	

    	
    	$('#btn-deletar').hide();	
	}

	

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