<?php 
@session_start();
require_once("../conexao.php");
require_once("verificar.php");


$data_atual = date('Y-m-d');
$mes_atual = Date('m');
$ano_atual = Date('Y');
$data_inicio_mes = $ano_atual."-".$mes_atual."-01";
$data_inicio_ano = $ano_atual."-01-01";

$data_ontem = date('Y-m-d', strtotime("-1 days",strtotime($data_atual)));
$data_amanha = date('Y-m-d', strtotime("+1 days",strtotime($data_atual)));


if($mes_atual == '04' || $mes_atual == '06' || $mes_atual == '09' || $mes_atual == '11'){
	$data_final_mes = $ano_atual.'-'.$mes_atual.'-30';
}else if($mes_atual == '02'){
	$bissexto = date('L', @mktime(0, 0, 0, 1, 1, $ano_atual));
	if($bissexto == 1){
		$data_final_mes = $ano_atual.'-'.$mes_atual.'-29';
	}else{
		$data_final_mes = $ano_atual.'-'.$mes_atual.'-28';
	}

}else{
	$data_final_mes = $ano_atual.'-'.$mes_atual.'-31';
}



$pag_inicial = 'processos';

if(@$_GET['pagina'] != ""){
	$pagina = @$_GET['pagina'];
}else{
	$pagina = $pag_inicial;
}

$id_cliente = @$_SESSION['id_cliente'];
$query = $pdo->query("SELECT * from clientes where id = '$id_cliente'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
	$nome_usuario = $res[0]['nome'];
	$email_usuario = $res[0]['email'];
	$telefone_usuario = $res[0]['telefone'];
	$endereco_usuario = $res[0]['endereco'];
	$tipo_pessoa_usuario = $res[0]['tipo_pessoa'];
	$cpf_usuario = $res[0]['cpf'];

	$numero_usuario = $res[0]['numero'];
	$bairro_usuario = $res[0]['bairro'];
	$cidade_usuario = $res[0]['cidade'];
	$estado_usuario = $res[0]['estado'];
	$cep_usuario = $res[0]['cep'];
	$profissao_usuario = $res[0]['profissao'];
	$nacionalidade_usuario = $res[0]['nacionalidade'];
	$estado_civil_usuario = $res[0]['estado_civil'];
	$indicacao_usuario = $res[0]['indicacao'];
	$usuario_usuario = $res[0]['usuario'];


	$rg_usuario = $res[0]['rg'];
	$complemento_usuario = $res[0]['complemento'];
	$genitor_usuario = $res[0]['genitor'];
	$genitora_usuario = $res[0]['genitora'];
	
	$data_cad_usuario = $res[0]['data_cad'];
	$data_nasc_usuario = $res[0]['data_nasc'];
	$visto_por_usuario = $res[0]['visto_por'];
	
}else{
	echo '<script>window.location="../"</script>';
	exit();
}

?>
<!DOCTYPE HTML>
<html lang="pt-BR" dir="ltr">
	
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
		

		<meta charset="UTF-8">
        <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="Description" content="Fluxo Comunicação Inteligente">
        <meta name="Author" content="Samuel Lima">
        <meta name="Keywords" content="fluxo, comunicacao, inteligente, marketing, whatsapp"/>

		<title><?php echo $nome_sistema ?></title>

		<link rel="icon" href="../img/icone.png" type="image/x-icon"/>
		<link href="../assets/css/icons.css" rel="stylesheet">
		<link id="style" href="../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
		<link href="../assets/css/style.css" rel="stylesheet">
		<link href="../assets/css/style-dark.css" rel="stylesheet">
		<link href="../assets/css/style-transparent.css" rel="stylesheet">
		<link href="../assets/css/skin-modes.css" rel="stylesheet" />
		<link href="../assets/css/animate.css" rel="stylesheet">
		<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
		<link href="../assets/css/custom.css" rel="stylesheet" />
		<script src="js/jquery-1.11.1.min.js"></script>
		<script src="js/modernizr.custom.js"></script>		


		


	</head>

	<body class="ltr main-body app sidebar-mini">

		<?php if($mostrar_preloader == 'Sim'){ ?>
		<!-- GLOBAL-LOADER -->
		<div id="global-loader">
			<img src="../img/loader.gif" class="loader-img loader loader_mobile" alt="">
		</div>
		<!-- /GLOBAL-LOADER -->
		<?php } ?>

		<!-- Page -->
		<div class="page">

			<div>
				<!-- APP-HEADER1 -->
				<div class="main-header side-header sticky nav nav-item">
						<div class=" main-container container-fluid">
							<div class="main-header-left ">
								<div class="responsive-logo">
									<a href="index.php" class="header-logo">
										<img src="../img/foto-painel.png" class="mobile-logo logo-1" alt="logo" style="width:40% !important; margin-left: -120px !important">
										<img src="../img/foto-painel.png" class="mobile-logo dark-logo-1" alt="logo" style="width:40% !important; margin-left: -120px !important">
									</a>
								</div>
								<div class="app-sidebar__toggle" data-bs-toggle="sidebar">
									<a class="open-toggle" href="javascript:void(0);"><i class="header-icon fe fe-align-left" ></i></a>
									<a class="close-toggle" href="javascript:void(0);"><i class="header-icon fe fe-x"></i></a>
								</div>
								<div class="logo-horizontal">
									<a href="index.php" class="header-logo">
										<img src="../img/foto-painel.png" class="mobile-logo logo-1" alt="logo">
										<img src="../img/foto-painel.png" class="mobile-logo dark-logo-1" alt="logo">
									</a>
								</div>
								<div class="main-header-center ms-4 d-sm-none d-md-none d-lg-block form-group">
									
								</div>
							</div>
							<div class="main-header-right">
								
								<div class="mb-0 navbar navbar-expand-lg navbar-nav-right responsive-navbar navbar-dark p-0">
									<div class="" id="navbarSupportedContent-4">
										<ul class="nav nav-item header-icons navbar-nav-right ms-auto">

											<li class="dropdown nav-item" style="opacity: 0">
												------------
											</li>

											
								
											<li class="dropdown nav-item ocultar_mobile">
												<a class="new nav-link theme-layout nav-link-bg layout-setting" >
													<span class="dark-layout"><svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" width="24" height="24" viewBox="0 0 24 24"><path d="M20.742 13.045a8.088 8.088 0 0 1-2.077.271c-2.135 0-4.14-.83-5.646-2.336a8.025 8.025 0 0 1-2.064-7.723A1 1 0 0 0 9.73 2.034a10.014 10.014 0 0 0-4.489 2.582c-3.898 3.898-3.898 10.243 0 14.143a9.937 9.937 0 0 0 7.072 2.93 9.93 9.93 0 0 0 7.07-2.929 10.007 10.007 0 0 0 2.583-4.491 1.001 1.001 0 0 0-1.224-1.224zm-2.772 4.301a7.947 7.947 0 0 1-5.656 2.343 7.953 7.953 0 0 1-5.658-2.344c-3.118-3.119-3.118-8.195 0-11.314a7.923 7.923 0 0 1 2.06-1.483 10.027 10.027 0 0 0 2.89 7.848 9.972 9.972 0 0 0 7.848 2.891 8.036 8.036 0 0 1-1.484 2.059z"/></svg></span>
													<span class="light-layout"><svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" width="24" height="24" viewBox="0 0 24 24"><path d="M6.993 12c0 2.761 2.246 5.007 5.007 5.007s5.007-2.246 5.007-5.007S14.761 6.993 12 6.993 6.993 9.239 6.993 12zM12 8.993c1.658 0 3.007 1.349 3.007 3.007S13.658 15.007 12 15.007 8.993 13.658 8.993 12 10.342 8.993 12 8.993zM10.998 19h2v3h-2zm0-17h2v3h-2zm-9 9h3v2h-3zm17 0h3v2h-3zM4.219 18.363l2.12-2.122 1.415 1.414-2.12 2.122zM16.24 6.344l2.122-2.122 1.414 1.414-2.122 2.122zM6.342 7.759 4.22 5.637l1.415-1.414 2.12 2.122zm13.434 10.605-1.414 1.414-2.122-2.122 1.414-1.414z"/></svg></span>
												</a>
											</li>


																							
											
											<li class="nav-item full-screen fullscreen-button">
												<a class="new nav-link full-screen-link" href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" width="24" height="24" viewBox="0 0 24 24"><path d="M5 5h5V3H3v7h2zm5 14H5v-5H3v7h7zm11-5h-2v5h-5v2h7zm-2-4h2V3h-7v2h5z"/></svg></a>
											</li>
						
											<li class="dropdown main-profile-menu nav nav-item nav-link ps-lg-2">
												<a class="new nav-link profile-user d-flex" href="#" data-bs-toggle="dropdown"><img src="../painel/images/perfil/sem-foto.jpg"></a>
												<div class="dropdown-menu">
													<div class="menu-header-content p-3 border-bottom">
														<div class="d-flex wd-100p">
															<div class="main-img-user"><img src="../painel/images/perfil/sem-foto.jpg"></div>
															<div class="ms-3 my-auto">
																<h6 class="tx-15 font-weight-semibold mb-0"><?php echo $nome_usuario ?></h6><span class="dropdown-title-text subtext op-6  tx-12"></span>
															</div>
														</div>
													</div>
													
														</span>
														
													<a class="dropdown-item" href="logout_cliente.php"><i class="fa fa-arrow-left"></i> Sair</a>
												</div>
											</li>
										</ul>
									</div>
								</div>
							
							</div>
						</div>
					</div>				<!-- /APP-HEADER -->

				<!--APP-SIDEBAR-->
				<div class="sticky">
					<aside class="app-sidebar">
						<div class="main-sidebar-header active">
							<a class="header-logo active" href="index.php">
								<img src="../img/foto-painel.png" class="main-logo  desktop-logo" alt="logo">
								<img src="../img/foto-painel.png" class="main-logo  desktop-dark" alt="logo">
								<img src="../img/icone.png" class="main-logo  mobile-logo" alt="logo">
								<img src="../img/icone.png" class="main-logo  mobile-dark" alt="logo">
							</a>
						</div>
						<div class="main-sidemenu">
							<div class="slide-left disabled" id="slide-left"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"><path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"/></svg></div>
							<ul class="side-menu">

								



								<li class="slide <?php echo @$processos ?>">
									<a class="side-menu__item" href="processos">
										<i class="fa fa-anchor text-white"></i>
										<span class="side-menu__label" style="margin-left: 15px">Processos</span></a>
								</li>
		

								
									<li class="slide">
									<a class="side-menu__item" href="pagar">
										<i class="fa fa-usd text-white"></i>
										<span class="side-menu__label" style="margin-left: 15px">Pagamentos</span></a>
								</li>


										
									<li class="slide">
									<a class="side-menu__item" href="dados">
										<i class="fa fa-edit text-white"></i>
										<span class="side-menu__label" style="margin-left: 15px">Editar Dados</span></a>
								</li>
								
						
							
			
								
							</ul>
							<div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"><path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"/></svg></div>
						</div>
					</aside>
				</div>				<!--/APP-SIDEBAR-->
			</div>

			<!-- MAIN-CONTENT -->
			<div class="main-content app-content">

				<!-- container -->
				<div class="main-container container-fluid ">

					<?php 
						//Classe para ocultar mobile
if($ocultar_mobile == 'Sim'){ ?>
	<style type="text/css">
		@media only screen and (max-width: 700px) {
		  .ocultar_mobile_app{
		    display:none; 
		  }
		}
	</style>
<?php } ?>
					

				<?php 
				echo "<script>localStorage.setItem('pagina', '$pagina')</script>";
				require_once('paginas/'.$pagina.'.php');
				?>				


				</div>
				<!-- Container closed -->
			</div>
			<!-- MAIN-CONTENT CLOSED -->

				
			






			<!-- FOOTER -->
			<div class="main-footer">
				<div class="container-fluid pt-0 ht-100p">
					 Copyright © <?php echo date('Y'); ?> <a href="javascript:void(0);" class="text-primary">PORTAL HUGO CURSOS</a>. Todos os direitos reservados
				</div>
			</div>			<!-- FOOTER END -->

		</div>
		<!-- End Page -->

		<!-- BUYNOW-MODAL -->
		       
		
	
		<a href="#top" id="back-to-top"><i class="las la-arrow-up"></i></a>


		<!-- GRAFICOS -->
		<script src="../assets/plugins/chart.js/Chart.bundle.min.js"></script>		
		<script src="../assets/js/apexcharts.js"></script>

		<!--INTERNAL  INDEX JS -->
		<script src="../assets/js/index.js"></script>
	

	
		<script src="../assets/plugins/jquery/jquery.min.js"></script>
		<script src="../assets/plugins/bootstrap/js/popper.min.js"></script>
		<script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>
		<script src="../assets/plugins/moment/moment.js"></script>
		<script src="../assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
		<script src="../assets/plugins/perfect-scrollbar/p-scroll.js"></script>
		<script src="../assets/js/eva-icons.min.js"></script>
		<script src="../assets/plugins/side-menu/sidemenu.js"></script>
		<script src="../assets/js/sticky.js"></script>
		<script src="../assets/plugins/sidebar/sidebar.js"></script>
		<script src="../assets/plugins/sidebar/sidebar-custom.js"></script>


		<!-- INTERNAL DATA TABLES -->
		<script src="../assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
		<script src="../assets/plugins/datatable/js/dataTables.bootstrap5.js"></script>
		<script src="../assets/plugins/datatable/js/dataTables.buttons.min.js"></script>
		<script src="../assets/plugins/datatable/js/buttons.bootstrap5.min.js"></script>
		<script src="../assets/plugins/datatable/js/jszip.min.js"></script>
		<script src="../assets/plugins/datatable/pdfmake/pdfmake.min.js"></script>
		<script src="../assets/plugins/datatable/pdfmake/vfs_fonts.js"></script>
		<script src="../assets/plugins/datatable/js/buttons.html5.min.js"></script>
		<script src="../assets/plugins/datatable/js/buttons.print.min.js"></script>
		<script src="../assets/plugins/datatable/js/buttons.colVis.min.js"></script>
		<script src="../assets/plugins/datatable/dataTables.responsive.min.js"></script>
		<script src="../assets/plugins/datatable/responsive.bootstrap5.min.js"></script>


		<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


		<!-- POPOVER JS -->
		<script src="../assets/js/popover.js"></script>

		<script src="../assets/js/themecolor.js"></script>
		<script src="../assets/js/custom.js"></script>		

		<!--INTERNAL  INDEX JS -->
		<script src="../assets/js/index.js"></script>




		
	</body>

</html>



	<!-- Mascaras JS -->
<script type="text/javascript" src="js/mascaras.js"></script>

<!-- Ajax para funcionar Mascaras JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script> 


<script type="text/javascript">
	$(document).on('select2:open', () => {
					document.querySelector('.select2-search__field').focus();
				});	
</script>

