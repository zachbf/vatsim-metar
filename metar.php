<?php
//A script to store VATSIM METARS and save bandwidth!
//By Zach Biesse-Fitton 29th January 2017

//Database connection.
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "database";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
//Finish database connection.

//Get the latest Australian METARS.
$masterArray = file('http://metar.vatsim.net/metar.php?id=Y');

//Or get the latest global METARS. I've turned this off for now.
//$masterArray = file('http://metar.vatsim.net/metar.php?id=');

//Start the new METAR array.
$metarArray = [];

//Update the new array with the METAR data, with a seperate ICAO code for each METAR.
foreach ($masterArray as $array)
{
	$metarJoin = array();
    $metarJoin['icao'] = substr($array, 0, 4);
    $metarJoin['wx'] = $array;           
    $metarArray[] = $metarJoin;
}

//Insert each METAR into the database using the new array.
foreach ($metarArray as $metar)
{
	//Prepare variables for the query
	$icao = $metar['icao'];
	$wx = $metar['wx'];
	
	//Write and run the query. The database details that I have used, are available in the repository.
	$sql = "REPLACE INTO weather (icao, wx) VALUES ('$icao', '$wx')";
	if (mysqli_query($conn, $sql))
	{
    echo "METAR updated for " . $icao;
    echo "<br />";
	}
	else
	{
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
}

mysqli_close($conn);
?>
