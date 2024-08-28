<?php 
require_once("../../../conexao.php");
require_once("../../verificar.php");
$pagina = 'receber';
$id = $_POST['id'];

$query = $pdo->query("SELECT * FROM $pagina where id_ref = '$id' and referencia = 'Processo' order by id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
echo <<<HTML
    <table class="table table-hover " id="">
        <thead class="bg-primary"> 
            <tr>                
                <th>Valor</th>
                <th >Data Pgto</th>               
                <th>Forma Pgto</th>                
                <th>Lançado Por</th>
                <th>Excluir</th>
            </tr> 
        </thead> 
        <tbody> 
HTML;
$total_valores = 0;
for($i=0; $i < $total_reg; $i++){
$id = $res[$i]['id'];
$valor = $res[$i]['valor'];
$data_pgto = $res[$i]['data_pgto'];
$forma_pgto = $res[$i]['forma_pgto'];
$usuario_lanc = $res[$i]['usuario_lanc'];
$data_pgtoF = implode('/', array_reverse(@explode('-', $data_pgto)));

$total_valores += $valor;

$valorF = @number_format($valor, 2, ',', '.');
$total_valoresF = @number_format($total_valores, 2, ',', '.');

$query2 = $pdo->query("SELECT * FROM usuarios where id = '$usuario_lanc'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
if(@count($res2) > 0){
    $nome_usu_lanc = $res2[0]['nome'];
}else{
    $nome_usu_lanc = 'Sem Usuário';
}

$query2 = $pdo->query("SELECT * FROM formas_pgto where id = '$forma_pgto'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
if(@count($res2) > 0){
    $nome_pgto = $res2[0]['nome'];
    $taxa_pgto = $res2[0]['taxa'];
}else{
    $nome_pgto = 'Sem Registro';
    $taxa_pgto = 0;
}


echo <<<HTML
            <tr>                    
                <td class="">R$ {$valorF}</td>
                <td class="esc">{$data_pgtoF}</td> 
                <td class="esc">{$nome_pgto}</td>               
                <td class="esc">{$nome_usu_lanc}</td> 
                <td>

                    <div class="dropdown" style="display: inline-block;">                      
                        <a href="#" aria-expanded="false" aria-haspopup="true" data-bs-toggle="dropdown" class="dropdown"><i class="fe fe-trash-2 text-danger"></i> </a>
                        <div  class="dropdown-menu tx-13">
                        <div style="width: 240px; padding:15px 5px 0 10px;" class="dropdown-item-text">
                        <p>Confirmar Exclusão? <a href="#" onclick="excluirValor('{$id}')"><span class="text-danger">Sim</span></a></p>
                        </div>
                        </div>
                        </div>
                    
                </td>  
            </tr> 
HTML;
}
echo <<<HTML
        </tbody> 
    </table>
    
</small>
<div align="right" style="font-size:14px">Total: <span style="color:green">R$ {$total_valoresF}</span></div>
HTML;
}else{
    echo 'Não possui nenhum arquivo cadastrado!';
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


    function excluirValor(id){
    
    $.ajax({
        url: 'paginas/' + pag + "/excluir-valor.php",
        method: 'POST',
        data: {id},
        dataType: "text",

        success: function (mensagem) {

            $('#mensagem-valor').text('');
            $('#mensagem-valor').removeClass()
            if (mensagem.trim() == "Excluído com Sucesso") {                
                listarValores();                
            } else {

                $('#mensagem-valor').addClass('text-danger')
                $('#mensagem-valor').text(mensagem)
            }


        },      

    });
}


</script>


