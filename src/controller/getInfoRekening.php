<?php

function getInfoRekening ($account) {

   $url = 'https://sandbox.partner.api.bri.co.id'; //url
   $path = "/snap/v1.0/balance-inquiry"; // path
   $method = "POST"; //method
   
   // customer key & scret
   $clientId = $_ENV['CLIENT_KEY'];
   $clientSecret = $_ENV['CLIENT_SECRET'];
   // private key
   $pKeyId = $_ENV['PRIVATE_KEY'];
   
   // body request
   $dataRequest = array(
   'accountNo'=> $account
   );
   $bodyRequest = json_encode($dataRequest,true);
   
   $dt = new DateTime("now", new DateTimeZone('Asia/Jakarta'));
   $timestamp = $dt->format('Y-m-d\TH:i:s.000P');
   
   // access Token
   $accessToken = getAccessToken($clientId, $pKeyId, $timestamp);
   
   //Signature request
   $signatureRequest = generateSignatureRequest($clientSecret, $method, $timestamp, $accessToken, $bodyRequest, $path);
   
   //Generate number random for X-External-id
   $panjangRandom = 9;
   $randomNumber = generateRandomNumber($panjangRandom);
   
   //Header request 
   $headersRequest = array(          
      "X-TIMESTAMP:" . $timestamp,
      "X-SIGNATURE:" . $signatureRequest,
      "Content-Type: application/json",
      "X-PARTNER-ID: feedloop",
      "CHANNEL-ID: SNPBI",
      "X-EXTERNAL-ID:" . $randomNumber,
      "Authorization: Bearer ".$accessToken,
   );
   
   //CURL Request Fitur
   $chPost1 = curl_init();
   curl_setopt($chPost1, CURLOPT_URL,"$url$path" );
   curl_setopt($chPost1, CURLOPT_HTTPHEADER, $headersRequest);
   curl_setopt($chPost1, CURLOPT_POSTFIELDS, $bodyRequest);
   curl_setopt($chPost1, CURLINFO_HEADER_OUT, true);
   curl_setopt($chPost1, CURLOPT_RETURNTRANSFER, true);
   curl_setopt($chPost1, CURLOPT_CUSTOMREQUEST, "POST");
   $resultPostRequest = curl_exec($chPost1);
   $httpCodePostreq = curl_getinfo($chPost1, CURLINFO_HTTP_CODE);
   curl_close($chPost1);
   
   //echo echoan
   // echo "<br\>body".$bodyRequest;
   // echo "<br\><br>signature: ".$signatureRequest;
   // echo "<br><br> Result: ". $resultPostRequest;
   return $resultPostRequest;
}

?>
