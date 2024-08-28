<?php 
$tabela = 'acessos';
require_once("../../../conexao.php");

if($alterar_acessos != 'Sim'){
	echo 'Você não tem permissão para alterar os acessos!';
	exit();
}

$id = $_POST['id'];

$pdo->query("DELETE FROM $tabela WHERE id = '$id' ");
echo 'Excluído com Sucesso';
?>