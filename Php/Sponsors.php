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
if (isset($_SESSION['alertError'])) {
    if (isset($_SESSION['sponsorName'], $_SESSION['companyInfo'], $_SESSION['externalUrl'], $_SESSION['logoUrl'], $_SESSION['foodCheck'], $_SESSION['place'])) {
        $companyName = $_SESSION['companyName'];
        $companyInfo = $_SESSION['companyInfo'];
        $externalUrl = $_SESSION['externalUrl'];

        $_SESSION['companyName'] = "";
        $_SESSION['companyInfo'] = "";
        $_SESSION['externalUrl'] = "";
    } else {
        $companyName = "";
        $companyInfo = "";
        $externalUrl = "";
    }
} else {
    $companyName = "";
    $companyInfo = "";
    $externalUrl = "";
}

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
if (isset($_SESSION['alertError'])) {
    if (isset($_SESSION['sponsorName'], $_SESSION['sponsorUrl'], $_SESSION['logoUrl'])) {
        $companyName = $_SESSION['sponsorName'];
        $companyInfo = $_SESSION['sponsorUrl'];
        $externalUrl = $_SESSION['logoUrl'];

        $_SESSION['sponsorName'] = "";
        $_SESSION['sponsorUrl'] = "";
        $_SESSION['logoUrl'] = "";
    } else {
        $companyName = "";
        $companyInfo = "";
        $externalUrl = "";
        $logoUrl = "";
        $foodCheck = "";
        $placement = [];
    }
} else {
    $companyName = "";
    $companyInfo = "";
    $externalUrl = "";
    $logoUrl = "";
    $foodCheck = "";
    $placement = [];
}

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
        $_SESSION['alertError'] = "Sponsornamn saknas";
        header("location:Sponsors.php");
        exit();
    } elseif ($_POST['sponsorUrl'] == "") {
        $_SESSION['alertError'] = "Länk till sponsorns hemsida saknas";
        header("location:Sponsors.php");
        exit();
    } elseif ($_POST['logoUrl'] == "") {
        $_SESSION['alertError'] = "Logo saknas";
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
        <Form method="POST">
            <input value="<?= $sponsorName; ?>" type="text" id="sponsorName" name="sponsorName" maxlength="50" placeholder="Namn på sponsor" autocomplete="off">
            <input value="<?= $sponsorUrl; ?>" type="url" id="sponsorUrl" name="sponsorUrl" maxlength="500" placeholder="Länk till Sponsorns hemsida" autocomplete="off">
            <input value="<?= $logoUrl; ?>" type="url" id="logoUrl" name="logoUrl" maxlength="500" placeholder="Länk till logo" autocomplete="off">
            <button name="addSponsor" type="submit">Spara sponsor</button>
        </Form>
    </main>
</body>

</html>
<?php
unset($_SESSION['alertError']);
unset($_SESSION['alertSuccess']);
