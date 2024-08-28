<?php 
@session_start();
$id_usuario = @$_SESSION['id'];
$nivel_usuario = @$_SESSION['nivel'];
$tabela = 'usuarios';
require_once("../../../conexao.php");
require_once("../../verificar.php");

$query = $pdo->query("SELECT * from $tabela where nivel != 'Cliente' and nivel != 'Administrador' order by id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
echo <<<HTML

	<table class="table text-nowrap border-bottom dt-responsive" id="tabela">
	<thead> 
	<tr class="bg-primary"> 
	<th align="center" width="5%" class="text-center">Selecionar</th>
	<th>Nome</th>	
	<th class="esc">Telefone</th>
	<th class="esc">Cargo / Especialidade</th>	
	
	<th class="esc">Foto</th>	
	<th>Ações</th>
	</tr> 
	</thead> 
	<tbody>	
HTML;

for($i=0; $i<$linhas; $i++){
	$id = $res[$i]['id'];
	$nome = $res[$i]['nome'];
	$telefone = $res[$i]['telefone'];
	$email = $res[$i]['email'];
	
	$foto = $res[$i]['foto'];
	$nivel = $res[$i]['nivel'];
	$endereco = $res[$i]['endereco'];
	$ativo = $res[$i]['ativo'];
	$data = $res[$i]['data'];	
	$chave_pix = $res[$i]['pix'];
	$especialidade = $res[$i]['especialidade'];

	$nacionalidade = $res[$i]['nacionalidade'];
	$estado_civil = $res[$i]['estado_civil'];
	$endereco_profissional = $res[$i]['endereco_profissional'];
	$seccional_oab = $res[$i]['seccional_oab'];
	$numero_oab = $res[$i]['numero_oab'];
	$visto_por = $res[$i]['visto_por'];
	$usuario_lanc = $res[$i]['usuario_lanc'];



	$dataF = implode('/', array_reverse(@explode('-', $data)));

	if($ativo == 'Sim'){
	$icone = 'fa-check-square';
	$titulo_link = 'Desativar Usuário';
	$acao = 'Não';
	$classe_ativo = '';
	}else{
		$icone = 'fa-square-o';
		$titulo_link = 'Ativar Usuário';
		$acao = 'Sim';
		$classe_ativo = '#c4c4c4';
	}

	if($nivel == 'Administrador'){
		
	}

	$ultimos_email = substr($email, -13);
	$emailF = str_replace($ultimos_email, '*************', $email);

	$ultimos_tel = substr($telefone, -5);
	$telefoneF = str_replace($ultimos_tel, '*****', $telefone);


	if(($visto_por == 'Não' and $usuario_lanc == $id_usuario) or $nivel_usuario == 'Administrador' or $nivel_usuario == 'Escritório' or $id_usuario == $id){
		
	}else{
		continue;
	}



echo <<<HTML
<tr >
<td align="center">
<div class="custom-checkbox custom-control">
<input type="checkbox" class="custom-control-input" id="seletor-{$id}" onchange="selecionar('{$id}')">
<label for="seletor-{$id}" class="custom-control-label mt-1 text-dark"></label>
</div>
</td>
<td style="color:{$classe_ativo}">{$nome}</td>
<td style="color:{$classe_ativo}" class="esc">{$telefoneF}</td>
<td style="color:{$classe_ativo}" class="esc">{$nivel} {$especialidade}</td>

<td style="color:{$classe_ativo}" class="esc"><img src="images/perfil/{$foto}" width="25px"></td>
<td>
	<big><a class="btn btn-info btn-sm" href="#" onclick="editar('{$id}','{$nome}','{$email}','{$telefone}','{$endereco}','{$nivel}','{$chave_pix}','{$especialidade}', '{$nacionalidade}', '{$estado_civil}', '{$endereco_profissional}', '{$seccional_oab}', '{$numero_oab}', '{$visto_por}')" title="Editar Dados"><i class="fa fa-edit "></i></a></big>

	<div class="dropdown" style="display: inline-block;">                      
                        <a class="btn btn-danger btn-sm" href="#" aria-expanded="false" aria-haspopup="true" data-bs-toggle="dropdown" class="dropdown"><i class="fa fa-trash "></i> </a>
                        <div  class="dropdown-menu tx-13">
                        <div class="dropdown-item-text botao_excluir">
                        <p>Confirmar Exclusão? <a href="#" onclick="excluir('{$id}')"><span class="text-danger">Sim</span></a></p>
                        </div>
                        </div>
                        </div>

<big><a class="btn btn-primary btn-sm" href="#" onclick="mostrar('{$nome}','{$email}','{$telefone}','{$endereco}','{$ativo}','{$dataF}',  '{$nivel}', '{$foto}','{$chave_pix}','{$especialidade}', '{$nacionalidade}', '{$estado_civil}', '{$endereco_profissional}', '{$seccional_oab}', '{$numero_oab}')" title="Mostrar Dados"><i class="fa fa-info-circle "></i></a></big>


<big><a class="btn btn-success btn-sm" href="#" onclick="ativar('{$id}', '{$acao}')" title="{$titulo_link}"><i class="fa {$icone} "></i></a></big>


	<big><a class="btn btn-primary btn-sm" href="#" onclick="arquivo('{$id}', '{$nome}')" title="Inserir / Ver Arquivos"><i class="fa fa-file-o " ></i></a></big>

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
	function editar(id, nome, email, telefone, endereco, nivel, chave_pix, especialidade, nacionalidade, estado_civil, endereco_profissional, seccional_oab, numero_oab, visto_por){
		$('#mensagem').text('');
    	$('#titulo_inserir').text('Editar Registro');

    	$('#id').val(id);
    	$('#nome').val(nome);
    	$('#email').val(email);
    	$('#telefone').val(telefone);
    	$('#endereco').val(endereco);
    	$('#nivel').val(nivel).change();
    	$('#especialidade').val(especialidade);

    	$('#nacionalidade').val(nacionalidade);
    	$('#estado_civil').val(estado_civil).change();
    	$('#endereco_profissional').val(endereco_profissional);
    	$('#seccional_oab').val(seccional_oab).change();
    	$('#numero_oab').val(numero_oab);

    	$('#visto_por').val(visto_por).change();
    	
    	$('#chave_pix').val(chave_pix);

    	$('#modalForm').modal('show');
	}


	function mostrar(nome, email, telefone, endereco, ativo, data,  nivel, foto, chave_pix, especialidade, nacionalidade, estado_civil, endereco_profissional, seccional_oab, numero_oab){
		    	
    	$('#titulo_dados').text(nome);
    	$('#email_dados').text(email);
    	$('#telefone_dados').text(telefone);
    	$('#endereco_dados').text(endereco);
    	$('#ativo_dados').text(ativo);
    	$('#data_dados').text(data);
    	$('#especialidade_dados').text(especialidade);

    	$('#nacionalidade_dados').text(nacionalidade);
    	$('#estado_civil_dados').text(estado_civil);
    	$('#endereco_profissional_dados').text(endereco_profissional);
    	$('#seccional_oab_dados').text(seccional_oab);
    	$('#numero_oab_dados').text(numero_oab);
    	
    	$('#nivel_dados').text(nivel);
    	$('#foto_dados').attr("src", "images/perfil/" + foto);
    	
    	$('#pix_dados').text(chave_pix);

    	$('#modalDados').modal('show');
	}

	function limparCampos(){
		$('#id').val('');
    	$('#nome').val('');
    	$('#email').val('');
    	$('#telefone').val('');
    	$('#endereco').val('');
    	$('#especialidade').val('');
    	
    	$('#chave_pix').val('');

    	$('#visto_por').val('Sim').change();

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
</script>