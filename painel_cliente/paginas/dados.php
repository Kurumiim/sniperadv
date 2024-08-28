<?php 
require_once("verificar.php");
$pag = 'dados';


?>


<div class="row row-sm">
<div class="col-lg-12">
<div class="card custom-card">
<div class="card-body" >

	<div class="">
			<form id="form" style="padding:10px">
				<div class="modal-body">


					<div class="row">
						<div class="col-md-6 mb-2 col-12">							
							<label>Nome</label>
							<input type="text" class="form-control" id="nome" name="nome" placeholder="Seu Nome" required value="<?php echo $nome_usuario ?>">							
						</div>

						<div class="col-md-3 col-12">							
							<label>Telefone</label>
							<input type="text" class="form-control" id="telefone" name="telefone" placeholder="Seu Telefone" value="<?php echo $telefone_usuario ?>">							
						</div>		

						<div class="col-md-3 mb-2 col-12">							
							<label>Nascimento</label>
							<input type="date" class="form-control" id="data_nasc" name="data_nasc" placeholder="" value="<?php echo $data_nasc_usuario ?>" >							
						</div>

						
					</div>


					<div class="row">

						<div class="col-md-2 mb-2 col-6">							
							<label>Pessoa</label>
							<select name="tipo_pessoa" id="tipo_pessoa" class="form-select" onchange="mudarPessoa()">
								<option <?php if($tipo_pessoa_usuario == 'Física'){ echo 'selected'; } ?> value="Física">Física</option>
								<option <?php if($tipo_pessoa_usuario == 'Jurídica'){ echo 'selected'; } ?> value="Jurídica">Jurídica</option>
							</select>							
						</div>		

						<div class="col-md-3 mb-2 col-6">							
							<label>CPF / CNPJ</label>
							<input type="text" class="form-control" id="cpf" name="cpf" placeholder="CPF/CNPJ" required="">							
						</div>


						<div class="col-md-3">							
							<label>RG</label>
							<input type="text" class="form-control" id="rg" name="rg" placeholder="RG" value="<?php echo $rg_usuario ?>">							
						</div>
						

						<div class="col-md-4">							
							<label>Email</label>
							<input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $email_usuario ?>">							
						</div>

						
					</div>

					<div class="row">

						<div class="col-md-2 mb-2">							
							<label>CEP</label>
							<input type="text" class="form-control" id="cep" name="cep" placeholder="CEP" onblur="pesquisacep(this.value);" value="<?php echo $cep_usuario ?>">							
						</div>

						<div class="col-md-5 mb-2">							
							<label>Rua</label>
							<input type="text" class="form-control" id="endereco" name="endereco" placeholder="Rua"  value="<?php echo $endereco_usuario ?>">							
						</div>

						<div class="col-md-2 mb-2">							
							<label>Número</label>
							<input type="text" class="form-control" id="numero" name="numero" placeholder="Número"  value="<?php echo $numero_usuario ?>">							
						</div>

						<div class="col-md-3 mb-2">							
							<label>Complemento</label>
							<input type="text" class="form-control" id="complemento" name="complemento" placeholder="Se houver" value="<?php echo $complemento_usuario ?>">							
						</div>



					</div>


					<div class="row">

						<div class="col-md-4 mb-2">							
							<label>Bairro</label>
							<input type="text" class="form-control" id="bairro" name="bairro" placeholder="Bairro"  value="<?php echo $bairro_usuario ?>">							
						</div>

						<div class="col-md-5 mb-2">							
							<label>Cidade</label>
							<input type="text" class="form-control" id="cidade" name="cidade" placeholder="Cidade" value="<?php echo $cidade_usuario ?>" >							
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
							<input type="text" class="form-control" id="profissao" name="profissao" placeholder="Profissão" value="<?php echo $profissao_usuario ?>">							
						</div>

						<div class="col-md-4 mb-2">							
							<label>Nacionalidade</label>
							<input type="text" class="form-control" id="nacionalidade" name="nacionalidade" placeholder="Nacionalidade" value="<?php echo $nacionalidade_usuario ?>">							
						</div>

							<div class="col-md-3 mb-2">							
							<label>Estado Civil</label>
							<select class="form-select" id="estado_civil" name="estado_civil">
							<option <?php if($estado_civil_usuario == 'Solteiro(a)'){ echo 'selected'; } ?> value="Solteiro(a)">Solteiro(a)</option>
							<option <?php if($estado_civil_usuario == 'Casado(a)'){ echo 'selected'; } ?> value="Casado(a)">Casado(a)</option>
							<option <?php if($estado_civil_usuario == 'Divorciado(a)'){ echo 'selected'; } ?> value="Divorciado(a)">Divorciado(a)</option>
							<option <?php if($estado_civil_usuario == 'Viúvo(a)'){ echo 'selected'; } ?> value="Viúvo(a)">Viúvo(a)</option>
							</select>							
						</div>

					
				</div>



				<div class="row">
					<div class="col-md-6 mb-2">							
							<label>Genitor</label>
							<input type="text" class="form-control" id="genitor" name="genitor" placeholder="Nome do Pai" value="<?php echo $genitor_usuario ?>">							
						</div>

						<div class="col-md-6 mb-2">							
							<label>Genitora</label>
							<input type="text" class="form-control" id="genitora" name="genitora" placeholder="Nome da mãe" value="<?php echo $genitora_usuario ?>">							
						</div>
				</div>


					<div class="row">
					<div class="col-md-6 mb-2">							
							<label>Indicador Por</label>
							<input type="text" class="form-control" id="indicacao" name="indicacao" placeholder="Indicado Por" value="<?php echo $indicacao_usuario ?>">							
						</div>


						


						<input type="hidden" id="visto_por" name="visto_por" value="Todos">
						<input type="hidden" id="" name="id" value="<?php echo $id_cliente ?>">
						
						
				</div>

				<div class="row">
					<div class="col-6 mb-2">							
							<label>Senha Acesso Painel</label>
							<input type="password" class="form-control" id="senha" name="senha" placeholder="Sua Senha"  required="">							
						</div>

					<div class="col-6 mb-2">							
							<label>Confirmar Senha</label>
							<input type="password" class="form-control" id="conf_senha" name="conf_senha" placeholder="Confirmar Senha" required="">							
						</div>
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
</div>
</div>
</div>







<script type="text/javascript">var pag = "<?=$pag?>"</script>
<script src="js/ajax.js"></script>

<script type="text/javascript">
	$(document).ready( function () {	
		mudarPessoa();

		var cpf = "<?=$cpf_usuario?>";
		var estado = "<?=$estado_usuario?>";
		setTimeout(function() {
		$('#cpf').val(cpf);
		$('#estado').val(estado).change();
		}, 150)


	

		
	});
</script>


 <script type="text/javascript">
	$("#form").submit(function () {

		$('#mensagem').text("Cadastrando!!");
		$('#btn_salvar').hide();

		event.preventDefault();
		var formData = new FormData(this);

		$.ajax({
			url: "../painel/paginas/clientes/salvar.php",
			type: 'POST',
			data: formData,

			success: function (mensagem) {
				$('#mensagem').text('');
				$('#mensagem').removeClass()
				if (mensagem.trim() == "Salvo com Sucesso") {
					//$('#btn-fechar-rec').click();				
					
					alert('Editado com Sucesso');
					window.location="dados";		

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
	function mudarPessoa(){
		var pessoa = $('#tipo_pessoa').val();
		
		if(pessoa == 'Física'){
			$('#cpf').mask('000.000.000-00');
			$('#cpf').attr("placeholder", "Insira CPF");
		}else{
			 $('#cpf').mask('00.000.000/0000-00');
			$('#cpf').attr("placeholder", "Insira CNPJ");				
		}
	}
</script>




<script>
    
    function limpa_formulário_cep() {
            //Limpa valores do formulário de cep.
            document.getElementById('endereco').value=("");
            document.getElementById('bairro').value=("");
            document.getElementById('cidade').value=("");
            document.getElementById('estado').value=("");
            //document.getElementById('ibge').value=("");
    }

    function meu_callback(conteudo) {
        if (!("erro" in conteudo)) {
            //Atualiza os campos com os valores.
            document.getElementById('endereco').value=(conteudo.logradouro);
            document.getElementById('bairro').value=(conteudo.bairro);
            document.getElementById('cidade').value=(conteudo.localidade);
            document.getElementById('estado').value=(conteudo.uf);
            //document.getElementById('ibge').value=(conteudo.ibge);
        } //end if.
        else {
            //CEP não Encontrado.
            limpa_formulário_cep();
            alert("CEP não encontrado.");
        }
    }
        
    function pesquisacep(valor) {

        //Nova variável "cep" somente com dígitos.
        var cep = valor.replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if(validacep.test(cep)) {

                //Preenche os campos com "..." enquanto consulta webservice.
                document.getElementById('endereco').value="...";
                document.getElementById('bairro').value="...";
                document.getElementById('cidade').value="...";
                document.getElementById('estado').value="...";
                //document.getElementById('ibge').value="...";

                //Cria um elemento javascript.
                var script = document.createElement('script');

                //Sincroniza com o callback.
                script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';

                //Insere script no documento e carrega o conteúdo.
                document.body.appendChild(script);

            } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cep();
                alert("Formato de CEP inválido.");
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
        }
    };

    </script>


