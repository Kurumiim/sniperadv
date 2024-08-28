<?php 
require_once("../../../conexao.php");

$id_usuario = $_POST['usuario'];
$id_permissao = $_POST['id'];

$query = $pdo->query("SELECT * FROM usuarios_permissoes where permissao = '$id_permissao' and usuario = '$id_usuario'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
	$pdo->query("DELETE FROM usuarios_permissoes where permissao = '$id_permissao' and usuario = '$id_usuario'");
}else{
	$pdo->query("INSERT INTO usuarios_permissoes SET permissao = '$id_permissao', usuario = '$id_usuario'");
}

?>