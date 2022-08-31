<?php


 //echo $_POST["description"]."---".$_POST["note"]; 
 
$status = $_POST["statusVal"];
$jobId = $_POST["jobIdVal"];

# DB Credentials 
$config = parse_ini_file("config.ini");

$mysqli = new mysqli($config['servername'], $config['username'],
                $config['password'], $config['dbname']);

// Checking for connections
if ($mysqli->connect_error) {
    die('Connect Error (' .
    $mysqli->connect_errno . ') '.
    $mysqli->connect_error);
}

	$sql = " UPDATE jobs SET status = '$status' WHERE job_identifier = '$jobId' ; ";
	$result = $mysqli->query($sql);
	$mysqli->close();
echo "Successfully Updated Job Status"


?>