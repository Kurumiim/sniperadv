<?php 
$tabela = 'abertura_contratos';
require_once("../../../conexao.php");

$id = $_POST['id'];

$pdo->query("DELETE FROM $tabela WHERE id = '$id' ");
$pdo->query("DELETE FROM receber WHERE referencia = 'Abertura Contrato' and id_ref = '$id' ");


echo 'Excluído com Sucesso';
?>