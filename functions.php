<?php
	//functions.php
	//siia tulevad funktsioonid
	
	//loome AB ühenduse
	require_once("../config_global.php");
	$database = "if15_naaber";
	
	//vaikeväärtus sulgudes, et vältida errorit, mis tekiks real ~31 table.php's
	function getAllData($keyword=""){
		
		if($keyword == ""){
			//ei otsi
			$search = "%%";
		}else{
			
			//otsime
			$search = "%".$keyword."%"; 
			
		}
		
		//sellega loome ühenduse andmbebaasiga
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT id, user_id, number_plate, color FROM car_plates WHERE deleted IS NULL AND (number_plate LIKE ? OR color LIKE ?)");
		$stmt->bind_param("ss", $search, $search);
		$stmt->bind_result($id_from_db, $user_id_from_db, $number_plate_from_db, $color_from_db);
		$stmt->execute();
		
		//masiiv, kus hoiame autosid
		$array = array();
		
		//$row_nr = 0;
		
		//echo "<table border=1>";
		//echo "<tr><th>rea nr</th><th>auto nr märk</th></tr>";
		while ($stmt->fetch()){
			//saime andmed kätte
			//echo $row_nr." ".$number_plate_from_db."<br>";
			//uus rida
			//echo "<tr>";
			//reanr tulba
			//echo "<td>".$row_nr."</td>";
			//autonr tulba
			//echo "<td>".$number_plate_from_db."</td>";
			// paneme rea kinni
			//echo "</tr>";
			//$row_nr++;
			
			//suvaline muutuja, kus hoiame auto andmeid selle hetkeni, kui lisame massiivi
			
			//tühi objekt, kus hoiame väärtusi
			$car = new StdClass();
			$car->id = $id_from_db;
			$car->number_plate = $number_plate_from_db;
			$car->color = $color_from_db;
			
			//lisan massiivi (auto lisan massiivi)
			array_push($array, $car);
			//echo "<pre>";
			//var_dump($array);
			//echo "</pre>";
		}
		
		return $array;
		
		$stmt->close();
		$mysqli->close();
	}
	
	function deleteCarData($car_id){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		//uuendan välja deleted, lisan praeguse date´i
		$stmt = $mysqli->prepare("UPDATE car_plates SET deleted=NOW() WHERE id=?");
		$stmt->bind_param("i", $car_id);
		$stmt->execute();
		
		//tühjendame aadressirea
		header("Location: table.php");
		
		$stmt->close();
		$mysqli->close();
	}

	function updateCarData($car_id, $number_plate, $color){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("UPDATE car_plates SET number_plate=?, color=? WHERE id=?");
		$stmt->bind_param("ssi",$number_plate, $color, $car_id);
		$stmt->execute();
		
		header("Location: table.php");
		
		$stmt->close();
		$mysqli->close();
	}
?>