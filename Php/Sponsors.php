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
    header('Location: Login.php');
    exit;
}

//checks if the error or success-alerts are set on refresh/load, assigns previous inputs to variables & clears the sessions
if (isset($_SESSION['alertError'])) {
    if (isset($_SESSION['sponsorName'], $_SESSION['sponsorUrl'], $_SESSION['logoUrl'])) {
        $sponsorName = $_SESSION['sponsorName'];
        $sponsorUrl = $_SESSION['sponsorUrl'];
        $logoUrl = $_SESSION['logoUrl'];

        $_SESSION['sponsorName'] = "";
        $_SESSION['sponsorUrl'] = "";
        $_SESSION['logoUrl'] = "";
    } else {
        $sponsorName = "";
        $sponsorUrl = "";
        $logoUrl = "";
    }
} else {
    //creates empty variables if there are no previous inputs
    $sponsorName = "";
    $sponsorUrl = "";
    $logoUrl = "";
}

$db = connectDatabase();

//creates the function array_key_first if the server runs a php version that doesn't support it
if (!function_exists('array_key_first')) {
    function array_key_first(array $arr)
    {
        foreach ($arr as $key => $unused) {
            return $key;
        }
        return NULL;
    }
}

if (isset($_POST['deleteSponsor']) && $_POST['deleteSponsor'] != "") {
    //checks if the user has selected to delete a place, creates sql & deletes the post from the placement
    deleteSponsor($db);
} elseif (isset($_POST['addSponsor'])) {
    //checks if the user is trying to add a new sponsor & checks that the inputs are correct.
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
        //adds the sponsor if the inputs are correct
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
        <nav class="navbar">
            <div class="navcontent">
                <li><a class="btn adminbtn" href="AdminPage.php">Admin</a></li>
                <li><a class="btn" href="Sponsors.php">Sponsorer</a></li>
                <li><a class="btn" href="Addcompany.php">Utställare</a></li>
            </div>
        </nav>
    </header>
    <main>
        <?php
        //session to create alerts on actions
        if (isset($_SESSION['alertError'])) {
            if (isset($_SESSION["alertError"])) {
                $error = $_SESSION["alertError"];
            } else {
                $error = "";
            }

            //gets the error message from the error session & prints it out
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

            //gets the success message from the success session & prints it out
            echo "<div class='success-msg'>
                    <i class='fa fa-check'></i>
                    $success
                  </div>";
        } ?>

        <div class="contentbox">
            <div class="tablebox">
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
            </div>
            <div class="inputbox">
                <Form method="POST">
                    <input value="<?= $sponsorName; ?>" type="text" id="sponsorName" name="sponsorName" maxlength="50" placeholder="Namn på sponsor" autocomplete="off"> <br>
                    <input value="<?= $sponsorUrl; ?>" type="url" id="sponsorUrl" name="sponsorUrl" maxlength="500" placeholder="Länk till Sponsorns hemsida" autocomplete="off"><br>
                    <input value="<?= $logoUrl; ?>" type="url" id="logoUrl" name="logoUrl" maxlength="500" placeholder="Länk till logo" autocomplete="off"><br>
                    <button name="addSponsor" type="submit">Spara sponsor</button>
                </Form>
            </div>
        </div>
    </main>
</body>

</html>
<?php
unset($_SESSION['alertError']);
unset($_SESSION['alertSuccess']);
