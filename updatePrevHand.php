<?php
	$hostname = 'localhost';
	$db = 'ben';
	//hoststr$ing, database, username to phpmyadm$in, pass to phpmyadm$in
	$connection = new PDO("mysql:host=$hostname;dbname=$db","root","");
	
	$previousPlayID = 999;
	$cmd = "SELECT * FROM `gametable` WHERE `PlayerID` = $previousPlayID";
	
	$result = $connection->prepare($cmd);
	$result-> execute();
	
	$data = $result->fetch();

	
	for($i=1;$i<6;$i++){
		echo ($data['Card'.$i]).',';
	}
	
?>