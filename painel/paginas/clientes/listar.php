<?php 
@session_start();
require_once("../../verificar.php");
$mostrar_registros = @$_SESSION['registros'];
$id_usuario = @$_SESSION['id'];
$nivel_usuario = @$_SESSION['nivel'];



$inad = @$_POST['p1'];

$tabela = 'clientes';
require_once("../../../conexao.php");

$inserir_clientes = '';
$editar_clientes = '';
$excluir_clientes = '';
$arquivos_clientes = '';
$contas_clientes = '';
$whatsapp_clientes = '';
$detalhes_clientes = '';
$copiar_clientes = '';
$senha_clientes = '';
$exportar_clientes = '';
if(@$_SESSION['nivel'] != 'Administrador' and @$_SESSION['nivel'] != 'Escritório'){
	require_once("../../verificar_permissoes.php");
}



if($mostrar_registros == 'Não'){
	$query = $pdo->query("SELECT * from clientes where usuario = '$id_usuario' or visto_por = 'Todos' order by id desc");
}else{
	$query = $pdo->query("SELECT * from clientes order by id desc");
}

$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
echo <<<HTML

	<table class="table text-nowrap border-bottom dt-responsive" id="tabela">
	<thead> 
	<tr class="bg-primary"> 
	<th align="center" width="5%" class="text-center">Selecionar</th>
	<th>Nome</th>	
	<th>Indicado Por</th>	
	<th >Telefone</th>	
	
	<th >Tipo Pessoa</th>
	<th >Data Cadastro</th>	
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
	$endereco = $res[$i]['endereco'];
	$tipo_pessoa = $res[$i]['tipo_pessoa'];
	$cpf = $res[$i]['cpf'];

	$numero = $res[$i]['numero'];
	$bairro = $res[$i]['bairro'];
	$cidade = $res[$i]['cidade'];
	$estado = $res[$i]['estado'];
	$cep = $res[$i]['cep'];
	$profissao = $res[$i]['profissao'];
	$nacionalidade = $res[$i]['nacionalidade'];
	$estado_civil = $res[$i]['estado_civil'];
	$indicacao = $res[$i]['indicacao'];
	$usuario = $res[$i]['usuario'];


	$rg = $res[$i]['rg'];
	$complemento = $res[$i]['complemento'];
	$genitor = $res[$i]['genitor'];
	$genitora = $res[$i]['genitora'];
	
	$data_cad = $res[$i]['data_cad'];
	$data_nasc = $res[$i]['data_nasc'];
	$visto_por = $res[$i]['visto_por'];
	$resumo_fatos = $res[$i]['resumo_fatos'];

	if($visto_por == 'Somente Eu' and $usuario != $id_usuario and $nivel_usuario != 'Administrador'){
		continue;
	}


	$data_cadF = implode('/', array_reverse(@explode('-', $data_cad)));
	$data_nascF = implode('/', array_reverse(@explode('-', $data_nasc)));

	$tel_whatsF = '55'.preg_replace('/[ ()-]+/' , '' , $telefone);

	$ultimos_cpf = substr($cpf, -10);
	$cpfF = str_replace($ultimos_cpf, '**********', $cpf);

	$ultimos_email = substr($email, -13);
	$emailF = str_replace($ultimos_email, '*************', $email);

	$ultimos_tel = substr($telefone, -5);
	$telefoneF = str_replace($ultimos_tel, '*****', $telefone);


	$ultimos_nome = substr($nome, -13);
	$nomeF = str_replace($ultimos_nome, '*****', $nome);


	//verificar inadimplemencia
	$query2 = $pdo->query("SELECT * from receber where vencimento < curDate() and pago != 'Sim' and cliente = '$id'");
	$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
	$linhas2 = @count($res2);
	if($linhas2 > 0){
		$classe_inad = 'text-danger';
	}else{
		$classe_inad = '';
		if($inad == 'ina'){
			continue;
		}
	}

	$texto = $nome.', '.$nacionalidade.', '.$estado_civil.', '.$profissao.', nascido(a) em '.$data_nascF.', inscrito(a) no CPF sob o nº '.$cpf.', sob identidade nº '.$rg.', filho de '.$genitor.' e '.$genitora.', residente e domiciliado(a) a '.$endereco.', '.$numero.', bairro '.$bairro.', município '.$cidade.' - '.$estado.' - CEP: '.$cep.' - email: '.$email.' - telefone: '.$telefone;

echo <<<HTML
<input type="text" id="resumo_fatos_{$id}" value="{$resumo_fatos}" style="display:none">

<tr>
<td align="center">
<div class="custom-checkbox custom-control">
<input type="checkbox" class="custom-control-input" id="seletor-{$id}" onchange="selecionar('{$id}')">
<label for="seletor-{$id}" class="custom-control-label mt-1 text-dark"></label>
</div>
</td>
<td class="{$classe_inad}">{$nomeF}</td>
<td>{$indicacao}</td>
<td>{$telefoneF}</td>


<td><span class="badge bg-primary me-1 my-2 p-1"><big>{$tipo_pessoa}</big></span></td>
<td>{$data_cadF}</td>
<td>
	<a class="btn btn-primary btn-sm {$editar_clientes}" href="#" onclick="editar('{$id}','{$nome}','{$email}','{$telefone}','{$endereco}','{$cpf}','{$tipo_pessoa}','{$data_nasc}','{$numero}','{$bairro}','{$cidade}','{$estado}','{$cep}','{$rg}','{$complemento}','{$genitor}','{$genitora}','{$profissao}','{$estado_civil}','{$nacionalidade}','{$indicacao}','{$visto_por}')" title="Editar Dados"><i class="fa fa-edit"></i></a>

	<div class="dropdown" style="display: inline-block;">                      
                        <a class="btn btn-danger btn-sm {$excluir_clientes}" href="#" aria-expanded="false" aria-haspopup="true" data-bs-toggle="dropdown" class="dropdown"><i class="fa fa-trash"></i> </a>
                        <div  class="dropdown-menu tx-13">
                        <div class="dropdown-item-text botao_excluir">
                        <p>Confirmar Exclusão? <a href="#" onclick="excluir('{$id}')"><span class="text-danger">Sim</span></a></p>
                        </div>
                        </div>
                        </div>

<a class="btn btn-primary btn-sm {$detalhes_clientes}" href="#" onclick="mostrar('{$id}','{$nome}','{$email}','{$telefone}','{$endereco}', '{$data_cadF}','{$cpf}','{$tipo_pessoa}','{$data_nascF}','{$numero}','{$bairro}','{$cidade}','{$estado}','{$cep}','{$rg}','{$complemento}','{$genitor}','{$genitora}','{$profissao}','{$estado_civil}','{$nacionalidade}','{$indicacao}','{$visto_por}')" title="Mostrar Dados"><i class="fa fa-info-circle"></i></a>


<a class="btn btn-info btn-sm {$arquivos_clientes}" href="#" onclick="arquivo('{$id}', '{$nome}')" title="Inserir / Ver Arquivos"><i class="fa fa-file-o "></i></a>

<a class="btn btn-success btn-sm {$contas_clientes}" href="#" onclick="mostrarContas('{$nome}','{$id}')" title="Mostrar Contas"><i class="fa fa-money "></i></a>

<a class="btn btn-success btn-sm {$whatsapp_clientes}" class="" href="http://api.whatsapp.com/send?1=pt_BR&phone={$tel_whatsF}" title="Whatsapp" target="_blank"><i class="fa fa-whatsapp " ></i></a>


<a class="btn btn-primary btn-sm {$copiar_clientes}" class=""  href="#" onclick="copiar('{$texto}')" title="Copiar Dados Cliente Contrato" ><i class="fa fa-clone " ></i></a>

<div class="dropdown" style="display: inline-block;">                      
                        <a title="Redefinir Senha para 123" class="btn btn-danger btn-sm {$senha_clientes}" href="#" aria-expanded="false" aria-haspopup="true" data-bs-toggle="dropdown" class="dropdown"><i class="fa fa-lock"></i> </a>
                        <div  class="dropdown-menu tx-13">
                        <div class="dropdown-item-text botao_excluir">
                        <p>Redefinir a Senha para 123? <a href="#" onclick="redefinir('{$id}')"><span class="text-danger">Sim</span></a></p>
                        </div>
                        </div>
                        </div>



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
	function editar(id, nome, email, telefone, endereco, cpf, tipo_pessoa, data_nasc, numero, bairro, cidade, estado, cep, rg, complemento, genitor, genitora, profissao, estado_civil, nacionalidade, indicacao, visto_por){
		$('#mensagem').text('');
    	$('#titulo_inserir').text('Editar Registro');

    	$('#id').val(id);
    	$('#nome').val(nome);
    	$('#email').val(email);
    	$('#telefone').val(telefone);
    	$('#endereco').val(endereco);    	
    	$('#cpf').val(cpf);
    	$('#tipo_pessoa').val(tipo_pessoa).change();
    	$('#data_nasc').val(data_nasc);

    	$('#numero').val(numero);
    	$('#bairro').val(bairro);
    	$('#cidade').val(cidade);
    	$('#estado').val(estado).change();
    	$('#cep').val(cep);

    	$('#rg').val(rg);
    	$('#complemento').val(complemento);
    	$('#genitor').val(genitor);
    	$('#genitora').val(genitora);

    	$('#profissao').val(profissao);
    	$('#nacionalidade').val(nacionalidade);
    	$('#estado_civil').val(estado_civil).change();
    	$('#visto_por').val(visto_por).change();

    	$('#indicacao').val(indicacao);

    	$('#modalForm').modal('show');
	}


	function mostrar(id, nome, email, telefone, endereco, data, cpf, tipo_pessoa, data_nasc, numero, bairro, cidade, estado, cep, rg, complemento, genitor, genitora, profissao, estado_civil, nacionalidade, indicacao, visto_por){

		var resumo_fatos = $('#resumo_fatos_'+id).val();
		
		    	
    	$('#titulo_dados').text(nome);
    	$('#email_dados').text(email);
    	$('#telefone_dados').text(telefone);
    	$('#endereco_dados').text(endereco);
    	$('#cpf_dados').text(cpf);
    	$('#data_dados').text(data);
    	$('#pessoa_dados').text(tipo_pessoa);
    	$('#data_nasc_dados').text(data_nasc);

    	$('#numero_dados').text(numero);
    	$('#bairro_dados').text(bairro);
    	$('#cidade_dados').text(cidade);
    	$('#estado_dados').text(estado);
    	$('#cep_dados').text(cep);

    	$('#indicacao_dados').text(indicacao);

    	$('#profissao_dados').text(profissao);
    	$('#nacionalidade_dados').text(nacionalidade);
    	$('#estado_civil_dados').text(estado_civil);
    	$('#visto_por_dados').text(visto_por);

    	$('#rg_dados').text(rg);
    	$('#complemento_dados').text(complemento);
    	$('#genitor_dados').text(genitor);
    	$('#genitora_dados').text(genitora);
    	$('#resumo_fatos_dados').text(resumo_fatos);
    	
    	$('#modalDados').modal('show');
	}

	function limparCampos(){
		$('#id').val('');
    	$('#nome').val('');
    	$('#email').val('');
    	$('#telefone').val('');
    	$('#endereco').val('');
    	$('#cpf').val('');
    	$('#tipo_pessoa').val('Física').change();
    	$('#data_nasc').val('');
    	$('#visto_por').val('Todos').change();


    	$('#rg').val('');
    	$('#complemento').val('');
    	$('#genitor').val('');
    	$('#genitora').val('');

    	$('#numero').val('');
    	$('#bairro').val('');
    	$('#cidade').val('');
    	$('#estado').val('').change();
    	$('#cep').val('');

    	$('#indicacao').val('');

    	$('#profissao').val('');
    	$('#nacionalidade').val('');
    	$('#estado_civil').val('Solteiro(a)');

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



	function mostrarContas(nome, id){
		    	
    	$('#titulo_contas').text(nome); 
    	$('#id_contas').val(id); 	
    	    	
    	$('#modalContas').modal('show');
    	listarDebitos(id);
    	
	}


	function listarDebitos(id){

		 $.ajax({
        url: 'paginas/' + pag + "/listar_debitos.php",
        method: 'POST',
        data: {id},
        dataType: "html",

        success:function(result){
            $("#listar_debitos").html(result);           
        }
    });
	}


	async function copiar(texto){
		await navigator.clipboard.writeText(texto);
	    alert('Texto copiado : '+texto);
	}


		function redefinir(id){

		 $.ajax({
        url: 'paginas/' + pag + "/redefinir_senha.php",
        method: 'POST',
        data: {id},
        dataType: "html",

        success:function(result){
        	alert('Senha redefinida para 123');
            listar();         
        }
    });
	}
</script>