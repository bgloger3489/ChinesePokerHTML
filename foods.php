<?php

$food = $_GET["food"];

if ($food == "hamburger")
	$group = "Meat";
else
	if ($food == "strawberry")
		$group = "Fruits & Vegetables";
	else
		if ($food == "ice cream")
			$group = "Dairy";
		else
			if ($food == "bread")
				$group = "Grain";
			else
				$group = "Unknown";
				
echo $group;
?>