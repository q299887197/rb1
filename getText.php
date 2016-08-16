<?php
header("content-type: text/html; charset=utf-8");

$filename = "test.txt";




// $handle = fopen($filename, "r");
// // if ($handle)
// // {
//       //while (!feof($handle))
//       //{
//             //fgets為每次讀取一列文字
//             // $buffer = fgets($handle);
//             echo substr( $handle , 65 );
//             // echo $buffer . "<br>";
//       //}
// // }
// fclose($handle);


$handle = fopen($filename, "rb");
$contents = '';
while (!feof($handle))
{
      //8192為字元數，每一次取8192個字元
      $contents = fread($handle, 8192);
      //echo $contents . "<br>";
      //echo strip_tags($contents);
      echo substr( $contents , 65 );
}

fclose($handle);