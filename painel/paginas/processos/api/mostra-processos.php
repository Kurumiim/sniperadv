<?php 
require_once("../../../../conexao.php");

foreach ($retornoDadosProcesso[0]->hits->hits as $contador => $registros) { ?>

	 <div class="accordion-item">
            <h4 class="accordion-header">
            <button style="height: 25px" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $contador ?>" aria-expanded="false" aria-controls="collapse<?php echo $contador ?>">
            <?php
            if ($registros->_source->grau == 'G1') {
                echo "1a instância - " . $registros->_source->classe->nome;
            } else {
                echo "2a instância";
            }
            ?>
                - Movimentação
            </button>
            </h4>
            
            <div id="collapse<?php echo $contador ?>" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <div class="row align-items-start" style="font-size:13px">
                        <div class="col">
                            <p><b>Tipo de processo: </b> <?php echo $registros->_source->classe->nome . " (" . $registros->_source->classe->codigo . ")" ?></p>
                        </div>
                        <div class="col">
                            <p><b>Formato do processo: </b> <?php echo $registros->_source->formato->nome ?></p>
                        </div>
                        <div class="col">
                            <p><b>Data de instauração nesta instância:</b> <?php 
                            $dataAjuizamento = new datetime($registros->_source->dataAjuizamento);
                            echo $dataAjuizamento->format('d/m/Y') 
                            ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <?php
                        foreach ($registros->_source->movimentos as $movimentacao) { 
                            echo '<div style="border-bottom:1px solid #000; padding:10px; width:100%">';
                            $dataMovimentacao = '';
                            $dataMovimentacao = new datetime ($movimentacao->dataHora);
                            echo '<span><i class="fa fa-calendar-o " ></i> <b>'.$dataMovimentacao->format('d/m/Y').'</b></span> -> ';
                            ?>
                            <?php echo $movimentacao->nome ?> (
                            <?php 
                            if (isset($movimentacao->complementosTabelados[0])) {
                                foreach ($movimentacao->complementosTabelados as $complementoMovimentacao) {
                                    echo '<span>'.$complementoMovimentacao->descricao . " - " . $complementoMovimentacao->nome.'</span>';
                                }
                            } 
                            ?>
                            )
                        <?php echo '</div>'; } ?>
                    </div>
                </div>
            </div>
        </div>

<?php } ?>