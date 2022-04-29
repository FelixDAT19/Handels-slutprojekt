<?php
require_once "qrCodeClass.php";

if (!function_exists('array_key_first')) {
    function array_key_first(array $arr)
    {
        foreach ($arr as $key => $unused) {
            return $key;
        }
        return NULL;
    }
}

function deleteUser($db)
{
    $deleteUser = array_key_first($_POST['deleteUser']);
    $sqlDeleteUser = "DELETE FROM adminlogin WHERE id=$deleteUser";

    $stmtDeleteUser = $db->prepare($sqlDeleteUser);

    $stmtDeleteUser->execute();

    $deleteUser = "";
    $_POST['deleteUser'] = "";
};

function deleteCompetition($db)
{
    $deleteCompetition = array_key_first($_POST['deleteCompetition']);
    $sqlDeleteCompetition = "DELETE FROM competitions WHERE id=$deleteCompetition";

    $stmtDeleteCompetition = $db->prepare($sqlDeleteCompetition);

    $stmtDeleteCompetition->execute();

    $deleteCompetition = "";
    $_POST['deleteCompetition'] = "";
};

function deleteOpenHours($db)
{
    $deleteOpenHours = array_key_first($_POST['deleteOpenHours']);

    $sqlDeleteOpenHours = "DELETE FROM openhours WHERE id=$deleteOpenHours";

    $stmtDeleteOpenHours = $db->prepare($sqlDeleteOpenHours);

    $stmtDeleteOpenHours->execute();

    $deleteOpenHours = "";
    $_POST['deleteOpenHours'] = "";
};

function checkDupesUsers($db)
{
    //creates sql used to check for already existing companies.
    $sqlNodupes = "SELECT * FROM adminlogin;";

    $stmtNodupes = $db->prepare($sqlNodupes);

    $stmtNodupes->execute([]);

    $rowNodupes = $stmtNodupes->fetchAll();

    $a = array();

    //checks the company table & compares the input to the already existing companies
    foreach ($rowNodupes as $names) {

        $arrayContent = $names['username'];
        array_push($a, $arrayContent);
    };
    return $a;
}

function checkDupesCompetitions($db)
{
    //creates sql used to check for already existing companies.
    $sqlNodupes = "SELECT * FROM competitions;";

    $stmtNodupes = $db->prepare($sqlNodupes);

    $stmtNodupes->execute([]);

    $rowNodupes = $stmtNodupes->fetchAll();

    $a = array();

    //checks the company table & compares the input to the already existing companies
    foreach ($rowNodupes as $names) {

        $arrayContent = $names['formUrl'];
        array_push($a, $arrayContent);
    };
    return $a;
}

function checkDupesQr($db)
{
    $return = new stdClass();
    //creates sql used to check for already existing companies.
    $sqlNodupes = "SELECT * FROM qrcodes;";

    $stmtNodupes = $db->prepare($sqlNodupes);

    $stmtNodupes->execute([]);

    $rowNodupes = $stmtNodupes->fetchAll();

    $a = array();
    $b = array();

    //checks the company table & compares the input to the already existing companies
    foreach ($rowNodupes as $qrs) {

        $arrayContenta = $qrs['qrName'];
        array_push($a, $arrayContenta);

        $arrayContentb = $qrs['Url'];
        array_push($b, $arrayContentb);
    };
    $return->qrName = $a;
    $return->Url = $b;

    return $return;
}

function userList($db)
{
    //creates sql & creates a list with all existing companies.
    $sqlUserList = "SELECT *
    FROM adminlogin";

    $stmtUserList = $db->prepare($sqlUserList);
    $stmtUserList->execute([]);

    while ($row = $stmtUserList->fetch()) {
        echo "<tr>
        <td>$row[username]</td>
        <td>
        <form method='post'><input type='submit' name='deleteUser[$row[id]]' value='ta bort'></form>
        </td>
        </tr>";
    }
}

function addUser($db, $userName, $password)
{
    $sqlAddUser = "INSERT INTO adminlogin (username, hashedPswd)
                VALUES (:username, :password);";

    $stmtAddUser = $db->prepare($sqlAddUser);

    $stmtAddUser->bindParam('username', $userName, PDO::PARAM_STR);
    $stmtAddUser->bindParam('password', $password, PDO::PARAM_STR);

    $stmtAddUser->execute();
    $_SESSION['alertSuccess'] = "Användaren har lagts till";
    header("location:AdminPage.php");
    exit();
}

function createUser($db)
{
    $a = checkDupesUsers($db);

    //checks that both usernames and password are set.
    if (!isset($_POST['username']) or $_POST['username'] == "") {
        $_SESSION['alertError'] = "Användarnamn saknas";
        header("location:AdminPage.php");
        exit();
    } elseif (!isset($_POST['password']) or $_POST['password'] == "") {
        $_SESSION['alertError'] = "Lösenord saknas";
        header("location:AdminPage.php");
        exit();
    } else {
        $username = trim(htmlspecialchars($_POST["username"]));     //Filtering username input
        $password = $_POST["password"];

        $hashedPswd = password_hash($password, PASSWORD_DEFAULT);       //Hashes password
        //Checks if the company you want to add already exists, adds it if it doesn't
        if (isset($username) && in_array($username, $a)) {
            $_SESSION['alertError'] = "Användaren finns redan";
            header("location:AdminPage.php");
            exit();
        } else {
            addUser($db, $username, $hashedPswd);
        }
    }
}

function competitionList($db)
{
    //creates sql & creates a list with all existing companies.
    $sqlCompetitionList = "SELECT *, competitions.id AS compId FROM competitions
    INNER JOIN company ON competitions.companyId=company.id;";

    $stmtCompetitionList = $db->prepare($sqlCompetitionList);
    $stmtCompetitionList->execute([]);

    while ($row = $stmtCompetitionList->fetch()) {
        echo "<tr>
        <td>$row[name]</td>
        <td>$row[formUrl]</td>
        <td>
            <form method='post'><input type='submit' name='deleteCompetition[$row[compId]]' value='ta bort'></form>
        </td>
    </tr>";
    }
}

function selectCompany($db)
{
    //prepares sql & binds params.
    $sqlSelectCompany = "SELECT * FROM company ORDER BY id;";

    $stmtSelectCompany = $db->prepare($sqlSelectCompany);

    $stmtSelectCompany->execute([]);

    $row = $stmtSelectCompany->fetchAll();

    //loops the placement table & creates a checkbox list with all the showcases
    echo "<option value='' disabled selected>Företag</option>";
    foreach ($row as $companies) {
        echo "
    <option value='$companies[id]'>$companies[name]</option>";
    };
}

function createCompetition($db)
{
    $chosenCompany = $_POST['companies'];
    $competitionUrl = trim(htmlspecialchars($_POST['formUrl']));
    if (!isset($_POST['companies'])) {
        $_SESSION['alertError'] = "Välj ett företag";
        header("location:AdminPage.php");
        exit();
    } elseif (isset($_POST['companies']) && $_POST['companies'] != "") {
        //Checks all fields are filled in & that the price is more than 0, and sends error alert of not
        if ($_POST['formUrl'] == "") {
            $_SESSION['alertError'] = "Tävlingslänk saknas";
            header("location:AdminPage.php");
            exit();
        } else {
            $a = checkDupesCompetitions($db);
            //Checks if the company you want to add already exists, adds it if it doesn't
            if (isset($competitionUrl) && in_array($competitionUrl, $a)) {
                $_SESSION['alertError'] = "Tävlingen finns redan";
                header("location:AdminPage.php");
                exit();
            } else {
                $sqlAddCompetition = "INSERT INTO competitions (companyId, formUrl)
            VALUES (:chosenCompany, :competitionUrl);";

                $stmtAddCompetition = $db->prepare($sqlAddCompetition);

                $stmtAddCompetition->bindParam('chosenCompany', $chosenCompany, PDO::PARAM_STR);
                $stmtAddCompetition->bindParam('competitionUrl', $competitionUrl, PDO::PARAM_STR);

                $stmtAddCompetition->execute();
            }
        }
    }
}

function addOpenHours($db)
{
    $openHours = $_POST['openHours'];
    $openDates = $_POST['openDates'];

    if (!isset($openHours) or $openHours == "") {
        $_SESSION['alertError'] = "Öppettid saknas";
        header("location:AdminPage.php");
        exit();
    } elseif (!isset($openDates) or $openDates == "") {
        $_SESSION['alertError'] = "Datum saknas";
        header("location:AdminPage.php");
        exit();
    } else {
        $sqlAddOpenHours = "INSERT INTO openhours (openHours, openDates)
                VALUES (:openHours, :openDates);";

        $stmtAddOpenHours = $db->prepare($sqlAddOpenHours);

        $stmtAddOpenHours->bindParam('openHours', $openHours, PDO::PARAM_STR);
        $stmtAddOpenHours->bindParam('openDates', $openDates, PDO::PARAM_STR);

        $stmtAddOpenHours->execute();
        $_SESSION['alertSuccess'] = "Öppettiden har lagts till";
        header("location:AdminPage.php");
        exit();
    }
}

function addQrCode($db)
{
    $randomString = generateRandomString();

    $qrName = trim(htmlspecialchars($_POST["qrName"]));
    $qrCodeLink = trim(htmlspecialchars($_POST["qrUrl"]));

    if (!isset($qrName) or $qrName == "") {
        $_SESSION['alertError'] = "qr namn saknas";
        header("location:AdminPage.php");
        exit();
    } elseif (!isset($qrCodeLink) or $qrCodeLink == "") {
        $_SESSION['alertError'] = "qr länk saknas";
        header("location:AdminPage.php");
        exit();
    } else {
        $getQrInfo = checkDupesQr($db);
        $qrNames = $getQrInfo->qrName;
        $Urls = $getQrInfo->Url;

        //Checks if the company you want to add already exists, adds it if it doesn't
        if (in_array($qrName, $qrNames)) {
            $_SESSION['alertError'] = "en qr-kod med namnet finns redan";
            header("location:AdminPage.php");
            exit();
        } elseif (in_array($qrCodeLink, $Urls)) {
            $_SESSION['alertError'] = "Det finns redan en qr med denna Url";
            header("location:AdminPage.php");
            exit();
        } else {
            $sqlAddQrCodes = "INSERT INTO qrcodes (randomId, Url, qrName) VALUES (:randomId, :qrCodeLink, :qrName );";

            $stmtAddQrCodes = $db->prepare($sqlAddQrCodes);

            $stmtAddQrCodes->bindParam('randomId', $randomString, PDO::PARAM_STR);
            $stmtAddQrCodes->bindParam('qrCodeLink', $qrCodeLink, PDO::PARAM_STR);
            $stmtAddQrCodes->bindParam('qrName', $qrName, PDO::PARAM_STR);


            $stmtAddQrCodes->execute();

            $qc = new SaveQRCODE();

            $qc->URL("https://datanom.ax/~williame/Handelsmessan/qrscan.php?qrId=" . $randomString);

            if ($qc->QRCODE(400, $qrName) === null) {
                $_SESSION['alertError'] = "QR-kod har inte lagts till";
            } else {
                $_SESSION['alertSuccess'] = "QR-kod har lagts till";
            }


            header("location:AdminPage.php");
            exit();
        }
    }
}

function deleteQrData($db)
{
    $location = 'qrcodes/';
    $deleteQrData = array_key_first($_POST['deleteQrData']);
    var_dump($deleteQrData);
    //sql for deleting the qr-data
    $sqlDeleteQrData = "DELETE FROM qrscan WHERE id=$deleteQrData";

    $stmtDeleteQrData = $db->prepare($sqlDeleteQrData);

    $stmtDeleteQrData->execute();

    $deleteQrData = "";
    $_POST['deleteQrData'] = "";

    $_SESSION['alertSuccess'] = "Datan har raderats";
    header("location:AdminPage.php");
    exit();
}

function deleteQr($db)
{
    $deleteQrCode = array_key_first($_POST['deleteQr']);

    $location = 'qrcodes/';

    //sql for deleting the qr-data
    $sqlDeleteQrData = "DELETE FROM qrscan WHERE qrId=$deleteQrCode";

    $stmtDeleteQrData = $db->prepare($sqlDeleteQrData);

    $stmtDeleteQrData->execute();

    $sql = "SELECT * FROM qrcodes WHERE id = $deleteQrCode";

    $stmt = $db->prepare($sql);
    $stmt->execute();

    $row = $stmt->fetch();
    $filename = $location.$row['qrName'] . ".png";

    unlink($filename);


    //Sql for deleting the qr
    $sqlDeleteQrCode = "DELETE FROM qrcodes WHERE id=$deleteQrCode";

    $stmtDeleteQrCode = $db->prepare($sqlDeleteQrCode);

    $stmtDeleteQrCode->execute();

    $deleteQrCode = "";
    $_POST['deleteQr'] = "";

    $_SESSION['alertSuccess'] = "QR-koden har raderats";
    header("location:AdminPage.php");
    exit();
};

function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
