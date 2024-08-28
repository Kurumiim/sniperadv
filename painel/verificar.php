<?php 
@session_start();
if (@$_SESSION['id'] == ""){
	echo '<script>window.location="../"</script>';
	exit();
}

if (@$_SESSION['aut_token_075'] != "xss_010203"){
	echo '<script>window.location="../"</script>';
	exit();
}

 ?>
