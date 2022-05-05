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

function placementList($db, $selectedCompany)
{
    //creates sql & creates a list with all booked places.
    $sql = "SELECT placement.id, company.name, placement.companyId
    FROM placement
    INNER JOIN company ON placement.companyId=company.id
    WHERE companyId=$selectedCompany
    ORDER BY placement.id;";

    $stmt = $db->prepare($sql);
    $stmt->execute([]);

    while ($row = $stmt->fetch()) {
        echo "<tr>
            <td title='$row[id]'>$row[id]</td>
            <td title='$row[name]'>$row[name]</td>
            <td>
            <form method='post'><input type='submit' name='deletePlace[$row[id]]' value='töm'></form>
            </td>
            </tr>";
    }
}

function deletePlace($db)
{
    //creates sql & clears the selected place from the database
    $deletePlace = array_key_first($_POST['deletePlace']);
    $sqlDeletePlace = "UPDATE placement
            SET companyId = NULL 
            WHERE id=$deletePlace";

    $stmtDeletePlace = $db->prepare($sqlDeletePlace);

    $stmtDeletePlace->execute();

    $_POST['deletePlace'] = "";
};

function selectPlacement($db, $selectedCompany, $placement)
{
    //Creates sql for displaying all the places & executes
    $sqlPlacement = "SELECT * FROM placement ORDER BY id;";

    $placementStmt = $db->prepare($sqlPlacement);

    $placementStmt->execute([]);

    $row = $placementStmt->fetchAll();
    //loops the placement table & creates a checkbox list with all the showcases
    foreach ($row as $places) {

        if (isset($_SESSION['alertError']) == true && $places['companyId'] == null) {
            //checks if the user has made an incorrect input
            if (in_array($places['id'], $placement)) {
                //takes the new user input & creates checked boxes on the new selected places, and empty boxes were it isn't
                echo ("<div class='grid-item'><input type='checkbox' value='$places[id]' name='place[]' checked>$places[id]</div>");
            } else {
                echo ("<div class='grid-item'><input type='checkbox' value='$places[id]' name='place[]'>$places[id]</div>");
            }
        } elseif ($places['companyId'] == $selectedCompany && isset($_SESSION['alertError']) == false) {
            //compares the selected companys id to the booked places in the database and returns wich places are booked by the selected company
            echo ("<div class='grid-item'><input type='checkbox' value='$places[id]' name='place[]' checked>$places[id]</div>");
            //creates a checked box if the place is booked by the selected company
        } elseif ($places['companyId'] == null && isset($_SESSION['alertError']) == false) {
            //checks if a checkbox isn't booked by a company in the database & returns an empty checkbox
            echo ("<div class='grid-item'><input type='checkbox' value='$places[id]' name='place[]'>$places[id]</div>");
        } else {
            //returns disabled checkboxes where the places are booked by other companies
            echo ("<div class='grid-item'><input type='checkbox' disabled>$places[id]</div>");
        }
    }
}

function updateCompany($db, $selectedCompany, $oldPlacement, $placement)
{
    //assigns the user inputs to variables
    $companyName = trim(htmlspecialchars($_POST["companyName"]));
    $companyInfo = trim(htmlspecialchars($_POST["companyInfo"]));
    $externalUrl = $_POST["externalUrl"];
    $logoUrl = $_POST["logoUrl"];
    $foodCheck = $_POST['foodCheck'];
    if (isset($_POST['place'])) {
        $placement = $_POST['place'];
    }
    $placementLength = count($placement);
    $oldPlacementLength = count($oldPlacement);

    //creates sql to update the company data, binds params & executes
    $sqlChangeInfo = "UPDATE company
                SET name= :companyName,
                companyInfo = :companyInfo, 
                externalUrl= :externalUrl,
                logoUrl= :logoUrl,
                foodCheck= :foodCheck
                WHERE id = $selectedCompany;";

    $stmtChangeInfo = $db->prepare($sqlChangeInfo);

    $stmtChangeInfo->bindParam('companyName', $companyName, PDO::PARAM_STR);
    $stmtChangeInfo->bindParam('companyInfo', $companyInfo, PDO::PARAM_STR);
    $stmtChangeInfo->bindParam('externalUrl', $externalUrl, PDO::PARAM_STR);
    $stmtChangeInfo->bindParam('logoUrl', $logoUrl, PDO::PARAM_STR);
    $stmtChangeInfo->bindParam('foodCheck', $foodCheck, PDO::PARAM_STR);

    $stmtChangeInfo->execute();

    //creates sql to clear all the old places related to the selected company & executes
    $sqlClearPlaces = "UPDATE placement
            SET companyId = NULL
            WHERE id=:oldPlacement";

    $stmtOldPlacement = $db->prepare($sqlClearPlaces);

    for ($i = 0; $i < $oldPlacementLength; $i++) {
        $stmtOldPlacement->bindParam('oldPlacement', $oldPlacement[$i], PDO::PARAM_INT);
        $stmtOldPlacement->execute();
    };

    //creates sql to assign the new places to the company & executes
    $sqlUpdatePlacement = "UPDATE placement
            SET companyId = $selectedCompany
            WHERE id=:placement;";
    $stmtPlacement = $db->prepare($sqlUpdatePlacement);

    for ($i = 0; $i < $placementLength; $i++) {
        $stmtPlacement->bindParam('placement', $placement[$i], PDO::PARAM_INT);
        $stmtPlacement->execute();
    };
    $_SESSION['alertSuccess'] = "Företagsinfon har uppdaterats";
    header("location:Addcompany.php");
    exit();
}

function getCompanyInfo($db, $oldPlacement, $selectedCompany)
{
    //gets info from the database & inserts into a stdclass, returns the stdclass with the data
    $oldPlacement = [];
    $return = new stdClass();
    $sqlGetCompanyInfo = "SELECT *, placement.id AS placement FROM company 
                    LEFT JOIN placement ON company.id=placement.companyId
                    WHERE company.id=$selectedCompany";

    $stmtGetCompanyInfo = $db->prepare($sqlGetCompanyInfo);
    $stmtGetCompanyInfo->execute();

    foreach ($stmtGetCompanyInfo as $place) {
        $return->companyName = $place['name'];
        $return->companyInfo = $place['companyInfo'];
        $return->externalUrl = $place['externalUrl'];
        $return->logoUrl = $place['logoUrl'];
        $return->foodCheck = $place['foodCheck'];
        array_push($oldPlacement, $place['id']);
    };
    $return->oldPlacement = $oldPlacement;
    return $return;
}
