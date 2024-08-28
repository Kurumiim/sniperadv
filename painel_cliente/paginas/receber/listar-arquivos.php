<?php 
require_once("../../../conexao.php");
require_once("../../verificar.php");
$pagina = 'arquivos';
$id = $_POST['id'];

echo <<<HTML
<small>
HTML;
$query = $pdo->query("SELECT * FROM $pagina where id_reg = '$id' and registro = 'Conta à Receber' order by id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
echo <<<HTML
	<table class="table table-hover" id="tabela_arquivos">
		<thead> 
			<tr> 				
				<th>Nome</th>
				<th class="esc">Data</th>				
				<th>Arquivo</th>				
			
			</tr> 
		</thead> 
		<tbody> 
HTML;
for($i=0; $i < $total_reg; $i++){
	foreach ($res[$i] as $key => $value){}
$id = $res[$i]['id'];
$nome = $res[$i]['nome'];
$data_cad = $res[$i]['data_cad'];
$arquivo = $res[$i]['arquivo'];

//extensão do arquivo
$ext = pathinfo($arquivo, PATHINFO_EXTENSION);
if($ext == 'pdf' || $ext == 'PDF'){
	$tumb_arquivo = 'pdf.png';
}else if($ext == 'rar' || $ext == 'zip' || $ext == 'RAR' || $ext == 'ZIP'){
	$tumb_arquivo = 'rar.png';
}else if($ext == 'doc' || $ext == 'docx' || $ext == 'DOC' || $ext == 'DOCX'){
	$tumb_arquivo = 'word.png';
}else if($ext == 'xlsx' || $ext == 'xlsm' || $ext == 'xls'){
	$tumb_arquivo = 'excel.png';
}else if($ext == 'xml'){
	$tumb_arquivo = 'xml.png';
}else{
	$tumb_arquivo = $arquivo;
}

$data_cadF = implode('/', array_reverse(@explode('-', $data_cad)));

echo <<<HTML
			<tr>					
				<td class="">{$nome}</td>
				<td class="esc">{$data_cadF}</td>				
				<td><a href="../painel/images/arquivos/{$arquivo}" target="_blank"><img src="../painel/images/arquivos/{$tumb_arquivo}" width="18px" height="18px"></a></td>
				
			</tr> 
HTML;
}
echo <<<HTML
		</tbody> 
	</table>
</small>
HTML;
}else{
	echo 'Não possui nenhum arquivo cadastrado!';
}

?>


<script type="text/javascript">


	$(document).ready( function () {
	    $('#tabela_arquivos').DataTable({
	    	"ordering": false,
	    	"stateSave": true,
	    });
	    $('#tabela_filter label input').focus();	    
	} );


	function excluirArquivo(id, nome){
    
    $.ajax({
        url: 'paginas/' + pag + "/excluir-arquivo.php",
        method: 'POST',
        data: {id, nome},
        dataType: "text",

        success: function (mensagem) {

            $('#mensagem-arquivo').text('');
            $('#mensagem-arquivo').removeClass()
            if (mensagem.trim() == "Excluído com Sucesso") {                
                listarArquivos();                
            } else {

                $('#mensagem-arquivo').addClass('text-danger')
                $('#mensagem-arquivo').text(mensagem)
            }


        },      

    });
}


</script>


