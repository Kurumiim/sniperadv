<?php

function  validaCPF ( $cpf ){
 
    // Extrai somente os números
    $cpf = preg_replace( '/[^0-9]/is' , '' , $cpf );
     
    // Verifique se todos os dígitos foram informados corretamente
    if (strlen( $cpf )!= 11 ){
        echo 'CPF Inválido!';
            exit();
            return  false ;
    }

    // Verifica se foi informada uma sequência de dígitos repetidos. Ex: 111.111.111-11
    if (preg_match( '/(\d)\1{10}/' , $cpf )) {
        echo 'CPF Inválido!';
            exit();
            return  false ;
    }

    // Faz o cálculo para validar o CPF
    for ( $t = 9 ; $t < 11 ; $t ++) {
        for ( $d = 0 , $c = 0 ; $c < $t ; $c ++) {
            $d += $cpf [ $c ] * (( $t + 1 ) - $c );
        }
        $d =(( 10 * $d )% 11 )% 10 ;
        if ( $cpf [ $c ]!= $d ){
            echo 'CPF Inválido!';
            exit();
            return  false ;
            
        }
    }
    //echo 'true';
    return  true ;


}

validaCPF($cpf);