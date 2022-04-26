<?php
//Stop bugs
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
require_once "Config.php";
require_once "functionsAddcompany.php";

session_start();

//Session to check if you are logged in & redirect if u aren't
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
        $placement = $_SESSION['place'];

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
    //creates empty variables for the imputs if there are no previous inputs
    $companyName = "";
    $companyInfo = "";
    $externalUrl = "";
    $logoUrl = "";
    $foodCheck = "";
    $placement = [];
}

//creates empty variables for the post data to be added to
$_SESSION['editCompany'] = "";
$chosenCompany = "";
$offerInfo = "";
$offerPrice = "";

//connects to the database
$db = connectDatabase();

//makes sure one of the radio values are always checked.
if ($foodCheck == "") {
    $radiochecked = ['0' => "", '1' => ""];
    if (isset($_POST['foodCheck'])) {
        $radiochecked[$_POST['foodCheck']] = "checked";
    } else {
        $radiochecked['0'] = "checked";
    }
} else {
    $radiochecked = ['0' => "", '1' => ""];
    if (isset($_POST['foodCheck'])) {
        $radiochecked[$_POST['foodCheck']] = "checked";
    } else {
        $radiochecked[$foodCheck] = "checked";
    }
}

if ($_POST) {
    if (isset($_POST['editCompany']) && $_POST['editCompany'] != "") {
        $_SESSION['editCompany'] = array_key_first($_POST['editCompany']);
        header("location:editCompany.php");
        exit();
    } elseif (isset($_POST['deletePlace']) && $_POST['deletePlace'] != "") {
        //checks if the user has selected to delete a place, creates sql & deletes the post from the placement
        deletePlace($db);
    } elseif (isset($_POST['deleteCompany']) && $_POST['deleteCompany'] != "") {
        //checks if the user has selected to delete a company
        deleteCompany($db);
    } elseif (isset($_POST['deleteOffer'])) {
        //checks if the user has selected to delete an offer
        deleteOffer($db);
    } elseif (isset($_POST['addOffer'])) {
        //checks if the user is trying to add an offer
        createOffer($db);
    } elseif (isset($_POST['addCompany'])) {
        //checks if the user is trying to add a company
        createCompany($db);
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
    <title>Add company</title>
</head>

<body>
    <header>
        <nav class="navbar">
            <div class="navcontent">
                <li><a class="btn adminbtn" href="Adminpage.php">Admin</a></li>
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
        ?>
        <form method="POST">
            <select class="selectcompany" name="companies">
                <?php
                selectCompany($db);
                ?>
            </select>
            <input type="text" id="offerInfo" name="offerInfo" maxlength="150" placeholder="Kort info om erbjudandet" autocomplete="off">
            <input type="number" id="offerPrice" name="offerPrice" maxlength="20" placeholder="Pris på produkt" autocomplete="off">
            <label for="offerPrice">€</label>
            <button name="addOffer" type="submit" autocomplete="off">Lägg till</button>
        </form>
        <table>
            <thead>
                <tr>
                    <th>Företag:</th>
                    <th>Företagsinfo:</th>
                    <th>Företagets hemsida:</th>
                    <th>Logons url:</th>
                    <th>Ändra:</th>
                    <th>Ta bort:</th>
                </tr>
            </thead>
            <tbody>
                <?php
                companyList($db);
                ?>
            </tbody>
        </table>

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
                placementList($db);
                ?>
            </tbody>
        </table>

        <table>
            <thead>
                <tr>
                    <th>Företag:</th>
                    <th>Erbjudande:</th>
                    <th>Pris</th>
                    <th>Ta bort:</th>
                </tr>
            </thead>
            <tbody>
                <?php
                offerList($db);
                ?>
            </tbody>
        </table>
        <div class="inputbox">
            <Form method="POST">
                <input value="<?= $companyName; ?>" type="text" id="companyName" name="companyName" maxlength="100" placeholder="Företagsnamn" autocomplete="off"><br>
                <input value="<?= $companyInfo; ?>" type="text" id="companyInfo" name="companyInfo" maxlength="350" placeholder="Företagsinfo" autocomplete="off"><br>
                <input value="<?= $externalUrl; ?>" type="url" id="externalUrl" name="externalUrl" maxlength="500" placeholder="Företagets hemsida" autocomplete="off"><br>
                <input value="<?= $logoUrl; ?>" type="url" id="logoUrl" name="logoUrl" maxlength="500" placeholder="företagets logo" autocomplete="off"><br>
                <label>Är det ett matföretag?</label>
                <input <?= $radiochecked['1']; ?> type="radio" id="foodCheck" name="foodCheck" value="1">
                <label for="foodCheck">Ja</label>
                <input <?= $radiochecked['0']; ?> type="radio" id="foodCheck" name="foodCheck" value="0">
                <label for="foodCheck">Nej</label><br>
                <div class="dropdown">
                    <div class="dropbtn">välj montrar</div>
                    <div class="dropdown-content">
                        <?php
                        selectPlacement($db, $placement);
                        ?>
                    </div>
                </div><br>
                <button name="addCompany" type="submit">Lägg till</button>
            </Form>
        </div>
    </main>
</body>

</html>
<?php
unset($_SESSION['alertError']);
unset($_SESSION['alertSuccess']);
