<?php 
@session_start();
if (@$_SESSION['cpf_cliente'] == ""){
	echo '<script>window.location="../"</script>';
	exit();
}

if (@$_SESSION['aut_token_085'] != "xss_010204"){
	echo '<script>window.location="../"</script>';
	exit();
}

 ?>
