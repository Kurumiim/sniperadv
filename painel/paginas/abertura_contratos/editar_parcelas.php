<?php 
@session_start();
$id_usuario = @$_SESSION['id'];
$tabela = 'receber';
require_once("../../../conexao.php");

$id = $_POST['id'];
$valor = $_POST['valor'];
$valor = str_replace(',', '.', $valor);
$descricao = $_POST['descricao'];
$data_venc = $_POST['data_venc'];

$query = $pdo->prepare("UPDATE $tabela SET valor = :valor, descricao = :descricao, vencimento = :data_venc WHERE id = '$id'");
$query->bindValue(":valor", "$valor");
$query->bindValue(":descricao", "$descricao");
$query->bindValue(":data_venc", "$data_venc");
$query->execute();
?>