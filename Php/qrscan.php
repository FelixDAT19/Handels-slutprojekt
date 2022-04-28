<?php
require_once "Config.php";

session_start();
if (!isset($_GET["qrId"])) {
   header("Location: https://handelsmessan.netlify.app/");
   var_dump("hej ho"); 
} else {

    $qrid = $_GET["qrId"];

    $device = $_SESSION["device"];

    $db = connectDatabase();

    $sql = "SELECT id,randomId,Url FROM qrcodes WHERE randomId='$qrid'";
    $stmt = $db->prepare($sql);
    $result = $stmt->execute([]);
    $row = $stmt->fetch();
    $url = $row["Url"];
    $id = $row["id"];

    var_dump($id);

    if (!isset($qrid) or $qrid == "" or $url == "") {
        header("Location: https://handelsmessan.netlify.app/");
        var_dump($qrid);
        
    } else if (!isset($device)) {
            
            var_dump("tja");
            $deviceRandom = generateRandomString();

            var_dump($deviceRandom);

            $sqlScan="INSERT INTO qrscan(qrId, device) VALUES (:qrId, :device)";
            $stmtAddQrScan = $db->prepare($sqlScan);

            $stmtAddQrScan->bindParam('qrId', $id, PDO::PARAM_STR);
            $stmtAddQrScan->bindParam('device', $deviceRandom, PDO::PARAM_STR);

            $stmtAddQrScan->execute();

    
            $device = $deviceRandom;

            var_dump($device);

            header("Location: $url");
            
    }  else {

            $sqlScan="INSERT INTO qrscan(qrId, device) VALUES (:qrId, :device)";
            $stmtAddQrScan = $db->prepare($sqlScan);

            $stmtAddQrScan->bindParam('qrId', $id, PDO::PARAM_STR);
            $stmtAddQrScan->bindParam('device', $device, PDO::PARAM_STR);

            $stmtAddQrScan->execute();
            header("Location: $url");


    }

        


    $_SESSION["device"] = $device;

}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}