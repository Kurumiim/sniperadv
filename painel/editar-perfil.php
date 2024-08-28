<?php 
$tabela = 'usuarios';
require_once("../conexao.php");

$nome = $_POST['nome'];
$email = $_POST['email'];
$telefone = $_POST['telefone'];
$conf_senha = $_POST['conf_senha'];
$endereco = $_POST['endereco'];
$senha = $_POST['senha'];
$senha_crip = password_hash($senha, PASSWORD_DEFAULT);
$id = $_POST['id_usuario'];

$nacionalidade = $_POST['nacionalidade'];
$estado_civil = $_POST['estado_civil'];
$endereco_profissional = $_POST['endereco_profissional'];
$seccional_oab = $_POST['seccional_oab'];
$numero_oab = $_POST['numero_oab'];

if($conf_senha != $senha){
	echo 'As senhas não se coincidem';
	exit();
}

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




//validar troca da foto
$query = $pdo->query("SELECT * FROM $tabela where id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
	$foto = $res[0]['foto'];
}else{
	$foto = 'sem-foto.jpg';
}



//SCRIPT PARA SUBIR FOTO NO SERVIDOR
$nome_img = date('d-m-Y H:i:s') .'-'.@$_FILES['foto']['name'];
$nome_img = preg_replace('/[ :]+/' , '-' , $nome_img);

$caminho = 'images/perfil/' .$nome_img;

$imagem_temp = @$_FILES['foto']['tmp_name']; 

if(@$_FILES['foto']['name'] != ""){
	$ext = pathinfo($nome_img, PATHINFO_EXTENSION);   
	if($ext == 'png' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'gif' or $ext == 'webp' or $ext == 'PNG' or $ext == 'JPG' or $ext == 'JPEG' or $ext == 'GIF' or $ext == 'WEBP'){ 
	
			//EXCLUO A FOTO ANTERIOR
			if($foto != "sem-foto.jpg"){
				@unlink('images/perfil/'.$foto);
			}

			$foto = $nome_img;
		
			//pegar o tamanho da imagem
			list($largura, $altura) = getimagesize($imagem_temp);
		 	if($largura > 1400){
		 		$image = imagecreatefromjpeg($imagem_temp);
		        // Reduza a qualidade para 20% ajuste conforme necessário
		        imagejpeg($image, $caminho, 20);
		        imagedestroy($image);
		 	}else{
		 		move_uploaded_file($imagem_temp, $caminho);
		 	}
	}else{
		echo 'Extensão de Imagem não permitida!';
		exit();
	}
}



$query = $pdo->prepare("UPDATE $tabela SET nome = :nome, email = :email, telefone = :telefone, senha_crip = '$senha_crip', endereco = :endereco, foto = '$foto', nacionalidade = :nacionalidade, estado_civil = :estado_civil, endereco_profissional = :endereco_profissional, seccional_oab = :seccional_oab, numero_oab = :numero_oab where id = '$id'");

$query->bindValue(":nome", "$nome");
$query->bindValue(":email", "$email");
$query->bindValue(":telefone", "$telefone");
$query->bindValue(":endereco", "$endereco");
$query->bindValue(":nacionalidade", "$nacionalidade");
$query->bindValue(":estado_civil", "$estado_civil");
$query->bindValue(":endereco_profissional", "$endereco_profissional");
$query->bindValue(":seccional_oab", "$seccional_oab");
$query->bindValue(":numero_oab", "$numero_oab");
$query->execute();

echo 'Editado com Sucesso';
 ?>