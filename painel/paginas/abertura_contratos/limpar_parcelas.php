<?php 
@session_start();
$id_usuario = @$_SESSION['id'];
$tabela = 'receber';
require_once("../../../conexao.php");

$pdo->query("DELETE FROM $tabela WHERE referencia = 'Abertura Contrato' and id_ref = '0' and usuario_lanc = '$id_usuario'");

?>