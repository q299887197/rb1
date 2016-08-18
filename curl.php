<?php
// header('refresh: 2');

require_once("BallSql.php");

header("content-type: text/html; charset=utf-8");

//连接本地的 Redis 服务
$redis = new Redis();
$redis->connect('127.0.0.1', 6379);

$ballSql = new BallSql();

$ballSql->deleteAll(); //刪除全部數據,只保留新增最新的數據

// 1. 初始設定
$ch = curl_init();

$fp = fopen("test.txt", "w+"); // W以寫模式打開文件
$cookie_jar_index = dirname(__FILE__)."/".'cookie.txt';

$url = "http://www.228365365.com/sports.php"; //下注網
$url2 = "http://www.228365365.com/app/member/FT_browse/body_var.php?uid=test00&rtype=r&langx=zh-cn&mtype=3&page_no=0&league_id=&hot_game="; //今日賽事網址
$url3 = "http://www.228365365.com/app/member/FT_future/body_var.php?uid=test00&rtype=r&langx=zh-cn&mtype=3&page_no=1&league_id=&hot_game=";

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

$noFunction = explode("function", $pageContent1); //拆除後面的function
$arr = explode("parent.GameFT", $noFunction[0]); //拆除前面的資料部分 0不要


//取出賽事資料 二為陣列
for($i=1 ; $i < count($arr) ; $i++){
// for($i=1 ; $i < 2 ; $i++){
	$arr[$i] = str_replace( '<br>' , ' ' , $arr[$i]);
	// echo $arr[$i] . "<br>";

	$arr[$i] = explode(',', $arr[$i]); //拆除逗號

	for($j=0 ; $j < count($arr[$i]) ; $j++){
		echo $j . " ";
		$arr[$i][$j] = str_replace( "'" , '' , $arr[$i][$j]);  //拆除 '
		echo $arr[$i][$j] . "<br>";
	}

	$league = $arr[$i][2]; //聯賽名稱
	$date = $arr[$i][1]; //時間
	$event = $arr[$i][5]."&".$arr[$i][6]; //賽事隊伍
	$allWin = $arr[$i][15] ."&". $arr[$i][16] ."&". $arr[$i][17]; //全場獨贏
	$allScore = $arr[$i][8] ."&". $arr[$i][9] ."&". $arr[$i][10]; //全場讓球 黑字+上+下
	$allSize = $arr[$i][11] ."&". $arr[$i][14] ."&". $arr[$i][12] ."&". $arr[$i][13]; //全場大小 上黑字+上+下黑字+下
	$oddEven = $arr[$i][18] ."&". $arr[$i][20] ."&". $arr[$i][19] ."&". $arr[$i][21]; //單 上 雙 下
	$halfWin = $arr[$i][31] ."&". $arr[$i][32] ."&". $arr[$i][33]; //半場獨贏
	$halfScore = $arr[$i][24] ."&". $arr[$i][25] ."&". $arr[$i][26]; //半場讓球 黑字+上+下
	$halfSize = $arr[$i][27] ."&". $arr[$i][30] ."&". $arr[$i][28] ."&". $arr[$i][29]; //半場大小 上黑字+上+下黑字+下
	$gameId = $arr[$i][22]; //賽事編號

	/* 新增賽事 */
	$ballSql->insertGame($league, $date, $event, $allWin, $allScore, $allSize, $oddEven, $halfWin, $halfScore, $halfSize, $gameId);

	echo "<br><br>";

}

$record = $ballSql->selectAll();
$redis->set('todayGame', json_encode($record)); //set資料庫資料,並存入json格式
