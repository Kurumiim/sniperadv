<?php 
require_once("../../../conexao.php");

$id_usuario = $_POST['id_usuario'];

$pdo->query("DELETE FROM usuarios_permissoes where usuario = '$id_usuario'");

?>