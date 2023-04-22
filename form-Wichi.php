<?php
$body_class = "form";
require_once 'header-Wichi.php';
?>

<form action="">
    <p><strong>Thathu aka datos tolesainek- hina</strong></p>

    <label for="name">Ey<sup>*</sup><input type="text" id="name" name="nombre" value="" required placeholder="thathu ey"> </label><br>
    <label for="nation">Aw’etes/Nación <sup>*</sup></label> <br>
    <label for="qom" class="nation-option-label"><input type="radio" id="qom" name="nation" value="1" required>Qom </label><br>
    <label for="wichi" class="nation-option-label"><input type="radio" id="wichi" name="nation" value="2">Wichi </label><br>
    <label for="moqoit" class="nation-option-label"><input type="radio" id="moqoit" name="nation" value="3">Moqoit </label><br>
    <label for="otro" class="nation-option-label"><input type="radio" id="otro" name="nation" value="4">
        Otro:<input type="text" name="nation" class="other-nation-input" placeholder="ej. Argentina">
    </label><br>
    <label for="parcialidad">Enlhi tojh lahane (yahin ):<input type="text" id="parcialidad" name="parcialidad" value="" placeholder="Om kalelhojh"> </label><br>
    <label for="comunidad">Aw'etes (yahin)<input type="text" id="comunidad" name="comunidad" value="" placeholder="Om kalelhojh aw’etes"> </label><br>
    <label for="institucion">Che latolhey tochefwenyajhw’et, fwel Lhey (yahin):<input type="text" id="institucion" name="institucion" value="" placeholder="Thathu tochefwenyajhw’et lhey"> </label><br>
    <label for="terminos" id="terms-label"><input type="checkbox" id="terminos" name="terminos" value="" required><strong> <a href="terminos-Wichi.php">watlok nñhanej mak tojh tothalhn’uya tojh ihi plataformana</a></strong></label><br>
    <button>Athana</button>


</form>
<article class="show-after-submission">
    <p>Nkachiseshi-am         <br>
            tojh latach'uta.
    </p>
</article>

<section class="contact-us">
    <h2>Che atha-amhu mañhey tojh hana wusey che lawu atshonhaya.</h2>
    <form action="">
        <strong>wumnamej añhi, mak tojh lathek lahanej</strong>
        <label for="">Ey <input type="text" placeholder="Thathu Ey"></label>
        <label for="">Mail <input type="mail" placeholder="Thathu aka mail"></label>
        <label for="">Mak tojh latay’otnej<textarea name="" id="" cols="30" rows="10" placeholder="Thathu mak tojh latay’otnej"></textarea></label>
        <button>Thattshi</button>
    </form>
</section>

<?php
require_once 'footer-Wichi.php';
