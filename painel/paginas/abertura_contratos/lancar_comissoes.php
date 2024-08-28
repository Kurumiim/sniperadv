<?php 
if($valor_escritorio > 0 ){
$desc_contrato = $nova_numeracao.' '.$valor_escritorio.'%';
$valor_n = $valor_entrada * $valor_escritorio / 100;	
$pdo->query("INSERT INTO receber set descricao = '$desc_contrato', cliente = '$cliente', valor = '$valor_n', usuario_lanc = '$id_usuario', data_lanc = curDate(), vencimento = '$data_do_venc' $sql_data_pgto , frequencia = '0', forma_pgto = '$forma_pgto', arquivo = 'sem-foto.png' $sql_usuario_pgto , pago = '$esta_pago', referencia = 'Abertura Contrato', id_ref = '$ult_id', subtotal = '$valor_n', usuario_receb = '0', hora = curTime(), caixa = '$id_caixa' $sql_parcela");
}

if($valor_advogado1 > 0 ){
	$desc_contrato = $nova_numeracao.' '.$valor_advogado1.'%';
	$valor_n = $valor_entrada * $valor_advogado1 / 100;
	$pdo->query("INSERT INTO receber set descricao = '$desc_contrato', cliente = '$cliente', valor = '$valor_n', usuario_lanc = '$id_usuario', data_lanc = curDate(), vencimento = '$data_do_venc' $sql_data_pgto , frequencia = '0', forma_pgto = '$forma_pgto', arquivo = 'sem-foto.png' $sql_usuario_pgto , pago = '$esta_pago', referencia = 'Abertura Contrato', id_ref = '$ult_id', subtotal = '$valor_n', usuario_receb = '$advogado1', hora = curTime(), caixa = '$id_caixa' $sql_parcela");
}

if($valor_advogado2 > 0 ){
	$desc_contrato = $nova_numeracao.' '.$valor_advogado2.'%';
	$valor_n = $valor_entrada * $valor_advogado2 / 100;
	$pdo->query("INSERT INTO receber set descricao = '$desc_contrato', cliente = '$cliente', valor = '$valor_n', usuario_lanc = '$id_usuario', data_lanc = curDate(), vencimento = '$data_do_venc' $sql_data_pgto , frequencia = '0', forma_pgto = '$forma_pgto', arquivo = 'sem-foto.png' $sql_usuario_pgto , pago = '$esta_pago', referencia = 'Abertura Contrato', id_ref = '$ult_id', subtotal = '$valor_n', usuario_receb = '$advogado2', hora = curTime(), caixa = '$id_caixa' $sql_parcela");
}

if($valor_advogado3 > 0 ){
	$desc_contrato = $nova_numeracao.' '.$valor_advogado3.'%';
	$valor_n = $valor_entrada * $valor_advogado3 / 100;
	$pdo->query("INSERT INTO receber set descricao = '$desc_contrato', cliente = '$cliente', valor = '$valor_n', usuario_lanc = '$id_usuario', data_lanc = curDate(), vencimento = '$data_do_venc' $sql_data_pgto , frequencia = '0', forma_pgto = '$forma_pgto', arquivo = 'sem-foto.png' $sql_usuario_pgto , pago = '$esta_pago', referencia = 'Abertura Contrato', id_ref = '$ult_id', subtotal = '$valor_n', usuario_receb = '$advogado3', hora = curTime(), caixa = '$id_caixa' $sql_parcela");
}

if($valor_marketing > 0){
	$desc_contrato = $nova_numeracao.' '.$valor_marketing.'%';
	$valor_n = $valor_entrada * $valor_marketing / 100;
	$pdo->query("INSERT INTO receber set descricao = '$desc_contrato', cliente = '$cliente', valor = '$valor_n', usuario_lanc = '$id_usuario', data_lanc = curDate(), vencimento = '$data_do_venc' $sql_data_pgto , frequencia = '0', forma_pgto = '$forma_pgto', arquivo = 'sem-foto.png' $sql_usuario_pgto , pago = '$esta_pago', referencia = 'Abertura Contrato', id_ref = '$ult_id', subtotal = '$valor_n', usuario_receb = '$marketing', hora = curTime(), caixa = '$id_caixa' $sql_parcela");
}

if($valor_indicacao > 0 ){
	$desc_contrato = $nova_numeracao.' '.$valor_indicacao.'%';
	$valor_n = $valor_entrada * $valor_indicacao / 100;
	$pdo->query("INSERT INTO receber set descricao = '$desc_contrato', cliente = '$cliente', valor = '$valor_n', usuario_lanc = '$id_usuario', data_lanc = curDate(), vencimento = '$data_do_venc' $sql_data_pgto , frequencia = '0', forma_pgto = '$forma_pgto', arquivo = 'sem-foto.png' $sql_usuario_pgto , pago = '$esta_pago', referencia = 'Abertura Contrato', id_ref = '$ult_id', subtotal = '$valor_n', usuario_receb = '$indicacao', hora = curTime(), caixa = '$id_caixa' $sql_parcela");
}

if($valor_pessoa1 > 0 ){
	$desc_contrato = $nova_numeracao.' '.$valor_pessoa1.'%';
	$valor_n = $valor_entrada * $valor_pessoa1 / 100;
	$pdo->query("INSERT INTO receber set descricao = '$desc_contrato', cliente = '$cliente', valor = '$valor_n', usuario_lanc = '$id_usuario', data_lanc = curDate(), vencimento = '$data_do_venc' $sql_data_pgto , frequencia = '0', forma_pgto = '$forma_pgto', arquivo = 'sem-foto.png' $sql_usuario_pgto , pago = '$esta_pago', referencia = 'Abertura Contrato', id_ref = '$ult_id', subtotal = '$valor_n', usuario_receb = '$pessoa1', hora = curTime(), caixa = '$id_caixa' $sql_parcela");
}

if($valor_pessoa2 > 0 ){
	$desc_contrato = $nova_numeracao.' '.$valor_pessoa2.'%';
	$valor_n = $valor_entrada * $valor_pessoa2 / 100;
	$pdo->query("INSERT INTO receber set descricao = '$desc_contrato', cliente = '$cliente', valor = '$valor_n', usuario_lanc = '$id_usuario', data_lanc = curDate(), vencimento = '$data_do_venc' $sql_data_pgto , frequencia = '0', forma_pgto = '$forma_pgto', arquivo = 'sem-foto.png $sql_usuario_pgto , pago = '$esta_pago', referencia = 'Abertura Contrato', id_ref = '$ult_id', subtotal = '$valor_n', usuario_receb = '$pessoa2', hora = curTime(), caixa = '$id_caixa' $sql_parcela");
}
 ?>