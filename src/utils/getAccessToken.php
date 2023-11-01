<?php
   function getAccessToken($clientId, $pKeyId, $timestamp) {
      // body request
      $dataToken = array(
         'grantType'=> "client_credentials"
      );
      
      $bodyToken = json_encode($dataToken,true);
      

      $signatureToken = generateSignatureToken($pKeyId, $clientId, $timestamp);

      $requestHeadersToken = array(
                        "X-TIMESTAMP:" . $timestamp,
                        "X-CLIENT-KEY:" . $clientId,
                        "X-SIGNATURE:" . $signatureToken,
                        "Content-Type:application/json",
                     );

      // fetch access token
      $urlPost ="https://sandbox.partner.api.bri.co.id/snap/v1.0/access-token/b2b";
      $chPost = curl_init();
      curl_setopt($chPost, CURLOPT_URL,$urlPost);
      curl_setopt($chPost, CURLOPT_HTTPHEADER, $requestHeadersToken);
      curl_setopt($chPost, CURLOPT_POSTFIELDS, $bodyToken);
      curl_setopt($chPost, CURLINFO_HEADER_OUT, true);
      curl_setopt($chPost, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($chPost, CURLOPT_CUSTOMREQUEST, "POST");
      $resultPost = curl_exec($chPost);
      curl_close($chPost);


      $jsonPost = json_decode($resultPost, true);
      echo "Response Token: ".$resultPost;
      return $jsonPost['accessToken'];
   }
?>