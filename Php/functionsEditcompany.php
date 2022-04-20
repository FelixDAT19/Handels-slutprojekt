<?php
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
            <td>$row[id]</td>
            <td>$row[name]</td>
            <td>
            <form method='post'><input type='submit' name='deletePlace[$row[id]]' value='töm'></form>
            </td>
            </tr>";
    }
}

function deletePlace($db)
{
    $deletePlace = array_key_first($_POST['deletePlace']);
    $sqlDeletePlace = "UPDATE placement
            SET companyId = NULL 
            WHERE id=$deletePlace";

    $stmtDeletePlace = $db->prepare($sqlDeletePlace);

    $stmtDeletePlace->execute();

    $_POST['deletePlace'] = "";
};

function selectPlacement($db, $selectedCompany)
{
    //prepares sql & binds params.
    $sqlPlacement = "SELECT * FROM placement ORDER BY id;";

    $placementStmt = $db->prepare($sqlPlacement);

    $placementStmt->execute([]);

    $row = $placementStmt->fetchAll();

    //loops the placement table & creates a checkbox list with all the showcases
    foreach ($row as $places) {
        if ($places['companyId'] == $selectedCompany) {
            echo ("<input type='checkbox' value='$places[id]' name='place[]' checked>$places[id]");
        } elseif ($places['companyId'] == null) {
            echo ("<input type='checkbox' value='$places[id]' name='place[]'>$places[id]");
        } else {
            echo ("<input type='checkbox' disabled>$places[id]");
        }
    }
}

function updateCompany($db, $selectedCompany, $oldPlacement, $placement)
{
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

    $sqlClearPlaces = "UPDATE placement
            SET companyId = NULL
            WHERE id=:oldPlacement";

    $stmtOldPlacement = $db->prepare($sqlClearPlaces);

    for ($i = 0; $i < $oldPlacementLength; $i++) {
        $stmtOldPlacement->bindParam('oldPlacement', $oldPlacement[$i], PDO::PARAM_INT);
        $stmtOldPlacement->execute();
    };

    $sqlUpdatePlacement = "UPDATE placement
            SET companyId = $selectedCompany
            WHERE id=:placement;";
    $stmtPlacement = $db->prepare($sqlUpdatePlacement);

    for ($i = 0; $i < $placementLength; $i++) {
        $stmtPlacement->bindParam('placement', $placement[$i], PDO::PARAM_INT);
        $stmtPlacement->execute();
    };
    $_SESSION['alert'] = "Företagsinfon har uppdaterats";
    header("location:Addcompany.php");
    exit();
}
function getCompanyInfo($db, $oldPlacement, $selectedCompany)
{
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
