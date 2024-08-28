<?php 
@session_start();
$id_usuario = @$_SESSION['id']; 
$data_atual = date('Y-m-d');

$tabela = 'audiencias';
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

$query = $pdo->query("SELECT * from $tabela where advogado = '$usuario' and data = curDate() order by id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$audiencias_hoje = @count($res);

$query = $pdo->query("SELECT * from $tabela where advogado = '$usuario' and data = '$data_amanha' order by id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$audiencias_amanha = @count($res);


$query = $pdo->query("SELECT * from $tabela where advogado = '$usuario' and data >= '$data_inicio_mes' and data <= '$data_final_mes' order by id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$audiencias_mes = @count($res);

$query = $pdo->query("SELECT * from $tabela where advogado = '$usuario' and data = '$data' order by hora asc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
echo <<<HTML
	<div class="row">
HTML;
for($i=0; $i<$linhas; $i++){
	$id = $res[$i]['id'];
	$usuario = $res[$i]['advogado'];
	$usuario_lanc = $res[$i]['usuario_lanc'];
	$data = $res[$i]['data'];
	$hora = $res[$i]['hora'];
	$descricao = $res[$i]['forum'];
	$online = $res[$i]['online'];
	$hora_mensagem = $res[$i]['hora_mensagem'];
	$obs = $res[$i]['obs'];

	
	$bg_card = 'bg-primary';
	$ocultar_itens = '';
	

	

	$dataF = implode('/', array_reverse(@explode('-', $data)));
	$horaF = date("H:i", @strtotime($hora));

	if($descricao == "" and $online == 'Sim'){
		$descricao = 'Audiência Online';
	}

	$descricaoF = mb_strimwidth($descricao, 0, 50, "...");

	$mostrar_obs = 'ocultar';
	if($obs != ""){
		$mostrar_obs = '';
	}


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
                        <a class="" href="#" aria-expanded="false" aria-haspopup="true" data-bs-toggle="dropdown" class="dropdown"><span style=" color:#4f4f4f; font-size: 12px; padding:3px" id=""><i class="fa fa-check-square " ></i> {$descricaoF}</span> </a>
                        <div  class="dropdown-menu tx-13">
                       <div class="dropdown-item-text" style="background: #f5f4eb">
                        <p><i class="fa fa-check-square " ></i> {$descricao}</p>
                        </div>
                        </div>
                        </div>
	        		
	        	</p>

	        	<div style="margin-top: -10px" class="{$ocultar_itens}">

	        		<big><a class="icones_mobile" href="#" onclick="editar('{$id}','{$usuario}','{$data}','{$hora}','{$hora_mensagem}','{$descricao}','{$online}','{$obs}')" title="Editar Dados"><i class="fa fa-edit " style="color:blue"></i></a></big>

	        		<div class="icones_mobile" class="dropdown" style="display: inline-block;">                      
                        <a class="{$mostrar_obs}" title="Mostrar Observações" href="#" aria-expanded="false" aria-haspopup="true" data-bs-toggle="dropdown" class="dropdown"><i class="fa fa-comment-o " style="color:#9c6806"></i> </a>
                        <div  class="dropdown-menu tx-13">
                        <div class="dropdown-item-text ">
                        <p>{$obs}</p>
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

	$('#audiencias_mes').text("<?=$audiencias_mes?>");
	$('#audiencias_hoje').text("<?=$audiencias_hoje?>");
	$('#audiencias_amanha').text("<?=$audiencias_amanha?>");

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
	function editar(id, usuario, data, hora, hora_mensagem, descricao, online, obs){
		$('#mensagem').text('');
    	$('#titulo_inserir').text('Editar Registro');

    	if(hora_mensagem == '00:00:00'){
    		hora_mensagem = '';
    	}

    	$('#id').val(id);
    	$('#data').val(data);
    	$('#hora').val(hora);
    	$('#hora_alerta').val(hora_mensagem);
    	$('#forum').val(descricao);
    	$('#online').val(online).change();
    	$('#obs').val(obs);

    
    	$('#modalForm').modal('show');
	}



	function limparCampos(){
		$('#id').val('');
    	$('#hora_alerta').val('');
    	$('#hora').val('');
    	$('#forum').val('');
    	$('#obs').val('');
    

    	$('#ids').val('');
    	$('#btn-deletar').hide();	
	}





	
</script>