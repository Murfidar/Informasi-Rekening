<?php 
//generate signature Token
	function generateSignatureToken($pKeyId, $clientId, $timestamp) {
        $stringToSign = $clientId . "|" . $timestamp;
        openssl_sign($stringToSign, $signature, $pKeyId, OPENSSL_ALGO_SHA256);
        $signature = base64_encode($signature);
      //   echo "stringToSign payload: ".$stringToSign . "<br><br>";
        return $signature;
     }

   function generateSignatureRequest($clientSecret, $method, $timestamp, $accessToken, $bodyRequest, $path){
      $sha256 = hash("sha256", $bodyRequest);
       //string to sign
      $stringToSign = "$method:$path:$accessToken:$sha256:$timestamp";
      // echo "stringToSign payload: ".$stringToSign . "<br><br>";

      // HMAC-SHA512 of stringToSign using client secret
      return hash_hmac("sha512", $stringToSign, $clientSecret);
   } 
?>