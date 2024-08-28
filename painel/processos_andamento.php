<?php 

require_once("verificar.php");
$pag = 'processos_andamento';

//verificar se ele tem a permissão de estar nessa página
if(@$processos_andamento == 'ocultar'){
	echo "<script>window.location='index'</script>";
	exit();
}
?>


	
<div class="row row-sm">
	<div class="col-lg-12">
		<div class="card custom-card">
			<div class="card-body" id="listar">

			</div>
		</div>
	</div>
</div>


		<!-- Modal Arquivos -->
		<div class="modal fade" id="modalArquivos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header bg-primary text-white">
						<h4 class="modal-title" id="tituloModal">Gestão de Arquivos - <span id="nome-arquivo"> </span></h4>
						<button id="btn-fechar-arquivos" aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span class="text-white" aria-hidden="true">&times;</span></button>
					</div>
					<form id="form-arquivos" method="post">
						<div class="modal-body">

							<div class="row">
								<div class="col-md-8">						
									<div class="form-group"> 
										<label>Arquivo</label> 
										<input class="form-control" type="file" name="arquivo_conta" onChange="carregarImgArquivos();" id="arquivo_conta">
									</div>	
								</div>
								<div class="col-md-4">	
									<div id="divImgArquivos">
										<img src="images/arquivos/sem-foto.png"  width="60px" id="target-arquivos">									
									</div>					
								</div>




							</div>

							<div class="row" >
								<div class="col-md-8">
									<input type="text" class="form-control" name="nome-arq"  id="nome-arq" placeholder="Nome do Arquivo * " required>
								</div>

								<div class="col-md-4">										 
									<button type="submit" class="btn btn-primary">Inserir</button>
								</div>
							</div>

							<hr>

							<small><div id="listar-arquivos"></div></small>

							<br>
							<small><div align="center" id="mensagem-arquivo"></div></small>

							<input type="hidden" class="form-control" name="id-arquivo"  id="id-arquivo">


						</div>
					</form>
				</div>
			</div>
		</div>







		<!-- Modal Movimentacoes -->
		<div class="modal fade" id="modalMovimentacoes" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header bg-primary text-white">
						<h4 class="modal-title" id="tituloModal">Histórico do Processo - <span id="nome-movimentacoes"> </span></h4>
						<button id="btn-fechar-arquivos" aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span class="text-white" aria-hidden="true">&times;</span></button>
					</div>
					<form id="form-movimentacoes" method="post">
						<div class="modal-body">

							<div class="row">
								<div class="col-md-8">						
									<div class="form-group"> 
										<label>Título</label> 
										<input maxlength="100" class="form-control" type="text" name="titulo"  id="titulo">
									</div>	
								</div>

								<div class="col-md-4">						
									<div class="form-group"> 
										<label>Notificar Cliente</label> 
										<select class="form-select" id="notificar" name="notificar">
										<option value="Sim">Sim</option>
										<option value="Não">Não</option>										
										</select>		
									</div>	
								</div>


							</div>

							<div class="row" style="margin-top:-15px">
								<div class="col-md-10">						
									<div class="form-group"> 
										<label>Descrição</label> 
										<input maxlength="1000" class="form-control" type="text" name="descricao"  id="descricao">
									</div>	
								</div>

								<div class="col-md-2" style="margin-top: 26px;">										 
									<button id="btn_mov" type="submit" class="btn btn-primary">Salvar</button>
								</div>
								
								
							</div>

						

							<hr>

							<small><div id="listar-movimentacoes" style="overflow: scroll; max-height:380px; scrollbar-width: thin;">
								
							</div></small>

							<br>
							<small><div align="center" id="mensagem-movimentacoes"></div></small>

							<input type="hidden" class="form-control" name="id-movimentacoes"  id="id-movimentacoes">


						</div>
					</form>
				</div>
			</div>
		</div>







		<!-- Modal Movimentacoes Api -->
		<div class="modal fade" id="modalMovimentacoesApi" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header bg-primary text-white">
						<h4 class="modal-title" id="tituloModal">Movimentações do Processo - <span id="nome-movimentacoes-api"> </span></h4>
						<button id="btn-fechar-movimentacoes-api" aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span class="text-white" aria-hidden="true">&times;</span></button>
					</div>
					
					<div id="listar_mov_api" style="padding:10px"></div>

					<div align="center" id="campo_erro" style="margin-top: 10px; padding:5px"></div>

						<input type="hidden" class="form-control" id="id-movimentacoes-api">
						<input type="hidden" class="form-control" id="numero-api">

				</div>
			</div>
		</div>





		<!-- Modal Valor -->
		<div class="modal fade" id="modalValor" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header bg-primary text-white">
						<h4 class="modal-title" id="tituloModal">Lançar Valor</span></h4>
						<button id="btn-fechar-arquivos" aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span class="text-white" aria-hidden="true">&times;</span></button>
					</div>
					<form id="form-valor" method="post">
						<div class="modal-body">

							<div class="row">
								<div class="col-md-4">						
									<div class="form-group"> 
										<label>Valor</label> 
										<input class="form-control" type="text" name="valor" id="valor_lanc">
									</div>	
								</div>

								<div class="col-md-4">						
									<div class="form-group"> 
										<label>Data Recebimento</label> 
										<input class="form-control" type="date" name="data" id="data_lanc" value="<?php echo $data_atual ?>">
									</div>	
								</div>

								<div class="col-md-4">							
							<label>Forma Pgto</label>
							<select name="forma_pgto" id="forma_pgto_lanc" class="form-select">
								<?php 
								$query = $pdo->query("SELECT * from formas_pgto order by id asc");
								$res = $query->fetchAll(PDO::FETCH_ASSOC);
								$linhas = @count($res);
								if($linhas > 0){
									for($i=0; $i<$linhas; $i++){
										echo '<option value="'.$res[$i]['id'].'">'.$res[$i]['nome'].'</option>';
									}
								}else{
									echo '<option value="0">Cadastre uma Forma de Pagamento</option>';
								}
								?>	
							</select>								
						</div>


							</div>

												

							<hr>

							<small><div id="listar-valores" style="overflow: scroll; max-height:380px; scrollbar-width: thin;">
								
							</div></small>

							<br>
							<small><div align="center" id="mensagem-valor"></div></small>

							<input type="hidden" class="form-control" name="id-valor"  id="id-valor">


						</div>
						<div class="modal-footer">       
							<button type="submit" id="btn_salvar_valor" class="btn btn-primary">Salvar</button>
						</div>
					</form>
				</div>
			</div>
		</div>



		<script type="text/javascript">var pag = "<?=$pag?>"</script>
		<script src="js/ajax.js"></script>

		<script type="text/javascript">
			$(document).ready(function() {
				listarClientes();
				$('.sel2').select2({
					dropdownParent: $('#modalForm')
				});

			});


		
		</script>


		<script type="text/javascript">
			$("#form-arquivos").submit(function () {
				event.preventDefault();
				var formData = new FormData(this);

				$.ajax({
					url: 'paginas/processos/arquivos.php',
					type: 'POST',
					data: formData,

					success: function (mensagem) {
						$('#mensagem-arquivo').text('');
						$('#mensagem-arquivo').removeClass()
						if (mensagem.trim() == "Inserido com Sucesso") {                    
						//$('#btn-fechar-arquivos').click();
						$('#nome-arq').val('');
						$('#arquivo_conta').val('');
						$('#target-arquivos').attr('src','images/arquivos/sem-foto.png');
						listarArquivos();
					} else {
						$('#mensagem-arquivo').addClass('text-danger')
						$('#mensagem-arquivo').text(mensagem)
					}

				},

				cache: false,
				contentType: false,
				processData: false,

			});

			});
		</script>

		<script type="text/javascript">
			function listarArquivos(){
				var pag = 'processos';
				var id = $('#id-arquivo').val();	
				$.ajax({
					url: 'paginas/processos/listar-arquivos.php',
					method: 'POST',
					data: {id},
					dataType: "text",

					success:function(result){
						$("#listar-arquivos").html(result);
					}
				});
			}

		</script>




		<script type="text/javascript">
			function carregarImgArquivos() {
				var target = document.getElementById('target-arquivos');
				var file = document.querySelector("#arquivo_conta").files[0];

				var arquivo = file['name'];
				resultado = arquivo.split(".", 2);

				if(resultado[1] === 'pdf'){
					$('#target-arquivos').attr('src', "images/pdf.png");
					return;
				}

				if(resultado[1] === 'rar' || resultado[1] === 'zip'){
					$('#target-arquivos').attr('src', "images/rar.png");
					return;
				}

				if(resultado[1] === 'doc' || resultado[1] === 'docx' || resultado[1] === 'txt'){
					$('#target-arquivos').attr('src', "images/word.png");
					return;
				}


				if(resultado[1] === 'xlsx' || resultado[1] === 'xlsm' || resultado[1] === 'xls'){
					$('#target-arquivos').attr('src', "images/excel.png");
					return;
				}


				if(resultado[1] === 'xml'){
					$('#target-arquivos').attr('src', "images/xml.png");
					return;
				}



				var reader = new FileReader();

				reader.onloadend = function () {
					target.src = reader.result;
				};

				if (file) {
					reader.readAsDataURL(file);

				} else {
					target.src = "";
				}
			}
		</script>


	



<script type="text/javascript">
			$("#form-movimentacoes").submit(function () {
				event.preventDefault();
				var formData = new FormData(this);

				 $('#mensagem-movimentacoes').text('Salvando...')
    			 $('#btn_mov').hide();

				$.ajax({
					url: 'paginas/processos/movimentacoes.php',
					type: 'POST',
					data: formData,

					success: function (mensagem) {
						$('#mensagem-movimentacoes').text('');
						$('#mensagem-movimentacoes').removeClass()
						if (mensagem.trim() == "Inserido com Sucesso") {                    
						//$('#btn-fechar-arquivos').click();
						$('#titulo').val('');
						$('#descricao').val('');
						listarMovimentacoes();
					} else {
						$('#mensagem-movimentacoes').addClass('text-danger')
						$('#mensagem-movimentacoes').text(mensagem)
					}

					 $('#btn_mov').show();

				},

				cache: false,
				contentType: false,
				processData: false,

			});

			});
		</script>

		<script type="text/javascript">
			function listarMovimentacoes(){
				var id = $('#id-movimentacoes').val();	
				$.ajax({
					url: 'paginas/processos/listar-movimentacoes.php',
					method: 'POST',
					data: {id},
					dataType: "text",

					success:function(result){
						$("#listar-movimentacoes").html(result);
					}
				});
			}

		</script>



<script type="text/javascript">

	$(document).ready( function () {
		verMasc();
	});

	function verMasc(){
		var cpf = $('#cpf_contraria').val();
		
		if(cpf.length >= 15){
			$('#cpf_contraria').mask('00.000.000/0000-00');
		}else{
			$('#cpf_contraria').mask('000.000.000-000');
		}
	}
	
</script>



<script type="text/javascript">
	function processoApi(){
		$("#campo_erro").html('');
		$("#listar_mov_api").html('');
		var numero = $('#numero-api').val();
		var acao = 'consulta';	
				$.ajax({
					url: 'paginas/processos/api/exec_api.php',
					method: 'POST',
					data: {numero, acao},
					dataType: "text",

					success:function(result){
						var split = result.split('!');
						if(split[0].trim() == 'Erro'){							
							$("#campo_erro").addClass('bg-warning');
							$("#campo_erro").html(result);
							$("#listar_mov_api").html('');
						}else{
							$("#listar_mov_api").html(result);
							$("#campo_erro").removeClass('bg-warning');
							$("#campo_erro").html('');
						}
						
					}
				});
	}
</script>




<script type="text/javascript">
			$("#form-valor").submit(function () {
				event.preventDefault();
				var formData = new FormData(this);

				var data_atual = "<?=$data_atual?>";

				$.ajax({
					url: 'paginas/processos/valor.php',
					type: 'POST',
					data: formData,

					success: function (mensagem) {
						$('#mensagem-valor').text('');
						$('#mensagem-valor').removeClass()
						if (mensagem.trim() == "Inserido com Sucesso") {                    
						//$('#btn-fechar-arquivos').click();
						$('#valor_lanc').val('');
										
						listarValores();
					} else {
						$('#mensagem-valor').addClass('text-danger')
						$('#mensagem-valor').text(mensagem)
					}

				},

				cache: false,
				contentType: false,
				processData: false,

			});

			});


			function listarValores(){
				var id = $('#id-valor').val();	
				$.ajax({
					url: 'paginas/processos/listar-valores.php',
					method: 'POST',
					data: {id},
					dataType: "text",

					success:function(result){
						$("#listar-valores").html(result);
					}
				});
			}
		</script>