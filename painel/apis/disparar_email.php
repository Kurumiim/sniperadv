<?php 

//envio do email
$assunto = @utf8_decode($assunto);
$mensagem = @$mensagem_email;
$cabecalhos = 'MIME-Version: 1.0' . "\r\n";
$cabecalhos .= 'Content-type: text/html; charset=utf-8;' . "\r\n";
$cabecalhos .= "From: ".$email_sistema;

@mail($destinatario, $assunto, $mensagem, $cabecalhos);

?>