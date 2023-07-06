<?php

require_once 'functions.php';

$body_class     = "form";
$form_result    = '';
$contact_result = '';

if (isset($_POST['contact'])) {
	$contact_name    = '';
	$contact_email   = '';
	$contact_message = '';

	if (!empty($_POST['contact-name']) && is_string($_POST['contact-name'])) {
		$contact_name = $_POST['contact-name'];
	}

	if (!empty($_POST['contact-email']) && is_string($_POST['contact-email'])) {
		$contact_email = $_POST['contact-email'];
	}

	if (!empty($_POST['contact-message']) && is_string($_POST['contact-message'])) {
		$contact_message = $_POST['contact-message'];
	}

	if (empty($contact_name) || empty($contact_email) || empty($contact_message)) {
		$contact_result = 'Missing required fields';
	} else {
		$result = mail( 'natimciraolodigena@gmail.com', 'Mensaje de formulario de contacto de Cartografias Chaco', $contact_message, 'From: ' . $contact_email);

		if ( $result ) {
			$contact_result = 'Success';
		} else {
			$contact_result = 'Error';
		}
	}
} else {
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

		header( 'Location: ' . APP_HOME_URL . 'mapa.php#lat=-26.415557179343296&lng=-60.20459532737732&zoom=7&interface_language=es&sparql_filter=%7B%3Fq%20p%3AP2596%20%3Fstatement0.%20%3Fstatement0%20(ps%3AP2596%2F(wdt%3AP279*))%20wd%3AQ1284276.%20%7D%20UNION%20%7B%3Fq%20p%3AP2596%20%3Fstatement0.%20%3Fstatement0%20(ps%3AP2596%2F(wdt%3AP279*))%20wd%3AQ3027047.%20%7D%20UNION%20%7B%3Fq%20p%3AP2596%20%3Fstatement0.%20%3Fstatement0%20(ps%3AP2596%2F(wdt%3AP279*))%20wd%3AQ1542227.%20%7D%20UNION%20%7B%3Fq%20p%3AP2596%20%3Fstatement0.%20%3Fstatement0%20(ps%3AP2596%2F(wdt%3AP279*))%20wd%3AQ3099764.%20%7D%20UNION%20%7B%3Fq%20p%3AP2596%20%3Fstatement0.%20%3Fstatement0%20(ps%3AP2596%2F(wdt%3AP279*))%20wd%3AQ3027906.%20%7D&worldwide=1' );
		exit;
	} else {
		require_once 'header.php';
		?>
		<form action="" method="POST">
			<?php if ($form_result === 'Error') { ?>
			<article class="show-after-submission">
				<p>Hubo un error en la carga del formulario, vuelva a intentarlo o escribinos a <a href="mailto:natimciraolodigena@gmail.com">natimciraolodigena@gmail.com</a></p>
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
}

require_once 'header.php';

if ( $contact_result === 'Success' ) {
	?>
<section class="contact-us">
	<article class="show-after-submission">
		<p>Gracias por tu consulta, te responderemos a la brevedad</p>
	</article>
</section>
	<?php
} else {
	?>
<section class="contact-us">
	<h2>Si tenés dudas o sugerencias, escribinos</h2>
    <form method="post">
		<input type="hidden" name="contact" value="1">
	<?php if ($contact_result === 'Error') { ?>
		<article class="show-after-submission">
			<p>Hubo un error en la carga del formulario, volvé a intentarlo o escribinos a <a href="mailto:natimciraolodigena@gmail.com">natimciraolodigena@gmail.com</a></p>
		</article>
		<?php } ?>
		<?php if ($contact_result === 'Missing required fields') { ?>
		<article class="show-after-submission">
			<p>Por favor, completá todos los campos requeridos</p>
		</article>
		<?php } ?>
        <strong>Dejanos tu consulta</strong>
        <label>Nombre *<input type="text" name="contact-name" placeholder="Escribí tu nombre" required></label>
        <label>Mail *<input type="email" name="contact-email" placeholder="Escribí tu mail" required></label>
        <label>Consulta *<textarea name="contact-message" id="" cols="30" rows="10" placeholder="Escribí tu consulta" required></textarea></label>
        <button>Enviar</button>
    </form>
	<?php
}
?>
</section>
<?php

require_once 'footer.php';
