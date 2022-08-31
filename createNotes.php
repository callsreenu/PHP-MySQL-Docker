<?php

//echo $_POST["description"]."---".$_POST["note"]; 
 
$status = $_POST["statusVal"];
$jobId = $_POST["jobIdVal"];
$noteDescription = $_POST["noteDescription"];

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

	$sqlUpdate = " UPDATE jobs SET status = '$status' WHERE job_identifier = '$jobId' ; ";
	$sqlInsert = " insert into notes(description, jobs_id) values('$noteDescription', '$jobId') ;";
	$resultUpdate = $mysqli->query($sqlUpdate);
	$resultInsert = $mysqli->query($sqlInsert);
	$mysqli->close();
echo "Successfully Added Notes to Job"


?>