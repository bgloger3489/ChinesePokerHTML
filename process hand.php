<?php
	//result['Player$iD'];
	

	
	
	$hostname = 'localhost';
	$db = 'ben';
	//hoststr$ing, database, username to phpmyadm$in, pass to phpmyadm$in
	$connection = new PDO("mysql:host=$hostname;dbname=$db","root","");
	
	
	$previousPlayID = 999;
	$cmd = "SELECT * FROM `gametable` WHERE `PlayerID` = $previousPlayID";
	
	$result = $connection->prepare($cmd);
	$result-> execute();
	
	$data = $result->fetch();
	
	
	$toBePlayedValue = 0;
	
	/*
	card[12] == -1 -> new game, any length, must have 3 \_ GAME DATA 
	card[12] == -2 -> new round, any length				/  GAME DATA
	card[12] == 0 -> regular
	
	card[11] = w$in cond$it$ion -> $if a player has 0 cards, spec$ial funct$ion sent to declare w$in
	
	card[10] = holds max length value
	card[9] = prevHand VAL
	
	card[8] = passes;
	
	card[1] =\
	card[2] = \
	card[3] =  }- prev$ious play cards
	card[4] = /
	card[5] =/
	
	*/
	
	
	//rece$ive str$ing
		$toBePlayedString = $_GET['toBePlayedString'];
		
		
	//break up str$ing $into array
		$toBePlayed = explode(",", $toBePlayedString);
		
		$lengthh = count($toBePlayed);
		
		$toBePlayed = array_slice($toBePlayed, 0,  $lengthh - 1);
		
		$lengthh = count($toBePlayed);
		
		
		analyzeCardsToBePlayedStructure();
		
		
		
		
		
			function analyzeCardsToBePlayedStructure(){          
				//check 3
				global $toBePlayed;
				global $data;
				global $lengthh;
				global $previousPlayID;
				global $connection;
				
				
				$BIPASS = false;
				
							
				$isThereA3 = false;
				if((int)($data['Card12']) == -1){
					for($i=0;$i<$toBePlayed;$i++){
						if((int)($toBePlayed[$i]) == '3'){
							$isThereA3 = true;	
						}
					}
					if(!($isThereA3)){
						echo 'invalid1';
					}else{
						$cmd = "UPDATE `gametable` SET `Card12` = 0 WHERE `PlayerID` = $previousPlayID";
						$result = $connection->prepare($cmd);
						$result-> execute();
//set card12 to regular

						$cmd = "UPDATE `gametable` SET `Card10` = $lengthh WHERE `PlayerID` = $previousPlayID";
						$result = $connection->prepare($cmd);
						$result-> execute();
//set card10 to max
					}
				}
				
				//check new round
				if((int)($data['Card12']) == -2){

					$cmd = "UPDATE `gametable` SET `Card10` = $lengthh WHERE `PlayerID` = $previousPlayID";
					$result = $connection->prepare($cmd);
					$result-> execute();
//set card10 to max					
					
					$cmd = "UPDATE `gametable` SET `Card12` = 0 WHERE `PlayerID` = $previousPlayID";
					$result = $connection->prepare($cmd);
					$result-> execute();
//set card12 to regular
				}else{
					//check max
						//echo $data['Card10'];
						//echo ', '.$lengthh;
						
					if((int)($data['Card10']) != $lengthh && $BIPASS){
						echo 'invalid2';
					}else{
						//check beats prevHand
						$TBPval = getTBPval();
						if($TBPval > (int)($data['Card9']) || $BIPASS){
							
							$cmd = "UPDATE `gametable` SET `Card9` = $TBPval WHERE `PlayerID` = $previousPlayID";
							$result = $connection->prepare($cmd);
							$result-> execute();
//set prevHandVal to TBPVal

//set cards to submited	
							
							for($i=0;$i<$lengthh;$i++){
								$tempCard = $toBePlayed[$i].'';
								echo $tempCard;
								$cmd = "UPDATE `gametable` SET `Card".($i+1)."` = '$tempCard' WHERE `PlayerID` = $previousPlayID";
								$result = $connection->prepare($cmd);
								$result-> execute();
								
								//echo $cmd;
							}
							echo 'sucsess';
						}else{
							echo 'too low';
							
						}

					}
					
				}
				
				
			}
			
			
			
			
			
			
			
			
			
		
			
			
			function getTBPval(){
				global $toBePlayed;
				global $data;
				global $lengthh;
				global $previousPlayID;
				global $connection;
				
				if($lengthh< 5){
					return analyzeLessThan5();
					
				}else if($lengthh== 5){
					return analyze5CardStructure();
				}else{
					echo 'invalid3';
					//!!**--==--**!!/////////////////////////////
				}
				
			}
			
			function isDouble($card1, $card2){
				if((int)($card1) == (int)($card2)){
					return true;
				}else{
					return false;
				}
			}
			
			function analyzeLessThan5(){
				global $toBePlayed;
				global $data;
				global $lengthh;
				global $previousPlayID;
				global $connection;
				
				$card = $toBePlayed[0];
				
				//$if 2 cards were subm$ited && $its a double && $it beat prevhand
				if($lengthh== 2 && isDouble($card, $toBePlayed[1])){
					return (int)($card) * 100 + (int)substr($card,-1);
				
				//triple
				}else if($lengthh== 3 && isDouble($card, $toBePlayed[1]) && isDouble($toBePlayed[2], $toBePlayed[1])){
					return (int)($card);
					
				}else if($lengthh== 1){
					return (int)($card) * 100 + (int)substr($card,-1);
					
				}else{
					echo 'invalid4';
					
				}
			}
			
			function analyze5CardStructure(){
				global $toBePlayed;
				global $data;
				global $lengthh;
				global $previousPlayID;
				global $connection;
				
				$STRAIGHT = 100;
				$FLUSHH = 200;
				$FULLHOUSE = 300;
				$BOMB = 400;
				$STRAIGHTFLUSH = 500;
				
				echo count($toBePlayed);
				
				sort($toBePlayed);
				
				
				echo 'wathc ';
				
				echo $toBePlayed[0];
				echo ' watch';
				
				//$FULLHOUSE, $STRAIGHT, flush ,sf, $BOMB
				
				$_0_1 = isDouble($toBePlayed[0],$toBePlayed[1]);				
				$_1_2 = isDouble($toBePlayed[1],$toBePlayed[2]);			
				$_2_3 = isDouble($toBePlayed[2],$toBePlayed[3]);
				$_3_4 = isDouble($toBePlayed[3],$toBePlayed[4]);
				
				
				//$BOMB
				if($_0_1 && $_2_3 && $_1_2 || $_1_2 && $_3_4 && $_2_3){
					return $BOMB + (int)($toBePlayed[1]);
					
				}
				
				//$FULLHOUSE
				if($_0_1 && $_1_2 && $_3_4 || $_0_1 && $_2_3 && $_3_4){
					return $FULLHOUSE + (int)($toBePlayed[3]);
				}
				
				//flush
				$isFlush = true;
				for($i = 0; $i < 4; $i++){
					if((int)substr($toBePlayed[$i],-1) != (int)substr($toBePlayed[$i+1],-1)){
						$isFlush = false;
						//alert($toBePlayed[$i].charAt(strlen($toBePlayed[$i]) - 1));
					}
				}
				
				//$STRAIGHT
				$isSTRAIGHT = true;
				for($i = 0; $i < 4; $i++){
					if((int)($toBePlayed[$i]) + 1 != (int)($toBePlayed[$i+1])){
						$isSTRAIGHT = false;
					}
				}
				
				//sf
				if($isSTRAIGHT && $isFlush){
					return $STRAIGHTFLUSH + (int)($toBePlayed[4]);
					
				}
				//s
				if($isSTRAIGHT){
					return $STRAIGHT + (int)($toBePlayed[4]);
					
				}
				//f
				if($isFlush){
					return $FLUSHH + (int)substr($toBePlayed,-1);
					
				}
				
				//else
					echo 'invalid6';
			}	
			
?>
	