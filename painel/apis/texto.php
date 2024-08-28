<?php 

if($api_whatsapp == 'menuia'){
	 $mensagem_whatsapp = str_replace("%0A", "\n", $mensagem_whatsapp); 
	 
	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => 'https://chatbot.menuia.com/api/create-message',
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => '',
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => 'POST',
	  CURLOPT_POSTFIELDS => array(
	  'appkey' => $token_whatsapp,
	  'authkey' => $instancia_whatsapp,
	  'to' => $telefone_envio,
	  'message' => $mensagem_whatsapp,
	  'sandbox' => 'false'
	  ),
	));

	$response = curl_exec($curl);

	curl_close($curl);
	//echo $response;
}



if($api_whatsapp == 'wm'){
	$url = "http://api.wordmensagens.com.br/send-text";

	$data = array('instance' => $instancia_whatsapp,
	              'to' => $telefone_envio,
	              'token' => $token_whatsapp,
	              'message' => $mensagem_whatsapp);

	$options = array('http' => array(
	               'method' => 'POST',
	               'content' => http_build_query($data)
	));

	$stream = stream_context_create($options);

	$result = @file_get_contents($url, false, $stream);

	//echo $result;

}


if($api_whatsapp == 'newtek'){
	$mensagem_whatsapp = str_replace("%0A", "\n", $mensagem_whatsapp); 
	$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://webapi.newteksoft.com.br/enviar-texto',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => json_encode(array(
    "instancia" => $instancia_whatsapp,
    "token" => $token_whatsapp,
    "mensagem" => $mensagem_whatsapp,
    "para" => array($telefone_envio),
    "delay" => "1"
  )),
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
//echo $response;
}

 ?>