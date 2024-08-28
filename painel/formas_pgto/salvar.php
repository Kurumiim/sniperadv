<?php 
require_once("../../../conexao.php");
$tabela = 'formas_pgto';

$id = $_POST['id'];
$nome = $_POST['nome'];
$taxa = $_POST['taxa'];

if($taxa == ""){
	$taxa = 0;
}

//validar nome
$query = $pdo->query("SELECT * from $tabela where nome = '$nome'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
if(@count($res) > 0 and $id != $res[0]['id']){
	echo 'Nome já Cadastrado, escolha outro!!';
	exit();
}


if($id == ""){
	$query = $pdo->prepare("INSERT INTO $tabela SET nome = :nome, taxa = '$taxa'");
}else{
	$query = $pdo->prepare("UPDATE $tabela SET nome = :nome, taxa = '$taxa' WHERE id = '$id'");
}

$query->bindValue(":nome", "$nome");
$query->execute();

echo 'Salvo com Sucesso';
 ?>