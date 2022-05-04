<?php
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

function deleteSponsor($db)
{
    //creates sql to delete sponsor & executes
    $deleteSponsor = array_key_first($_POST['deleteSponsor']);
    $sqlDeleteSponsor = "DELETE FROM sponsors WHERE id=$deleteSponsor";

    $stmtDeleteSponsor = $db->prepare($sqlDeleteSponsor);

    $stmtDeleteSponsor->execute();

    $_POST['deletePSponsor'] = "";
};

function sponsorList($db)
{
    //creates sql & creates a list with all existing companies.
    $sqlSponsorList = "SELECT *
    FROM sponsors";

    $stmtSponsorList = $db->prepare($sqlSponsorList);
    $stmtSponsorList->execute([]);

    while ($row = $stmtSponsorList->fetch()) {
        echo "<tr>
        <td title='$row[name]'>$row[name]</td>
        <td title='$row[sponsorUrl]'>$row[sponsorUrl]</td>
        <td title='$row[logoUrl]'>$row[logoUrl]</td>
        <td>
        <form method='post'><input type='submit' name='deleteSponsor[$row[id]]' value='ta bort'></form>
        </td>
        </tr>";
    }
}

function checkDupes($db)
{
    //creates sql used to check for already existing companies.
    $sqlNodupes = "SELECT * FROM sponsors;";

    $stmtNodupes = $db->prepare($sqlNodupes);

    $stmtNodupes->execute([]);

    $rowNodupes = $stmtNodupes->fetchAll();

    $a = array();

    //Inserts the sponsors from the database into array
    foreach ($rowNodupes as $names) {

        $arrayContent = $names['name'];
        array_push($a, $arrayContent);
    };
    return $a;
}

function addSponsor($db, $sponsorName, $sponsorUrl, $logoUrl)
{
    //creates sql to add sponsor to database, binds params & executes
    $sqlAddSponsor = "INSERT INTO sponsors (name, sponsorUrl, logoUrl)
                VALUES (:sponsorName, :sponsorUrl, :logoUrl);";

    $stmtAddSponsor = $db->prepare($sqlAddSponsor);

    $stmtAddSponsor->bindParam('sponsorName', $sponsorName, PDO::PARAM_STR);
    $stmtAddSponsor->bindParam('sponsorUrl', $sponsorUrl, PDO::PARAM_STR);
    $stmtAddSponsor->bindParam('logoUrl', $logoUrl, PDO::PARAM_STR);

    $stmtAddSponsor->execute();
    $_SESSION['alertSuccess'] = "Sponsorn har lagts till";
    header("location:Sponsors.php");
    exit();
}

function createSponsor($db)
{
    //checks if the sponsor you're trying to add is a duplicate, assigns the inputs to variables & runs the addSponsor-function
    $a = checkDupes($db);
    $sponsorName = trim(htmlspecialchars($_POST['sponsorName']));
    $sponsorUrl = trim(htmlspecialchars($_POST['sponsorUrl']));
    $logoUrl = trim(htmlspecialchars($_POST['logoUrl']));

    //Checks if the company you want to add already exists, adds it if it doesn't
    if (isset($sponsorName) && in_array($sponsorName, $a)) {
        $_SESSION['alertError'] = "Sponsorn finns redan";
        header("location:Sponsors.php");
        exit();
    } else {
        addSponsor($db, $sponsorName, $sponsorUrl, $logoUrl);
    }
}
