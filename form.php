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
<form action="">
    <p><strong>No>xataxachiriguilec na> leré </strong></p>

    <label for="name">Neenaxat: Ỹichiriñi qadeenaxachi>
        <sup>*</sup><input type="text" id="name" name="nombre" value="" required placeholder="escribí tu nombre"> </label><br>
    <label for="nation">Nauo>/Chicqochigui
        <sup>*</sup></label> <br>
    <label for="qom" class="nation-option-label"><input type="radio" id="qom" name="nation" value="1" required>Qom </label><br>
    <label for="wichi" class="nation-option-label"><input type="radio" id="wichi" name="nation" value="2">Wichi </label><br>
    <label for="moqoit" class="nation-option-label"><input type="radio" id="moqoit" name="nation" value="3">Moqoit </label><br>
    <label for="otro" class="nation-option-label"><input type="radio" id="otro" name="nation" value="4">
        Liỹa:<input type="text" name="nation" class="other-nation-input" placeholder="naloqojnaxanaxat. Argentina">
    </label><br>
    <label for="parcialidad">Ỹorigchi (da> vi>saqué): choxochi ca>chicqoraugui
        <input type="text" id="parcialidad" name="parcialidad" value="" placeholder="indicá tu parcialidad"> </label><br>
    <label for="comunidad">Na>areaxahua (da> vi>saque): Choxochi na>maq ra>areaxahuai
        <input type="text" id="comunidad" name="comunidad" value="" placeholder="indicá tu comunidad"> </label><br>
    <label for="institucion">No>om ca> no>ueenataxanaxaqui loqo>m paxaguinataxanaxaqui>  ro’ueenataxanqa>chi, choxochi ca> leenaxat.<input type="text" id="institucion" name="institucion" value="" placeholder="nombre de la institución"> </label><br>
    <label for="terminos" id="terms-label"><input type="checkbox" id="terminos" name="terminos" value="" required>Acepto los <strong> <a href="terminos.php"> términos y condiciones</a></strong></label><br>
    <button>Siguiente</button>

</form>

<?php
require_once 'footer.php';
?>