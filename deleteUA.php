<?php
include "ConnectDB.php";
ob_start();
session_start();

$id = $_SESSION['id'];
$uN = '';
$uT = '';

// Codes for recording actions for history log //
date_default_timezone_set("Asia/Manila");
$date = date("M d, Y");
$time = date("h:i:s a");
// Get account's username and type
$sqlQuery ="SELECT * FROM account WHERE id= $id";
$res = $link->query($sqlQuery);
while($row=mysqli_fetch_array($res))
{
    $uN = $row["username"];
    $uT = $row["type"];
}
// Save action in the Database
$log = "[".$_SESSION['UserId']."] ".$_SESSION['username']." (".$_SESSION['type'].") Deleted an account: [".$id."] ".$uN." (".$uT.")";
$sqlQuery = "INSERT INTO history VALUES (DEFAULT,'$date','$time','$log')";
$res = $link->query($sqlQuery);

// Delete
$sql = "DELETE FROM account WHERE id= $id";
$res = $link->query($sql);

if($res){
    header('Location: admin_manageUserAccounts.php');
    ob_end_flush();
}
?>