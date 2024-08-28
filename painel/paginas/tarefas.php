<?php 
@session_start();
$id_usuario = @$_SESSION['id'];
require_once("verificar.php");
$pag = 'tarefas';

if(@$tarefas == 'ocultar'){
	echo "<script>window.location='index'</script>";
	exit();
}

?>

<link rel="stylesheet" type="text/css" href="css/style-calendario.css">

<div class="justify-content-between">

	<div class="left-content mt-2 mb-3">
		<span style="margin-right: 20px;"><a class="btn ripple btn-primary text-white" onclick="inserir()" type="button"><i class="fe fe-plus me-2 "></i> Adicionar Tarefa</a></span>

		<span class="<?php echo $lancar_tarefas ?>">
		<select class="form-control sel50 " aria-label="Default select example" name="usuario_selecionado" id="usuario_selecionado" style="width:230px;" onchange="buscar()">	

				<?php 
				if($nivel_usuario == 'Administrador' || $lancar_tarefas == ''){
					$query = $pdo->query("SELECT * FROM usuarios where nivel != 'Cliente'");
					
				}else{
					$query = $pdo->query("SELECT * FROM usuarios where id = '$id_usuario' ");
				}
				

				$res = $query->fetchAll(PDO::FETCH_ASSOC);

				for($i=0; $i < @count($res); $i++){

					if($res[$i]['visto_por'] == 'Não' and $res[$i]['id'] != '$id_usuario'){
						continue;
					}

						?>	

						<option value="<?php echo $res[$i]['id'] ?>" <?php if($res[$i]['id'] == $id_usuario){ ?> selected <?php } ?> ><?php echo $res[$i]['nome'] ?> </option>



				<?php } ?>			

				

			</select>
			</span>

			
	</div>



<div style="display: inline-block;">
	<div class="" id="container" style="float:left;">
      <div id="header">
        <div id="monthDisplay"></div>

        <div>
          <button class="botao_calendar" id="backButton"><</button>
          <button class="botao_calendar" id="nextButton">></button>
        </div>
          
      </div>

      <div id="weekdays">
        <div>Dom</div>
        <div>Seg</div>
        <div>Ter</div>
        <div>Qua</div>
        <div>Qui</div>
        <div>Sex</div>
        <div>Sáb</div>
      </div>


      <!-- div dinamic -->
      <div id="calendar" ></div>

     
  </div>


  <div class="ocultar_mobile" style="float:left;  margin-top: 25px; margin-left: 15px; width:800px">

  	<div class="card-group" style="margin-bottom: -30px">
  		
  		<div class="card text-center mb-5" style="width: 100%; margin-right: 10px; border-radius: 10px; height:110px; box-shadow: 2px 2px 2px 1px rgba(0, 0, 0, 0.1);">		
			<div class="card-header bg-red border-light">
	             Tarefas Atrasadas
	            
	        </div>
	        <div class="card-body">
	        	<p class="card-text" style="margin-top:-15px;">
	        		<h4><span class="text-danger" id="tarefas_atrasadas"></span></h4>
	        	</p>
	        </div>      
    </div>


    <div class="card text-center mb-5" style="width: 100%; margin-right: 10px; border-radius: 10px; height:110px; box-shadow: 2px 2px 2px 1px rgba(0, 0, 0, 0.1);">	
			<div class="card-header border-light" style="background: #eb3f3f; color:#FFF">
	             Tarefas Pendentes
	           
	        </div>
	        <div class="card-body">
	        	<p class="card-text" style="margin-top:-15px;">
	        		<h4><span style="color:#eb3f3f" class="" id="tarefas_pendentes"></span></h4>
	        	</p>
	        </div>
        
    </div>


    <div class="card text-center mb-5" style="width: 100%; margin-right: 10px; border-radius: 10px; height:110px; box-shadow: 2px 2px 2px 1px rgba(0, 0, 0, 0.1);">	
		
			<div class="card-header border-light" style="background: #189ca1; color:#FFF">
	             Pendentes Hoje
	            
	        </div>
	        <div class="card-body">
	        	<p class="card-text" style="margin-top:-15px;">
	        		<h4><span style="color:#189ca1" id="tarefas_dia"></span></h4>
	        	</p>
	        </div>
        
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

<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-primary text-white">
				<h4 class="modal-title" id="exampleModalLabel"><span id="titulo_inserir"></span></h4>
				 <button id="btn-fechar" aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span class="text-white" aria-hidden="true">&times;</span></button>
			</div>
			<form id="form_tarefas">
			<div class="modal-body">

				<div class="row">
						<div class="col-md-6 mb-2">							
								<label>Hora</label>
								<input type="time" class="form-control" id="hora" name="hora" placeholder="" required>							
						</div>

						<div class="col-md-6 mb-2">							
								<label>Data</label>
								<input type="date" class="form-control" id="data_tarefa" name="data" required="" value="<?php echo $data_atual ?>">							
						</div>

						

						
					</div>


					<div class="row">
						<div class="col-md-6 mb-2">							
								<label>Hora Alerta</label>
								<input type="time" class="form-control" id="hora_alerta" name="hora_alerta" placeholder="" >							
						</div>


						<div class="col-md-6 mb-2">							
								<label>Prioridade</label>
								<select class="form-select" id="prioridade" name="prioridade" >
									<option value="Baixa">Baixa</option>
									<option value="Média">Média</option>
									<option value="Alta">Alta</option>
								</select>					
						</div>


						
					</div>
				

					<div class="row">
						<div class="col-md-12 mb-2">							
								<label>Descrição</label>
								<input maxlength="255" type="text" class="form-control" id="descricao" name="descricao" placeholder="Descrição da tarefa se Houver">							
						</div>

					
						
					</div>

					<input type="hidden" class="form-control" id="usuario_tarefa" name="usuario_tarefa" value="<?php echo $id_usuario ?>">	
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

<input type="hidden" id="data_selecionada" value="<?php echo $data_atual ?>">
<input type="hidden" id="array_datas" value="">


<script type="text/javascript">var pag = "<?=$pag?>"</script>
<script src="js/ajax.js"></script>



<script type="text/javascript">

	$(document).ready(function() {

		buscar();		

		$('.sel50').select2({
					//dropdownParent: $('#modalBaixar')
				});
	});

</script>


<script type="text/javascript">
	

$("#form_tarefas").submit(function () {

    event.preventDefault();
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
                buscar();

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
	function buscar(){
		listarDatas();
		var usu_sel = $('#usuario_selecionado').val();
		$('#usuario_tarefa').val(usu_sel);	
		var data = $('#data_selecionada').val();
				
		$('#data_tarefa').val(data);			

		listar(data, usu_sel)

		
	}


	function concluir(id){   
        
    $.ajax({
        url: 'paginas/' + pag + "/concluir.php",
        method: 'POST',
        data: {id},
        dataType: "html",

        success:function(mensagem){
        	if (mensagem.trim() == "Concluído com Sucesso") {                
                buscar();                
            } 
        }
    });
}


function excluirTarefa(id){   
    $('#mensagem-excluir').text('Excluindo...')
    
    $.ajax({
        url: 'paginas/' + pag + "/excluir.php",
        method: 'POST',
        data: {id},
        dataType: "html",

        success:function(mensagem){
            if (mensagem.trim() == "Excluído com Sucesso") {                
                buscar();
                
            } else {
                $('#mensagem-excluir').addClass('text-danger')
                $('#mensagem-excluir').text(mensagem)
            }
        }
    });
}


function listarDatas(){

	var usuario = $('#usuario_selecionado').val();
	
	 $.ajax({
        url: 'paginas/' + pag + "/listar_datas.php",
        method: 'POST',
        data: {usuario},
        dataType: "html",

        success:function(result){ 
				$('#array_datas').val(result)			

				load();
        }
    });
}
</script>


<script src="js/script-calendario.js"></script>