<?php 
$tabela = 'usuarios';
require_once("../../../conexao.php");

$nome = $_POST['nome'];
$email = $_POST['email'];
$telefone = $_POST['telefone'];
$nivel = $_POST['nivel'];
$endereco = $_POST['endereco'];
$senha = '123';
$senha_crip = password_hash($senha, PASSWORD_DEFAULT);
$id = $_POST['id'];
$mostrar_registros = $_POST['mostrar_registros'];

//validacao email
$query = $pdo->query("SELECT * from $tabela where email = '$email'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$id_reg = @$res[0]['id'];
if(@count($res) > 0 and $id != $id_reg){
	echo 'Email já Cadastrado!';
	exit();
}

//validacao telefone
$query = $pdo->query("SELECT * from $tabela where telefone = '$telefone'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$id_reg = @$res[0]['id'];
if(@count($res) > 0 and $id != $id_reg){
	echo 'Telefone já Cadastrado!';
	exit();
}

if($id == ""){
$query = $pdo->prepare("INSERT INTO $tabela SET nome = :nome, email = :email, senha_crip = '$senha_crip', nivel = '$nivel', ativo = 'Sim', foto = 'sem-foto.jpg', telefone = :telefone, data = curDate(), endereco = :endereco, mostrar_registros = :mostrar_registros ");

//enviar whatsapp
if($api_whatsapp != 'Não' and $telefone != ''){

	$telefone_envio = '55'.preg_replace('/[ ()-]+/' , '' , $telefone);
	$mensagem_whatsapp = '*'.$nome_sistema.'*%0A';
	$mensagem_whatsapp .= '🤩_Olá '.$nome.' Você foi Cadastrado no Sistema!!_ %0A';
	$mensagem_whatsapp .= '*Email:* '.$email.' %0A';
	$mensagem_whatsapp .= '*Senha:* '.$senha.' %0A';
	$mensagem_whatsapp .= '*Url Acesso:* %0A'.$url_sistema.' %0A%0A';
	$mensagem_whatsapp .= '_Ao entrar no sistema, troque sua senha!_';

	require('../../apis/texto.php');
}

//enviar email
if($email != ''){
	$url_logo = $url_sistema.'img/logo.png';
	$destinatario = $email;
	$assunto = utf8_decode('Cadastrado no sistema '. $nome_sistema);
	$mensagem_email = 'Olá '.$nome.' você foi cadastrado no sistema <br>';
	$mensagem_email .= '<b>Usuário</b>: '.$email.'<br>';
	$mensagem_email .= '<b>Senha: </b>'.$senha.'<br><br>';
	$mensagem_email .= 'Url Acesso: <br><a href="'.$url_sistema.'">'.$url_sistema. '</a><br><br>';
	$mensagem_email .= '<i>Ao entrar no sistema, troque sua senha!</i>'. '<br><br>';
	$mensagem_email .= "<img src='".$url_logo."' width='200px'> ";
}


require('../../apis/disparar_email.php');
	
}else{
$query = $pdo->prepare("UPDATE $tabela SET nome = :nome, email = :email, nivel = '$nivel', telefone = :telefone, endereco = :endereco, mostrar_registros = :mostrar_registros  where id = '$id'");
}
$query->bindValue(":nome", "$nome");
$query->bindValue(":email", "$email");
$query->bindValue(":telefone", "$telefone");
$query->bindValue(":endereco", "$endereco");
$query->bindValue(":mostrar_registros", "$mostrar_registros");
$query->execute();

echo 'Salvo com Sucesso';
 ?>