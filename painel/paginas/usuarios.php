<?php 
require_once("verificar.php");
$pag = 'usuarios';

if(@$usuarios == 'ocultar'){
	echo "<script>window.location='index'</script>";
	exit();
}

?>

<div class="justify-content-between">
	<div class="left-content mt-2 mb-3">
		<a class="btn ripple btn-primary text-white" onclick="inserir()" type="button"><i class="fe fe-plus me-2"></i> Adicionar <?php echo ucfirst($pag); ?></a>



		<div class="dropdown" style="display: inline-block;">                      
			<a href="#" aria-expanded="false" aria-haspopup="true" data-bs-toggle="dropdown" class="btn btn-danger dropdown" id="btn-deletar" style="display:none"><i class="fe fe-trash-2"></i> Deletar</a>
			<div  class="dropdown-menu tx-13">
				<div style="width: 240px; padding:15px 5px 0 10px;" class="dropdown-item-text">
					<p>Excluir Selecionados? <a href="#" onclick="deletarSel()"><span class="text-danger">Sim</span></a></p>
				</div>
			</div>
		</div>

	</div>

</div>


<div class="row row-sm">
	<div class="col-lg-12">
		<div class="card custom-card">
			<div class="card-body" id="listar">

			</div>
		</div>
	</div>
</div>

<input type="hidden" id="ids">

<!-- Modal  -->
<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header bg-primary text-white">
				<h4 class="modal-title" id="exampleModalLabel"><span id="titulo_inserir"></span></h4>
				<button id="btn-fechar" aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span class="text-white" aria-hidden="true">&times;</span></button>
			</div>
			<form id="form">
				<div class="modal-body">


					<div class="row">
						<div class="col-md-6 mb-2">							
							<label>Nome</label>
							<input type="text" class="form-control" id="nome" name="nome" placeholder="Seu Nome" required>							
						</div>

						<div class="col-md-6 mb-2">							
							<label>Email</label>
							<input type="email" class="form-control" id="email" name="email" placeholder="Seu Email"  required>							
						</div>

						
					</div>


					<div class="row">

						<div class="col-md-4 mb-2 col-6">							
							<label>Telefone</label>
							<input type="text" class="form-control" id="telefone" name="telefone" placeholder="Seu Telefone" required>							
						</div>
						

						<div class="col-md-4 mb-2 col-6">							
							<label>Nível</label>
							<select class="form-select" name="nivel" id="nivel">
								<?php 
								$query = $pdo->query("SELECT * from cargos order by id asc");
								$res = $query->fetchAll(PDO::FETCH_ASSOC);
								$linhas = @count($res);
								if($linhas > 0){
									for($i=0; $i<$linhas; $i++){ ?>
										<option value="<?php echo $res[$i]['nome'] ?>"><?php echo $res[$i]['nome'] ?></option>
									<?php } } ?>
								</select>								
							</div>


							<div class="col-md-4 mb-2 col-6">							
							<label>Mostrar todos os Registros</label>
							<select class="form-select" name="mostrar_registros" id="mostrar_registros">
								<option value="Não">Não</option>
								<option value="Sim">Sim</option>
								
								</select>								
							</div>




						</div>

						<div class="row">

							<div class="col-md-12">							
								<label>Endereço</label>
								<input type="text" class="form-control" id="endereco" name="endereco" placeholder="Seu Endereço" >							
							</div>
						</div>







						<input type="hidden" class="form-control" id="id" name="id">					

						<br>
						<small><div id="mensagem" align="center"></div></small>
					</div>
					<div class="modal-footer">       
						<button id="btn_salvar" type="submit" class="btn btn-primary">Salvar</button>
					</div>
				</form>
			</div>
		</div>
	</div>






	<!-- Modal Dados -->
	<div class="modal fade" id="modalDados" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header bg-primary text-white">
					<h4 class="modal-title" id="exampleModalLabel"><span id="titulo_dados"></span></h4>
					<button id="btn-fechar-dados" aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span class="text-white" aria-hidden="true">&times;</span></button>
				</div>

				<div class="modal-body">


					<div class="row">


						<div class="col-md-6">
							<div class="tile">
								<div class="table-responsive">
									<table id="" class="text-left table table-bordered">
										<tr>
											<td class="bg-warning alert-warning">Telefone</td>
											<td><span id="telefone_dados"></span></td>
										</tr>

										<tr>
											<td class="bg-warning alert-warning">Email</td>
											<td><span id="email_dados"></span></td>
										</tr>

										<tr>
											<td class="bg-warning alert-warning w_150">Nível</td>
											<td><span id="nivel_dados"></span></td>
										</tr>

										<tr>
											<td class="bg-warning alert-warning w_150">Ativo</td>
											<td><span id="ativo_dados"></span></td>
										</tr>

										<tr>
											<td class="bg-warning alert-warning w_150">Data Cadastro</td>
											<td><span id="data_dados"></span></td>
										</tr>
										<tr>
											<td class="bg-warning alert-warning w_150">Endereço</td>
											<td><span id="endereco_dados"></span></td>
										</tr>


										 

									</table>
								</div>
							</div>
						</div>



						<div class="col-md-6">
							<div class="tile">
								<div class="table-responsive">
									<table id="" class="text-left table table-bordered">
									
									<tr>
											<td align="center"><img src="" id="foto_dados" width="200px"></td>
										</tr>      
										
									</table>
								</div>
							</div>
						</div>

					</div>





				</div>

			</div>
		</div>
	</div>




	<!-- Modal Permissoes -->
	<div class="modal fade" id="modalPermissoes" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" >
			<div class="modal-content">
				<div class="modal-header bg-primary text-white">
					<h4 class="modal-title" id="exampleModalLabel"><span id="nome_permissoes"></span>

						<span style="position:absolute; right:45px">
							<input class="form-check-input" type="checkbox" id="input-todos" onchange="marcarTodos()">
							<label class="" >Marcar Todos</label>
						</span>

					</h4>
					<button style="" id="btn-fechar-arquivos" aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span class="text-white" aria-hidden="true">&times;</span></button>
				</div>

				<div class="modal-body">
					<div id="listar_permissoes">

					</div>

					<br>
					<input type="hidden" name="id" id="id_permissoes">
					<small><div id="mensagem_permissao" align="center" class="mt-3"></div></small>		
				</div>

			</div>
		</div>
	</div>




	<script type="text/javascript">var pag = "<?=$pag?>"</script>
	<script src="js/ajax.js"></script>



	<script type="text/javascript">

		function listarPermissoes(id){
			$.ajax({
				url: 'paginas/' + pag + "/listar_permissoes.php",
				method: 'POST',
				data: {id},
				dataType: "html",

				success:function(result){        	
					$("#listar_permissoes").html(result);
					$('#mensagem_permissao').text('');
				}
			});
		}

		function adicionarPermissao(id, usuario){
			$.ajax({
				url: 'paginas/' + pag + "/add_permissao.php",
				method: 'POST',
				data: {id, usuario},
				dataType: "html",

				success:function(result){        	
					listarPermissoes(usuario);
				}
			});
		}


		function marcarTodos(){
			let checkbox = document.getElementById('input-todos');
			var usuario = $('#id_permissoes').val();

			if(checkbox.checked) {
				adicionarPermissoes(usuario);		    
			} else {
				limparPermissoes(usuario);
			}
		}


		function adicionarPermissoes(id_usuario){

			$.ajax({
				url: 'paginas/' + pag + "/add_permissoes.php",
				method: 'POST',
				data: {id_usuario},
				dataType: "html",

				success:function(result){        	
					listarPermissoes(id_usuario);
				}
			});
		}


		function limparPermissoes(id_usuario){

			$.ajax({
				url: 'paginas/' + pag + "/limpar_permissoes.php",
				method: 'POST',
				data: {id_usuario},
				dataType: "html",

				success:function(result){        	
					listarPermissoes(id_usuario);
				}
			});
		}
	</script>