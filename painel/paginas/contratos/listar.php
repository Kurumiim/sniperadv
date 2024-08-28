<?php 
$tabela = 'contratos';
require_once("../../verificar.php");
require_once("../../../conexao.php");

$query = $pdo->query("SELECT * from $tabela order by id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
echo <<<HTML

	<table class="table text-nowrap border-bottom dt-responsive" id="tabela">
	<thead> 
	<tr class="bg-primary"> 
	<th align="center" width="5%" class="text-center">Selecionar</th>
	<th>Modelo</th>			
	<th>Ações</th>
	</tr> 
	</thead> 
	<tbody>	
HTML;
}else{
	echo 'Não possui nenhum cadastro!';
}

for($i=0; $i<$linhas; $i++){
	$id = $res[$i]['id'];
	$modelo = $res[$i]['modelo'];
	$texto = $res[$i]['texto'];

	$texto = str_replace('"', "**", $texto);
	
echo <<<HTML
<input type="text" id="texto_contrato_{$id}" value="{$texto}" style="display:none">

<tr >
<td align="center">
<div class="custom-checkbox custom-control">
<input type="checkbox" class="custom-control-input" id="seletor-{$id}" onchange="selecionar('{$id}')">
<label for="seletor-{$id}" class="custom-control-label mt-1 text-dark"></label>
</div>
</td>
<td>{$modelo}</td>
<td>
	<big><a class="btn btn-info btn-sm" href="#" onclick="editar('{$id}','{$modelo}')" title="Editar Dados"><i class="fa fa-edit "></i></a></big>

	<div class="dropdown" style="display: inline-block;">                      
                        <a class="btn btn-danger btn-sm" href="#" aria-expanded="false" aria-haspopup="true" data-bs-toggle="dropdown" class="dropdown"><i class="fa fa-trash"></i> </a>
                        <div  class="dropdown-menu tx-13">
                        <div class="dropdown-item-text botao_excluir">
                        <p>Confirmar Exclusão? <a href="#" onclick="excluir('{$id}')"><span class="text-danger">Sim</span></a></p>
                        </div>
                        </div>
                        </div>


</td>
</tr>
HTML;

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
	function editar(id, modelo){



		var texto = $('#texto_contrato_'+id).val();	

		for (let letra of texto){  				
			if (letra === '*'){
				texto = texto.replace('**', '"');
			}			
		}	

		$('#mensagem').text('');
    	$('#titulo_inserir').text('Editar Registro');

    	$('#id').val(id);
    	nicEditors.findEditor("area").setContent(texto);
    	$('#modelo').val(modelo);

    	$('#nav-tab button[data-bs-target="#nav-profile"]').tab('show');

    	//$('#nav-profile-tab').click();
	}


	

	function limparCampos(){
		$('#id').val('');
    	$('#modelo').val('');
    	nicEditors.findEditor("area").setContent('');
    	
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
			excluir(id[i]);			
		}

		limparCampos();
	}
</script>