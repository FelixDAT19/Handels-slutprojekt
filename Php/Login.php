<?php

//Stop bugs
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
require_once "Config.php";

//Session to check if you are logged in
session_start();
$_SESSION['loggedin'] = false;

if (isset($_SESSION['alert'])) {
    function alert($msg)
    {
        echo "<script type='text/javascript'>alert('$msg');</script>";
    }
    $message = $_SESSION['alert'];
    alert($message);
    unset($_SESSION['alert']);
}

$db = connectDatabase();

if (isset($_POST['login'])) {
    $username = trim(htmlspecialchars($_POST["username"]));     //Filtering username input
    $password = $_POST["password"];

    //Checks that username and password are set.
    if (!isset($username) or $username == "") {
        $_SESSION['alert'] = "Användarnamn saknas";
        header("location:AdminPage.php");
        exit();
    } elseif (!isset($_POST['password']) or $password == "") {
        $_SESSION['alert'] = "Lösenord saknas";
        header("location:AdminPage.php");
        exit();
    }

    //Creates sql & compares the username input to the usernames in the database
    $sql = "SELECT username, hashedPswd FROM adminlogin WHERE UserName=:username";
    $stmt = $db->prepare($sql);
    $result = $stmt->execute(['username' => $username]);

    //Redirects back to the login page if the username doesn't match
    if ($result == false) {
        $_SESSION['alert'] = "Fel användarnamn eller lösenord";
        header("location:AdminPage.php");
        exit();
    }
    //compares password where the username matches the input
    $row = $stmt->fetch();
    //Unhashes the password & compares the input with the password in the database.
    if (password_verify($password, $row['hashedPswd'])) {
        $_SESSION['loggedin'] = true;
        header("Location: AdminPage.php");
        exit();
    } else {
        $_SESSION['alert'] = "Fel användarnamn eller lösenord";
        header("location:AdminPage.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <img src="https://cdn.discordapp.com/attachments/950309989157863434/958240009310334996/handek-removebg-preview.png" class="logo">
    <Form autocomplete="off" method="POST" action="Login.php">
        <input type="text" id="username" name="username" placeholder="Username">
        <input type="password" id="password" name="password" placeholder="Password">
        <button name="login" type="submit">Login</button>
    </Form>
</body>

</html>
