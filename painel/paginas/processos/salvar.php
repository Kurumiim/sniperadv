<?php 
@session_start();
$id_usuario = @$_SESSION['id'];
$tabela = 'processos';
require_once("../../../conexao.php");

$cliente = $_POST['cliente'];
$valor = $_POST['valor'];
$valor = str_replace(',', '.', $valor);
$tipo_acao = $_POST['tipo_acao'];
$numero_processo = $_POST['numero_processo'];
$status = $_POST['status'];
$segredo_justica = $_POST['segredo_justica'];
$justica_gratuita = $_POST['justica_gratuita'];
$obs = $_POST['obs'];

$orgao_julgador = $_POST['orgao_julgador'];
$data_abertura = $_POST['data_abertura'];

$advogado1 = @$_POST['advogado1'];
$advogado2 = @$_POST['advogado2'];
$advogado3 = @$_POST['advogado3'];
$advogado4 = @$_POST['advogado4'];


$jurisdicao = $_POST['jurisdicao'];
$vara = $_POST['vara'];
$comarca = $_POST['comarca'];


$nome_contraria = $_POST['nome_contraria'];
$cpf_contraria = $_POST['cpf_contraria'];
$rg_contraria = $_POST['rg_contraria'];
$telefone_contraria = $_POST['telefone_contraria'];
$advogado_contraria = $_POST['advogado_contraria'];
$endereco_contraria = $_POST['endereco_contraria'];
$estado_civil_contraria = $_POST['estado_civil_contraria'];

$id = $_POST['id'];


//validacao num processo
if($numero_processo != ""){
	$query = $pdo->query("SELECT * from $tabela where num_processo = '$numero_processo'");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$id_reg = @$res[0]['id'];
	if(@count($res) > 0 and $id != $id_reg){
		echo 'Processo já Cadastrado!';
		exit();
	}
}


if($status == 'Finalizado'){
	$sql_data = ' , data_fechamento = curDate()';
}else{
	$sql_data = '';
}

if($id == ""){
$query = $pdo->prepare("INSERT INTO $tabela SET num_processo = :num_processo, tipo_acao = :tipo_acao, jurisdicao = :jurisdicao, vara = :vara, comarca = :comarca, valor = :valor, segredo = :segredo, justica_gratuita = :justica_gratuita, orgao_julgador = :orgao_julgador, status = :status, advogado1 = :advogado1, advogado2 = :advogado2, advogado3 = :advogado3, advogado4 = :advogado4, data_abertura = :data_abertura, cliente = :cliente, usuario_lanc = :usuario_lanc, nome_contraria = :nome_contraria, telefone_contraria = :telefone_contraria, cpf_contraria = :cpf_contraria, rg_contraria = :rg_contraria, endereco_contraria = :endereco_contraria, estado_civil_contraria = :estado_civil_contraria, advogado_contraria = :advogado_contraria, data_cad = curDate(), obs = :obs");
	
}else{
$query = $pdo->prepare("UPDATE $tabela SET num_processo = :num_processo, tipo_acao = :tipo_acao, jurisdicao = :jurisdicao, vara = :vara, comarca = :comarca, valor = :valor, segredo = :segredo, justica_gratuita = :justica_gratuita, orgao_julgador = :orgao_julgador, status = :status, advogado1 = :advogado1, advogado2 = :advogado2, advogado3 = :advogado3, advogado4 = :advogado4, data_abertura = :data_abertura, cliente = :cliente, usuario_lanc = :usuario_lanc, nome_contraria = :nome_contraria, telefone_contraria = :telefone_contraria, cpf_contraria = :cpf_contraria, rg_contraria = :rg_contraria, endereco_contraria = :endereco_contraria, estado_civil_contraria = :estado_civil_contraria, advogado_contraria = :advogado_contraria, data_cad = curDate(), obs = :obs $sql_data where id = '$id'");
}

$query->bindValue(":num_processo", "$numero_processo");
$query->bindValue(":tipo_acao", "$tipo_acao");
$query->bindValue(":jurisdicao", "$jurisdicao");
$query->bindValue(":vara", "$vara");
$query->bindValue(":comarca", "$comarca");
$query->bindValue(":valor", "$valor");
$query->bindValue(":segredo", "$segredo_justica");
$query->bindValue(":justica_gratuita", "$justica_gratuita");
$query->bindValue(":orgao_julgador", "$orgao_julgador");
$query->bindValue(":status", "$status");
$query->bindValue(":advogado1", "$advogado1");
$query->bindValue(":advogado2", "$advogado2");
$query->bindValue(":advogado3", "$advogado3");
$query->bindValue(":advogado4", "$advogado4");
$query->bindValue(":data_abertura", "$data_abertura");
$query->bindValue(":cliente", "$cliente");
$query->bindValue(":usuario_lanc", "$id_usuario");
$query->bindValue(":nome_contraria", "$nome_contraria");
$query->bindValue(":telefone_contraria", "$telefone_contraria");
$query->bindValue(":cpf_contraria", "$cpf_contraria");
$query->bindValue(":rg_contraria", "$rg_contraria");
$query->bindValue(":endereco_contraria", "$endereco_contraria");
$query->bindValue(":estado_civil_contraria", "$estado_civil_contraria");
$query->bindValue(":advogado_contraria", "$advogado_contraria");
$query->bindValue(":obs", "$obs");

$query->execute();
$ult_id = $pdo->lastInsertId();

echo 'Salvo com Sucesso';


 ?>
