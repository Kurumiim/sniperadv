<?php 
$pag = 'rel_contratos';
require_once("verificar.php");
if(@$rel_contratos == 'ocultar'){
	echo "<script>window.location='index'</script>";
    exit();
}	

$id_cliente = '';
$numero_contrato = '';

$id_contrato = @$_POST['id_contrato'];
if($id_contrato != ""){
	$query = $pdo->query("SELECT * from abertura_contratos where id = '$id_contrato'");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$id_cliente = $res[0]['cliente'];
	$numero_contrato = $res[0]['numeracao'];
}


 ?>

<div class="justify-content-between">
 

			<div class="modal-body">

			<div class="row">

						<div class="col-md-2 mb-2" >							
									<label>Tipo Contrato</label>
									
									<select class="sel203" id="contrato" style="width:100%" onchange="listarContrato()" required="">
										<option value="">Selecionar Modelo</option>
										<?php										
										$query = $pdo->query("SELECT * from contratos order by modelo asc");
										$res = $query->fetchAll(PDO::FETCH_ASSOC);
										$linhas = @count($res);
										if($linhas > 0){
											for($i=0; $i<$linhas; $i++){
												if($res[$i]['modelo'] == 'Contrato de Honorário' and $id_contrato != ""){
													$select = 'selected';
												}else{
													$select = '';
												}
											 ?>
												<option <?php echo $select ?> value="<?php echo $res[$i]['id'] ?>"><?php echo $res[$i]['modelo'] ?></option>
											<?php } } ?>
										</select>							
									</div>



						<div class="col-md-3 mb-2" >							
									<label>Cliente (Nome ou CPF)</label>

									<select class="sel203" id="cliente" style="width:100%" onchange="listarContrato()">
										<option value="">Selecionar Cliente</option>
										<?php 
										if($mostrar_registros == 'Não'){
											$query = $pdo->query("SELECT * from clientes where usuario = '$id_usuario' or visto_por = 'Todos' order by nome asc");
										}else{
											$query = $pdo->query("SELECT * from clientes order by nome asc");
										}
										$res = $query->fetchAll(PDO::FETCH_ASSOC);
										$linhas = @count($res);
										if($linhas > 0){
											for($i=0; $i<$linhas; $i++){
												if($res[$i]['id'] == $id_cliente){
													$select = 'selected';
												}else{
													$select = '';
												}
											 ?>
												<option <?php echo $select ?> value="<?php echo $res[$i]['id'] ?>"><?php echo $res[$i]['nome'] ?> - <?php echo $res[$i]['cpf'] ?></option>
											<?php } } ?>
										</select>							
									</div>


						<div class="col-md-3 mb-2" >							
									<label>Profissional</label>
									<select class="sel203" id="profissional" style="width:100%" onchange="listarContrato()">
										<option value="">Selecionar Profissional</option>
										<?php 
										if($mostrar_registros == 'Não'){
											$query = $pdo->query("SELECT * from usuarios where id = '$id_usuario' order by id desc");
										}else{
											$query = $pdo->query("SELECT * from usuarios order by nome asc");
										}
										
										$res = $query->fetchAll(PDO::FETCH_ASSOC);
										$linhas = @count($res);
										if($linhas > 0){
											for($i=0; $i<$linhas; $i++){
												
											 ?>
												<option value="<?php echo $res[$i]['id'] ?>"><?php echo $res[$i]['nome'] ?></option>
											<?php } } ?>
										</select>							
									</div>



										<div class="col-md-2 mb-2" >							
									<label>Serviço Prestado</label>
									<select class="sel203" id="servico" style="width:100%" onchange="listarContrato()">
										<option value="">Selecionar Contrato</option>
										<?php 
										if($mostrar_registros == 'Não'){
											$query = $pdo->query("SELECT * from abertura_contratos where usuario_lanc = '$id_usuario' order by numeracao asc");
										}else{
											$query = $pdo->query("SELECT * from abertura_contratos order by numeracao asc");
										}
										
										$res = $query->fetchAll(PDO::FETCH_ASSOC);
										$linhas = @count($res);
										if($linhas > 0){
											for($i=0; $i<$linhas; $i++){

													if($res[$i]['numeracao'] == $numero_contrato){
													$select = 'selected';
												}else{
													$select = '';
												}
											 ?>
												<option <?php echo $select ?> value="<?php echo $res[$i]['id'] ?>"><?php echo $res[$i]['numeracao'] ?></option>
											<?php } } ?>
										</select>							
									</div>


										<div class="col-md-1 mb-2" >							
									<label>Cabeçalho</label>
									<select class="sel203" id="cabecalho" style="width:100%" onchange="$('#cabecalho_form').val($('#cabecalho').val())">
										<option value="Sim">Sim</option>
										<option value="Não">Não</option>
										</select>							
									</div>


									<div class="col-md-1 mb-1" style="margin-top: 26px">	
										<button onclick="$('#botao_form').click()" type="submit" class="btn btn-primary">Gerar</button>
									</div>



				
			</div>		


			
				<div class="row">
					
				</div>
						

			</div>
			
			

</div>


<div class="container">
 <form method="POST" action="rel/contrato_class.php" target="_blank">
<textarea class="textarea text_area_mobile" id="texto_contrato" name="texto"></textarea>
<input type="hidden" id="cabecalho_form" name="cabecalho_form" value="Sim">
<button type="submit" id="botao_form" style="display:none"></button>
</form>
</div>


<script src="//js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>

<script type="text/javascript">
	$(document).ready(function() {	
	listarContrato()			
				$('.sel203').select2({
					
				});

			});
</script>

<script type="text/javascript">var pag = "<?=$pag?>"</script>
<script src="js/ajax.js"></script>


<script type="text/javascript">
	function listarContrato(){
		var contrato = $('#contrato').val();
		var cliente = $('#cliente').val();
		var profissional = $('#profissional').val();
		var servico = $('#servico').val();

		$.ajax({
        url: 'paginas/' + pag + "/listar_texto.php",
        method: 'POST',
        data: {contrato, cliente, profissional, servico},
        dataType: "html",

        success:function(result){
          	 nicEditors.findEditor("texto_contrato").setContent(result);       
	        }
	    });
	}
</script>

