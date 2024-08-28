<?php 
$tabela = 'receber';
require_once("../../../conexao.php");
@session_start();
$id_usuario = @$_SESSION['id'];

$id = $_POST['id-valor'];
$valor = $_POST['valor'];
$data = $_POST['data'];
$forma_pgto = $_POST['forma_pgto'];


//verificar caixa aberto
$query1 = $pdo->query("SELECT * from caixas where operador = '$id_usuario' and data_fechamento is null order by id desc limit 1");
$res1 = $query1->fetchAll(PDO::FETCH_ASSOC);
if(@count($res1) > 0){
	$id_caixa = @$res1[0]['id'];
}else{
	$id_caixa = 0;
}

//buscar valores do processo
$query1 = $pdo->query("SELECT * from processos where id = '$id'");
$res1 = $query1->fetchAll(PDO::FETCH_ASSOC);
$cliente = @$res1[0]['cliente'];


$query = $pdo->prepare("INSERT INTO $tabela SET descricao = 'Valor Processo', cliente = '$cliente', valor = :valor, vencimento = '$data', data_pgto = '$data', data_lanc = curDate(), forma_pgto = '$forma_pgto', frequencia = '0', arquivo = 'sem-foto.png', subtotal = :valor, usuario_lanc = '$id_usuario', usuario_pgto = '$id_usuario', pago = 'Sim', referencia = 'Processo', id_ref = '$id', caixa = '$id_caixa', hora = curTime() ");

$query->bindValue(":valor", "$valor");
$query->execute();

echo 'Inserido com Sucesso';

?>