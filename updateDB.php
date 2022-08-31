<?php


 //echo $_POST["description"]."---".$_POST["note"]; 
 
$desc = $_POST["description"];
$noteId = $_POST["note"];

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

	$sql1 = " UPDATE notes SET description = '$desc' WHERE notes_id = '$noteId' ; ";
	$result1 = $mysqli->query($sql1);
	$mysqli->close();
echo "Successfully Updated Notes"


?>