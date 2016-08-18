<?php
require_once("PdoConfig.php");

class BallSql
{
    public $dbh;

    /* 將 NEW PDO物件放置建構子 並將內容丟給外面的 $dbh讓大家都可以用*/
    public function __construct()
    {
        $db_con = new PdoConfig();
        $db = $db_con->db;
        $this->dbh = $db;
    }

    /* 查詢所有球賽數據    SELECT */
    public function selectAll()
    {
        $dbh = $this->dbh;
        $select = $dbh->prepare("SELECT * FROM `today_game`");
        $select->execute();

        return $select->fetchAll();
    }

    /* 新增球賽數據    INSERT */
    public function insertGame($league, $date, $event, $allWin, $allScore, $allSize, $oddEven, $halfWin, $halfScore, $halfSize, $gameId)
    {
        $dbh = $this->dbh;
        $insert = $dbh->prepare("INSERT INTO `today_game`
            (`league`, `date`, `event`, `allWin`, `allScore`, `allSize`,
            `oddEven`, `halfWin`, `halfScore`, `halfSize`, `gameId`)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $insert->bindParam(1, $league); //聯賽名稱
        $insert->bindParam(2, $date); //時間
        $insert->bindParam(3, $event); //賽事隊伍
        $insert->bindParam(4, $allWin); //全場獨贏
        $insert->bindParam(5, $allScore); //全場讓球
        $insert->bindParam(6, $allSize); //全場大小
        $insert->bindParam(7, $oddEven); //單雙
        $insert->bindParam(8, $halfWin); //半場獨贏
        $insert->bindParam(9, $halfScore); //半場讓球
        $insert->bindParam(10, $halfSize); //半場大小
        $insert->bindParam(11, $gameId); //賽事編號
        $insert->execute();

        $dbh = NULL;
    }

    /* 刪除全部數據    DELETE */
    public function deleteAll(){
        $dbh = $this->dbh;
        $delete = $dbh->prepare("DELETE FROM `today_game`");
        $delete->execute();

        $dbh = NULL;
    }
}
