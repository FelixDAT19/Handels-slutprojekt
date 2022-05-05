<?php
//Stop bugs
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
require_once "Config.php";
require_once "functionsEditcompany.php";

session_start();

//Session to check if you are logged in
if (empty($_SESSION['loggedin'])) {
    header('Location: Login.php');
    exit;
}

//checks if the error or success-alerts are set on refresh/load, assigns previous inputs to variables & clears the sessions
if (isset($_SESSION['alertError'])) {
    if (isset($_SESSION['companyName'], $_SESSION['companyInfo'], $_SESSION['externalUrl'], $_SESSION['logoUrl'], $_SESSION['foodCheck'], $_SESSION['place'])) {
        $companyName = $_SESSION['companyName'];
        $companyInfo = $_SESSION['companyInfo'];
        $externalUrl = $_SESSION['externalUrl'];
        $logoUrl = $_SESSION['logoUrl'];
        $foodCheck = $_SESSION['foodCheck'];

        var_dump($_SESSION['place']);
        $_SESSION['companyName'] = "";
        $_SESSION['companyInfo'] = "";
        $_SESSION['externalUrl'] = "";
        $_SESSION['logoUrl'] = "";
        $_SESSION['foodCheck'] = "";
        $_SESSION['place'] = [];
    } else {
        $companyName = "";
        $companyInfo = "";
        $externalUrl = "";
        $logoUrl = "";
        $foodCheck = "";
        $placement = [];
    }
} else {
    //creates empty variables if the inputs aren't set
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

    //gets the error message from the error session & prints it out
    echo "<div class='alertError'> $error </div>";
} elseif (isset($_SESSION['alertSuccess'])) {
    if (isset($_SESSION["alertSuccess"])) {
        $success = $_SESSION["alertSuccess"];
    } else {
        $success = "";
    }

    //gets the success message from the success session & prints it out
    echo "<div class='alertSuccess'> $success </div>";
}

//checks if the edit-data is set & redirects to addcompany if it's not
if (empty($_SESSION['editCompany']) or $_SESSION['editCompany'] == "") {
    header("location:Addcompany.php");
    exit();
}

//connects to the database
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

$selectedCompany = $_SESSION['editCompany'];

if (isset($_POST['deletePlace']) && $_POST['deletePlace'] != "") {
    //checks if the user has selected to delete a place, creates sql & deletes the post from the placement
    deletePlace($db);
}

if (isset($_SESSION['editCompany'])) {
    //checks if the session editcompany is set & gets the selected companys data from the database.
    $getCompanyInfo = getCompanyInfo($db, $selectedCompany, $selectedCompany);
    $companyName = $getCompanyInfo->companyName;
    $companyInfo = $getCompanyInfo->companyInfo;
    $externalUrl = $getCompanyInfo->externalUrl;
    $logoUrl = $getCompanyInfo->logoUrl;
    $foodCheck = $getCompanyInfo->foodCheck;
    $oldPlacement = $getCompanyInfo->oldPlacement;

    //compares the radio value with the database & checks the value from the database. 
    $radiochecked = ['0' => "", '1' => ""];
    if (isset($_POST['foodCheck'])) {
        $radiochecked[$_POST['foodCheck']] = "checked";
    } else {
        $radiochecked[$foodCheck] = "checked";
    }
    if (isset($_POST['submitChanges'])) {
        //checks if the user is trying to submit changes & checks if all inputs are valid. If they aren't it gives an error message
        if ($_POST['companyName'] == "") {
            $_SESSION['alertError'] = "Företagsnamn saknas";
            header("location:editCompany.php");
            exit();
        } elseif ($_POST['companyInfo'] == "") {
            $_SESSION['alertError'] = "Företagsinfo saknas";
            header("location:editCompany.php");
            exit();
        } elseif ($_POST['logoUrl'] == "") {
            $_SESSION['alertError'] = "Logo saknas";
            header("location:editCompany.php");
            exit();
        } elseif (isset($_POST['place']) && $_POST['place'] == "") {
            $_SESSION['alertError'] = "Inga montrar är valda";
            header("location:editCompany.php");
            exit();
        } elseif (!isset($_POST['place'])) {
            $_SESSION['alertError'] = "Inga montrar är valda";
            header("location:editCompany.php");
            exit();
        } else {
            //if the inputs are correct it makes the changes in the database
            updateCompany($db, $selectedCompany, $oldPlacement, $placement);
        }
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
    <title>Edit company</title>
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
        <div class="contentbox">
            <div class="tablebox">
                <table>
                    <thead>
                        <tr>
                            <th>Monter:</th>
                            <th>Bokad av:</th>
                            <th>Töm monter:</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        placementList($db, $selectedCompany);
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="inputbox">
                <Form method="POST">
                    <input value="<?= $companyName; ?>" type="text" id="companyName" name="companyName" maxlength="100" autocomplete="off"><br>
                    <textarea type="text" id="companyInfo" name="companyInfo" maxlength="350" autocomplete="off"><?= $companyInfo; ?></textarea><br>
                    <input value="<?= $externalUrl; ?>" type="url" id="externalUrl" name="externalUrl" maxlength="500" autocomplete="off"><br>
                    <input value="<?= $logoUrl; ?>" type="url" id="logoUrl" name="logoUrl" maxlength="500" autocomplete="off"><br>
                    <label>Är det ett matföretag?</label>
                    <input <?= $radiochecked['1']; ?> type="radio" id="foodCheck" name="foodCheck" value="1">
                    <label for="foodCheck">Ja</label>
                    <input <?= $radiochecked['0']; ?> type="radio" id="foodCheck" name="foodCheck" value="0">
                    <label for="foodCheck">Nej</label><br>
                    <div class="dropdown">
                        <div class="dropbtn">välj montrar</div>
                        <div class="dropdown-content">
                            <div class="grid-container">
                                <?php
                                selectPlacement($db, $selectedCompany, $placement);
                                ?>
                            </div>
                        </div>
                    </div><br>
                    <button name="submitChanges" type="submit">Genomför ändringar</button>
                </Form>
            </div>
        </div>
    </main>
</body>

</html>
<?php
unset($_SESSION['alertError']);
unset($_SESSION['alertSuccess']);
