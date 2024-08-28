<?php 
$tabela = 'tipos_servicos';
require_once("../../../conexao.php");

$nome = $_POST['nome'];
$id = $_POST['id'];

//validacao nome
$query = $pdo->query("SELECT * from $tabela where nome = '$nome'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$id_reg = @$res[0]['id'];
if(@count($res) > 0 and $id != $id_reg){
	echo 'Nome já Cadastrado!';
	exit();
}


if($id == ""){
$query = $pdo->prepare("INSERT INTO $tabela SET nome = :nome ");
	
}else{
$query = $pdo->prepare("UPDATE $tabela SET nome = :nome where id = '$id'");
}
$query->bindValue(":nome", "$nome");

$query->execute();

echo 'Salvo com Sucesso';
 ?>