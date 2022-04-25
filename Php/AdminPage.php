<?php
//Stop bugs
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
require_once "Config.php";
require_once "functionsAdminPage.php";

//Session to check if you are logged in
session_start();
if (empty($_SESSION['loggedin'])) {
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

if (isset($_POST['createAccount'])) {
    createUser($db);
}

if (isset($_POST['deleteUser'])) {
    deleteUser($db);
}

if (isset($_POST['deleteCompetition'])) {
    deleteCompetition($db);
}

if (isset($_POST['createCompetition'])) {
    createCompetition($db);
}
if (isset($_POST['addOpenHours'])) {
    addOpenhours($db);
}

if (isset($_POST['deleteOpenHours'])) {
    deleteOpenHours($db);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="adminpage.css">
    <title>Admin main</title>
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
        <table>
            <thead>
                <tr>
                    <th>Tävlingsägare:</th>
                    <th>Länk till tävling:</th>
                    <th>Ta bort:</th>
                </tr>
            </thead>
            <tbody>
                <?php
                competitionList($db);
                ?>
            </tbody>
        </table>
        <form method="POST">
            <select name="companies">
                <?php
                selectCompany($db);
                ?>
            </select>
            <input type="url" id="formUrl" name="formUrl" placeholder="Länk till ny tävling" maxlength="500" autocomplete="off">
            <button name="createCompetition" type="submit">Lägg till</button>
        </form>
        <table>
            <thead>
                <tr>
                    <th>Användarnamn:</th>
                    <th>Ta bort:</th>
                </tr>
            </thead>
            <tbody>
                <?php
                userList($db);
                ?>
            </tbody>
        </table>
        <Form method="POST">
            <input type="text" id="username" name="username" placeholder="Username" autocomplete="off">
            <input type="password" id="password" name="password" placeholder="Password" autocomplete="off">
            <button name="createAccount" type="submit">Create Account</button>
        </Form>
        <table>
            <thead>
                <tr>
                    <th>Scannad kod:</th>
                    <th>När koden scannats:</th>
                    <th>Scannad av:</th>
                    <th>Ta bort post:</th>
                </tr>
            </thead>
            <tbody>
                <?php
                //creates sql & creates a list with qr-scan data.
                $sql = "SELECT qrcodes.qrName, qrscan.dateTime, qrscan.device, qrscan.randomId
                FROM qrScan
                INNER JOIN qrcodes ON qrScan.randomId=qrcodes.id;";

                $stmt = $db->prepare($sql);
                $result = $stmt->execute([]);

                while ($row = $stmt->fetch()) {
                    echo "<tr>
                    <td>$row[qrName]</td>
                    <td>$row[dateTime]</td>
                    <td>$row[device]</td>
                    <td>
                    <form method='post'><input type='submit' name='delete[$row[randomId]]' value='delete'></form>
                    </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
        <table>
            <thead>
                <tr>
                    <th>Qr-kod:</th>
                    <th>Länkad sida:</th>
                    <th>Ta bort qr-kod:</th>
                </tr>
            </thead>
            <tbody>
                <?php
                //creates sql & creates a list with the different qr-codes that exist
                $sql = "SELECT * FROM qrcodes";

                $stmt = $db->prepare($sql);
                $result = $stmt->execute([]);

                while ($row = $stmt->fetch()) {
                    echo "<tr>
                    <td>$row[qrName]</td>
                    <td>$row[Url]</td>
                    <td>
                    <form method='post'><input type='submit' name='deleteQr[$row[id]]' value='Ta bort'></form>
                    </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
        <div>
            <form method="POST">
                <input type="text" id="qrName" name="qrName" placeholder="Länk till qr-kod" autocomplete="off">
                <input type="text" id="qrUrl" name="qrUrl" placeholder="Länk till qr-kod" autocomplete="off">
                <button type="submit" name="addQrCode">Lägg till</button>
            </form>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Öppettider:</th>
                    <th>Datum:</th>
                    <th>Ta bort:</th>
                </tr>
            </thead>
            <tbody>
                <?php
                //creates sql & creates a list with the different qr-codes that exist
                $sqlOpenHours = "SELECT * FROM openhours";

                $stmtOpenHours = $db->prepare($sqlOpenHours);
                $stmtOpenHours->execute([]);

                while ($row = $stmtOpenHours->fetch()) {
                    echo "<tr>
                    <td>$row[openHours]</td>
                    <td>$row[openDates]</td>
                    <td>
                        <form method='post'><input type='submit' name='deleteOpenHours[$row[id]]' value='Ta bort'></form>
                    </td>
                </tr>";
                }
                ?>
            </tbody>
        </table>
        <form method="POST">
            <input type="text" id="openHours" name="openHours" placeholder="Öppettider" autocomplete="off">
            <input type="text" id="openDates" name="openDates" placeholder="Datum" autocomplete="off">
            <button type="submit" Name="addOpenHours">Lägg till</button>
        </form>
    </main>
</body>

</html>