<?php

require __DIR__.'/../vendor/autoload.php';

Dotenv\Dotenv::createUnsafeImmutable(__DIR__.'/..'. '')->load();

include __DIR__.'/../src/utils/generateRandomNumber.php';
include __DIR__.'/../src/utils/getSignature.php';
include __DIR__.'/../src/utils/getAccessToken.php';
include __DIR__.'/../src/controller/getInfoRekening.php';

$account = '111231271284142'; // account number

echo "\nResult: ".getInfoRekening($account);

?>