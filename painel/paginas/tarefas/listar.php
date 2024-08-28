<?php 
@session_start();
$id_usuario = @$_SESSION['id']; 
$data_atual = date('Y-m-d');

$tabela = 'tarefas';
require_once("../../../conexao.php");
require_once("../../verificar.php");

$data = @$_POST['p1'];
$usuario = @$_POST['p2'];

if($data == ""){
	$data = $data_atual;
}

if($usuario == ""){
	$usuario = $id_usuario;
}


$query = $pdo->query("SELECT * from $tabela where usuario = '$usuario' and status = 'Agendada' and data <= curDate() and hora < curTime() order by id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$tarefas_atrasadas = @count($res);

$query = $pdo->query("SELECT * from $tabela where usuario = '$usuario' and status = 'Agendada' order by id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_tarefas = @count($res);


$query = $pdo->query("SELECT * from $tabela where usuario = '$usuario' and status = 'Agendada' and data = '$data' order by id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$agendadas_hoje = @count($res);

$query = $pdo->query("SELECT * from $tabela where usuario = '$usuario' and data = '$data' order by hora asc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
echo <<<HTML
	<div class="row">
HTML;
for($i=0; $i<$linhas; $i++){
	$id = $res[$i]['id'];
	$usuario = $res[$i]['usuario'];
	$usuario_lanc = $res[$i]['usuario_lanc'];
	$data = $res[$i]['data'];
	$hora = $res[$i]['hora'];
	$descricao = $res[$i]['descricao'];
	$status = $res[$i]['status'];
	$hora_mensagem = $res[$i]['hora_mensagem'];
	$prioridade = $res[$i]['prioridade'];

	if($status == 'Agendada'){
		$bg_card = 'bg-red';
		$ocultar_itens = '';
	}else{
		$bg_card = 'bg-success';
		$ocultar_itens = 'ocultar';
	}

	if($prioridade == 'Baixa'){
		$classe_pri = 'green';
	}else if($prioridade == 'Média'){
		$classe_pri = 'blue';
	}else{
		$classe_pri = 'red';
	}
	

	$dataF = implode('/', array_reverse(@explode('-', $data)));
	$horaF = date("H:i", @strtotime($hora));

	$descricaoF = mb_strimwidth($descricao, 0, 50, "...");

echo <<<HTML
		<div class="card text-center col-md-3" style="box-shadow: 2px 2px 2px 1px rgba(0, 0, 0, 0.1);">		
			<div class="card-header {$bg_card} border-light" style="font-size: 17px; padding:2px">
	             {$horaF}
	            

	            <div class="dropdown pull-right" style="display: inline-block;">                      
                        <a class="" href="#" aria-expanded="false" aria-haspopup="true" data-bs-toggle="dropdown" class="dropdown"><i class="fa fa-close " style="color:#FFF"></i> </a>
                        <div  class="dropdown-menu tx-13" style="background: transparent; border:none">
                       <div class="dropdown-item-text botao_excluir" style="margin-left: -250px">
                        <p>Confirmar Exclusão? <a href="#" onclick="excluirTarefa('{$id}')"><span class="text-danger">Sim</span></a></p>
                        </div>
                        </div>
                        </div>
	        </div>

	        <div class="card-body" style="background: #f2f2f2; padding:2px">
	        	<p class="card-text" style="margin-top:-15px; padding:2px; ">
	        	<div class="dropdown" style="display: inline-block;">                      
                        <a class="" href="#" aria-expanded="false" aria-haspopup="true" data-bs-toggle="dropdown" class="dropdown"><span style=" color:#4f4f4f; font-size: 12px; padding:3px" id=""><i class="fa fa-check-square " style="color:{$classe_pri}"></i> {$descricaoF}</span> </a>
                        <div  class="dropdown-menu tx-13">
                       <div class="dropdown-item-text" style="background: #f5f4eb">
                        <p><i class="fa fa-check-square " style="color:{$classe_pri}"></i> {$descricao}</p>
                        </div>
                        </div>
                        </div>
	        		
	        	</p>

	        	<div style="margin-top: -10px" class="{$ocultar_itens}">

	        		<big><a class="icones_mobile" href="#" onclick="editar('{$id}','{$usuario}','{$data}','{$hora}','{$hora_mensagem}','{$descricao}','{$prioridade}')" title="Editar Dados"><i class="fa fa-edit " style="color:blue"></i></a></big>

	        		<div class="icones_mobile" class="dropdown" style="display: inline-block;">                      
                        <a title="Concluir Tarefa" href="#" aria-expanded="false" aria-haspopup="true" data-bs-toggle="dropdown" class="dropdown"><i class="fa fa-check-square " style="color:green"></i> </a>
                        <div  class="dropdown-menu tx-13">
                        <div class="dropdown-item-text ">
                        <p>Concluir Tarefa? <a href="#" onclick="concluir('{$id}')"><span class="text-success">Sim</span></a></p>
                        </div>
                        </div>
                        </div>

	        	</div>
	        </div>  



    	</div>
HTML;
}
echo <<<HTML
	</div>
HTML;

}else{
	echo '<small>Nenhum Registro Encontrado!</small>';
}

?>



<script type="text/javascript">
	$(document).ready( function () {	

	$('#tarefas_pendentes').text("<?=$total_tarefas?>");
	$('#tarefas_dia').text("<?=$agendadas_hoje?>");
	$('#tarefas_atrasadas').text("<?=$tarefas_atrasadas?>");

    $('#tabela').DataTable({
    	"language" : {
            //"url" : '//cdn.datatables.net/plug-ins/1.13.2/i18n/pt-BR.json'
        },
        "ordering": false,
		"stateSave": true
    });
} );
</script>

<script type="text/javascript">
	function editar(id, usuario, data, hora, hora_mensagem, descricao, prioridade){
		$('#mensagem').text('');
    	$('#titulo_inserir').text('Editar Registro');

    	if(hora_mensagem == '00:00:00'){
    		hora_mensagem = '';
    	}

    	$('#id').val(id);
    	$('#data').val(data);
    	$('#hora').val(hora);
    	$('#hora_alerta').val(hora_mensagem);
    	$('#descricao').val(descricao);
    	$('#usuario_tarefa').val(usuario);
    	$('#prioridade').val(prioridade).change();

    
    	$('#modalForm').modal('show');
	}



	function limparCampos(){
		$('#id').val('');
    	$('#hora_alerta').val('');
    	$('#hora').val('');
    	$('#descricao').val('');
    	
    

    	$('#ids').val('');
    	$('#btn-deletar').hide();	
	}





	
</script>