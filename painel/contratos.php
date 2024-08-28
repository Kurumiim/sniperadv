<?php 
require_once("verificar.php");
$pag = 'contratos';

//verificar se ele tem a permissão de estar nessa página
if(@$contratos == 'ocultar'){
    echo "<script>window.location='index'</script>";
    exit();
}
 ?>

<div class="justify-content-between" style="margin-top: 20px">
<nav style="margin-bottom: 20px">
						<div class="nav nav-tabs" id="nav-tab" role="tablist">
							<button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Listar Contrato</button>
							<button onclick="limparCampos()" class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">
							<i class="fa fa-plus "></i>	
							Novo Modelo</button>

						</div>
					</nav>

</div>



<div class="tab-content" id="nav-tabContent">

	<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
		<div class="row row-sm">
		<div class="col-lg-12">
		<div class="card custom-card">
		<div class="card-body" id="listar">

		</div>
		</div>
		</div>
		</div>
	</div>


<div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" >

<form id="form_contrato">
			<div >
				

					<div class="row">
						<div class="col-md-4 mb-2">							
								<label>Modelo</label>
								<input type="text" class="form-control" id="modelo" name="modelo" placeholder="Procuração, Petição, etc" required>	

								</div>	
										
						

						<div class="col-md-1 mb-2" style="margin-top: 26px">		
						<button type="submit" id="btn_salvar" class="btn btn-primary">Salvar</button>
						<small><div id="mensagem" align="center"></div></small>	
						</div>		
					
					</div>


						<div class="row" style="z-index: 1000">
						<div class="col-md-12 mb-2">							
								<label>Texto (Liberado apenas para edição básica)</label>
								<textarea class="textarea text_area_mobile" id="area" name="texto" >
									
								</textarea>						
						</div>			
					
					</div>


					
					<input type="hidden" class="form-control" id="id" name="id">					

				
				
			</div>

						
			</form>

</div>

</div>










<script type="text/javascript">var pag = "<?=$pag?>"</script>
<script src="js/ajax.js"></script>


<script src="//js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>


<script type="text/javascript">
	

$("#form_contrato").submit(function () {

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

                $('#nav-home-tab').click();
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