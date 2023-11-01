<?php
 function generateRandomNumber($panjangRandom){
      $min = pow(10, $panjangRandom - 1);
      $max = pow(10, $panjangRandom) - 1;
      return rand($min, $max);
   }

?>