<?php 
require_once("verificar.php");
$pag = 'receber';

if(@$receber == 'ocultar'){
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
											<td class="bg-warning alert-warning">Cliente</td>
											<td><span id="cliente_dados"></span></td>
										</tr>

										<tr>
											<td class="bg-warning alert-warning">Vencimento</td>
											<td><span id="vencimento_dados"></span></td>
										</tr>

										<tr>
											<td class="bg-warning alert-warning w_150">Pagamento</td>
											<td><span id="data_pgto_dados"></span></td>
										</tr>

									
										<tr>
											<td class="bg-warning alert-warning w_150">Frequência</td>
											<td><span id="frequencia_dados"></span></td>
										</tr>
										<tr>
											<td class="bg-warning alert-warning w_150">Multa</td>
											<td><span id="multa_dados"></span></td>
										</tr>

											<tr>
											<td class="bg-warning alert-warning w_150">Júros</td>
											<td><span id="juros_dados"></span></td>
										</tr>

											<tr>
											<td class="bg-warning alert-warning w_150">Desconto</td>
											<td><span id="desconto_dados"></span></td>
										</tr>

											<tr>
											<td class="bg-warning alert-warning w_150">Taxa</td>
											<td><span id="taxa_dados"></span></td>
										</tr>


										<tr>
											<td class="bg-warning alert-warning w_150">Subtotal</td>
											<td><span id="total_dados"></span></td>
										</tr>

										<tr>
											<td class="bg-warning alert-warning w_150">Pagador</td>
											<td><span id="usuario_receb_dados"></span></td>
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
											<td class="bg-warning alert-warning w_150">Pago</td>
											<td><span id="pago_dados"></span></td>
										</tr>

										<tr>
											<td class="bg-warning alert-warning w_150">Lançado Por</td>
											<td><span id="usu_lanc_dados"></span></td>
										</tr>


										<tr>
											<td class="bg-warning alert-warning w_150">Baixa Usuário</td>
											<td><span id="usu_pgto_dados"></span></td>
										</tr>


										<tr>
											<td class="bg-warning alert-warning w_150">OBS</td>
											<td><span id="obs_dados"></span></td>
										</tr>

									
										<tr>
											<td align="center"><img src="" id="target_dados" width="200px"></td>
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




	<!-- Modal -->
	<div class="modal fade" id="modalResiduos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-primary text-white">
					<h4 class="modal-title" id="tituloModal">Residuos da Conta</h4>
					 <button id="btn-fechar-residuos" aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span class="text-white" aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">

					<small><div id="listar-residuos"></div></small>

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
										<img src="../painel/images/arquivos/sem-foto.png"  width="60px" id="target-arquivos">									
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






	<script type="text/javascript">var pag = "<?=$pag?>"</script>
	<script src="js/ajax.js"></script>



<script type="text/javascript">
			$("#form-arquivos").submit(function () {
				event.preventDefault();
				var formData = new FormData(this);

				$.ajax({
					url: 'paginas/' + pag + "/arquivos.php",
					type: 'POST',
					data: formData,

					success: function (mensagem) {
						$('#mensagem-arquivo').text('');
						$('#mensagem-arquivo').removeClass()
						if (mensagem.trim() == "Inserido com Sucesso") {                    
						//$('#btn-fechar-arquivos').click();
						$('#nome-arq').val('');
						$('#arquivo_conta').val('');
						$('#target-arquivos').attr('src','../painel/images/arquivos/sem-foto.png');
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
				var id = $('#id-arquivo').val();	
				$.ajax({
					url: 'paginas/' + pag + "/listar-arquivos.php",
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
					$('#target-arquivos').attr('src', "../painel/images/pdf.png");
					return;
				}

				if(resultado[1] === 'rar' || resultado[1] === 'zip'){
					$('#target-arquivos').attr('src', "../painel/images/rar.png");
					return;
				}

				if(resultado[1] === 'doc' || resultado[1] === 'docx' || resultado[1] === 'txt'){
					$('#target-arquivos').attr('src', "../painel/images/word.png");
					return;
				}


				if(resultado[1] === 'xlsx' || resultado[1] === 'xlsm' || resultado[1] === 'xls'){
					$('#target-arquivos').attr('src', "../painel/images/excel.png");
					return;
				}


				if(resultado[1] === 'xml'){
					$('#target-arquivos').attr('src', "../painel/images/xml.png");
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

