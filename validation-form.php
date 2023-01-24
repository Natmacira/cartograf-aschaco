<label for="name">Nombre<input type="text" id="name" name="nombre" required value="name"> </label><br>
    <label for="nation">Pueblo/Nación</label> <br>
    <label for="qom"><input type="radio" id="qom" name="nation" value="1">Qom </label><br>
    <label for="wichi"><input type="radio" id="wichi" name="nation" value="2">Wichi </label><br>
    <label for="moqoit"><input type="radio" id="moqoit" name="nation" value="3">Moqoit </label><br>

    <label for="otro"><input type="radio" id="otro" name="nation" value="4">Otro <input type="text" name="nation" value="otro">
    </label><br>

    <label for="parcialidad">Parcialidad<input type="text" id="parcialidad" name="parcialidad" value="parcialidad"> </label><br>
    <label for="comunidad">Comunidad<input type="text" id="comunidad" name="comunidad" value="comunidad"> </label><br>
    <label for="institucion">Nombre de la institución<input type="text" id="institucion" name="institucion" value="institucion"> </label><br>
    <label for="terminos"><input type="checkbox" id="terminos" name="terminos" value="terminos">Acepto los <a href="">términos y condiciones</a></label><br>

<?php

$nombre      = '';
$nation    = '';
$parcialidad  = '';
$comunidad          = 'no';
$institucion        = 'no';
$terminos        = 'no';


/* nombre */

if (!empty($_POST['nombre']) && is_string($_POST['nombre'])) {
  $nombre = $_POST['nombre'];
 
}

/* nation VER QUE PASA CON EL CAMPO TEXT DE OTROS */

if (!empty($_POST['nation']) && is_string($_POST['nation'])) {
  $nation = $_POST['nation'];
 

}

/* parcialidad */

if (!empty($_POST['parcialidad']) && is_string($_POST['parcialidad'])) {
  $parcialidad = $_POST['parcialidad'];
};


/* comunidad */

if (!empty($_POST['comunidad']) && is_string($_POST['comunidad'])) {
  $comunidad = $_POST['comunidad'];
}



/* institucion */

if (!empty($_POST['institucion']) && is_string($_POST['institucion'])) {
  $institucion = $_POST['institucion'];
}

/* terminos */ /* ESTE ES UN CHECKBOX COMO SE VALIDA/

if (!empty($_POST['terminos']) && is_string($_POST['terminos'])) {
  $terminos = $_POST['terminos'];
}






/* actividad */

// if (!empty($_POST['que-actividad-haces']) && is_string($_POST['que-actividad-haces'])) {
//   $actividadFisica = $_POST['que-actividad-haces'];
// }


// $mensaje = " 'area: ' . $areaLaboral . ' cantidad de horas: ' . $cantidadHoras . ' Atención a la postura: ' . $atencionPostura . ' Tiene dolores: ' . $dolores . ' Hacé actividad ' . $compensar . ' Actividad Física: ' . $actividadFisica . ";

// if ($areaLaboral !== '' && $cantidadHoras !== '' && $atencionPostura  !== null && $dolores !== null && $compensar !== null) {
//   mail('natmaciraestudionomade@gmail.com', 'Respuesta Form', $mensaje);
//   header('location: gracias.php#gracias');
// } else {
//   header('location: index.php');
// }