<?php 

if($api_whatsapp == 'menuia'){
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
  'message' => $hash,
  'cancelarAgendamento' => 'true',
  ),
));

$response = curl_exec($curl);

curl_close($curl);
//echo $response;
	
}



if($api_whatsapp == 'wm'){
	$url = "http://api.wordmensagens.com.br/delete-agenda";

$data = array('token' => $token_whatsapp,
              'hash' => $hash);

$options = array('http' => array(
               'method' => 'POST',
               'content' => http_build_query($data)
));

$stream = stream_context_create($options);

$result = @file_get_contents($url, false, $stream);

//echo $result;

}



if($api_whatsapp == 'newtek'){
  $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://webapi.newteksoft.com.br/deletar',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => json_encode(array(
    'instancia' => $instancia_whatsapp,
    'token' => $token_whatsapp,
    'hash' => $hash
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