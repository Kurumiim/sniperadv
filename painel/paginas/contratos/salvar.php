<?php 
$tabela = 'contratos';
require_once("../../../conexao.php");

$modelo = $_POST['modelo'];
$texto = $_POST['texto'];
$id = $_POST['id'];



if($texto == ''){
	echo 'Preecha o texto do contrato!';
	exit();
}

if($id == ""){
$query = $pdo->prepare("INSERT INTO $tabela SET modelo = :modelo, texto = :texto");
	
}else{
$query = $pdo->prepare("UPDATE $tabela SET modelo = :modelo, texto = :texto where id = '$id'");
}
$query->bindValue(":modelo", "$modelo");
$query->bindValue(":texto", "$texto");
$query->execute();

echo 'Salvo com Sucesso';
 ?>