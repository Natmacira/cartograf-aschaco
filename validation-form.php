<?php
if (isset($_POST['submit'])) {
	$nombre       = '';
	$nation_id    = '';
	$nation_other    = '';
	$parcialidad  = '';
	$comunidad    = '';
	$institucion  = '';

	$host     = 'localhost';
	$username = 'root';
	$password = '';
	$dbname   = 'cartografiaschaco.com';

	if (!empty($_POST['nombre']) && is_string($_POST['nombre'])) {
		$nombre = $_POST['nombre'];
	}

	if (!empty($_POST['nation-id']) && is_string($_POST['nation-id'])) {
		$nation_id = $_POST['nation-id'];
	}

	if (!empty($_POST['nation-other']) && is_string($_POST['nation-other'])) {
		$nation_other = $_POST['nation-other'];
	}

	if (!empty($_POST['parcialidad']) && is_string($_POST['parcialidad'])) {
		$parcialidad = $_POST['parcialidad'];
	};

	if (!empty($_POST['comunidad']) && is_string($_POST['comunidad'])) {
		$comunidad = $_POST['comunidad'];
	}

	if (!empty($_POST['institucion']) && is_string($_POST['institucion'])) {
		$institucion = $_POST['institucion'];
	}

	if ($nombre && $nation_id) {
		$con = mysqli_connect($host, $username, $password, $dbname);

		if (!$con) {
			die('Connection failed!' . mysqli_connect_error());
		}

		$sql = "INSERT INTO users
		(nombre, nation_id, nation_other, parcialidad, comunidad, institucion) VALUES
		('$nombre', '$nation_id', '$nation_other', '$parcialidad', '$comunidad', '$institucion')";

		$rs = mysqli_query($con, $sql);

		if ($rs) {
			$result = 'Success';
		} else {
			$result = 'Error';
		}

		mysqli_close($con);
	} else {
		$result = 'Missing required fields';
	}

}
