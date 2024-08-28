<?php 

//validacao
if($cliente == '' || $cliente == '0'){
	echo 'Selecione um Cliente!';
	exit();
}

if($parcelas > 1){
	if($frequencia <=0){
		echo 'Selecione uma Frequência!';
		exit();
	}
}


if($valor == ""){
	echo "Preencha um valor!";
	exit();
}

if($valor_entrada == ""){
	$valor_entrada = 0;
}

if($valor_advogado1 == ""){
	$valor_advogado1 = 0;
}

if($valor_advogado2 == ""){
	$valor_advogado2 = 0;
}

if($valor_advogado3 == ""){
	$valor_advogado3 = 0;
}

if($valor_indicacao == ""){
	$valor_indicacao = 0;
}

if($valor_marketing == ""){
	$valor_marketing = 0;
}

if($valor_pessoa1 == ""){
	$valor_pessoa1 = 0;
}

if($valor_pessoa2 == ""){
	$valor_pessoa2 = 0;
}


if($valor_advogado1 > 0 and $advogado1 == "0"){
	echo 'Selecione um Advogado 1!';
	exit();
}

if($valor_advogado2 > 0 and $advogado2 == "0"){
	echo 'Selecione um Advogado 2!';
	exit();
}

if($valor_advogado3 > 0 and $advogado3 == "0"){
	echo 'Selecione um Advogado 1!';
	exit();
}

if($valor_marketing > 0 and $marketing == "0"){
	echo 'Selecione um Usuário Marketing !';
	exit();
}

if($valor_indicacao > 0 and $indicacao == "0"){
	echo 'Selecione um Usuário Indicação!';
	exit();
}

if($valor_pessoa1 > 0 and $pessoa1 == "0"){
	echo 'Selecione uma Pessoa 1!';
	exit();
}

if($valor_pessoa2 > 0 and $pessoa2 == "0"){
	echo 'Selecione uma Pessoa 2!';
	exit();
}

 ?>