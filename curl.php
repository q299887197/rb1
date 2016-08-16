<?php
header("content-type: text/html; charset=utf-8");

// 1. 初始設定
$ch = curl_init();

$fp = fopen("test.txt", "w+"); // W以寫模式打開文件
$cookie_jar_index = dirname(__FILE__)."/".'cookie.txt';

$url = "http://www.228365365.com/sports.php"; //下注網
$url2 = "http://www.228365365.com/app/member/FT_browse/body_var.php?uid=test00&rtype=r&langx=zh-cn&mtype=3&page_no=0&league_id=&hot_game=undefined"; //內部網址
$url3 = "http://www.228365365.com/app/member/FT_future/body_var.php?uid=test00&rtype=r&langx=zh-cn&mtype=3&page_no=0&league_id=&hot_game=";

// 2. 設定 / 調整參數
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_jar_index);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //將curl_exec()獲取的訊息以文件流的形式返回，而不是直接輸出。
curl_setopt($ch, CURLOPT_HEADER, 0);
$pageContent = curl_exec($ch);

curl_setopt($ch, CURLOPT_URL, $url3);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_jar_index);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //將curl_exec()獲取的訊息以文件流的形式返回，而不是直接輸出。
curl_setopt($ch, CURLOPT_HEADER, 0);
$pageContent1 = curl_exec($ch);
curl_setopt($ch, CURLOPT_FILE, $fp);  //將抓到資料寫入test.txt

// 3. 執行，取回 response 結果
$pageContent = curl_exec($ch);

// 4. 關閉與釋放資源
curl_close($ch);
// echo strip_tags($pageContent);

echo "<iframe  width='50%' height='50%'>";
echo $pageContent1;
// var_dump($pageContent);
echo "</iframe>";
// echo $pageContent;

$contents;

// while (!feof($fp))
// {
      //8192為字元數，每一次取8192個字元
      $contents = fread($fp, 8192);
      //echo $contents . "<br>";
      echo substr( $contents , 65 );
// }