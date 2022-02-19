<?php
$db = mysqli_connect('database', 'root', 'tiger', 'fullcalendar');
mysqli_set_charset($db, "utf8");
$start = $_POST['start'];
$end = $_POST['end'];
$meetName = $_POST['meetName'];
$cityName = $_POST['cityName'];
$streetName = $_POST['streetName'];
$op = $_POST['op'];
$id = $_POST['id'];

switch ($op) {
	case 'add':
		
		$sql = 'INSERT INTO events (
			start, 
			end, 
			meetName,
			cityName,
			streetName) 
			VALUES 
			("' . date("Y-m-d H:i:s", strtotime($start)) . '",
			"' . date("Y-m-d H:i:s", strtotime($end)) . '", 
			"' . $meetName . '",
			"' . $cityName . '",
			"' . $streetName . '")';
		if (mysqli_query($db, $sql)) {
			echo mysqli_insert_id($db);
		}
		break;
	case 'edit':
		$sql = 'UPDATE events SET 	start = "' . date("Y-m-d H:i:s", strtotime($start)) . '",
									end	  = "' . date("Y-m-d H:i:s", strtotime($end)) . '",
									meetName  = "' . $meetName . '",
									cityName = "' . $cityName . '",
									streetName = "' . $streetName . '"
									WHERE id = "' . $id . '"';
		if (mysqli_query($db, $sql)) {
			echo $id;
		}
		break;
	case 'source':
		$sql = 'SELECT * FROM events';
		$result = mysqli_query($db, $sql);
		$json = array();
		while ($row = mysqli_fetch_array($result)) {
			$json[] = array(
				'id' => $row['id'],
				'title' => $row['meetName'] . "/" . $row['cityName'] . "/" . $row['streetName'],
				'start' => $row['start'],
				'end' => $row['end'],
				'allDay' => false,
				'cityName' => $row['cityName'],
				'streetName' => $row['streetName']
			);
		}
		echo json_encode($json);
		break;
	case 'delete':
		$sql = 'DELETE FROM events WHERE id = "' . $id . '"';
		if (mysqli_query($db, $sql)) {
			echo $id;
		}
		break;
	case 'showStreets':
		$sql  = "SELECT s.streetName
		FROM city c
		INNER JOIN citystreet c1 ON c.city_id = c1.city_id
		INNER JOIN street s ON c1.street_id = s.street_id
		WHERE c.cityName = '$cityName'";
		$result = mysqli_query($db, $sql);
		$json = array();
		while ($row = mysqli_fetch_array($result)) {
			$json[] = array(
				'streetName' => $row['streetName'],
			);
		}
		echo json_encode($json);
		break;
}


function getAllVarietes()
{
	$conn = mysqli_connect('database', 'root', $_ENV['MYSQL_ROOT_PASSWORD'], 'fullcalendar');;
	/* для решения проблемы с русскими символами */
	mysqli_set_charset($conn, "utf8");
	if ($conn != null) {
		$query = "SELECT * FROM events order by id";
		$result = mysqli_query($conn, $query);
		if (mysqli_num_rows($result) > 0) {
			$varietesInfo = array();
			while ($vr = mysqli_fetch_array($result))
				$varietesInfo[] = $vr;
			return $varietesInfo;
		}
		mysqli_free_result($result);
		return array();
	}
	return array();
}

function getAllCities() {
	$conn = mysqli_connect('database', 'root', $_ENV['MYSQL_ROOT_PASSWORD'], 'fullcalendar');;
	/* для решения проблемы с русскими символами */
	mysqli_set_charset($conn, "utf8");
	if ($conn != null) {
		$query = "SELECT c.cityName FROM city c";
		$result = mysqli_query($conn, $query);
		if (mysqli_num_rows($result) > 0) {
			$varietesInfo = array();
			while ($vr = mysqli_fetch_array($result))
				$varietesInfo[] = $vr;
			return $varietesInfo;
		}
		mysqli_free_result($result);
		return array();
	}
	return array();
}

function getCityStreet($cityName) {
	$conn = mysqli_connect('database', 'root', $_ENV['MYSQL_ROOT_PASSWORD'], 'fullcalendar');
	/* для решения проблемы с русскими символами */
	mysqli_set_charset($conn, "utf8");
	if ($conn != null) {
		$query = "SELECT s.streetName
		FROM city c
		INNER JOIN citystreet c1 ON c.city_id = c1.city_id
		INNER JOIN street s ON c1.street_id = s.street_id
		WHERE c.cityName = 'Волгоград'";
		$result = mysqli_query($conn, $query);
		if (mysqli_num_rows($result) > 0) {
			$varietesInfo = array();
			while ($vr = mysqli_fetch_array($result))
				$varietesInfo[] = $vr;
			return $varietesInfo;
		}
		mysqli_free_result($result);
		return array();
	}
	return array();
}

