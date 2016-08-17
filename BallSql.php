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

    /* 查詢球賽編號    SELECT */
    public function selectGame($league, $date, $event, $allWin, $allScore, $allSize, $oddEven, $halfWin, $halfScore, $halfSize, $gameId)
    {
        $dbh = $this->dbh;
        $select = $dbh->prepare("SELECT * FROM `today_game` WHERE `gameId` = :gameId");
        $select->bindParam(':gameId', $gameId);
        $select->execute();

        $data = $select->fetch();

        /* 賽事編號一樣只更新數據 */
        if($data['gameId'] == $gameId){
            $this->upDateGame($league, $date, $event, $allWin, $allScore, $allSize, $oddEven, $halfWin, $halfScore, $halfSize, $gameId);
        }

        if($data['gameId'] != $gameId){
            $this->insertGame($league, $date, $event, $allWin, $allScore, $allSize, $oddEven, $halfWin, $halfScore, $halfSize, $gameId);
        }


        $select->execute();
        $dbh = NULL;

        return $select->fetchAll();
    }

    /* 新增球賽數據    INSERT */
    public function insertGame($league, $date, $event, $allWin, $allScore, $allSize, $oddEven, $halfWin, $halfScore, $halfSize, $gameId)
    {
        $dbh = $this->dbh;
        $insert = $dbh->prepare("INSERT INTO `today_game`
            (`league`, `date`, `event`, `allWin`, `allScore`, `allSize`, `oddEven`, `halfWin`, `halfScore`, `halfSize`, `gameId`)
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
    }

    /* 更新球賽數據    UPDATE */
    public function upDateGame($league, $date, $event, $allWin, $allScore, $allSize, $oddEven, $halfWin, $halfScore, $halfSize, $gameId)
    {
        $dbh = $this->dbh;
        $update = $dbh->prepare("UPDATE `today_game` SET
            `league` = :league,
            `date` = :date,
            `event` = :event,
            `allWin` = :allWin,
            `allScore` = :allScore,
            `allSize` = :allSize,
            `oddEven` = :oddEven,
            `halfWin` = :halfWin,
            `halfScore` = :halfScore,
            `halfSize` = :halfSize
            WHERE `gameId`= :gameId");

        $update->bindParam(':league', $league); //聯賽名稱
        $update->bindParam(':date', $date); //時間
        $update->bindParam(':event', $event); //賽事隊伍
        $update->bindParam(':allWin', $allWin); //全場獨贏
        $update->bindParam(':allScore', $allScore); //全場讓球
        $update->bindParam(':allSize', $allSize); //全場大小
        $update->bindParam(':oddEven', $oddEven); //單雙
        $update->bindParam(':halfWin', $halfWin); //半場獨贏
        $update->bindParam(':halfScore', $halfScore); //半場讓球
        $update->bindParam(':halfSize', $halfSize); //半場大小
        $update->bindParam(':gameId', $gameId); //賽事編號

        $update->execute();
    }

    public function selectAll()
    {
        $dbh = $this->dbh;
        $select = $dbh->prepare("SELECT * FROM `today_game`");
        $select->execute();

        return $select->fetchAll();
    }
}
