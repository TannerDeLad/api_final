<?php
error_reporting(E_ALL); ini_set('display_errors', 1);
header('Content-Type: application/json');
include "database.php";
global $pdo;

$sql = "select * from API";
//check to see if the get has a value of id
if(isset($_GET['id']))
{

    $sql .= " Where Stock_ID = :id";
    //prepares the code to be executed
    $statement = $pdo->prepare($sql);
    //binds the :id with the input from the get request
    $statement->bindValue(':id', filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS));
    $statement->execute();
    $qry = $statement->fetchAll();
} else {
    //else we return all
    $qry = $pdo->query($sql)->fetchAll();
}

echo json_encode($qry);