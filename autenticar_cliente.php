<?php 
@session_set_cookie_params(['httponly' => true]);
@session_start();
@session_regenerate_id(true);
require_once("conexao.php");


$cpf = filter_var(@$_POST['cpf'], @FILTER_SANITIZE_STRING);
$senha = filter_var(@$_POST['senha'], @FILTER_SANITIZE_STRING);


$query = $pdo->prepare("SELECT * from clientes where cpf = :cpf order by id asc limit 1");
$query->bindValue(":cpf", "$cpf");
$query->execute();
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){	

	if(!password_verify($senha, $res[0]['senha'])){
		echo '<script>window.alert("Dados Incorretos!!")</script>'; 
		echo '<script>window.location="acesso.php"</script>';  
		exit();
	}

	$_SESSION['cpf_cliente'] = $res[0]['cpf'];
	$_SESSION['id_cliente'] = $res[0]['id'];	
	$_SESSION['aut_token_085'] = 'xss_010204';	

	echo '<script>window.location="painel_cliente"</script>';

}else{
	$_SESSION['msg'] = 'CPF Sem Acesso!'; 
	echo '<script>window.location="acesso"</script>';  
}


 ?>

