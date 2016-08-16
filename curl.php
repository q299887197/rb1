<?php
header("content-type: text/html; charset=utf-8");

// 1. 初始設定
$ch = curl_init();

$fp = fopen("test.txt", "w+"); // W以寫模式打開文件
$cookie_jar_index = dirname(__FILE__)."/".'cookie.txt';

$url = "http://www.228365365.com/sports.php"; //下注網
$url2 = "http://www.228365365.com/app/member/FT_browse/body_var.php?uid=test00&rtype=r&langx=zh-cn&mtype=3&page_no=0&league_id=&hot_game="; //內部網址


// 2. 設定 / 調整參數
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_jar_index);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //將curl_exec()獲取的訊息以文件流的形式返回，而不是直接輸出。
curl_setopt($ch, CURLOPT_HEADER, 0);
$pageContent = curl_exec($ch);

curl_setopt($ch, CURLOPT_URL, $url2);
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

// $contents = substr( $pageContent1 , 100); //防止第一行被導走


$arr = explode("parent.GameFT", $pageContent1); //拆

for($i=1 ; $i < count($arr) ; $i++){
	$arr[$i] = str_replace( '<br>' , ' ' , $arr[$i]);
	echo $arr[$i] . "<br>";

	$arr[$i] = explode(',', $arr[$i]); //拆
	for($j=0 ; $j < count($arr[$i]) ; $j++){
		echo $j . " ";
		echo $arr[$i][$j] . "<br>";
	}
	echo "<br><br>";
}
echo count($arr[$i]);


