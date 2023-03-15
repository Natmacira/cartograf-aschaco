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
require_once 'header.php';
?>


<!-- <form action="validation-form.php"> -->
<form action="validation-form.php" method="POST">
    <p><strong>Completá el siguiente formulario con tus datos</strong></p>

    
    <label for="name">Nombre <sup>*</sup><input type="text" id="name" name="nombre" value="" required placeholder="escribí tu nombre"> </label><br>
    
    <label for="nation">Pueblo/Nación <sup>*</sup></label> <br>
    <label for="qom" class="nation-option-label"><input type="radio" id="qom" name="nation" value="1" required>Qom </label><br>
    <label for="wichi" class="nation-option-label"><input type="radio" id="wichi" name="nation" value="2">Wichi </label><br>
    <label for="moqoit" class="nation-option-label"><input type="radio" id="moqoit" name="nation" value="3">Moqoit </label><br>
    <label for="otro" class="nation-option-label"><input type="radio" id="otro" name="nation" value="4">
        Otro:<input type="text" name="nation" class="other-nation-input" placeholder="ej. Argentina">
    </label><br>
    
    <label for="parcialidad">Parcialidad (opcional)<input type="text" id="parcialidad" name="parcialidad" value="" placeholder="indicá tu parcialidad"> </label><br>
    
    <label for="comunidad">Comunidad (opcional)<input type="text" id="comunidad" name="comunidad" value="" placeholder="indicá tu comunidad"> </label><br>
    
    <label for="institucion">Si pertenecés a una institución indicá su nombre (opcional)<input type="text" id="institucion" name="institucion" value="" placeholder="nombre de la institución"> </label><br>
    
    <label for="terminos" id="terms-label"><input type="checkbox" id="terminos" name="terminos" value="" required>Acepto los <strong> <a href="terminos.php"> términos y condiciones</a></strong></label><br>
    
    <button>Siguiente</button>

</form>
<article class="show-after-submission">
    <p>¡Muchas gracias
        <br>
        por tu aporte!
    </p>
</article>

<section class="contact-us">
    <h2>Si tenés dudas o sugerencias, escribinos</h2>
    <form action="">
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
?>