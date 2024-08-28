<?php 
require_once("../../../conexao.php");
require_once("../../verificar.php");
$pagina = 'movimentacao_processo';
$id = $_POST['id'];

$query = $pdo->query("SELECT * FROM $pagina where processo = '$id' order by id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
for($i=0; $i < $total_reg; $i++){
$id = $res[$i]['id'];
$titulo = $res[$i]['titulo'];
$descricao = $res[$i]['descricao'];
$data = $res[$i]['data'];
$dataF = implode('/', array_reverse(@explode('-', $data)));

echo <<<HTML
			<div style="border-bottom: 1px solid #757575; margin-bottom: 10px; padding-bottom:5px">					
				<span style="font-size: 14px"><b>{$titulo}</b>
					<div class="dropdown" style="display: inline-block;">                      
                        <a title="Excluir Movimentação" href="#" aria-expanded="false" aria-haspopup="true" data-bs-toggle="dropdown" class="dropdown"><i class="text-danger" style="font-size: 13px"> X </i> </a>
                        <div  class="dropdown-menu tx-13">
                        <div style="width: 240px; padding:15px 5px 0 10px;" class="dropdown-item-text">
                        <p>Confirmar Exclusão? <a href="#" onclick="excluirMovimentacoes('{$id}')"><span class="text-danger">Sim</span></a></p>
                        </div>
                        </div>
                        </div>
				</span> 

				<br>
				<span style="font-size: 12px; ">{$descricao}</span>

				<br>
				<span style="font-size: 11px;"><i>Data: {$dataF}</i></span>
			</div> 
			
HTML;
}
}else{
	echo 'Não possui nenhuma movimentação cadastrada!';
}

?>


<script type="text/javascript">


	$(document).ready( function () {
	   	    
	} );


	function excluirMovimentacoes(id){
    
    $.ajax({
        url: 'paginas/' + pag + "/excluir-movimentacoes.php",
        method: 'POST',
        data: {id},
        dataType: "text",

        success: function (mensagem) {

            $('#mensagem-movimentacoes').text('');
            $('#mensagem-movimentacoes').removeClass()
            if (mensagem.trim() == "Excluído com Sucesso") {                
                listarMovimentacoes();                
            } else {

                $('#mensagem-movimentacoes').addClass('text-danger')
                $('#mensagem-movimentacoes').text(mensagem)
            }


        },      

    });
}


</script>


