<?php 
$tabela = 'clientes';
require_once("../../../conexao.php");

@session_start();

$advogado = filter_var(@$_POST['advogado'], @FILTER_SANITIZE_STRING);
if($advogado == ""){
	$id_usuario = @$_SESSION['id'];
}else{
	$id_usuario = $advogado;
}


filter_var(@$_POST['usuario'], @FILTER_SANITIZE_STRING);
$nome = filter_var($_POST['nome'], @FILTER_SANITIZE_STRING);
$email = filter_var($_POST['email'], @FILTER_SANITIZE_STRING);
$telefone = filter_var($_POST['telefone'], @FILTER_SANITIZE_STRING);
$endereco = filter_var($_POST['endereco'], @FILTER_SANITIZE_STRING);
$data_nasc = filter_var($_POST['data_nasc'], @FILTER_SANITIZE_STRING);
$cpf = filter_var($_POST['cpf'], @FILTER_SANITIZE_STRING);
$tipo_pessoa = filter_var($_POST['tipo_pessoa'], @FILTER_SANITIZE_STRING);
$numero = filter_var($_POST['numero'], @FILTER_SANITIZE_STRING);
$bairro = filter_var($_POST['bairro'], @FILTER_SANITIZE_STRING);
$cidade = filter_var($_POST['cidade'], @FILTER_SANITIZE_STRING);
$estado = filter_var($_POST['estado'], @FILTER_SANITIZE_STRING);
$cep = filter_var($_POST['cep'], @FILTER_SANITIZE_STRING);
$id = filter_var(@$_POST['id'], @FILTER_SANITIZE_STRING);

$rg = filter_var($_POST['rg'], @FILTER_SANITIZE_STRING);
$complemento = filter_var($_POST['complemento'], @FILTER_SANITIZE_STRING);
$genitor = filter_var($_POST['genitor'], @FILTER_SANITIZE_STRING);
$genitora = filter_var($_POST['genitora'], @FILTER_SANITIZE_STRING);

$profissao = filter_var($_POST['profissao'], @FILTER_SANITIZE_STRING);
$nacionalidade = filter_var($_POST['nacionalidade'], @FILTER_SANITIZE_STRING);
$estado_civil = filter_var($_POST['estado_civil'], @FILTER_SANITIZE_STRING);
$indicacao = filter_var($_POST['indicacao'], @FILTER_SANITIZE_STRING);
$visto_por = filter_var(@$_POST['visto_por'], @FILTER_SANITIZE_STRING);

$senha = filter_var(@$_POST['senha'], @FILTER_SANITIZE_STRING);
$conf_senha = filter_var(@$_POST['conf_senha'], @FILTER_SANITIZE_STRING);
$resumo_fatos = filter_var(@$_POST['resumo_fatos'], @FILTER_SANITIZE_STRING);

if($senha != $conf_senha){
	echo 'As senhas não coincidem!!';
	exit();
}


$senha_crip = password_hash($senha, PASSWORD_DEFAULT);

$sql_editar_senha = '';
if($senha == ""){
	$senha = '123';
	$senha_crip = password_hash($senha, PASSWORD_DEFAULT);
}else{
	$sql_editar_senha = " ,senha = '$senha_crip'";
}


if($tipo_pessoa == 'Física' and $cpf != ""){
	require_once("../../validar_cpf.php");
}

$sql_usuario_lanc = '';
if($visto_por != 'Todos'){
	$sql_usuario_lanc = " , usuario = '$id_usuario'";
}

//validacao email
if($email != ""){
	$query = $pdo->prepare("SELECT * from $tabela where email = :email");
	$query->bindValue(":email", "$email");
	$query->execute();
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$id_reg = @$res[0]['id'];
	if(@count($res) > 0 and $id != $id_reg){
		echo 'Email já Cadastrado!';
		exit();
	}
}



//validacao telefone
if($telefone != ""){
	$query = $pdo->prepare("SELECT * from $tabela where telefone = :telefone");
	$query->bindValue(":telefone", "$telefone");
	$query->execute();
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$id_reg = @$res[0]['id'];
	if(@count($res) > 0 and $id != $id_reg){
		echo 'Telefone já Cadastrado!';
		exit();
	}
}


if($data_nasc == ""){
	$nasc = '';	
}else{
	$nasc = " ,data_nasc = '$data_nasc'";
	
}


if($id == ""){
$query = $pdo->prepare("INSERT INTO $tabela SET nome = :nome, email = :email, telefone = :telefone, data_cad = curDate(), endereco = :endereco, cpf = :cpf, tipo_pessoa = :tipo_pessoa $nasc, usuario = '$id_usuario', numero = :numero, bairro = :bairro, cidade = :cidade, estado = :estado, cep = :cep, rg = :rg, complemento = :complemento, genitor = :genitor, genitora = :genitora, profissao = :profissao, nacionalidade = :nacionalidade, estado_civil = :estado_civil, indicacao = :indicacao, visto_por = :visto_por, senha = '$senha_crip', resumo_fatos = :resumo_fatos");

$link_acesso = $url_sistema.'acesso';
//enviar whatsapp
if($api_whatsapp != 'Não' and $telefone != ''){

	$telefone_envio = '55'.preg_replace('/[ ()-]+/' , '' , $telefone);
	$mensagem_whatsapp = '*'.$nome_sistema.'*%0A';
	$mensagem_whatsapp .= '🤩 _Olá '.$nome.' Você foi Cadastrado no Sistema!!_ %0A%0A';
	$mensagem_whatsapp .= 'Você pode fazer o acesso usando seu CPF no link abaixo e a senha '.$senha.', esta senha você pode trocar dentro do painel! %0A';
	$mensagem_whatsapp .= $link_acesso.'%0A';	

	require('../../apis/texto.php');
}

//enviar email
if($email != ''){
	$url_logo = $url_sistema.'img/logo.png';
	$destinatario = $email;
	$assunto = utf8_decode('Cadastrado no sistema '. $nome_sistema);
	$mensagem_email = 'Olá '.$nome.' você foi cadastrado no sistema <br>';
	$mensagem_email .= 'Você pode fazer o acesso usando seu <b>CPF</b> no link abaixo <br><br>';
	$mensagem_email .= '<a href="'.$link_acesso.'">'.$link_acesso. '</a><br><br>';
	$mensagem_email .= "<img src='".$url_logo."' width='200px'> ";
}


require('../../apis/disparar_email.php');
	
}else{
$query = $pdo->prepare("UPDATE $tabela SET nome = :nome, email = :email, telefone = :telefone, endereco = :endereco, cpf = :cpf, tipo_pessoa = :tipo_pessoa $nasc , numero = :numero, bairro = :bairro, cidade = :cidade, estado = :estado, cep = :cep, rg = :rg, complemento = :complemento, genitor = :genitor, genitora = :genitora, profissao = :profissao, nacionalidade = :nacionalidade, estado_civil = :estado_civil, indicacao = :indicacao, visto_por = :visto_por $sql_usuario_lanc $sql_editar_senha where id = '$id'");
}
$query->bindValue(":nome", "$nome");
$query->bindValue(":email", "$email");
$query->bindValue(":telefone", "$telefone");
$query->bindValue(":endereco", "$endereco");
$query->bindValue(":cpf", "$cpf");
$query->bindValue(":tipo_pessoa", "$tipo_pessoa");
$query->bindValue(":numero", "$numero");
$query->bindValue(":bairro", "$bairro");
$query->bindValue(":cidade", "$cidade");
$query->bindValue(":estado", "$estado");
$query->bindValue(":cep", "$cep");
$query->bindValue(":rg", "$rg");
$query->bindValue(":complemento", "$complemento");
$query->bindValue(":genitor", "$genitor");
$query->bindValue(":genitora", "$genitora");
$query->bindValue(":profissao", "$profissao");
$query->bindValue(":estado_civil", "$estado_civil");
$query->bindValue(":nacionalidade", "$nacionalidade");
$query->bindValue(":indicacao", "$indicacao");
$query->bindValue(":visto_por", "$visto_por");
$query->bindValue(":resumo_fatos", "$resumo_fatos");
$query->execute();

echo 'Salvo com Sucesso';


 ?>
