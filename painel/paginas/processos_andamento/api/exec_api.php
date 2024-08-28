<?php
require_once 'datajus.php';

$acao = 'consulta';
$numero = $num_processo;

switch ($acao) {
    case 'consulta': 


        $retornoValidacaoNumero = apicnjClass::validarNumeroCnj($numero);

        if (isset($retornoValidacaoNumero['erro'])) {
            echo $retornoValidacaoNumero['erro'];
            break;
        };

        $retornoApi = apicnjClass::buscarTribunalApi($retornoValidacaoNumero);

        if (isset($retornoApi['erro'])) {
            echo $retornoApi['erro'];
            break;
        };

        $retornoDadosProcesso = apicnjClass::consomeApi($retornoApi);
        
        if (!empty($retornoDadosProcesso['erro'])) {
            echo $retornoDadosProcesso['erro'];
            break;
        };

        require 'mostra-processos.php';

        break;
    case 'verificaNumero':
    break;
}