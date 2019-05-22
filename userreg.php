<?php
	$hostname = 'localhost';
	$db = 'ben';
	//hoststring, database, username to phpmyadmin, pass to phpmyadmin
	$connection = new PDO("mysql:host=$hostname;dbname=$db","root","");
	
	$getallcmd = "SELECT * FROM `usertable`";
	$result = $connection->prepare($getallcmd);
	$result-> execute();
			
	$totalRows = $result->rowCount();
	
	
	
	if(array_key_exists('newuser',$_POST)){
		registerNewUser($_POST['uname'],$_POST['pword']);
	
	}else{
		loginUser($_POST['uname'],$_POST['pword']);
	
	}
		
		
	function registerNewUser($username, $password){
		global $connection;
		
		$cmd = "SELECT * FROM `usertable` WHERE `Username` = '$username'";
	
		$result = $connection->prepare($cmd);
		$result-> execute();
		
		
		if($result->rowCount() > 0){
			echo 'This username has been taken';
			echo '<a href = "template.html"> Return Home </a>';
		}else{
			
			//get all rows to find new id
			
			global $totalRows;
			
			$insertCMD = "INSERT INTO `usertable` VALUES ('$username', '$password', $totalRows)";
			$result = $connection->prepare($insertCMD);
			$result->execute();
		}
	}
	
	function loginUser($username, $password){
		global $connection;
		global $totalRows;
		$cmd = "SELECT `Password` FROM `usertable` WHERE `Username` = '$username'";
	
		$result = $connection->prepare($cmd);
		$result->execute();
			
		if($result->rowCount() == 0){
			echo 'No Such Username Found!';
			
		}else{
			$data = $result->fetch();
			if($data['Password'] == $password){
				echo 'Login Sucsessful!';
				
				echo '<a href = "Client Poker.html?ID='.$totalRows.'"> Continue to Online Chinese Poker </a>';
			}else{
				echo 'Password Is Incorrect!';
			}
		}
	}
?>
	