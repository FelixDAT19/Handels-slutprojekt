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

//session to create alerts on actions
if (isset($_SESSION['alertError'])) {
    if (isset($_SESSION["alertError"])) {
        $error = $_SESSION["alertError"];
    } else {
        $error = "";
    }

    echo "<div class='error-msg'>
    <i class='fa fa-times-circle'></i>
    $error
  </div>";
} elseif (isset($_SESSION['alertSuccess'])) {
    if (isset($_SESSION["alertSuccess"])) {
        $success = $_SESSION["alertSuccess"];
    } else {
        $success = "";
    }

    echo "<div class='success-msg'>
    <i class='fa fa-check'></i>
    $success
  </div>";
}

$db = connectDatabase();

if (isset($_POST['login'])) {
    $username = trim(htmlspecialchars($_POST["username"]));     //Filtering username input
    $password = $_POST["password"];

    //Checks that username and password are set.
    if (!isset($username) or $username == "") {
        $_SESSION['alertError'] = "Användarnamn saknas";
        header("location:AdminPage.php");
        exit();
    } elseif (!isset($_POST['password']) or $password == "") {
        $_SESSION['alertError'] = "Lösenord saknas";
        header("location:AdminPage.php");
        exit();
    }

    //Creates sql & compares the username input to the usernames in the database
    $sql = "SELECT username, hashedPswd FROM adminlogin WHERE UserName=:username";
    $stmt = $db->prepare($sql);
    $result = $stmt->execute(['username' => $username]);

    //Redirects back to the login page if the username doesn't match
    if ($result == false) {
        $_SESSION['alertError'] = "Fel användarnamn eller lösenord";
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
        $_SESSION['alertError'] = "Fel användarnamn eller lösenord";
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
    <link rel="stylesheet" href="adminpage.css">
    <title>Login</title>
</head>

<body>
    <div class="center-screen">
        <div>
            <img class="loginimg" src="https://cdn.discordapp.com/attachments/950309989157863434/958240009310334996/handek-removebg-preview.png" class="logo">
        </div>
        <div class="loginform">
            <Form method="POST" action="Login.php" autocomplete="off">
                <input class="logininput" type="text" id="username" name="username" placeholder="Username" autocomplete="off"> <br>
                <input class="logininput" type="password" id="password" name="password" placeholder="Password" autocomplete="off"><br>
                <button class="loginbutton" name="login" type="submit">Logga in</button>
            </Form>
        </div>
    </div>
</body>

</html>
<?php
unset($_SESSION['alertError']);
unset($_SESSION['alertSuccess']);
