<?php

$valid_passwords = array(
	'carto_admin' => 'P$Tkkf1T$sjr84sd-sdS%DY'
);

$valid_users = array_keys($valid_passwords);

$user = $_SERVER['PHP_AUTH_USER'];
$pass = $_SERVER['PHP_AUTH_PW'];

$validated = (in_array($user, $valid_users)) && ($pass === $valid_passwords[$user]);

if (!$validated) {
	header('WWW-Authenticate: Basic realm="Cartografia Chaco - Admin"');
	header('HTTP/1.0 401 Unauthorized');
	die("Not authorized");
}

require_once '../functions.php';

?>
<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Cartografías abiertas Admin</title>
	<style>
		table {
			border-collapse: collapse;
			width: 100%;
		}

		th,
		td {
			border: solid 1px;
			padding: 3px 6px;
		}
	</style>
</head>

<body class="cartografiachaco-admin">

	<h1>Vista de administrador</h1>

	<h2>Registro de usuaries</h2>
	<?php

	$host     = APP_DB_HOST;
	$username = APP_DB_USER;
	$password = APP_DB_PASSWORD;
	$dbname   = APP_DB_NAME;

	$mysqli = new mysqli($host, $username, $password, $dbname);

	// Check for connection errors
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: " . $mysqli->connect_error;
		exit;
	}

	// Query to fetch users with corresponding nation names
	$query = "SELECT users.id, users.name, nations.name AS nation_name, users.nation_other, users.parcialidades, users.community, users.institution
          FROM users
          INNER JOIN nations ON users.nation_id = nations.id";
	$result = $mysqli->query($query);

	// Check if the query was successful
	if ($result) {
		// Start the HTML table
		echo "<table>";
		echo "<tr>
            <th>ID</th>
            <th>Name</th>
            <th>Nation</th>
            <th>Nation Other</th>
            <th>Parcialidades</th>
            <th>Community</th>
            <th>Institution</th>
          </tr>";

		// Loop through the result set and output each row
		while ($row = $result->fetch_assoc()) {
			echo "<tr>";
			echo "<td>" . $row['id'] . "</td>";
			echo "<td>" . $row['name'] . "</td>";
			echo "<td>" . $row['nation_name'] . "</td>";
			echo "<td>" . $row['nation_other'] . "</td>";
			echo "<td>" . $row['parcialidades'] . "</td>";
			echo "<td>" . $row['community'] . "</td>";
			echo "<td>" . $row['institution'] . "</td>";
			echo "</tr>";
		}

		// End the HTML table
		echo "</table>";

		// Free the result set
		$result->free();
	} else {
		// Query execution failed
		echo "Error: " . $mysqli->error;
	}

	// Query to fetch all rows from the `entries` table
	$query = "SELECT * FROM `entries`";
	$result = $mysqli->query($query);
	?>

	<h2>Registro de Entradas</h2>
	<?php
	// Check if the query was successful
	if ($result) {
		// Start the HTML table
		echo "<table>";
		echo "<tr>
            <th>ID</th>
            <th>Commons Filename</th>
            <th>Wikidata ID</th>
            <th>Date</th>
            <th>Commons Error</th>
            <th>Wikidata Error</th>
          </tr>";

		// Loop through the result set and output each row
		while ($row = $result->fetch_assoc()) {
			echo "<tr>";
			echo "<td>" . $row['id'] . "</td>";
			echo "<td>" . $row['commons_filename'] . "</td>";
			echo "<td>" . $row['wikidata_id'] . "</td>";
			echo "<td>" . $row['date'] . "</td>";
			echo "<td>" . $row['commons_error'] . "</td>";
			echo "<td>" . $row['wikidata_error'] . "</td>";
			echo "</tr>";
		}

		// End the HTML table
		echo "</table>";

		// Free the result set
		$result->free();
	} else {
		// Query execution failed
		echo "Error: " . $mysqli->error;
	}

	// Close the database connection
	$mysqli->close();

	?>
	<h2>Registro de Archivos Subidos al Servidor</h2>
	<?php

$uploadsFolder = __DIR__ . '/../uploads'; // Path to the uploads folder

// Check if the uploads folder exists
if (is_dir($uploadsFolder)) {
    // Get the list of files in the uploads folder
    $files = scandir($uploadsFolder);

    // Remove "." and ".." from the list
    $files = array_diff($files, array('.', '..'));

    // Check if there are any files
    if (count($files) > 0) {
        // Start the HTML table
        echo "<table>";
        echo "<tr>
			<th>Filename</th>
			<th>Link</th>
			<th>Date</th>
		</tr>";

        // Loop through the files and display each filename and its creation date
        foreach ($files as $file) {
            $filePath = $uploadsFolder . '/' . $file;
            $creationDate = date('Y-m-d H:i:s', filectime($filePath));

            echo "<tr>
				<td>$file</td>
				<td><a href='". APP_HOME_URL . "uploads/$file' target='_blank'>". APP_HOME_URL . "uploads/$file</a></td>
				<td>$creationDate</td>
			</tr>";
        }

        // End the HTML table
        echo "</table>";
    } else {
        echo "No files found in the uploads folder.";
    }
} else {
    echo "The uploads folder does not exist.";
}

?>

<br>
<br>
</body>
</html>