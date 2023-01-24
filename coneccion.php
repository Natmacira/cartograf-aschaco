<?php
$mysqli = new mysqli("localhost", "root", "", "cartografiaschaco.com");

// Check connection
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
} else {
    echo "Hola que tal";
}
?>

<p>Completá el siguiente formulario con tus datos</p>
<form action="validation-form.php">

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
    <button>Siguiente</button>

</form>