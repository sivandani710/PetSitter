<?php
$servername = "localhost";
$dBUsername = "sivandn";
$dBPassword = "P+L4tUro*o";
$dBName = "sivandn_petsitter";

$conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);

if (!$conn){
    die("Connection failed: ".mysqli_connect_error());
}

?>