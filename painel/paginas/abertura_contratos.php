<?php 

require_once("verificar.php");
$pag = 'abertura_contratos';

//verificar se ele tem a permissão de estar nessa página
if(@$abertura_contratos == 'ocultar'){
	echo "<script>window.location='index'</script>";
	exit();
}
?>

<div class="justify-content-between">
	<form action="rel/abertura_contrato_class.php" target="_blank" method="POST">
 	<div class="left-content mt-2 mb-3">
 <a style="margin-bottom: 10px; margin-top: 5px" class="btn ripple btn-primary text-white <?php echo $inserir_ab ?>" onclick="inserir()" type="button"><i class="fe fe-plus me-2"></i>Abertura de Contrato</a>


 <div style="display: inline-block; position:absolute; right:10px; margin-bottom: 10px">
			<button style="width:40px" type="submit" class="btn btn-danger ocultar_mobile_app" title="Gerar Relatório"><i class="fa fa-file-pdf-o"></i></button>
		</div>

		<div class="dropdown" style="display: inline-block;">                      
                        <a href="#" aria-expanded="false" aria-haspopup="true" data-bs-toggle="dropdown" class="btn btn-danger dropdown" id="btn-deletar" style="display:none"><i class="fe fe-trash-2"></i> Deletar</a>
                        <div  class="dropdown-menu tx-13">
                        <div style="width: 240px; padding:15px 5px 0 10px;" class="dropdown-item-text">
                        <p>Excluir Selecionados? <a href="#" onclick="deletarSel()"><span class="text-danger">Sim</span></a></p>
                        </div>
                        </div>
                        </div>




         <div class="cab_mobile"></div>               

         <div style="display: inline-block; margin-bottom: 10px">
			<input type="date" name="dataInicial" id="dataInicial" style="height:35px; width:49%; font-size: 13px;" value="<?php echo $data_inicio_mes ?>" onchange="buscar()">

			<input type="date" name="dataFinal" id="dataFinal" style="height:35px; width:49%; font-size: 13px" value="<?php echo $data_final_mes ?>" onchange="buscar()">	
		</div>	


		<select class="form-select" name="status" id="status" style="display:inline-block; width:200px" onchange="buscar()">
			<option value="">Selecine um Status</option>
			<option value="Aberto">Aberto</option>
			<option value="Finalizado">Finalizado</option>
		</select>
		


		</div>			
		
		</form>
		
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

<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content" >
			<div class="modal-header bg-primary text-white">
				<h4 class="modal-title" id="exampleModalLabel"><span id="titulo_inserir"></span></h4>
				<button id="btn-fechar" aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span class="text-white" aria-hidden="true">&times;</span></button>
			</div>
			<form id="form">
				<div class="modal-body">
					
					<nav style="margin-bottom: 20px">
						<div class="nav nav-tabs" id="nav-tab" role="tablist">
							<button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Dados Contrato</button>
							<button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Divisão Valores</button>

						</div>
					</nav>

					<div class="tab-content" id="nav-tabContent">

						<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

							<div class="row">
								<div class="col-md-4 mb-2">							
									<label>Cliente</label>
									<div id="listar_clientes">
										
									</div>

								</div>

								<div class="col-md-1 mb-2" style="margin-top: 26px; padding: 0px;">							
									<button type="button" class="btn btn-primary" href="" data-bs-toggle="modal" data-bs-target="#modalCliente"><i class="fa fa-plus "></i></button>				
								</div>

								<div class="col-md-4 mb-2" >							
									<label>Tipo Serviço</label>
									<select class="sel2" name="tipo_servico" id="tipo_servico" style="width:100%">
										<?php 
										$query = $pdo->query("SELECT * from tipos_servicos order by nome asc");
										$res = $query->fetchAll(PDO::FETCH_ASSOC);
										$linhas = @count($res);
										if($linhas > 0){
											for($i=0; $i<$linhas; $i++){ ?>
												<option value="<?php echo $res[$i]['id'] ?>"><?php echo $res[$i]['nome'] ?></option>
											<?php } } ?>
										</select>							
									</div>

									<div class="col-md-3 mb-2" >							
										<label>Valor</label>
										<input type="text" class="form-control" id="valor" name="valor" placeholder="Valor do Serviço" onkeyup="criarParcelas()">							
									</div>






								</div>


								<div class="row">

									<div class="col-md-2 mb-2" >							
										<label>Valor Entrada</label>
										<input type="text" class="form-control" id="valor_entrada" name="valor_entrada" placeholder="Valor Entrada"  onkeyup="criarParcelas()">							
									</div>	

									<div class="col-md-3 mb-2 ">							
										<label>Forma Pgto</label>
										<select name="forma_pgto" id="forma_pgto" class="form-select">
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

									<div class="col-md-2 mb-2 col-6">							
										<label>Frequência</label>
										<select class="form-select" name="frequencia" id="frequencia" onchange="criarParcelas()">
											<?php 
											$query = $pdo->query("SELECT * from frequencias order by id asc");
											$res = $query->fetchAll(PDO::FETCH_ASSOC);
											$linhas = @count($res);
											if($linhas > 0){
												for($i=0; $i<$linhas; $i++){ ?>
													<option value="<?php echo $res[$i]['dias'] ?>"><?php echo $res[$i]['frequencia'] ?></option>
												<?php } } ?>
											</select>							
										</div>


										<div class="col-md-2 mb-2 col-6">							
											<label>Parcelas</label>
											<input type="number" class="form-control" id="parcelas" name="parcelas" value="1" required onchange="criarParcelas()">							
										</div>


										<div class="col-md-3 mb-2 ">							
											<label>Vencimento</label>
											<input type="date" class="form-control" id="data_venc" name="data_venc" value="<?php echo $data_atual ?>" required="" onchange="criarParcelas()">							
										</div>

										



									</div>

									<div class="row">

										<div class="col-md-3 mb-2 ">							
											<label>Nº Processo</label>
											<input type="text" class="form-control" id="numero_processo" name="numero_processo" placeholder="Se Existir" >							
										</div>

										<div class="col-md-2">							
											<label>% Escritório</label>
											<input type="text" class="form-control" id="valor_escritorio" name="valor_escritorio" placeholder="Inteiro ou Decimal" value="0">					
										</div>

										<div class="col-md-7">							
											<label>OBS</label>
											<input maxlength="255" type="text" class="form-control" id="obs" name="obs" placeholder="Observações caso tenha alguma" >							
										</div>


										


									</div>	


									<div id="listar_parcelas">
										
									</div>


								</div>

								<div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" style="overflow: scroll; max-height:380px; scrollbar-width: thin; padding-right:10px">

									<div class="row">

										<div class="col-md-4">							
											<label>Advogado 1</label>
											<select name="advogado1" id="advogado1" class="sel2" style="width:100%; height:35px; " >
												<option value="0">Selecionar Advogado</option>
												<?php 								
												$query = $pdo->query("SELECT * from usuarios where nivel = 'Advogado' and (ativo = 'Sim' or nivel = 'Administrador') and (visto_por = 'Sim' or visto_por = 'Não' and usuario_lanc = '$id_usuario') order by id asc");
												$res = $query->fetchAll(PDO::FETCH_ASSOC);
												$linhas = @count($res);
												if($linhas > 0){
													for($i=0; $i<$linhas; $i++){
														echo '<option value="'.$res[$i]['id'].'">'.$res[$i]['nome'].'</option>';
													}
												}
												?>	
											</select>									
										</div>


										<div class="col-md-4">							
											<label>Advogado 2</label>
											<select name="advogado2" id="advogado2" class="sel2" style="width:100%; height:35px; " >
												<option value="0">Selecionar Advogado</option>
												<?php 								
												$query = $pdo->query("SELECT * from usuarios where nivel = 'Advogado' and (ativo = 'Sim' or nivel = 'Administrador') and (visto_por = 'Sim' or visto_por = 'Não' and usuario_lanc = '$id_usuario') order by id asc");
												$res = $query->fetchAll(PDO::FETCH_ASSOC);
												$linhas = @count($res);
												if($linhas > 0){
													for($i=0; $i<$linhas; $i++){
														echo '<option value="'.$res[$i]['id'].'">'.$res[$i]['nome'].'</option>';
													}
												}
												?>	
											</select>									
										</div>


										<div class="col-md-4">							
											<label>Advogado 3</label>
											<select name="advogado3" id="advogado3" class="sel2" style="width:100%; height:35px; " >
												<option value="0">Selecionar Advogado</option>
												<?php 								
												$query = $pdo->query("SELECT * from usuarios where nivel = 'Advogado' and (ativo = 'Sim' or nivel = 'Administrador') and (visto_por = 'Sim' or visto_por = 'Não' and usuario_lanc = '$id_usuario') order by id asc");
												$res = $query->fetchAll(PDO::FETCH_ASSOC);
												$linhas = @count($res);
												if($linhas > 0){
													for($i=0; $i<$linhas; $i++){
														echo '<option value="'.$res[$i]['id'].'">'.$res[$i]['nome'].'</option>';
													}
												}
												?>	
											</select>									
										</div>

									</div>	



									<div class="row">
										<div class="col-md-4">							
											<label>% Advogado1</label>
											<input type="text" class="form-control" id="valor_advogado1" name="valor_advogado1" placeholder="Inteiro ou Decimal" value="0">					
										</div>
										<div class="col-md-4">							
											<label>% Advogado2</label>
											<input type="text" class="form-control" id="valor_advogado2" name="valor_advogado2" placeholder="Inteiro ou Decimal" value="0">					
										</div>
										<div class="col-md-4">							
											<label>% Advogado3</label>
											<input type="text" class="form-control" id="valor_advogado3" name="valor_advogado3" placeholder="Inteiro ou Decimal" value="0">					
										</div>
									</div>	



									<hr style="margin:15px; border:1px solid #424242">		


									<div class="row">

										<div class="col-md-4">							
											<label>Marketing</label>
											<select name="marketing" id="marketing" class="sel2" style="width:100%; height:35px; ">
												<option value="0">Selecionar Pessoa</option>
												<?php 								
												$query = $pdo->query("SELECT * from usuarios where ativo = 'Sim' and (visto_por = 'Sim' or visto_por = 'Não' and usuario_lanc = '$id_usuario') order by id asc");
												$res = $query->fetchAll(PDO::FETCH_ASSOC);
												$linhas = @count($res);
												if($linhas > 0){
													for($i=0; $i<$linhas; $i++){
														echo '<option value="'.$res[$i]['id'].'">'.$res[$i]['nome'].'</option>';
													}
												}
												?>	
											</select>									
										</div>

										<div class="col-md-2">							
											<label>% Marketing</label>
											<input type="text" class="form-control" id="valor_marketing" name="valor_marketing" placeholder="Inteiro ou Decimal" value="0">					
										</div>


										<div class="col-md-4">							
											<label>Indicação</label>
											<select name="indicacao" id="indicacao" class="sel2" style="width:100%; height:35px; " >
												<option value="0">Selecionar Pessoa</option>
												<?php 								
												$query = $pdo->query("SELECT * from usuarios where ativo = 'Sim' and (visto_por = 'Sim' or visto_por = 'Não' and usuario_lanc = '$id_usuario') order by id asc");
												$res = $query->fetchAll(PDO::FETCH_ASSOC);
												$linhas = @count($res);
												if($linhas > 0){
													for($i=0; $i<$linhas; $i++){
														echo '<option value="'.$res[$i]['id'].'">'.$res[$i]['nome'].'</option>';
													}
												}
												?>	
											</select>									
										</div>

										<div class="col-md-2">							
											<label>% Indicação</label>
											<input type="text" class="form-control" id="valor_indicacao" name="valor_indicacao" placeholder="Inteiro ou Decimal" value="0">					
										</div>




									</div>



									<hr style="margin:15px; border:1px solid #424242">


									<div class="row">
										<div class="col-md-4">							
											<label>Outra Pessoa</label>
											<select name="pessoa1" id="pessoa1" class="sel2" style="width:100%; height:35px; " >
												<option value="0">Selecionar Pessoa</option>
												<?php 								
												$query = $pdo->query("SELECT * from usuarios where ativo = 'Sim' and (visto_por = 'Sim' or visto_por = 'Não' and usuario_lanc = '$id_usuario') order by id asc");
												$res = $query->fetchAll(PDO::FETCH_ASSOC);
												$linhas = @count($res);
												if($linhas > 0){
													for($i=0; $i<$linhas; $i++){
														echo '<option value="'.$res[$i]['id'].'">'.$res[$i]['nome'].'</option>';
													}
												}
												?>	
											</select>									
										</div>

										<div class="col-md-2">							
											<label>% Pessoa 1</label>
											<input type="text" class="form-control" id="valor_pessoa1" name="valor_pessoa1" placeholder="Inteiro ou Decimal" value="0">					
										</div>


										<div class="col-md-6">							
											<label>Motivo</label>
											<input type="text" class="form-control" id="motivo1" name="motivo1" placeholder="Indicação, Marketing, outro..." >					
										</div>

									</div>



									<div class="row">
										<div class="col-md-4">							
											<label>Outra Pessoa</label>
											<select name="pessoa2" id="pessoa2" class="sel2" style="width:100%; height:35px; " >
												<option value="0">Selecionar Pessoa</option>
												<?php 								
												$query = $pdo->query("SELECT * from usuarios where ativo = 'Sim' and (visto_por = 'Sim' or visto_por = 'Não' and usuario_lanc = '$id_usuario') order by id asc");
												$res = $query->fetchAll(PDO::FETCH_ASSOC);
												$linhas = @count($res);
												if($linhas > 0){
													for($i=0; $i<$linhas; $i++){
														echo '<option value="'.$res[$i]['id'].'">'.$res[$i]['nome'].'</option>';
													}
												}
												?>	
											</select>									
										</div>

										<div class="col-md-2">							
											<label>% Pessoa 2</label>
											<input type="text" class="form-control" id="valor_pessoa2" name="valor_pessoa2" placeholder="Inteiro ou Decimal" value="0">					
										</div>


										<div class="col-md-6">							
											<label>Motivo</label>
											<input type="text" class="form-control" id="motivo2" name="motivo2" placeholder="Indicação, Marketing, outro..." >					
										</div>

									</div>


								</div>

							</div>



							<input type="hidden" class="form-control" id="id" name="id">					

							<br>
							<small><div id="mensagem" align="center"></div></small>
						</div>
						<div class="modal-footer">       
							<button type="submit" id="btn_salvar" class="btn btn-primary">Salvar</button>
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
												<td class="bg-warning alert-warning w_150">Cargo</td>
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
												<td class="bg-warning alert-warning w_150">Chave Pix</td>
												<td><span id="pix_dados"></span></td>
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







		<!-- Modal Cliente -->
		<div class="modal fade" id="modalCliente" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header bg-primary text-white">
						<h4 class="modal-title" id="exampleModalLabel"><span id="titulo_inserir"></span></h4>
						<button onclick="fecharModal()" id="btn-fechar_cliente" aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span class="text-white" aria-hidden="true">&times;</span></button>
					</div>
					<form id="form_cliente">
						<div class="modal-body">


							<div class="row">
								<div class="col-md-6 mb-2 col-6">							
									<label>Nome</label>
									<input type="text" class="form-control" id="nome" name="nome" placeholder="Seu Nome" required>							
								</div>

								<div class="col-md-3 col-6">							
									<label>Telefone</label>
									<input type="text" class="form-control" id="telefone" name="telefone" placeholder="Seu Telefone">							
								</div>		

								<div class="col-md-3 mb-2">							
									<label>Nascimento</label>
									<input type="date" class="form-control" id="data_nasc" name="data_nasc" placeholder="" >							
								</div>


							</div>


							<div class="row">

								<div class="col-md-2 mb-2 col-6">							
									<label>Pessoa</label>
									<select name="tipo_pessoa" id="tipo_pessoa" class="form-select" onchange="mudarPessoa()">
										<option value="Física">Física</option>
										<option value="Jurídica">Jurídica</option>
									</select>							
								</div>		

								<div class="col-md-3 mb-2 col-6">							
									<label>CPF / CNPJ</label>
									<input type="text" class="form-control" id="cpf" name="cpf" placeholder="CPF/CNPJ" >							
								</div>


								<div class="col-md-3">							
									<label>RG</label>
									<input type="text" class="form-control" id="rg" name="rg" placeholder="RG" >							
								</div>


								<div class="col-md-4">							
									<label>Email</label>
									<input type="email" class="form-control" id="email" name="email" placeholder="Email" >							
								</div>


							</div>

							<div class="row">

								<div class="col-md-2 mb-2">							
									<label>CEP</label>
									<input type="text" class="form-control" id="cep" name="cep" placeholder="CEP" onblur="pesquisacep(this.value);">							
								</div>

								<div class="col-md-5 mb-2">							
									<label>Rua</label>
									<input type="text" class="form-control" id="endereco" name="endereco" placeholder="Rua" >							
								</div>

								<div class="col-md-2 mb-2">							
									<label>Número</label>
									<input type="text" class="form-control" id="numero" name="numero" placeholder="Número" >							
								</div>

								<div class="col-md-3 mb-2">							
									<label>Complemento</label>
									<input type="text" class="form-control" id="complemento" name="complemento" placeholder="Se houver" >							
								</div>



							</div>


							<div class="row">

								<div class="col-md-4 mb-2">							
									<label>Bairro</label>
									<input type="text" class="form-control" id="bairro" name="bairro" placeholder="Bairro" >							
								</div>

								<div class="col-md-5 mb-2">							
									<label>Cidade</label>
									<input type="text" class="form-control" id="cidade" name="cidade" placeholder="Cidade" >							
								</div>

								<div class="col-md-3 mb-2">							
									<label>Estado</label>
									<select class="form-select" id="estado" name="estado">
										<option value="">Selecionar</option>
										<option value="AC">Acre</option>
										<option value="AL">Alagoas</option>
										<option value="AP">Amapá</option>
										<option value="AM">Amazonas</option>
										<option value="BA">Bahia</option>
										<option value="CE">Ceará</option>
										<option value="DF">Distrito Federal</option>
										<option value="ES">Espírito Santo</option>
										<option value="GO">Goiás</option>
										<option value="MA">Maranhão</option>
										<option value="MT">Mato Grosso</option>
										<option value="MS">Mato Grosso do Sul</option>
										<option value="MG">Minas Gerais</option>
										<option value="PA">Pará</option>
										<option value="PB">Paraíba</option>
										<option value="PR">Paraná</option>
										<option value="PE">Pernambuco</option>
										<option value="PI">Piauí</option>
										<option value="RJ">Rio de Janeiro</option>
										<option value="RN">Rio Grande do Norte</option>
										<option value="RS">Rio Grande do Sul</option>
										<option value="RO">Rondônia</option>
										<option value="RR">Roraima</option>
										<option value="SC">Santa Catarina</option>
										<option value="SP">São Paulo</option>
										<option value="SE">Sergipe</option>
										<option value="TO">Tocantins</option>
										<option value="EX">Estrangeiro</option>
									</select>												
								</div>


							</div>



								<div class="row">

						<div class="col-md-5 mb-2">							
							<label>Profissão</label>
							<input type="text" class="form-control" id="profissao" name="profissao" placeholder="Profissão" >							
						</div>

						<div class="col-md-4 mb-2">							
							<label>Nacionalidade</label>
							<input type="text" class="form-control" id="nacionalidade" name="nacionalidade" placeholder="Nacionalidade" >							
						</div>

							<div class="col-md-3 mb-2">							
							<label>Estado Civil</label>
							<select class="form-select" id="estado_civil" name="estado_civil">
							<option value="Solteiro(a)">Solteiro(a)</option>
							<option value="Casado(a)">Casado(a)</option>
							<option value="Divorciado(a)">Divorciado(a)</option>
							<option value="Viúvo(a)">Viúvo(a)</option>
							</select>							
						</div>

					
				</div>



							<div class="row">
								<div class="col-md-6 mb-2">							
									<label>Genitor</label>
									<input type="text" class="form-control" id="genitor" name="genitor" placeholder="Nome do Pai" >							
								</div>

								<div class="col-md-6 mb-2">							
									<label>Genitora</label>
									<input type="text" class="form-control" id="genitora" name="genitora" placeholder="Nome da mãe" >							
								</div>
							</div>




							<input type="hidden" class="form-control" id="id" name="id">					

							<br>
							<small><div id="mensagem_cliente" align="center"></div></small>
						</div>
						<div class="modal-footer">       
							<button type="submit" id="btn_salvar_cliente" class="btn btn-primary">Salvar</button>
						</div>
					</form>
				</div>
			</div>
		</div>





<!-- Modal Contas -->
<div class="modal fade" id="modalContas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header bg-primary text-white">
				<h4 class="modal-title" id="exampleModalLabel"><span id="titulo_contas"></span></h4>
				<button id="btn-fechar-contas" aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span class="text-white" aria-hidden="true">&times;</span></button>
			</div>
			
			<div class="modal-body">				
				<div id="listar_debitos" style="margin-top: 15px">

				</div>
				<input type="hidden" id="id_contas">
			</div>

		</div>
	</div>
</div>






<!-- Modal -->
<div class="modal fade" id="modalBaixar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog ">
		<div class="modal-content">
			<div class="modal-header bg-primary text-white">
				<h4 class="modal-title" id="tituloModal">Baixar Conta: <span id="descricao-baixar"> </span></h4>
				<button id="btn-fechar-baixar" aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span class="text-white" aria-hidden="true">&times;</span></button>
			</div>
			<form id="form-baixar" method="post">
				<div class="modal-body">

					<div class="row">
						<div class="col-md-6">
							<div class="mb-3">
								<label>Valor <small class="text-muted">(Total ou Parcial)</small></label>
								<input onkeyup="totalizar()" type="text" class="form-control" name="valor-baixar"  id="valor-baixar" required>
							</div>
						</div>


						<div class="col-md-6">
							<div class="form-group"> 
								<label>Forma PGTO</label> 
								<select class="form-select" name="saida-baixar" id="saida-baixar" required onchange="calcularTaxa()">	
									<?php 
									$query = $pdo->query("SELECT * FROM formas_pgto order by id asc");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									for($i=0; $i < @count($res); $i++){
										foreach ($res[$i] as $key => $value){}

											?>	
										<option value="<?php echo $res[$i]['id'] ?>"><?php echo $res[$i]['nome'] ?></option>

									<?php } ?>

								</select>
							</div>
						</div>

					</div>	


					<div class="row">


						<div class="col-md-3">
							<div class="mb-3">
								<label>Multa em R$</label>
								<input onkeyup="totalizar()" type="text" class="form-control" name="valor-multa"  id="valor-multa" placeholder="Ex 15.00" value="0">
							</div>
						</div>

						<div class="col-md-3">
							<div class="mb-3">
								<label>Júros em R$</label>
								<input onkeyup="totalizar()" type="text" class="form-control" name="valor-juros"  id="valor-juros" placeholder="Ex 0.15" value="0">
							</div>
						</div>

						<div class="col-md-3">
							<div class="mb-3">
								<label >Desconto R$</label>
								<input onkeyup="totalizar()" type="text" class="form-control" name="valor-desconto"  id="valor-desconto" placeholder="Ex 15.00" value="0" >
							</div>
						</div>



						<div class="col-md-3">
							<div class="mb-3">
								<label >Taxa PGTO</label>
								<input onkeyup="totalizar()" type="text" class="form-control" name="valor-taxa"  id="valor-taxa" placeholder="" value="" >
							</div>
						</div>

					</div>


					<div class="row">

						<div class="col-md-6">
							<div class="mb-3">
								<label >Data da Baixa</label>
								<input type="date" class="form-control" name="data-baixar"  id="data-baixar" value="<?php echo date('Y-m-d') ?>" >
							</div>
						</div>


						<div class="col-md-6">
							<div class="mb-3">
								<label >SubTotal</label>
								<input type="text" class="form-control" name="subtotal"  id="subtotal" readonly>
							</div>	
						</div>
					</div>




					<small><div id="mensagem-baixar" align="center"></div></small>

					<input type="hidden" class="form-control" name="id-baixar"  id="id-baixar">


				</div>
				<div class="modal-footer">

					<button type="submit" class="btn btn-success">Baixar</button>
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


			function buscar(){
			var status = $('#status').val();
			var dataInicial = $('#dataInicial').val();
			var dataFinal = $('#dataFinal').val();
			
			listar(status, dataInicial, dataFinal)

		}
		</script>


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
			function fecharModal(){
				$('#modalForm').modal('show');
			}





			$("#form_cliente").submit(function () {

				event.preventDefault();
				var formData = new FormData(this);

				$('#mensagem_cliente').text('Salvando...')
				$('#btn_salvar_cliente').hide();

				$.ajax({
					url: 'paginas/clientes/salvar.php',
					type: 'POST',
					data: formData,

					success: function (mensagem) {
						$('#mensagem_cliente').text('');
						$('#mensagem_cliente').removeClass()
						if (mensagem.trim() == "Salvo com Sucesso") {

							$('#btn-fechar_cliente').click();
							listarClientes('ult');

							$('#mensagem_cliente').text('')          

						} else {

							$('#mensagem_cliente').addClass('text-danger')
							$('#mensagem_cliente').text(mensagem)
						}

						$('#btn_salvar_cliente').show();

					},

					cache: false,
					contentType: false,
					processData: false,

				});

			});



			function listarClientes(ult){

				$.ajax({
					url: 'paginas/' + pag + "/listar_clientes.php",
					method: 'POST',
					data: {ult},
					dataType: "text",

					success:function(result){
						$("#listar_clientes").html(result);
					}
				});
			}


				function listarParcelas(){				
				var id = $("#id").val();

				if(id == ""){
					id = 0;
				}	
				
				$.ajax({
					url: 'paginas/' + pag + "/listar_parcelas.php",
					method: 'POST',
					data: {id},
					dataType: "text",

					success:function(result){						
						$("#listar_parcelas").html(result);
					}
				});
			}


			function criarParcelas(){
				setTimeout(function() {
				  ajaxCriar();
				}, 500)	

			}


			function ajaxCriar(){
				var parcelas = $("#parcelas").val();
				var frequencia = $("#frequencia").val();
				var valor = $("#valor").val();
				var entrada = $("#valor_entrada").val();
				var tipo_servico = $("#tipo_servico").val();
				var data_venc = $("#data_venc").val();
				var cliente = $("#cliente").val();
				var forma_pgto = $("#forma_pgto").val();
				var id = $("#id").val();				

				if(parcelas <= 1){
					$("#parcelas").val('1');		
				}

				if(parcelas > 1){
					if(frequencia <= 0){
						if(id != "0"){
							alert("Selecione uma Frequência");
							$("#parcelas").val('1');
						}						
						return;
					}
				}

				if(valor == "" || valor == undefined || valor <= 0 || parcelas <= 0 || parcelas == "" || parcelas == undefined){
					return;
				}				

				$.ajax({
					url: 'paginas/' + pag + "/criar_parcelas.php",
					method: 'POST',
					data: {parcelas, frequencia, valor, entrada, tipo_servico, data_venc, cliente, forma_pgto, id},
					dataType: "text",

					success:function(result){
						
						listarParcelas();
					}
				});

			}



			function limparParcelas(){
				$.ajax({
					url: 'paginas/' + pag + "/limpar_parcelas.php",
					method: 'POST',
					data: {},
					dataType: "text",

					success:function(result){
						listarParcelas();
					}
				});
			}



		</script>



		
<script type="text/javascript">
	function totalizar(){
		valor = $('#valor-baixar').val();
		desconto = $('#valor-desconto').val();
		juros = $('#valor-juros').val();
		multa = $('#valor-multa').val();
		taxa = $('#valor-taxa').val();

		valor = valor.replace(",", ".");
		desconto = desconto.replace(",", ".");
		juros = juros.replace(",", ".");
		multa = multa.replace(",", ".");
		taxa = taxa.replace(",", ".");

		if(valor == ""){
			valor = 0;
		}

		if(desconto == ""){
			desconto = 0;
		}

		if(juros == ""){
			juros = 0;
		}

		if(multa == ""){
			multa = 0;
		}

		if(taxa == ""){
			taxa = 0;
		}

		subtotal = parseFloat(valor) + parseFloat(juros) + parseFloat(taxa) + parseFloat(multa) - parseFloat(desconto);


		console.log(subtotal)

		$('#subtotal').val(subtotal);

	}

	function calcularTaxa(){
		pgto = $('#saida-baixar').val();
		valor = $('#valor-baixar').val();
		$.ajax({
			url: 'paginas/receber/calcular_taxa.php',
			method: 'POST',
			data: {valor, pgto},
			dataType: "html",

			success:function(result){		           
				$('#valor-taxa').val(result);
				totalizar();
			}
		});


	}
</script>




<script type="text/javascript">
	$("#form-baixar").submit(function () {
		event.preventDefault();
		var formData = new FormData(this);

		var id_conta = $('#id_contas').val(); 	

		$.ajax({
			url: 'paginas/receber/baixar.php',
			type: 'POST',
			data: formData,

			success: function (mensagem) {						

				$('#mensagem-baixar').text('');
				$('#mensagem-baixar').removeClass()
				if (mensagem.trim() == "Baixado com Sucesso") {                    
					$('#btn-fechar-baixar').click();
					listarDebitos(id_conta);

				} else {
					$('#mensagem-baixar').addClass('text-danger')
					$('#mensagem-baixar').text(mensagem)
				}

			},

			cache: false,
			contentType: false,
			processData: false,

		});

	});



	function ativarProcesso(id, acao){  
    $.ajax({
        url: 'paginas/' + pag + "/mudar-status.php",
        method: 'POST',
        data: {id, acao},
        dataType: "html",

        success:function(mensagem){
            
            if (mensagem.trim() == "Alterado com Sucesso") {
                buscar();
            } else {
                $('#mensagem-excluir').addClass('text-danger')
                $('#mensagem-excluir').text(mensagem)
            }
        }
    });
}
</script>



