<?php 
@session_start();
unset($_SESSION['id_cliente'], $_SESSION['cpf_cliente']);
$_SESSION['msg'] = "Deslogado com sucesso";
echo '<script>window.location="../acesso"</script>';

?>