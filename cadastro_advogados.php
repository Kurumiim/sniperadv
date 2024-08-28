<?php 
require_once("conexao.php");
?>

<!DOCTYPE html>
<html>
<head>
	<title><?php echo $nome_sistema ?></title>
	
	 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
  	 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
  	 <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

  	 <link rel="stylesheet" type="text/css" href="assets/css/recuperar.css">

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" type="image/x-icon" href="img/icone.png">

</head>
<body style="background: #f2f2f2; font-size: 12px">
	<div class="" >		
		<div class="">
			<form id="form" style="padding:10px">
				<div class="modal-body">


						<div class="row">
						<div class="col-md-4 mb-2">							
								<label>Nome</label>
								<input type="text" class="form-control" id="nome" name="nome" placeholder="Seu Nome" required>							
						</div>

						<div class="col-md-5 mb-2">							
								<label>Email</label>
								<input type="email" class="form-control" id="email" name="email" placeholder="Seu Email"  required>							
						</div>

							<div class="col-md-3 mb-2 col-12">							
								<label>Telefone</label>
								<input type="text" class="form-control" id="telefone" name="telefone" placeholder="Seu Telefone" required>							
						</div>

						
					</div>


					<div class="row">						
						
						<input type="hidden" id="nivel" name="nivel" value="Advogado">
						

						<div class="col-md-4 mb-2 col-12">							
								<label>Especialidade</label>
								<input type="text" class="form-control" id="especialidade" name="especialidade" placeholder="Especialidade do Profissional" >							
						</div>

							<div class="col-md-5 mb-2 ">							
								<label>Chave Pix</label>
								<input type="text" class="form-control" id="chave_pix" name="chave_pix" placeholder="Chave Pix" >							
						</div>	
						
					</div>


					<div class="row">		
											
						<div class="col-md-4 mb-2 col-12">							
								<label>Nacionalidade</label>
								<input type="text" class="form-control" id="nacionalidade" name="nacionalidade" placeholder="Nacionalidade" >							
						</div>

							<div class="col-md-3 mb-2 col-6">							
							<label>Estado Civil</label>
							<select class="form-select" id="estado_civil" name="estado_civil">
							<option value="Solteiro(a)">Solteiro(a)</option>
							<option value="Casado(a)">Casado(a)</option>
							<option value="Divorciado(a)">Divorciado(a)</option>
							<option value="Viúvo(a)">Viúvo(a)</option>
							</select>							
						</div>


						<div class="col-md-3 mb-2 col-6">							
							<label>Seccional OAB</label>
							<select class="form-select" id="seccional_oab" name="seccional_oab">
							<option value="">Selecionar</option>
							<option value="AC">AC</option>
							<option value="AL">AL</option>
							<option value="AP">AP</option>
							<option value="AM">AM</option>
							<option value="BA">BA</option>
							<option value="CE">CE</option>
							<option value="DF">DF</option>
							<option value="ES">ES</option>
							<option value="GO">GO</option>
							<option value="MA">MA</option>
							<option value="MT">MT</option>
							<option value="MS">MS</option>
							<option value="MG">MG</option>
							<option value="PA">PA</option>
							<option value="PB">PB</option>							
							<option value="PE">PE</option>
							<option value="PI">PI</option>
							<option value="RJ">RJ</option>
							<option value="RN">RN</option>
							<option value="RS">RS</option>
							<option value="RO">RO</option>
							<option value="RR">RR</option>
							<option value="SC">SC</option>
							<option value="SP">SP</option>
							<option value="SE">SE</option>
							<option value="TO">TO</option>
						</select>												
					</div>	


						<div class="col-md-2 mb-2 col-12">							
								<label>Número OAB</label>
								<input type="text" class="form-control" id="numero_oab" name="numero_oab" placeholder="Numero OAB Ex 200.000" >							
						</div>


						
					</div>



					<div class="row">

						<div class="col-md-12">							
								<label>Endereço Residencial</label>
								<input type="text" class="form-control" id="endereco" name="endereco" placeholder="Seu Endereço" >							
						</div>

						
					</div>



					<div class="row">

						<div class="col-md-12">							
								<label>Endereço Profissional</label>
								<input type="text" class="form-control" id="endereco_profissional" name="endereco_profissional" placeholder="Seu Endereço" >							
						</div>


						<input type="hidden" id="visto_por" name="visto_por" value="Sim">
						
						
				</div>

								

				<br>
				<small><div id="mensagem" align="center"></div></small>
			</div>
			<div class="">       
				<button id="btn_salvar" style="width:100%" type="submit" id="btn_salvar" class="btn btn-primary">Salvar</button>
			</div>
		</form>
		</div>
	</div>

</body>
</html>




<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


 <script type="text/javascript">
	$("#form").submit(function () {

		$('#mensagem').text("Cadastrando!!");
		$('#btn_salvar').hide();

		event.preventDefault();
		var formData = new FormData(this);

		$.ajax({
			url: "painel/paginas/funcionarios/salvar.php",
			type: 'POST',
			data: formData,

			success: function (mensagem) {
				$('#mensagem').text('');
				$('#mensagem').removeClass()
				if (mensagem.trim() == "Salvo com Sucesso") {
					//$('#btn-fechar-rec').click();				
					
					alert('Cadastrado com Sucesso');
					window.location="index.php";		

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






	<!-- Mascaras JS -->
<script type="text/javascript" src="painel/js/mascaras.js"></script>

<!-- Ajax para funcionar Mascaras JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script> 
