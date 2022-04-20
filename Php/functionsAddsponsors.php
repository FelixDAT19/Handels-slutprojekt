<?php

function deleteSponsor($db)
{
    $deleteSponsor = array_key_first($_POST['deleteSponsor']);
    $sqlDeleteSponsor = "DELETE FROM sponsors WHERE id=$deleteSponsor";

    $stmtDeleteSponsor = $db->prepare($sqlDeleteSponsor);

    $stmtDeleteSponsor->execute();

    $_POST['deletePSponsor'] = "";
};

function checkDupes($db)
{
    //creates sql used to check for already existing companies.
    $sqlNodupes = "SELECT * FROM sponsors;";

    $stmtNodupes = $db->prepare($sqlNodupes);

    $stmtNodupes->execute([]);

    $rowNodupes = $stmtNodupes->fetchAll();

    $a = array();

    //checks the company table & compares the input to the already existing companies
    foreach ($rowNodupes as $names) {

        $arrayContent = $names['name'];
        array_push($a, $arrayContent);
    };
    return $a;
}

function sponsorList($db)
{
    //creates sql & creates a list with all existing companies.
    $sqlSponsorList = "SELECT *
    FROM sponsors";

    $stmtSponsorList = $db->prepare($sqlSponsorList);
    $stmtSponsorList->execute([]);

    while ($row = $stmtSponsorList->fetch()) {
        echo "<tr>
        <td>$row[name]</td>
        <td>$row[sponsorUrl]</td>
        <td>$row[logoUrl]</td>
        <td>
        <form method='post'><input type='submit' name='deleteSponsor[$row[id]]' value='ta bort'></form>
        </td>
        </tr>";
    }
}

function addSponsor($db, $sponsorName, $sponsorUrl, $logoUrl)
{
    $sqlAddSponsor = "INSERT INTO sponsors (name, sponsorUrl, logoUrl)
                VALUES (:sponsorName, :sponsorUrl, :logoUrl);";

    $stmtAddSponsor = $db->prepare($sqlAddSponsor);

    $stmtAddSponsor->bindParam('sponsorName', $sponsorName, PDO::PARAM_STR);
    $stmtAddSponsor->bindParam('sponsorUrl', $sponsorUrl, PDO::PARAM_STR);
    $stmtAddSponsor->bindParam('logoUrl', $logoUrl, PDO::PARAM_STR);

    $stmtAddSponsor->execute();
    $_SESSION['alert'] = "Sponsorn har lagts till";
    header("location:Sponsors.php");
    exit();
}

function createSponsor($db)
{
    $a = checkDupes($db);
    $sponsorName = trim(htmlspecialchars($_POST['sponsorName']));
    $sponsorUrl = trim(htmlspecialchars($_POST['sponsorUrl']));
    $logoUrl = trim(htmlspecialchars($_POST['logoUrl']));

    //Checks if the company you want to add already exists, adds it if it doesn't
    if (isset($sponsorName) && in_array($sponsorName, $a)) {
        $_SESSION['alert'] = "Sponsorn finns redan";
        header("location:Sponsors.php");
        exit();
    } else {
        addSponsor($db, $sponsorName, $sponsorUrl, $logoUrl);
    }
}
