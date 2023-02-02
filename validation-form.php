

<?php

$nombre       = '';
$nation       = '';
$parcialidad  = '';
$comunidad    = '';
$institucion  = '';
$terminos     = '';


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