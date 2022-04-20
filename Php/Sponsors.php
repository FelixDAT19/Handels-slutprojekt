<?php
//Stop bugs
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
require_once "Config.php";
require_once "functionsAddsponsors.php";

session_start();

//Session to check if you are logged in
if (empty($_SESSION['loggedin'])) {
    $error[] = "'Username or password is incorrect'";
    header('Location: Login.php');
    exit;
}

//session to create alerts on actions
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

$sponsorName = "";
$sponsorUrl = "";
$logoUrl = "";
if (isset($_POST['editSponsor']) && $_POST['editSponsor'] != "") {
    $_SESSION['editSponsor'] = array_key_first($_POST['editSponsor']);
    header("location:editSponsor.php");
    exit();
} elseif (isset($_POST['deleteSponsor']) && $_POST['deleteSponsor'] != "") {
    //checks if the user has selected to delete a place, creates sql & deletes the post from the placement
    deleteSponsor($db);
} elseif (isset($_POST['addSponsor'])) {
    if ($_POST['sponsorName'] == "") {
        $_SESSION['alert'] = "Sponsornamn saknas";
        header("location:Sponsors.php");
        exit();
    } elseif ($_POST['sponsorUrl'] == "") {
        $_SESSION['alert'] = "Länk till sponsorns hemsida saknas";
        header("location:Sponsors.php");
        exit();
    } elseif ($_POST['logoUrl'] == "") {
        $_SESSION['alert'] = "Logo saknas";
        header("location:Sponsors.php");
        exit();
    } else {
        createSponsor($db);
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
    <title>Sponsors</title>
</head>

<body>
    <header>
        <h1><a href="Adminpage.php">Admin</a></h1>
        <a href="Sponsors.php" class="btn">Sponsorer</a>
        <a href="Addcompany.php" class="btn">Utställare</a>
    </header>
    <main>
        <table>
            <thead>
                <tr>
                    <th>Namn:</th>
                    <th>Hemsida:</th>
                    <th>Länk till Logo:</th>
                    <th>Ta bort:</th>
                </tr>
            </thead>
            <tbody>
                <?php
                sponsorList($db);
                ?>
            </tbody>
        </table>
        <Form autocomplete="off" method="POST">
            <input value="<?= $sponsorName; ?>" type="text" id="sponsorName" name="sponsorName" maxlength="50" placeholder="Namn på sponsor">
            <input value="<?= $sponsorUrl; ?>" type="url" id="sponsorUrl" name="sponsorUrl" maxlength="500" placeholder="Länk till Sponsorns hemsida">
            <input value="<?= $logoUrl; ?>" type="url" id="logoUrl" name="logoUrl" maxlength="500" placeholder="Länk till logo">
            <button name="addSponsor" type="submit">Spara sponsor</button>
        </Form>
    </main>
</body>

</html>
