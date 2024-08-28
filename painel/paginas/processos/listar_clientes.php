<?php 
@session_start();
$mostrar_registros = @$_SESSION['registros'];
$id_usuario = @$_SESSION['id'];
$tabela = 'clientes';
require_once("../../../conexao.php");

$ult = @$_POST['ult'];

echo '<select name="cliente" id="cliente" class="sel2" style="width:100%; height:35px; ">';

if($ult == ''){
	echo '<option value="">Selecione um Cliente</option>';
}

 
if($mostrar_registros == 'Não'){
	$query = $pdo->query("SELECT * from clientes where usuario = '$id_usuario' or visto_por = 'Todos' order by id desc");
}else{
	$query = $pdo->query("SELECT * from clientes order by id desc");
}
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
	for($i=0; $i<$linhas; $i++){
		echo '<option value="'.$res[$i]['id'].'">'.$res[$i]['nome'].'</option>';
	}
}

echo '</select>';

?>

<script type="text/javascript">
			$(document).ready(function() {
				
				$('.sel2').select2({
					dropdownParent: $('#modalForm')
				});

			});
		</script>
