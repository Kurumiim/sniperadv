<?php 
require_once("conexao.php");
@session_start();
?>



<!DOCTYPE html>
<html lang="pt-BR">
	
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
		<!-- META DATA -->
        <meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="Description" content="Fluxo Comunicação Inteligente">
		<meta name="Author" content="Samuel Lima">
		<meta name="Keywords" content="fluxo, comunicacao, inteligente, marketing, whatsapp"/>
		
		<!-- TITLE -->
		<title><?php echo $nome_sistema ?></title>


		<link rel="icon" href="img/icone.png" type="image/x-icon"/>
		<link href="assets/css/icons.css" rel="stylesheet">
		<link id="style" href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
		<link href="assets/css/style.css" rel="stylesheet">
		<link href="assets/css/custom.css" rel="stylesheet">
		<link href="assets/css/style-dark.css" rel="stylesheet">
		<link href="assets/css/style-transparent.css" rel="stylesheet">
		<link href="assets/css/skin-modes.css" rel="stylesheet" />
		<link href="assets/css/animate.css" rel="stylesheet">


		

	</head>


		<!-- GLOBAL-LOADER -->
		<div id="global-loader">
			<img src="img/loader.gif" class="loader-img loader loader_mobile" alt="">
		</div>
		<!-- /GLOBAL-LOADER -->

	<body class="ltr error-page1 bg-primary" id="pagina">


		<div class="square-box">
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
		</div>


		<div class="page" >


			<div class="page-single">
				<div class="container">
					<div class="row">
						<div class="col-xl-5 col-lg-6 col-md-8 col-sm-8 col-xs-10 card-sigin-main mx-auto my-auto py-4 justify-content-center">
							<div class="card-sigin">
								 <!-- Demo content-->
								 <div class="main-card-signin d-md-flex">
									 <div class="wd-100p"><div class="d-flex mb-4 justify-content-center"><a href="index.php"><img src="img/logo.png" class="sign-favicon" alt="logo" width="130px"></a></div>
										 <div class="">
											<div class="main-signup-header">
											
												<div class="panel panel-primary">
							
												   <div class="panel-body tabs-menu-body border-0 p-3">			

												   <?php
			if(isset($_SESSION['msg'])){

				echo '<div class="alert alert-danger mg-b-0 mb-3 alert-dismissible fade show" role="alert">
											<strong><span class="alert-inner--icon"><i class="fe fe-slash"></i></span></strong> '.$_SESSION['msg'].'!
											<button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button"><span aria-hidden="true">&times;</span></button>
										</div>';

				unset($_SESSION['msg']);
			}
		?>		


						
														
															   <form method="post" action="autenticar_cliente.php">
																   <div class="form-group">
																	   <label>CPF ou CNPJ</label> 
																	   <input class="form-control" name="cpf" placeholder="Digite seu CPF ou CNPJ" id="cpf_acesso" type="text" required value="" onkeyup="verMasc()">
																   </div>
																    <div class="form-group">
																	   <label>Senha</label> 
																	   <input class="form-control" name="senha" placeholder="Digite sua Senha" id="senha_acesso" type="password" required value="" >
																   </div>

																   <button class="btn btn-primary btn-block">Entrar</button>
																
																</form>													
													  
												   </div>
											   </div>

												
											</div>
										 </div>
									 </div>
								 </div>
							 </div>
						 </div>
					</div>
				</div>
			</div>
		</div>





	</body>

</html>

	


<script src="assets/plugins/jquery/jquery.min.js"></script>
		<script src="assets/plugins/bootstrap/js/popper.min.js"></script>
        <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/plugins/moment/moment.js"></script>
        <script src="assets/js/eva-icons.min.js"></script>        
        <script src="assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
        <script src="assets/js/themecolor.js"></script>
        <script src="assets/js/custom.js"></script>




	<!-- Mascaras JS -->
<script type="text/javascript" src="painel/js/mascaras.js"></script>

<!-- Ajax para funcionar Mascaras JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script> 


<script type="text/javascript">
	$(document).ready( function () {
		verMasc();
	});
	function verMasc(){
		var cpf = $('#cpf_acesso').val();
		if(cpf.length >= 15){
			$('#cpf_acesso').mask('00.000.000/0000-00');
		}else{
			$('#cpf_acesso').mask('000.000.000-000');
		}
	}
	
</script>
