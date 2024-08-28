<?php 
@session_start();
$id_usuario = @$_SESSION['id'];
$tabela = 'usuarios';
require_once("../../../conexao.php");

$nome = filter_var($_POST['nome'], @FILTER_SANITIZE_STRING);
$email = filter_var($_POST['email'], @FILTER_SANITIZE_STRING);
$telefone = filter_var($_POST['telefone'], @FILTER_SANITIZE_STRING);
$nivel = filter_var($_POST['nivel'], @FILTER_SANITIZE_STRING);
$endereco = filter_var($_POST['endereco'], @FILTER_SANITIZE_STRING);
$senha = '123';
$senha_crip = password_hash($senha, PASSWORD_DEFAULT);
$chave_pix = filter_var($_POST['chave_pix'], @FILTER_SANITIZE_STRING);
$id = filter_var(@$_POST['id'], @FILTER_SANITIZE_STRING);
$especialidade = filter_var($_POST['especialidade'], @FILTER_SANITIZE_STRING);

$nacionalidade = filter_var($_POST['nacionalidade'], @FILTER_SANITIZE_STRING);
$estado_civil = filter_var($_POST['estado_civil'], @FILTER_SANITIZE_STRING);
$endereco_profissional = filter_var($_POST['endereco_profissional'], @FILTER_SANITIZE_STRING);
$seccional_oab = filter_var($_POST['seccional_oab'], @FILTER_SANITIZE_STRING);
$numero_oab = filter_var($_POST['numero_oab'], @FILTER_SANITIZE_STRING);
$visto_por = filter_var($_POST['visto_por'], @FILTER_SANITIZE_STRING);
//validacao email
$query = $pdo->query("SELECT * from $tabela where email = '$email'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$id_reg = @$res[0]['id'];
if(@count($res) > 0 and $id != $id_reg){
	echo 'Email já Cadastrado!';
	exit();
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



if($id == ""){
$query = $pdo->prepare("INSERT INTO $tabela SET nome = :nome, email = :email, senha_crip = '$senha_crip', nivel = :nivel, ativo = 'Sim', foto = 'sem-foto.jpg', telefone = :telefone, data = curDate(), endereco = :endereco, pix = :chave_pix, especialidade = :especialidade, nacionalidade = :nacionalidade, estado_civil = :estado_civil, endereco_profissional = :endereco_profissional, seccional_oab = :seccional_oab, numero_oab = :numero_oab, usuario_lanc = '$id_usuario', visto_por = :visto_por, mostrar_registros = 'Não' ");
	
}else{
$query = $pdo->prepare("UPDATE $tabela SET nome = :nome, email = :email, nivel = :nivel, telefone = :telefone, endereco = :endereco, pix = :chave_pix, especialidade = :especialidade, nacionalidade = :nacionalidade, estado_civil = :estado_civil, endereco_profissional = :endereco_profissional, seccional_oab = :seccional_oab, numero_oab = :numero_oab, visto_por = :visto_por, mostrar_registros = 'Não' where id = '$id'");
}
$query->bindValue(":nome", "$nome");
$query->bindValue(":email", "$email");
$query->bindValue(":telefone", "$telefone");
$query->bindValue(":endereco", "$endereco");
$query->bindValue(":chave_pix", "$chave_pix");
$query->bindValue(":especialidade", "$especialidade");
$query->bindValue(":nacionalidade", "$nacionalidade");
$query->bindValue(":estado_civil", "$estado_civil");
$query->bindValue(":endereco_profissional", "$endereco_profissional");
$query->bindValue(":seccional_oab", "$seccional_oab");
$query->bindValue(":numero_oab", "$numero_oab");
$query->bindValue(":visto_por", "$visto_por");
$query->bindValue(":nivel", "$nivel");
$query->execute();

echo 'Salvo com Sucesso';


 ?>
