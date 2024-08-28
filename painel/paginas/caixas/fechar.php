<?php 

$tabela = 'caixas';

require_once("../../../conexao.php");

@session_start();

$id_usuario = $_SESSION['id'];

$data_atual = 'Y-m-d';

$id = $_POST['id'];
$total_caixa_fechar = $_POST['total_caixa_fechar'];
$valor_abertura_fechar = $_POST['valor_abertura_fechar'];


$query2 = $pdo->query("SELECT * FROM caixas where id = '$id'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$operador = @$res2[0]['operador'];
$data_abertura = @$res2[0]['data_abertura'];




//pegar a forma de pagamento dinheiro
$query2 = $pdo->query("SELECT * FROM formas_pgto where nome LIKE '%Dinheiro%'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$pgto_dinheiro = $res2[0]['id'];

//buscar total movimentado pelo caixa
//totalizar recebimentos
$total_recebido = 0;
$query2 = $pdo->query("SELECT * FROM receber where usuario_pgto = '$operador' and data_pgto >= '$data_abertura' and data_pgto <= curDate() and forma_pgto = '$pgto_dinheiro' and financeiro is null and caixa = '$id'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
if(@count($res2) > 0){
	for($i2=0; $i2 < @count($res2); $i2++){
		$valor_rec = $res2[$i2]['valor'];
		$total_recebido += $valor_rec;
	}
}

//totalizar saidas
$total_saidas = 0;
$query2 = $pdo->query("SELECT * FROM pagar where usuario_pgto = '$operador' and data_pgto >= '$data_abertura' and data_pgto <= curDate() and forma_pgto = '$pgto_dinheiro' and caixa = '$id'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
if(@count($res2) > 0){
	for($i2=0; $i2 < @count($res2); $i2++){
		$valor_sai = $res2[$i2]['valor'];
		$total_saidas += $valor_sai;
	}
}


//totalizar sangrias
$total_sangrias = 0;
$query2 = $pdo->query("SELECT * FROM sangrias where caixa = '$id'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
if(@count($res2) > 0){
	for($i2=0; $i2 < @count($res2); $i2++){
		$valor_s = $res2[$i2]['valor'];
		$total_sangrias += $valor_s;
	}
}
$total_sangriasF = number_format($total_sangrias, 2, ',', '.');


$total_do_caixa = $total_recebido - $total_saidas + $valor_abertura_fechar - $total_sangrias;
$valor_quebra = $total_caixa_fechar - $total_do_caixa;

$pdo->query("UPDATE $tabela SET data_fechamento = curDate(), valor_fechamento = '$total_caixa_fechar', quebra = '$valor_quebra', usuario_fechamento = '$id_usuario' where id = '$id'");



echo 'Salvo com Sucesso';



?>



