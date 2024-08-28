<?php 
$tabela = 'tarefas';
require_once("../../../conexao.php");

$id = $_POST['id'];

$query = $pdo->query("SELECT * FROM $tabela where id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$hash = @$res[0]['hash'];

if($hash != ""){
	require("../../apis/cancelar_agendamento.php");
}


$pdo->query("DELETE FROM $tabela WHERE id = '$id' ");
echo 'Excluído com Sucesso';
?>