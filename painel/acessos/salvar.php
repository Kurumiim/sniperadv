<?php 
$tabela = 'acessos';
require_once("../../../conexao.php");

if($alterar_acessos != 'Sim'){
	echo 'Você não tem permissão para alterar os acessos!';
	exit();
}

$nome = $_POST['nome'];
$chave = $_POST['chave'];
$grupo = $_POST['grupo'];
$id = $_POST['id'];
$pagina = $_POST['pagina'];

//validacao nome
$query = $pdo->query("SELECT * from $tabela where nome = '$nome'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$id_reg = @$res[0]['id'];
if(@count($res) > 0 and $id != $id_reg){
	//echo 'Nome já Cadastrado!';
	//exit();
}


if($id == ""){
$query = $pdo->prepare("INSERT INTO $tabela SET nome = :nome, chave = :chave, grupo = :grupo, pagina = :pagina ");
	
}else{
$query = $pdo->prepare("UPDATE $tabela SET nome = :nome, chave = :chave, grupo = :grupo, pagina = :pagina where id = '$id'");
}
$query->bindValue(":nome", "$nome");
$query->bindValue(":chave", "$chave");
$query->bindValue(":grupo", "$grupo");
$query->bindValue(":pagina", "$pagina");
$query->execute();

echo 'Salvo com Sucesso';
 ?>