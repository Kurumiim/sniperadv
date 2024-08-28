<?php 

$tabela = 'caixas';

require_once("../../../conexao.php");

@session_start();
$id_usuario = @$_SESSION['id'];

$operador = $_POST['operador'];
$valor_abertura = $_POST['valor_abertura'];
$valor_abertura = str_replace(',', '.', $valor_abertura);
$data_abertura = $_POST['data_abertura'];

$obs = $_POST['obs'];

$id = $_POST['id'];

if($id == ""){

	$query = $pdo->prepare("INSERT INTO $tabela SET operador = '$operador', data_abertura = '$data_abertura', valor_abertura = :valor_abertura, usuario_abertura = '$id_usuario', obs = :obs");	

}else{

	$query = $pdo->prepare("UPDATE $tabela SET operador = '$operador', data_abertura = '$data_abertura', valor_abertura = :valor_abertura, usuario_abertura = '$id_usuario', obs = :obs where id = '$id'");

}



$query->bindValue(":valor_abertura", "$valor_abertura");
$query->bindValue(":obs", "$obs");

$query->execute();

echo 'Salvo com Sucesso'; 

?>