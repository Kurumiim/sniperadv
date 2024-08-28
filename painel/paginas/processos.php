<?php 

require_once("verificar.php");
$pag = 'processos';

//verificar se ele tem a permissão de estar nessa página
if(@$processos == 'ocultar'){
	echo "<script>window.location='index'</script>";
	exit();
}
?>

<div class="justify-content-between">
	<form action="rel/processos_class.php" target="_blank" method="POST">
 	<div class="left-content mt-2 mb-3">
 <a style="margin-bottom: 10px; margin-top: 5px" class="btn ripple btn-primary text-white  <?php echo $inserir_processos ?>" onclick="inserir()" type="button"><i class="fe fe-plus me-2"></i>Novo Processo</a>


 <div style="display: inline-block; position:absolute; right:10px; margin-bottom: 10px">
			<button style="width:40px" type="submit" class="btn btn-danger ocultar_mobile_app" title="Gerar Relatório"><i class="fa fa-file-pdf-o"></i></button>
		</div>	
        

         <div class="cab_mobile"></div>               

         <div style="display: inline-block; margin-bottom: 10px">
			<input type="date" name="dataInicial" id="dataInicial" style="height:35px; width:49%; font-size: 13px;" value="<?php echo $data_inicio_mes ?>" onchange="buscar()">

			<input type="date" name="dataFinal" id="dataFinal" style="height:35px; width:49%; font-size: 13px" value="<?php echo $data_final_mes ?>" onchange="buscar()">	
		</div>	


		<select class="form-select" name="status" id="status_busca" style="display:inline-block; width:200px" onchange="buscar()">
			<option value="">Selecine um Status</option>
			<option value="Preparação">Em Preparação</option>
			<option value="Andamento">Em Andamento</option>
			<option value="Finalizado">Finalizado / Baixado</option>
			<option value="Cancelado">Cancelado</option>
			<option value="Arquivado">Arquivado</option>
		</select>
		


		</div>			
		
		</form>
		
	</div>



	<div class="card-group" style="margin-bottom: -30px">
	
	<div class="card text-center mb-5" style="width: 100%; margin-right: 10px; border-radius: 10px; height:110px">
		<a class="text-white" href="#" onclick="$('#tipo_data_filtro').val('Cancelado'); buscar(); ">
			<div class="card-header bg-red border-light">
	             Cancelados
	            <i class="fa fa-external-link pull-right"></i>
	        </div>
	        <div class="card-body">
	        	<p class="card-text" style="margin-top:-15px;">
	        		<h4><span class="text-danger" id="total_cancelado">0</span></h4>
	        	</p>
	        </div>
        </a>
    </div>
    


    <div class="card text-center mb-5" style="width: 100%; margin-right: 10px; border-radius: 10px; height:110px">
    	<a href="#" onclick="$('#tipo_data_filtro').val('Arquivado'); buscar(); ">
			<div class="card-header bg-orange border-light text-white">
	            Arquivados
	            <i class="fa fa-external-link pull-right"></i>
	        </div>
	        <div class="card-body">
	        	<p class="card-text" style="margin-top:-15px;">
	        		<h4><span style="color: #f05800" id="total_arquivado">0</span></h4>
	        	</p>
	        </div>
        </a>
    </div>


    <div class="card text-center mb-5" style="width: 100%; margin-right: 10px; border-radius: 10px; height:110px">
    	<a href="#" onclick="$('#tipo_data_filtro').val('Preparação');  buscar(); ">
			<div class="card-header border-light text-white" style="background: gray">
	            Em Preparação
	            <i class="fa fa-external-link pull-right"></i>
	        </div>
	        <div class="card-body">
	        	<p class="card-text" style="margin-top:-15px;">
	        		<h4><span style="color: gray" id="total_preparacao">0</span></h4>
	        	</p>
	        </div>
        </a>
    </div>

    


     <div class="card text-center mb-5" style="width: 100%; margin-right: 10px; border-radius: 10px; height:110px">
    	<a href="#" onclick=" $('#tipo_data_filtro').val('Finalizado');  buscar();">
			<div class="card-header border-light text-white" style="background: #2b7a00">
	            Finalizados
	            <i class="fa fa-external-link pull-right"></i>
	        </div>
	        <div class="card-body">
	        	<p class="card-text" style="margin-top:-15px;">
	        		<h4><span style="color: #2b7a00" id="total_finalizado">0</span></h4>
	        	</p>
	        </div>
        </a>
    </div>


      <div class="card text-center mb-5" style="width: 100%; margin-right: 10px; border-radius: 10px; height:110px">
    	<a href="#" onclick="$('#tipo_data_filtro').val('Andamento');  buscar();">
			<div class="card-header border-light text-white" style="background: #1c6cad;">
	            Em Andamento
	            <i class="fa fa-external-link pull-right"></i>
	        </div>
	        <div class="card-body">
	        	<p class="card-text" style="margin-top:-15px;">
	        		<h4><span  id="total_andamento">0</span></h4>
	        	</p>
	        </div>
        </a>
    </div>

<input type="hidden" id="tipo_data_filtro">
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

<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
	<div class="modal-dialog modal-lg" >
		<div class="modal-content" >
			<div class="modal-header bg-primary text-white">
				<h4 class="modal-title" id="exampleModalLabel"><span id="titulo_inserir"></span></h4>
				<button id="btn-fechar" aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span class="text-white" aria-hidden="true">&times;</span></button>
			</div>
			<form id="form_processo">
				<div class="modal-body">
					
					<nav style="margin-bottom: 20px">
						<div class="nav nav-tabs" id="nav-tab" role="tablist">
							<button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Dados Processo</button>
							<button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Parte Contrária</button>
							<button class="nav-link" id="nav-obs-tab" data-bs-toggle="tab" data-bs-target="#nav-obs" type="button" role="tab" aria-controls="nav-obs" aria-selected="false">Observações</button>

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
									<label>Tipo Ação</label>
									<select class="sel2" name="tipo_acao" id="tipo_acao" style="width:100%">
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
										<label>Valor Causa</label>
										<input type="text" class="form-control" id="valor" name="valor" placeholder="Valor da Causa">							
									</div>






								</div>


								<div class="row">

									<div class="col-md-3 mb-2" >							
										<label>Número do Processo</label>
										<input type="text" class="form-control" id="numero_processo" name="numero_processo" placeholder="Número Processo" >							
									</div>	

									<div class="col-md-3 mb-2 ">							
										<label>Status</label>
											<select class="form-select" name="status" id="status" required="">												
												<option value="Preparação">Em Preparação</option>
												<option value="Andamento">Em Andamento</option>
												<option value="Finalizado">Finalizado / Baixado</option>
												<option value="Cancelado">Cancelado</option>
												<option value="Arquivado">Arquivado</option>
											</select>				
									</div>					

									<div class="col-md-3 mb-2 ">							
										<label>Segredo Justiça</label>
											<select class="form-select" name="segredo_justica" id="segredo_justica" >	
												<option value="Não">Não</option>
												<option value="Sim">Sim</option>
												
											</select>				
									</div>		

										<div class="col-md-3 mb-2 ">							
										<label>Justiça Gratuita</label>
											<select class="form-select" name="justica_gratuita" id="justica_gratuita" >	
												<option value="Sim">Sim</option>
												<option value="Não">Não</option>
												
											</select>				
									</div>

										



									</div>							



									<div class="row">

										<div class="col-md-5 mb-2 ">							
											<label>Orgão Julgador</label>
											<input type="text" class="form-control" id="orgao_julgador" name="orgao_julgador" placeholder="" >							
										</div>

										<div class="col-md-3 mb-2 ">							
											<label>Data Abertura</label>
											<input type="date" class="form-control" id="data_abertura" name="data_abertura" placeholder="" value="<?php echo $data_atual ?>">							
										</div>

										<div class="col-md-4 mb-2 ">							
											<label>Advogado 1</label>
											<select name="advogado1" id="advogado1" class="sel2" style="width:100%; height:35px; " >
												<option value="0">Selecionar Advogado</option>
												<?php 								
												$query = $pdo->query("SELECT * from usuarios where nivel = 'Advogado' and (ativo = 'Sim' or nivel = 'Administrador') and (visto_por = 'Sim' or visto_por = 'Não' and usuario_lanc = '$id_usuario')  order by id asc");
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

										<div class="col-md-4 mb-2 ">							
											<label>Advogado 2</label>
											<select name="advogado2" id="advogado2" class="sel2" style="width:100%; height:35px; " >
												<option value="0">Selecionar Advogado</option>
												<?php 								
												$query = $pdo->query("SELECT * from usuarios where nivel = 'Advogado'and (ativo = 'Sim' or nivel = 'Administrador') and (visto_por = 'Sim' or visto_por = 'Não' and usuario_lanc = '$id_usuario') order by id asc");
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

										<div class="col-md-4 mb-2 ">							
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

										<div class="col-md-4 mb-2 ">							
											<label>Advogado 4</label>
											<select name="advogado4" id="advogado4" class="sel2" style="width:100%; height:35px; " >
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

										<div class="col-md-4 mb-2 ">							
											<label>Jurisdição</label>
											<input type="text" class="form-control" id="jurisdicao" name="jurisdicao" placeholder="" >							
										</div>

										<div class="col-md-4 mb-2 ">							
											<label>Vara</label>
											<input type="text" class="form-control" id="vara" name="vara" placeholder="" >							
										</div>

										<div class="col-md-4 mb-2 ">							
											<label>Comarca</label>
											<input type="text" class="form-control" id="comarca" name="comarca" placeholder="" >							
										</div>									


									</div>	


								


								</div>

								<div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" >

								

									<div class="row">
										<div class="col-md-5">							
											<label>Nome</label>
											<input type="text" class="form-control" id="nome_contraria" name="nome_contraria" placeholder="Nome Parte Contrária" >					
										</div>
										<div class="col-md-3">							
											<label>CPF ou CNPJ</label>
											<input type="text" class="form-control" id="cpf_contraria" name="cpf_contraria" placeholder="CPF Contrária" onkeyup="verMasc()">					
										</div>
										<div class="col-md-4">							
											<label>RG ou Outro Documento</label>
											<input type="text" class="form-control" id="rg_contraria" name="rg_contraria" placeholder="RG parte Contrária" >					
										</div>
									</div>	


									
									<div class="row">
										<div class="col-md-4">							
											<label>Telefone</label>
											<input type="text" class="form-control" id="telefone_contraria" name="telefone_contraria" placeholder="Tel Parte Contrária" >					
										</div>
											<div class="col-md-4 mb-2">							
												<label>Estado Civil</label>
												<select class="form-select" id="estado_civil_contraria" name="estado_civil_contraria">
												<option value="Solteiro(a)">Solteiro(a)</option>
												<option value="Casado(a)">Casado(a)</option>
												<option value="Divorciado(a)">Divorciado(a)</option>
												<option value="Viúvo(a)">Viúvo(a)</option>
												</select>							
											</div>
										<div class="col-md-4">							
											<label>Advogado(a)</label>
											<input type="text" class="form-control" id="advogado_contraria" name="advogado_contraria" placeholder="Nome do Advogado" >					
										</div>
									</div>	


									<div class="row">
										<div class="col-md-12">	
											<label>Endereço</label>
											<input type="text" class="form-control" id="endereco_contraria" name="endereco_contraria" placeholder="Endereço parte Contrária" >	
										</div>
									</div>							


								</div>








								<div class="tab-pane fade" id="nav-obs" role="tabpanel" aria-labelledby="nav-obs-tab" >	

									<div class="row">
										<div class="col-md-12">	
											<label>Observações</label>
											<textarea class="textarea_menor text_area_mobile" id="area" name="obs" ></textarea>
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
								<div class="col-md-6">						
									<div class="form-group"> 
										<label>Título</label> 
										<input maxlength="100" class="form-control" type="text" name="titulo"  id="titulo">
									</div>	
								</div>

								<div class="col-md-3">						
									<div class="form-group"> 
										<label>Notificar Cliente</label> 
										<select class="form-select" id="notificar" name="notificar">
										<option value="Sim">Sim</option>
										<option value="Não">Não</option>										
										</select>		
									</div>	
								</div>

								<div class="col-md-3">						
									<div class="form-group"> 
										<label>Visível Cliente</label> 
										<select class="form-select" id="visivel_cliente" name="visivel_cliente">
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


			function buscar(){
			var status = $('#status_busca').val();
			var dataInicial = $('#dataInicial').val();
			var dataFinal = $('#dataFinal').val();
			var status_filtro = $('#tipo_data_filtro').val();
			
			listar(status, dataInicial, dataFinal, status_filtro)

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


				

		</script>

<script src="//js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>

	
<script type="text/javascript">
	

$("#form_processo").submit(function () {

    event.preventDefault();
    nicEditors.findEditor('area').saveContent();
    var formData = new FormData(this);



    $('#mensagem').text('Salvando...')
    $('#btn_salvar').hide();

    $.ajax({
        url: 'paginas/' + pag + "/salvar.php",
        type: 'POST',
        data: formData,

        success: function (mensagem) {
            $('#mensagem').text('');
            $('#mensagem').removeClass()
            if (mensagem.trim() == "Salvo com Sucesso") {

                $('#btn-fechar').click();
                listar();

                $('#mensagem').text('')          

            } else {

                $('#mensagem').addClass('text-danger')
                $('#mensagem').text(mensagem)
            }

            $('#btn_salvar').show();

        },

        cache: false,
        contentType: false,
        processData: false,

    });

});
</script>




<script type="text/javascript">
			$("#form-movimentacoes").submit(function () {
				event.preventDefault();
				var formData = new FormData(this);

				 $('#mensagem-movimentacoes').text('Salvando...')
    			 $('#btn_mov').hide();

				$.ajax({
					url: 'paginas/' + pag + "/movimentacoes.php",
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
					url: 'paginas/' + pag + "/listar-movimentacoes.php",
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
					url: 'paginas/' + pag + "/api/exec_api.php",
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
					url: 'paginas/' + pag + "/valor.php",
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
					url: 'paginas/' + pag + "/listar-valores.php",
					method: 'POST',
					data: {id},
					dataType: "text",

					success:function(result){
						$("#listar-valores").html(result);
					}
				});
			}
		</script>