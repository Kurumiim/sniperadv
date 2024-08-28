<?php 
$tabela = 'pagar';
require_once("../../../conexao.php");

@session_start();
$id_usuario = $_SESSION['id'];

//verificar caixa aberto
$query1 = $pdo->query("SELECT * from caixas where operador = '$id_usuario' and data_fechamento is null order by id desc limit 1");
$res1 = $query1->fetchAll(PDO::FETCH_ASSOC);
if(@count($res1) > 0){
	$id_caixa = @$res1[0]['id'];
}else{
	$id_caixa = 0;
}
//  

$id = $_POST['novo_id'];

$pdo->query("UPDATE $tabela SET data_pgto = curDate(), usuario_pgto = '$id_usuario', pago = 'Sim', caixa = '$id_caixa', hora = curTime() where id = '$id' and pago != 'Sim'");

?>