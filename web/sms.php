<?php
$text = $_POST['text'];
$phoneNumber = $_POST['phoneNumber'];
$level = getLevel($text);

$host = 'ec2-54-217-240-205.eu-west-1.compute.amazonaws.com'; 
$port = '5432';
$dbname = 'dcaomiqgff85af';
$credentials = 'user=igkvnbupupuifl password=2eLlt2szzW8sUp0Tec7BWc1g7U';

// connect to the database
$db = pg_connect('$host $port $dbname $credentials');
if(!db) {
	echo 'END Error! Please try again';
} 
// Welcome the farmer to the app 
	// get the phone number

if($level == 0) {
	// Check if the farmer is registered
	$sql ='SELECT * FROM farmer_farmer WHERE phone_number = $phoneNumber';
	
	$rs = pg_query($db, $sql);
	if(!$rs) {
		echo 'CON Welcome to KEAB '.PHP_EOL.'1. Register'.PHP_EOL.'2. Exit';
	}  else {
		echo 'END You have already registered. Thanks for keeping it real';	
	}
	exit;
}
else if ($level == 1) {
	// Register The farmer
	if($text == '1') {
		echo 'CON Please enter your name#id#Location';
	} else {
		echo 'END Goodbye';
	}
		
}
else {
	$data = explode("#", $text);
	$name = $data[0];
	$id = $data[1];
	$location = $data[2];

	// save the details to db
	$sql = 'INSERT INTO farmer_farmer (name, location, id_number, phone_number)
			VALUES ($name, $location, $id, $phoneNumber)';
	$ret = pg_query($db, $sql);
	if(!$ret){
		echo 'END Error! Please try again';
	} else {
		echo 'END You have been successfully registered';
	}
}
function getLevel($text) {
	// check if text is empty
	if(empty($text)) {
		$level = 0;
	} else {
		$exploded_text = explode("*", $text);
		$level = count($exploded_text);
	}
	return $level;
}

pg_close($db);
?>