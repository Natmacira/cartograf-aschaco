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


<?php
$body_class = "form";
require_once 'header.php';
?>


<form action="validation-form.php">
    <p><strong>Completá el siguiente formulario con tus datos</strong></p>

    <label for="name">Nombre <sup>*</sup><input type="text" id="name" name="nombre"  value="name" required> </label><br>
    <label for="nation">Pueblo/Nación <sup>*</sup></label> <br>
    <label for="qom" class="nation-option-label"><input type="radio" id="qom" name="nation" value="1" required>Qom </label><br>
    <label for="wichi" class="nation-option-label"><input type="radio" id="wichi" name="nation" value="2">Wichi </label><br>
    <label for="moqoit" class="nation-option-label"><input type="radio" id="moqoit" name="nation" value="3">Moqoit </label><br>
    <label for="otro" class="nation-option-label"><input type="radio" id="otro" name="nation" value="4">
    Otro:<input type="text" name="nation" class="other-nation-input" placeholder="ej. Argentina">
    </label><br>
    <label for="parcialidad">Parcialidad<input type="text" id="parcialidad" name="parcialidad" value="parcialidad"> </label><br>
    <label for="comunidad">Comunidad<input type="text" id="comunidad" name="comunidad" value="comunidad"> </label><br>
    <label for="institucion">Nombre de la institución<input type="text" id="institucion" name="institucion" value="institucion"> </label><br>
    <label for="terminos"><input type="checkbox" id="terminos" name="terminos" value="terminos">Acepto los <a href="">términos y condiciones</a></label><br>
    <button>Siguiente</button>

</form>

<?php
require_once 'footer.php';
?>
