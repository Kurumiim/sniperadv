<?php 
$tabela = 'receber';
require_once("../../../conexao.php");

$id = $_POST['id'];

$query = $pdo->query("SELECT * FROM $tabela where id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$descricao = @$res[0]['descricao'];
$valor = @$res[0]['valor'];
$cliente = @$res[0]['cliente'];
$vencimento = @$res[0]['vencimento'];

$data_atual = date('Y-m-d');

$vencimentoF = implode('/', array_reverse(@explode('-', $vencimento)));
$valorF = @number_format($valor, 2, ',', '.');


$query2 = $pdo->query("SELECT * FROM clientes where id = '$cliente'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
if(@count($res2) > 0){
	$nome_cliente = $res2[0]['nome'];
	$telefone_cliente = $res2[0]['telefone'];
}else{
	$nome_cliente = 'Sem Registro';
	$telefone_cliente = "";
}


if($api_whatsapp != 'Não' and $telefone_cliente != ''){			

			$telefone_envio = '55'.preg_replace('/[ ()-]+/' , '' , $telefone_cliente);
			$mensagem_whatsapp = '*'.$nome_sistema.'*%0A';
			if(strtotime($vencimento) < strtotime($data_atual)){
				$mensagem_whatsapp .= '_Conta Vencida_ %0A';
			}else{
				$mensagem_whatsapp .= '_Lembrete de Pagamento_ %0A';
			}
			
			$mensagem_whatsapp .= '*Descrição:* '.$descricao.' %0A';
			$mensagem_whatsapp .= '*Valor:* '.$valorF.' %0A';	
			$mensagem_whatsapp .= '*Vencimento:* '.$vencimentoF.' %0A%0A';	

			if($dados_pagamento != ""){
				$mensagem_whatsapp .= '*Dados para o Pagamento:* %0A';
				$mensagem_whatsapp .= $dados_pagamento;
			}		
			
			require('../../apis/texto.php');			
			
		}	

echo 'Cobrança Efetuada';
?>