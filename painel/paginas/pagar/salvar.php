<?php 
@session_start();
$id_usuario = @$_SESSION['id'];
$nivel_usuario = @$_SESSION['nivel'];

$tabela = 'pagar';
require_once("../../../conexao.php");

$descricao = $_POST['descricao'];
$valor = $_POST['valor'];
$fornecedor = $_POST['fornecedor'];
$funcionario = $_POST['funcionario'];
$vencimento = $_POST['vencimento'];
$data_pgto = $_POST['data_pgto'];
$forma_pgto = $_POST['forma_pgto'];
$frequencia = $_POST['frequencia'];
$obs = $_POST['obs'];
$usuario_receb = @$_POST['usuario_receb'];
$id = $_POST['id'];

if($nivel_usuario == 'Administrador' || $nivel_usuario == 'Escritório'){
	$usuario_receb = 0;
}

$valor = str_replace(',', '.', $valor);

$valorF = @number_format($valor, 2, ',', '.');

if($fornecedor == ""){
	$fornecedor = 0;
}

if($funcionario == ""){
	$funcionario = 0;
}

if($forma_pgto == ""){
	$forma_pgto = 0;
}

if($frequencia == ""){
	$frequencia = 0;
}

if($data_pgto == ""){
	$pgto = '';
	$usu_pgto = '';
	$pago = 'Não';
}else{
	$pgto = " ,data_pgto = '$data_pgto'";
	$usu_pgto = " ,usuario_pgto = '$id_usuario'";
	$pago = 'Sim';
}

//validacao
if($descricao == "" and $fornecedor == "0" and $funcionario == "0"){
	echo 'Selecione um Fornecedor ou um Funcionário ou uma Descrição!';
	exit();
}

if($fornecedor != "0" and $funcionario != "0"){
	echo 'Selecione um Fornecedor ou um Funcionário!';
	exit();
}



//validar troca da foto
$query = $pdo->query("SELECT * FROM $tabela where id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
	$foto = $res[0]['arquivo'];
}else{
	$foto = 'sem-foto.png';
}



//SCRIPT PARA SUBIR FOTO NO SERVIDOR
$nome_img = date('d-m-Y H:i:s') .'-'.@$_FILES['foto']['name'];
$nome_img = preg_replace('/[ :]+/' , '-' , $nome_img);

$caminho = '../../images/contas/' .$nome_img;

$imagem_temp = @$_FILES['foto']['tmp_name']; 

if(@$_FILES['foto']['name'] != ""){
	$ext = pathinfo($nome_img, PATHINFO_EXTENSION);   
	if($ext == 'png' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'gif' or $ext == 'pdf' or $ext == 'rar' or $ext == 'zip' or $ext == 'doc' or $ext == 'docx' or $ext == 'webp' or $ext == 'PNG' or $ext == 'JPG' or $ext == 'JPEG' or $ext == 'GIF' or $ext == 'PDF' or $ext == 'RAR' or $ext == 'ZIP' or $ext == 'DOC' or $ext == 'DOCX' or $ext == 'WEBP' or $ext == 'xlsx' or $ext == 'xlsm' or $ext == 'xls' or $ext == 'xml'){ 
	
			//EXCLUO A FOTO ANTERIOR
			if($foto != "sem-foto.png"){
				@unlink('../../images/contas/'.$foto);
			}

			$foto = $nome_img;
		
		//pegar o tamanho da imagem
			list($largura, $altura) = getimagesize($imagem_temp);
		 	if($largura > 1400){
		 		if($ext == 'png' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'gif' or $ext == 'webp' or $ext == 'PNG' or $ext == 'JPG' or $ext == 'JPEG' or $ext == 'GIF' or $ext == 'PDF' or $ext == 'RAR' or $ext == 'WEBP'){
		 			$image = imagecreatefromjpeg($imagem_temp);
			        // Reduza a qualidade para 20% ajuste conforme necessário
			        imagejpeg($image, $caminho, 20);
			        imagedestroy($image);
		 		}else{
		 			move_uploaded_file($imagem_temp, $caminho);
		 		}
			 		
		 	}else{
		 		move_uploaded_file($imagem_temp, $caminho);
		 	}
	}else{
		echo 'Extensão de Imagem não permitida!';
		exit();
	}
}



if($fornecedor != 0 || $funcionario != 0){
	if($fornecedor != 0){
		$tab = 'fornecedores';
		$id_pessoa = $fornecedor;
	}

	if($funcionario != 0){
		$tab = 'usuarios';
		$id_pessoa = $funcionario;
	}

	//nome pessoa
	$query = $pdo->query("SELECT * FROM $tab where id = '$id_pessoa'");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);
	if($total_reg > 0){
		$nome_pessoa = $res[0]['nome'];
	}else{
		$nome_pessoa = '';
	}

	if($descricao == ""){
		$descricao = $nome_pessoa;
	}
	
}


//verificar caixa aberto
$query1 = $pdo->query("SELECT * from caixas where operador = '$id_usuario' and data_fechamento is null order by id desc limit 1");
$res1 = $query1->fetchAll(PDO::FETCH_ASSOC);
if(@count($res1) > 0){
	$id_caixa = @$res1[0]['id'];
}else{
	$id_caixa = 0;
}
//  

if($id == ""){
$query = $pdo->prepare("INSERT INTO $tabela SET descricao = :descricao, fornecedor = :fornecedor, funcionario = :funcionario, valor = :valor, vencimento = '$vencimento' $pgto, data_lanc = curDate(), forma_pgto = '$forma_pgto', frequencia = '$frequencia', obs = :obs, arquivo = '$foto', subtotal = :valor, usuario_lanc = '$id_usuario' $usu_pgto, pago = '$pago', referencia = 'Conta', caixa = '$id_caixa', hora = curTime(), usuario_receb = :usuario_receb ");

	
}else{
$query = $pdo->prepare("UPDATE $tabela SET descricao = :descricao, fornecedor = :fornecedor, funcionario = :funcionario, valor = :valor, vencimento = '$vencimento' $pgto, forma_pgto = '$forma_pgto', frequencia = '$frequencia', obs = :obs, arquivo = '$foto', subtotal = :valor, usuario_receb = :usuario_receb where id = '$id'");
}
$query->bindValue(":descricao", "$descricao");
$query->bindValue(":fornecedor", "$fornecedor");
$query->bindValue(":funcionario", "$funcionario");
$query->bindValue(":valor", "$valor");
$query->bindValue(":obs", "$obs");
$query->bindValue(":usuario_receb", "$usuario_receb");
$query->execute();
$ultimo_id = $pdo->lastInsertId();

if($id == ""){

	//enviar whatsapp
if($api_whatsapp != 'Não' and $telefone_sistema != ''){

	$telefone_envio = '55'.preg_replace('/[ ()-]+/' , '' , $telefone_sistema);
	$mensagem_whatsapp = '💰 *'.$nome_sistema.'*%0A';
	$mensagem_whatsapp .= '_Conta Vencendo Hoje_ %0A';
	$mensagem_whatsapp .= '*Descrição:* '.$descricao.' %0A';
	$mensagem_whatsapp .= '*Valor:* '.$valorF.' %0A';	
	
	$data_agd = $vencimento.' 08:00:00';
	require('../../apis/agendar.php');

	$pdo->query("UPDATE $tabela SET hash = '$hash' where id = '$ultimo_id'");
	
}

}

echo 'Salvo com Sucesso';
 ?>