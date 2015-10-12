Siia tuleb tabel
<?php
	require_once("functions.php");
	
	//kuulan, kas kasutaja tahab kustutada
	//?delete=... on aadressireal
	if (isset($_GET["delete"])){
		deleteCarData($_GET["delete"]);
	}
	
	//kasutaja muudab andmeid
	if(isset($_GET["update"])){
		//auto id, auto number, auto värv
		updateCarData($_GET["car_id"], $_GET["number_plate"], $_GET["color"]);
	}
	
	
	//saame kõik autod objektide kujul massiivis
	$car_array = getAllData();
	
	$keyword = "";
	if(isset($_GET["keyword"])){
		$keyword = $_GET["keyword"];
		
		//otsime
		$car_array = getAllData($keyword);
		
	}else{
		//näitame kõiki tulemusi
		//kõik autod objektide kujul massiivis
		$car_array = getAllData();
		
	}

?>

<h1>Tabel</h1>
<form action="table.php" method="get">
	<input name="keyword" type="search" value="<?=$keyword?>">
	<input type="submit" value="otsi">
</form>
<br>
<table border=1>
<tr>
	<th>id</th>
	<th>auto numbrimärk</th>
	<th>auto värv</th>
	<th></th>
	<th></th>
	<th></th>
</tr>
<?php

	//autod ükshaaval läbi käia
	for($i = 0; $i < count($car_array); $i++){
		
		//kasutaja tahab rida muuta
		if(isset($_GET["edit"]) && $_GET["edit"] == $car_array[$i]->id) {
			echo "<tr>";
			echo "<form action='table.php' method='get'>";
			// input mida välja ei näidata
            echo "<input type='hidden' name='car_id' value='".$car_array[$i]->id."'>";
			echo "<td>".$car_array[$i]->id."</td>";
			echo "<td><input name = 'number_plate' value ='".$car_array[$i]->number_plate."'></td>";
			echo "<td><input name = 'color' value ='".$car_array[$i]->color."'></td>";
			echo "<td><input name='update' type='submit'</td>";
			echo "<td><a href='table.php'>cancel</a></td>";
			echo "</form>";
			echo "</tr>";
		}else{
			echo "<tr>";
			echo "<td>".$car_array[$i]->id."</td>";
			echo "<td>".$car_array[$i]->number_plate."</td>";
			echo "<td>".$car_array[$i]->color."</td>";
			echo "<td><a href='?delete=".$car_array[$i]->id."'>x</a></td>";
			echo "<td><a href='?edit=".$car_array[$i]->id."'>edit</a></td>";
			echo "<td><a href='edit.php?edit_id=".$car_array[$i]->id."'>edit.php</a></td>";
			echo "</tr>";
		}
	}

?>
</table>