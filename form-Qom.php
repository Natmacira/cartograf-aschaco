<?php
// COMENTADO PARA PODER MOSTRAR EL FRONT
// $mysqli = new mysqli("localhost", "root", "", "cartografiaschaco.com");

// Check connection
// if ($mysqli->connect_errno) {
// echo "Failed to connect to MySQL: " . $mysqli->connect_error;
// exit();
// } else {
// echo "Hola que tal";
// } 
?>


<?php
$body_class = "form";
require_once 'header-Qom.php';
?>


<!-- <form action="validation-form.php"> -->
<form action="">
    <p><strong>Erelec nam aralamaxat </strong></p>

    <label for="name">Nombre <sup>*</sup><input type="text" id="name" name="nombre" value="" required placeholder="Eriñi  ca ʼar ʼenaxat"> </label><br>
    <label for="nation">Yi noỹic/ na lauo’<sup>*</sup></label> <br>
    <label for="qom" class="nation-option-label"><input type="radio" id="qom" name="nation" value="1" required>QOM </label><br>
    <label for="wichi" class="nation-option-label"><input type="radio" id="wichi" name="nation" value="2">LQAXAIC </label><br>
    <label for="moqoit" class="nation-option-label"><input type="radio" id="moqoit" name="nation" value="3">MOQOIT </label><br>
    <label for="otro" class="nation-option-label"><input type="radio" id="otro" name="nation" value="4">
        Otro:<input type="text" name="nation" class="other-nation-input" placeholder="ej. Argentina">
    </label><br>
    <label for="parcialidad">Parcialidad (opcional)<input type="text" id="parcialidad" name="parcialidad" value="" placeholder="indicá tu parcialidad"> </label><br>
    <label for="comunidad">Comunidad (opcional)<input type="text" id="comunidad" name="comunidad" value="" placeholder="indicá tu comunidad"> </label><br>
    <label for="institucion">Si pertenecés a una institución indicá su nombre (opcional)<input type="text" id="institucion" name="institucion" value="" placeholder="nombre de la institución"> </label><br>
    <label for="terminos" id="terms-label"><input type="checkbox" id="terminos" name="terminos" value="" required>Acepto los <strong> <a href="terminos-Qom.php"> términos y condiciones</a></strong></label><br>
    <button>Siguiente</button>


</form>

<section class="contact-us">
    <h2>Ram huo ʼo cam saq ʼahuaỹateeteguet, qomi anamaxa ca erec.</h2>
    <form action="">
        <strong>ʼan   ʼonaxatañi ca ʼarnataxanxac</strong>
        <label for="">Nombre <input type="text" placeholder="Eriñi cam ʼar ʼenaxat"></label>
        <label for="">Mail <input type="mail" placeholder="Eriñi ca an, mail"></label>
        <label for="">Consulta<textarea name="" id="" cols="30" rows="10" placeholder="Eriñi aca  ʼancontraseñ"></textarea></label>
        <button>ʼahuamaq</button>
    </form>
</section>

<?php
require_once 'footer-Qom.php';
?>