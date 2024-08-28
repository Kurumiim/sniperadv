<?php 
require_once("../../../conexao.php");
require_once("../../rel/data_formatada.php");

$contrato = @$_POST['contrato'];
$cliente = @$_POST['cliente'];
$profissional = @$_POST['profissional'];
$servico = @$_POST['servico'];

$query = $pdo->query("SELECT * from clientes where id = '$cliente'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
if(@count($res) > 0){

$nome_cliente = @$res[0]['nome'];
$telefone_cliente = @$res[0]['telefone'];
$email_cliente = @$res[0]['email'];	
$endereco_cliente = @$res[0]['endereco'];
$tipo_pessoa_cliente = @$res[0]['tipo_pessoa'];
$cpf_cliente = @$res[0]['cpf'];

$numero_cliente = @$res[0]['numero'];
$bairro_cliente = @$res[0]['bairro'];
$cidade_cliente = @$res[0]['cidade'];
$estado_cliente = @$res[0]['estado'];
$cep_cliente = @$res[0]['cep'];
$profissao_cliente = @$res[0]['profissao'];
$nacionalidade_cliente = @$res[0]['nacionalidade'];
$estado_civil_cliente = @$res[0]['estado_civil'];


$rg_cliente = @$res[0]['rg'];
$complemento_cliente = @$res[0]['complemento'];
$genitor_cliente = @$res[0]['genitor'];
$genitora_cliente = @$res[0]['genitora'];

$data_cad_cliente = @$res[0]['data_cad'];
$data_nasc_cliente = @$res[0]['data_nasc'];


$data_cadF_cliente = implode('/', array_reverse(@explode('-', $data_cad_cliente)));
$data_nascF_cliente = implode('/', array_reverse(@explode('-', $data_nasc_cliente)));
	
}



$query = $pdo->query("SELECT * from contratos where id = '$contrato'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
if(@count($res) > 0){
	$modelo_contrato = @$res[0]['modelo'];
	$texto_contrato = @$res[0]['texto'];
}


$query = $pdo->query("SELECT * from usuarios where id = '$profissional'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
if(@count($res) > 0){
	$nome_usuario = @$res[0]['nome'];
	$telefone_usuario = @$res[0]['telefone'];
	$email_usuario = @$res[0]['email'];	
	$endereco_usuario = @$res[0]['endereco_profissional'];
	$nacionalidade_usuario = @$res[0]['nacionalidade'];
	$estado_civil_usuario = @$res[0]['estado_civil'];
	$seccional_oab = @$res[0]['seccional_oab'];
	$numero_oab = @$res[0]['numero_oab'];
}



$query = $pdo->query("SELECT * from abertura_contratos where id = '$servico'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
if(@count($res) > 0){
	$valor_servico = @$res[0]['valor'];
	$forma_pgto = @$res[0]['forma_pgto'];
	$valor_servicoF = 'R$ '.@number_format($valor_servico, 2, ',', '.');

	$query = $pdo->query("SELECT * from formas_pgto where id = '$forma_pgto'");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	if(@count($res) > 0){
		$nome_forma_pgto = @$res[0]['nome'];	
	}
}




//dados cliente
if(@$nome_cliente != ""){
	$texto_contrato = @str_replace('{{NOME COMPLETO}}', @$nome_cliente, @$texto_contrato);
}

if(@$nome_cliente != ""){
	$texto_contrato = @str_replace('{{NOME}}', @$nome_cliente, @$texto_contrato);
}

if(@$nacionalidade_cliente != ""){
	$texto_contrato = @str_replace('{{NACIONALIDADE}}', @$nacionalidade_cliente, @$texto_contrato);
}

if(@$profissao_cliente != ""){
	$texto_contrato = @str_replace('{{PROFISSÃO}}', @$profissao_cliente, @$texto_contrato);
}

if(@$estado_civil_cliente != ""){
	$texto_contrato = @str_replace('{{ESTADO CIVIL}}', @$estado_civil_cliente, @$texto_contrato);
}

if(@$data_nasc_cliente != ""){
	$texto_contrato = @str_replace('{{DATA DE NASCIMENTO}}', @$data_nascF_cliente, @$texto_contrato);
}

if(@$cpf_cliente != ""){
	$texto_contrato = @str_replace('{{NÚMERO DO CPF}}', @$cpf_cliente, @$texto_contrato);
}

if(@$rg_cliente != ""){
	$texto_contrato = @str_replace('{{NÚMERO RG}}', @$rg_cliente, @$texto_contrato);
}

if(@$genitor_cliente != ""){
	$texto_contrato = @str_replace('{{GENITOR}}', @$genitor_cliente, @$texto_contrato);
}

if(@$genitora_cliente != ""){
	$texto_contrato = @str_replace('{{GENITORA}}', @$genitora_cliente, @$texto_contrato);
}

if(@$endereco_cliente != ""){
	$texto_contrato = @str_replace('{{LOGRADOURO}}', @$endereco_cliente, @$texto_contrato);
}

if(@$numero_cliente != ""){
	$texto_contrato = @str_replace('{{NÚMERO LOGRADOURO}}', @$numero_cliente, @$texto_contrato);
}

if(@$bairro_cliente != ""){
	$texto_contrato = @str_replace('{{BAIRRO}}', @$bairro_cliente, @$texto_contrato);
}


if(@$cidade_cliente != ""){
	$texto_contrato = @str_replace('{{MUNICÍPIO}}', @$cidade_cliente, @$texto_contrato);
}

if(@$estado_cliente != ""){
	$texto_contrato = @str_replace('{{ESTADO}}', @$estado_cliente, @$texto_contrato);
}

if(@$cep_cliente != ""){
	$texto_contrato = @str_replace('{{CEP}}', @$cep_cliente, @$texto_contrato);
}

if(@$email_cliente != ""){
	$texto_contrato = @str_replace('{{EMAIL}}', @$email_cliente, @$texto_contrato);
}

if(@$telefone_cliente != ""){
	$texto_contrato = @str_replace('{{TELEFONE}}', @$telefone_cliente, @$texto_contrato);
}






//dados segunda pessoa contrato

if(@$nome_usuario != ""){
	$texto_contrato = @str_replace('{{NOME2}}', @$nome_usuario, @$texto_contrato);
}

if(@$nacionalidade_usuario != ""){
	$texto_contrato = @str_replace('{{NACIONALIDADE2}}', @$nacionalidade_usuario, @$texto_contrato);
}

if(@$estado_civil_usuario != ""){
	$texto_contrato = @str_replace('{{ESTADO CIVIL2}}', @$estado_civil_usuario, @$texto_contrato);
}

if(@$seccional_oab != ""){
	$texto_contrato = @str_replace('{{SECCIONAL OAB}}', @$seccional_oab, @$texto_contrato);
}

if(@$numero_oab != ""){
	$texto_contrato = @str_replace('{{NÚMERO OAB}}', @$numero_oab, @$texto_contrato);
}

if(@$endereco_usuario != ""){
	$texto_contrato = @str_replace('{{ENDERECO2}}', @$endereco_usuario, @$texto_contrato);
}





if(@$cidade_sistema != ""){
	$texto_contrato = @str_replace('{{LOCAL}}', @$cidade_sistema, @$texto_contrato);
}


if(@$data_hoje != ""){
	$texto_contrato = @str_replace('{{DATA}}', @$data_hoje, @$texto_contrato);
}


if(@$nome_sistema != ""){
	$texto_contrato = @str_replace('{{NOME DO ESCRITÓRIO}}', @$nome_sistema, @$texto_contrato);
}


if(@$nome_sistema != ""){
	$texto_contrato = @str_replace('{{NOME ESCRITÓRIO}}', @$nome_sistema, @$texto_contrato);
}


if(@$cnpj_sistema != ""){
	$texto_contrato = @str_replace('{{CNPJ}}', @$cnpj_sistema, @$texto_contrato);
}


if(@$seccional_oab_escritorio != ""){
	$texto_contrato = @str_replace('{{SECCIONAL OAB ESCRITORIO}}', @$seccional_oab_escritorio, @$texto_contrato);
}


if(@$numero_oab_escritorio != ""){
	$texto_contrato = @str_replace('{{NÚMERO OAB ESCRITORIO}}', @$numero_oab_escritorio, @$texto_contrato);
}


if(@$endereco_sistema != ""){
	$texto_contrato = @str_replace('{{ENDERECO ESCRITORIO}}', @$endereco_sistema, @$texto_contrato);
}


if(@$dados_pagamento != ""){
	$texto_contrato = @str_replace('{{FORMA PGTO ESCRITORIO}}', @$dados_pagamento, @$texto_contrato);
}


if(@$cidade_sistema != ""){
	$texto_contrato = @str_replace('{{MUNICÍPIO ESCRITORIO}}', @$cidade_sistema, @$texto_contrato);
}


if(@$seccional_oab_escritorio != ""){
	$texto_contrato = @str_replace('{{ESTADO DO FORO}}', @$seccional_oab_escritorio, @$texto_contrato);
}







if(@$valor_servico != ""){
	$texto_contrato = @str_replace('{{VALOR}}', @$valor_servicoF, @$texto_contrato);
}


if(@$nome_forma_pgto != ""){
	$texto_contrato = @str_replace('{{FORMA DE PAGAMENTO}}', @$nome_forma_pgto, @$texto_contrato);
}

echo @$texto_contrato;

?>