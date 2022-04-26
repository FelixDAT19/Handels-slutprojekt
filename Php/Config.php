<?php
/*
function connectDatabase(): PDO
{
    $dbDSN = "mysql:dbname=handels;host=127.0.0.1;port=3306;charset=utf8";
    $dbUser = "root";
    $dbPassword = "";

    try {
        $db = new PDO($dbDSN, $dbUser, $dbPassword);
    } catch (PDOException $ex) {
        $err = new stdClass();
        $err->error = [$ex->getMessage()];
        exit($ex->getMessage());
    }
    return $db;
}
*/
function connectDatabase(): PDO
{
    $dbDSN = "mysql:dbname=heroku_f3b40c52a301cf5;host=eu-cdbr-west-02.cleardb.net;port=3306;charset=utf8";
    $dbUser = "b158ff6542ad9b";
    $dbPassword = "da525471";

    try {
        $db = new PDO($dbDSN, $dbUser, $dbPassword);
    } catch (PDOException $ex) {
        $err = new stdClass();
        $err->error = [$ex->getMessage()];
        exit($ex->getMessage());
    }
    return $db;
}
