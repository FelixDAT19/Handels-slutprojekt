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


//creates empty variables for the post data to be added to
$_SESSION['editCompany'] = "";
$companyName = "";
$companyInfo = "";
$externalUrl = "";
$logoUrl = "";
$foodCheck = "";
$placement = "";
$chosenCompany = "";
$offerInfo = "";
$offerPrice = "";

$db = connectDatabase();

//makes sure one of the radio values are always checked.
$radiochecked = ['0' => "", '1' => ""];
if (isset($_POST['foodCheck'])) {
    $radiochecked[$_POST['foodCheck']] = "checked";
} else {
    $radiochecked['0'] = "checked";
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
    <link rel="stylesheet" href="dropdown.css">
    <title>Add company</title>
</head>

<body>
    <header>
        <h1><a href="Adminpage.php">Admin</a></h1>
        <a href="Sponsors.php" class="btn">Sponsorer</a>
        <a href="Addcompany.php" class="btn">Utställare</a>

        <form method="POST">
            <select name="companies">
                <?php
                selectCompany($db);
                ?>
            </select>
            <input type="text" id="offerInfo" name="offerInfo" maxlength="150" placeholder="Kort info om erbjudandet">
            <input type="number" id="offerPrice" name="offerPrice" maxlength="20" placeholder="Pris på produkt">
            <label for="offerPrice">€</label>
            <button name="addOffer" type="submit">Lägg till</button>
        </form>
    </header>
    <main>
        <table>
            <thead>
                <tr>
                    <th>Företag:</th>
                    <th>Företagsinfo:</th>
                    <th>Företagets hemsida:</th>
                    <th>Logons url:</th>
                    <th>Ta bort:</th>
                    <th>Ändra:</th>
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

        <Form method="POST">
            <input value="<?= $companyName; ?>" type="text" id="companyName" name="companyName" maxlength="100" placeholder="Företagsnamn">
            <input value="<?= $companyInfo; ?>" type="text" id="companyInfo" name="companyInfo" maxlength="350" placeholder="Företagsinfo">
            <input value="<?= $externalUrl; ?>" type="url" id="externalUrl" name="externalUrl" maxlength="500" placeholder="Företagets hemsida">
            <input value="<?= $logoUrl; ?>" type="url" id="logoUrl" name="logoUrl" maxlength="500" placeholder="företagets logo">
            <label>Är det ett matföretag?</label>
            <input <?= $radiochecked['1']; ?> type="radio" id="foodCheck" name="foodCheck" value="1">
            <label for="foodCheck">Ja</label>
            <input <?= $radiochecked['0']; ?> type="radio" id="foodCheck" name="foodCheck" value="0">
            <label for="foodCheck">Nej</label>
            <div class="dropdown">
                <div class="dropbtn">välj montrar</div>
                <div class="dropdown-content">
                    <?php
                    selectPlacement($db);
                    ?>
                </div>
            </div>
            <button name="addCompany" type="submit">Lägg till</button>
        </Form>
    </main>
</body>

</html>