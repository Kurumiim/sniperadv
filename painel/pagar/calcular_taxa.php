<?php 

require_once("../../../conexao.php");

$valor = $_POST['valor'];
$pgto = $_POST['pgto'];

$query = $pdo->query("SELECT * FROM formas_pgto where id = '$pgto'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$taxa = $res[0]['taxa'];

$taxa_conta = $taxa * $valor / 100;

echo $taxa_conta;
?>