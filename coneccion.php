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
<form action="">

    <label for="name">Nombre<input type="text" id="name" name="nombre" required> </label><br>
    <label for="nation">Pueblo/Nación</label> <br>
    <label for="qom"><input type="radio" id="qom" name="qom">Qom </label><br>
    <label for="wichi"><input type="radio" id="wichi" name="wichi">Wichi </label><br>
    <label for="moqoit"><input type="radio" id="moqoit" name="moqoit">Moqoit </label><br>
    <label for="otro"><input type="radio" id="otro" name="otro">Otro <input type="text" name="otro">
    </label><br>
    <label for="parcialidad">Parcialidad<input type="text" id="parcialidad" name="parcialidad"> </label><br>
    <label for="comunidad">Comunidad<input type="text" id="comunidad" name="comunidad"> </label><br>
    <label for="institucion">Nombre de la institución<input type="text" id="institucion" name="institucion"> </label><br>
    <label for="terminos"><input type="checkbox" id="terminos" name="terminos">Acepto los <a href="">términos y condiciones</a></label><br>
    <button>Siguiente</button>

</form>