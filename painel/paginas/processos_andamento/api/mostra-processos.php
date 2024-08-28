<?php 


$texto_mov = '';
$texto_mov_restante = ''; 

foreach ($retornoDadosProcesso[0]->hits->hits as $contador => $registros) {            
           
   foreach ($registros->_source->movimentos as $movimentacao) { 
              
             $dataMovimentacao = '';
             $dataMovimentacao = new datetime ($movimentacao->dataHora);
             $dataMovimentacao = '<b>'.$dataMovimentacao->format('d/m/Y').'</b> ';
             $texto_mov = $movimentacao->nome;

             if (isset($movimentacao->complementosTabelados[0])) {
                                foreach ($movimentacao->complementosTabelados as $complementoMovimentacao) {
                                    $texto_mov_restante = '('.$complementoMovimentacao->descricao . " - " . $complementoMovimentacao->nome.')'; 
                                   
                                }
                            } 
            $texto_completo_processo = $texto_mov.' '.$texto_mov_restante;

            break;
         

    }   
        

 } 

 ?>