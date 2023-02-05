<?php

/** NOTAS 16.01 ----> Preferencia Ele tener un usuario único para que la gente no se tenga que crear el propio. Y en este caso 
 * el formulario se llenaría cada vez y sería la forma de loguearse.
 * 
 * Consultas sobre el site para responderte:
* Me podrías pasar mas datos sobre la herramienta? 
* Que requerimientos tiene? Una base de datos?
* Cuantas personas van a utilizarlo en simultaneo?
*
*
*
 * Preguntar cuáles son los pasos para subir un marcador al mapa. Y para agregar fotos a dicho marcador.
 * Desde que le usuarie inicia el proceso hasta que se visibiliza de manera pública. HAY QUE ESTAR LOGUEADE, SE PUEDE EDITAR
 * AGREGAR COSAS ETC DESDE WIKIDATA.ORG --> MIS CONTRIBUCIONES ----> tener en cuenta que parece tardar en aparecer la carga
 * en el mapa, ver tema caché. Pensar para nuestra versión que aparezca algún cartelito...preguntar a Lu...en nuestra versión
 * como haríamos para editar ?? también desde wikidata?? como sería ese logueo de usuarie?
 * 
 * 
 * Consultar a qué fuente (wikidata/wikicommons/wikipedia) se está añadiendo la información. ---- > en principio a wikidata, 
 * ver si podemos customizar que se suban a otras tmb directo tipo wikicommons
 *  
 * ¿Esto trae todo lo que está en cada una de las fuentes (si coinciden las coordenadas GPS)? SI ---> en principio si, dsps podemos
 * hacer filtros
 * 
 * Para agregar la funcionalidad de cargar marcadores en wikishootme, lo que hay que hacer desde nuestra app
 * sería lo siguiente? : SI
 *  - crear un bot en wikidata
 *  - esperar la aprobación
 *  - conectar este bot con wikidata para que envíe la información cargada por les usuaries en nuestra app.
 * ---> respondió que si pero no mucha mas data
 * 
 * O SEA:
 * une usuarie entra, carga una fotito. la fotito se la enviamos al bot, el bot la manda a wikidata a través
 * de su api, quien a su vez la recibe, la ingresa en la base de datos, y luego wikishoot me la levanta?
 * 
 * https://tools-static.wmflabs.org/tooltranslate/data/wikishootme/en.json
 *  -> las frases de wikishootme en inglés, para traducir. Ver si existen los ISO de estos idiomas
 * 
 * Angie Cervellera18:29
* RESPUESTA SI -- Juan pregunta de Angie: el nuevo wikishootme se puede albergar en toolforge (¿qué es?) donde 
*estan todas las herramientas? conviene o no? yo pensando en la sostenibilidad digamos de  la herramienta "nueva" creada.
 * claro y en flickr puede estar lo que no tiene licencias libres
*o del CDI
*
*Esta la Propiedad P953: trabajo completo disponible en URL // https://www.wikidata.org/wiki/Q110954084


*** notas 12.01 -- Las contribuciones que no son aprobadas quien las autoriza? cuál es el criterio para aceptar una carga? Por ejemplo 
* si alguien de una comunidad quiere subir algo sencillo como la casa de un intengrante de su comunidad se le aprobaría? porque yo
*quise hacer una carga de mi casa y no fue aprobada. Tampoco tuve ningún tipo de notificación en relación a porque como o cuando fueron
*rechazadas, cómo funciona eso?
*
*
* El GPS anda super mal
*
*PARA GENERAR LA URL DE LLAMADA PARA CARGAR ALGO -- FUNCIONA SI ESTÁS LOGUEADE A WIKI
*<!DOCTYPE html>
*<html lang="en">
*<head>
*	<meta charset="UTF-8">
*	<meta http-equiv="X-UA-Compatible" content="IE=edge">
*	<meta name="viewport" content="width=device-width, initial-scale=1.0">
*	<title>Nati hermosa</title>
*</head>
*<body>
*	<form action="https://wikishootme.toolforge.org/api_v3.php" method="get">
*		<input type="text" name="action" value="new_item">
*		<input type="text" name="lat" value="-34.63091972363547">
*		<input type="text" name="lng" value="-60.501471996241904">
*		<input type="text" name="p131" value="Q1486">
*		<input type="text" name="p18" value="">
*		<input type="text" name="label" value="Casa de Luli">
*		<input type="text" name="lang" value="en">
*		<button>enviar</button>
*	</form>
*</body>
*</html>
*
*
*PREGUNTAR A WIKI ---> SE PUEDE HACER EL LOGUEO VIA API?
*/

?>
<!DOCTYPE HTML>
<html><head>
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
<link rel="stylesheet" href="https://tools-static.wmflabs.org/cdnjs/ajax/libs/twitter-bootstrap/4.0.0-alpha.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://tools-static.wmflabs.org/cdnjs/ajax/libs/tether/1.3.4/css/tether.min.css">
<link rel="stylesheet" href="https://tools-static.wmflabs.org/cdnjs/ajax/libs/leaflet/1.2.0/leaflet.css">
<link rel="stylesheet" href="https://tools-static.wmflabs.org/cdnjs/ajax/libs/leaflet-contextmenu/1.4.0/leaflet.contextmenu.min.css">
<link rel="stylesheet" href="https://tools-static.wmflabs.org/cdnjs/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
<link rel="stylesheet" href="style.min.css">
<!--<link rel="stylesheet" type="text/css" href="https://tools-static.wmflabs.org/magnustools/resources/css/common.css">-->
<title tt='toolname'></title>
<script src='https://tools-static.wmflabs.org/cdnjs/ajax/libs/jquery/3.1.0/jquery.min.js'></script>
<script src='https://tools-static.wmflabs.org/cdnjs/ajax/libs/tether/1.3.4/js/tether.min.js'></script>
<script src='https://tools-static.wmflabs.org/cdnjs/ajax/libs/twitter-bootstrap/4.0.0-alpha.3/js/bootstrap.min.js'></script>
<script src='https://tools-static.wmflabs.org/cdnjs/ajax/libs/leaflet/1.2.0/leaflet.js'></script>
<script src="https://tools-static.wmflabs.org/cdnjs/ajax/libs/leaflet-contextmenu/1.4.0/leaflet.contextmenu.min.js"></script>
<script src="https://tools-static.wmflabs.org/magnustools/resources/js/common.js"></script>
<script src="https://tools-static.wmflabs.org/magnustools/resources/js/md5.js"></script>
<script src="https://tools-static.wmflabs.org/magnustools/resources/js/wikidata.js"></script>
<script src="https://tools-static.wmflabs.org/tooltranslate/tt.js"></script>
<script src="js/main.js"></script>
<script src="js/sm_comm.js"></script>


<script type='text/javascript'>
$(document).ready ( function () {
	wikishootme.init() ;
} ) ;

{
var m = window.location.href.match(/\?(.+)$/) ;
if ( m != null  ) {
	var url = '/wikishootme/#' + m[1].replace(/\#/,'&') ;
	window.location.href = url ;
}
}
</script>

</head>

<body>

<div id='top'>
<nav class="navbar navbar-light bg-faded">
<ul class="nav navbar-nav">
	<li class="nav-item"><button id='center_on_me' class='btn btn-secondary' tt_title='go_to_my_position'><i class="fa fa-compass" style='font-size:24pt' aria-hidden="true"></i></button></li>
	<li class="nav-item"><button id='search' class='btn btn-secondary' tt_title='search'>&#128269;</button></li>
  <li class='nav-item' style='display:none' id='li_authorize'>
    <a class='btn btn-outline-primary' href='api_v3.php?action=authorize' tt='authorize_upload'></a>
  </li>
	<li class="nav-item" id='dropdownUploadsLi'>
		<div class="dropdown" style='display:inline'>
		  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownUploads" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
		  <div class="dropdown-menu dropdown-menu-left" id='upload_list' style='margin-top:1em'></div>
		</div>
	</li>
	<li class="nav-item" id="geo_error" style='font-size:7pt'></li>
	<li class="nav-item"><button id='update' class='btn btn-info' tt='update'></button></li>
	<li class="nav-item"><div id='busy' tt_title='updating'><i class="fa fa-spinner" style='font-size:24pt' aria-hidden="true"></i></div></li>
</ul>

<div class='pull-xs-right'>
<div class="dropdown" style='display:inline'>
  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
  <i class="fa fa-bars" style='font-size:16pt' aria-hidden="true"></i>
  </button>
  <div class="dropdown-menu dropdown-menu-right" style='margin-top:1em'>
	<div id='interface_language_wrapper' class='dropdown-item'></div>
    <a class="dropdown-item" href="#" target='_blank' id='wdfist' tt='wdfist' tt_title='wdfist_hint'></a>
    <a class="dropdown-item" href="#" target='_blank' id='flickr' tt='flickr' tt_title='flickr_hint'></a>
    <a class="dropdown-item" href="#" target='_blank' id='sparql_filter_button'><span tt='sparql_filter_dialog'></span><span id='is_using_filter'>&nbsp;<i class="fa fa-check" aria-hidden="true"></i></span></a>
    <a class="dropdown-item"  href='https://meta.wikimedia.org/wiki/WikiShootMe' target='_blank' tt='about'></a>
    <div id='tile_wrapper' class='dropdown-item'></div>
  </div>
</div>
</div><!--pull-right-->

</nav>
</div>
<div id='map'></div>

<div id='sparql_filter_dialog' class="modal fade">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" tt='sparql_filter_dialog'></h4>
      </div>
      <div class="modal-body">

        <div style='margin-top:10px;margin-bottom:10px' tt='sparql_filter_desc'></div>
        
        <div>
        <form id='sparql_simple_form' class='form form-inline'>
        <div class="row">
        <div class="col-lg-12">
			<div class="input-group">
			<input type='text' id='sparql_filter_p31' class='form-control' tt_placeholder='ph_p31' />
			<span class="input-group-btn"><input type='submit' class='btn btn-secondary' tt_value='use_p31' /></span>
			</div>
		</div>
		</div>
        </form>
        </div>
        
        <div class="card" style='margin-top:10px'>
			<pre>SELECT ?q { /*...*/</pre>
			<textarea id='sparql_filter_query' style='width:100%' rows=5 tt_placeholder='sparql_filter_query_hint'></textarea>
			<pre>}</pre>
		</div>
		
		<div>
		<label><input type='checkbox' id='worldwide' value='1' /> <span tt='worldwide'></span></label>
		</div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" tt='close'></button>
        <button type="button" id='sparql_filter_clear' class="btn btn-danger" tt='clear_filter'></button>
        <button type="button" id='sparql_filter_use' class="btn btn-primary" tt='use_filter'></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div id='search_dialog' class="modal fade">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" tt='search_title'></h4>
      </div>
      <div class="modal-body">
        
        <div>
        <form id='search_form' class='form form-inline'>
        <div class="row">
        <div class="col-lg-12">
			<div class="input-group">
			<input type='text' id='search_query' class='form-control' />
			<span class="input-group-btn"><input type='submit' class='btn btn-primary' tt_value='search' /></span>
			</div>
		</div>
		</div>
        </form>
        </div>
        
        <div class="card" id='search_results' style='display:none'>
		<ul class="list-group list-group-flush" id='search_results_list'></ul>
		</div>
        
      </div>
<!--      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>-->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<div class="modal fade hide" id="pleaseWaitDialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" tt="performing_action"></h4>
			</div>
			<div class="modal-body">
				<progress class="progress progress-striped progress-animated" value="100" max="100"></progress>
			</div>
		</div>
	</div>
</div>

</body>
</html>