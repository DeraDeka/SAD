<?php
include "ConnectDB.php";
ob_start();
session_start();

$id = $_SESSION['id'];
$sT1 = '';
$sT2 = '';

// Codes for recording actions for history log //
date_default_timezone_set("Asia/Manila");
$date = date("M d, Y");
$time = date("h:i:s a");
// Get study's title and type
$sqlQuery ="SELECT * FROM study WHERE id= $id";
$res = $link->query($sqlQuery);
while($row=mysqli_fetch_array($res))
{
    $sT1 = $row["title"];
    $sT2 = $row["type"];
}
// Save action in the Database
$log = "[".$_SESSION['UserId']."] ".$_SESSION['username']." (".$_SESSION['type'].") Removed a study: [".$id."] ".$sT1." (".$sT2.")";
$sqlQuery = "INSERT INTO history VALUES (DEFAULT,'$date','$time','$log')";
$res = $link->query($sqlQuery);

$sql = "DELETE FROM study WHERE id= $id";
$res = $link->query($sql);

if($res){
    header('Location: admin_manageStudies.php');
    ob_end_flush();
}
?>