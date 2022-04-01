<?php

header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');

function connectDatabase(): PDO
{
    $dbDSN = "mysql:dbname=slutprojekt;host=127.0.0.1;port=3306;charset=utf8";
    $dbUser = "root";
    $dbPassword = "";

    try {
        $db = new PDO($dbDSN, $dbUser, $dbPassword);
    } catch (PDOException $ex) {
        $err = new stdClass();
        $err->error = [$ex->getMessage()];
        //skickaSvar($err, 401);
        exit($ex->getMessage());
    }
    return $db;
}

