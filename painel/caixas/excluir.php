<?php 

$tabela = 'caixas';

require_once("../../../conexao.php");



@session_start();

$nivel_usuario = @$_SESSION['nivel'];


$id = $_POST['id'];



$query = $pdo->query("SELECT * FROM $tabela where valor_fechamento is not null");

$res = $query->fetchAll(PDO::FETCH_ASSOC);

$total_reg = @count($res);

if($total_reg > 0 and $nivel_usuario != 'Administrador'){

	echo 'Somente um Administrador pode excluir um caixa já fechado!';

	exit();

}




$pdo->query("DELETE FROM $tabela where id = '$id'");



echo 'Excluído com Sucesso';





?>