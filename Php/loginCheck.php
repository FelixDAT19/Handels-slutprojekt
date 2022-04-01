<?php

header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');

require_once "Config.php";



$username = $_POST["username"];
$password = $_POST["password"];

if ($_POST) {

    $sql = "SELECT userName, userPassword FROM adminLogin";
    $result = $link->query($sql);
    var_dump($result);

    while ($row = $result->fetch_assoc()) {
        if ($row['userName'] == $username) {
            if ($row['userPassword'] == $password) {
                header("Location: http://localhost:3000/adminQr");
                exit();
            } else {
                header("Location: http://localhost:3000/admin");
                exit();
            }
        } else {
            header("Location: http://localhost:3000/admin");
            exit();
        }
    }
}