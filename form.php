<?php
$body_class = "form";

require_once 'header.php';

$form_result = '';

if (isset($_POST['submit'])) {
	$nombre       = '';
	$nation_id    = '';
	$nation_other = '';
	$parcialidad  = '';
	$comunidad    = '';
	$institucion  = '';

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
		require_once 'env.php';

		$host     = APP_DB_HOST;
		$username = APP_DB_USER;
		$password = APP_DB_PASSWORD;
		$dbname   = APP_DB_NAME;

		// Create connection
		$mysqli = new mysqli( $host, $username, $password, $dbname );

		// Check connection
		if ( $mysqli->connect_errno ) {
			echo "Failed to connect to MySQL: " . $mysqli->connect_error;
			exit();
		}

		$sql = 'INSERT INTO users (name, nation_id, nation_other, parcialidades, community, institution) VALUES
		("' . $mysqli->real_escape_string($nombre) . '",
		"' . $mysqli->real_escape_string($nation_id) . '",
		"' . $mysqli->real_escape_string($nation_other) . '",
		"' . $mysqli->real_escape_string($parcialidad) . '",
		"' . $mysqli->real_escape_string($comunidad) . '",
		"' . $mysqli->real_escape_string($institucion) . '")';

		$insert = mysqli_query($mysqli, $sql);

		if ($insert) {
			$form_result = 'Success';
		} else {
			$form_result = 'Error';
		}

		mysqli_close($mysqli);
	} else {
		$form_result = 'Missing required fields';
	}
}


if ($form_result === 'Success') {
	chaco_set_user_cookie();

	header( 'Location: ' . APP_HOME_URL . 'mapa.php#lat=-27.451389658914252&lng=-58.98666858673096&zoom=16' );
	exit;
	?>
	<article class="show-after-submission">
		<p>¡Muchas gracias
			<br>
			por tu aporte!
		</p>
	</article>
	<?php
} else {
	?>
	<form action="" method="POST">
		<?php if ($form_result === 'Error') { ?>
		<article class="show-after-submission">
			<p>Hubo un error en la carga del formulario, vuelva a intentarlo o escribinos a <a href="mailto:test@test.com"></p>
		</article>
		<?php } ?>
		<?php if ($form_result === 'Missing required fields') { ?>
		<article class="show-after-submission">
			<p>Por favor, completa todos los campos requeridos</p>
		</article>
		<?php } ?>
	<input type="hidden" name="submit" value="1">
    <p><strong>Completá el siguiente formulario con tus datos</strong></p>

    <label for="name">Nombre <sup>*</sup><input type="text" id="name" name="nombre" value="" required placeholder="escribí tu nombre"> </label><br>

    <label for="nation">Pueblo/Nación <sup>*</sup></label> <br>
    <label for="qom" class="nation-option-label"><input type="radio" id="qom" name="nation-id" value="1" required>Qom </label><br>
    <label for="wichi" class="nation-option-label"><input type="radio" id="wichi" name="nation-id" value="2">Wichi </label><br>
    <label for="moqoit" class="nation-option-label"><input type="radio" id="moqoit" name="nation-id" value="3">Moqoit </label><br>
    <label for="otro" class="nation-option-label"><input type="radio" id="otro" name="nation-id" value="4">
        Otro:<input type="text" name="nation-other" class="other-nation-input" placeholder="ej. Argentina">
    </label><br>

    <label for="parcialidad">Parcialidad (opcional)<input type="text" id="parcialidad" name="parcialidad" value="" placeholder="indicá tu parcialidad"> </label><br>

    <label for="comunidad">Comunidad (opcional)<input type="text" id="comunidad" name="comunidad" value="" placeholder="indicá tu comunidad"> </label><br>

    <label for="institucion">Si pertenecés a una institución indicá su nombre (opcional)<input type="text" id="institucion" name="institucion" value="" placeholder="nombre de la institución"> </label><br>

    <label for="terminos" id="terms-label"><input type="checkbox" id="terminos" name="terminos" value="" required>Acepto los <strong> <a href="terminos.php"> términos y condiciones</a></strong></label><br>

    <button>Siguiente</button>

</form>
	<?php
}
?>

<section class="contact-us">
    <h2>Si tenés dudas o sugerencias, escribinos</h2>
    <form method="post">
        <strong>Dejanos tu consulta</strong>
        <label for="">Nombre <input type="text" placeholder="Escribí tu nombre"></label>
        <label for="">Mail <input type="mail" placeholder="Escribí tu mail"></label>
        <label for="">Consulta<textarea name="" id="" cols="30" rows="10" placeholder="Escribí tu consulta"></textarea></label>
        <button>Enviar</button>
    </form>
    <article class="show-after-submission">
        <p>¡Muchas gracias
            <br>
            por tu aporte!
        </p>
    </article>
</section>

<?php

require_once 'footer.php';
