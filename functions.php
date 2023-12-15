<?php
include "database.php";
function addUsertoDatabase($fName, $email, $API)
{
    global $pdo;
    $sql = "INSERT into `Users` (`FirstName`, `Email`, `APIKey`) values ('$fName', '$email', '$API')";
    $pdo->query($sql);
}
function checkValidation($fName, $api)
{
    global $pdo;
    $sql1 = "SELECT u.UserID from `Users` as u where u.FirstName = '$fName'";
    $query1 = $pdo->query($sql1);
    $arraygrab = $query1->fetchAll();
    if (isset($arraygrab[0]['UserID'])) {
        $id = $arraygrab[0]['UserID'];
        $sql2 = "SELECT u.APIKey from `Users` as u where u.UserID = '$id'";
        $query2 = $pdo->query($sql2);
        $anothergrab = $query2->fetchAll();
        $trueKey = $anothergrab[0]['APIKey'];
        
        if ($api == $trueKey) {
            //query the database and get the data 
            //still need to insert the data
            return true;
        } else {
            //the user has input the wrong stuff- should've flagged earlier but we will return an error regardless
            return false;
        }
    } else {
        return false;
    }
    //$id = $arraygrab[0]['UserID'];

    //echo $id;
    //now that we have the id lets match it to the saved users information and make sure 
    //that the key lines up with the id 


}
?>