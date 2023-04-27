<?php

require_once 'functions.php';

?>
<!DOCTYPE HTML>
<html>

<head>
	<meta name="robots" content="noindex,nofollow">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
	<link rel="stylesheet" href="<?php echo APP_HOME_URL; ?>lib/bootstrap/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo APP_HOME_URL; ?>lib/tether/tether.min.css">
	<link rel="stylesheet" href="<?php echo APP_HOME_URL; ?>lib/leaflet/leaflet.css">
	<link rel="stylesheet" href="<?php echo APP_HOME_URL; ?>lib/leaflet/leaflet.contextmenu.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="style.min.css?v=1">
	<title>Cartografías Abiertas</title>
	<script src='<?php echo APP_HOME_URL; ?>lib/jquery/jquery.min.js'></script>
	<script src='<?php echo APP_HOME_URL; ?>lib/tether/tether.min.js'></script>
	<script src='<?php echo APP_HOME_URL; ?>lib/bootstrap/bootstrap.min.js'></script>
	<script src='<?php echo APP_HOME_URL; ?>lib/leaflet/leaflet.js'></script>
	<script src="<?php echo APP_HOME_URL; ?>lib/leaflet/leaflet.contextmenu.min.js"></script>
	<script src="<?php echo APP_HOME_URL; ?>lib/magnustools/common.js"></script>
	<script src="<?php echo APP_HOME_URL; ?>lib/magnustools/md5.js"></script>
	<script src="<?php echo APP_HOME_URL; ?>lib/magnustools/wikidata.js"></script>
	<script src="<?php echo APP_HOME_URL; ?>lib/tooltranslate/tt.js"></script>
	<script>
		var cartografiasTranslations = <?php echo file_get_contents( 'lib/tooltranslate/data/languages-custom.json'); ?>;
		var homeUrl = '<?php echo APP_HOME_URL; ?>';
	</script>
	<script src="js/main-legacy.js"></script>
	<script src="js/main.js"></script>
	<script src="js/burger-menu.js"></script>
	<script src="js/sm_comm.js"></script>

	<style>
		.sign-in-map,
		.leaflet-contextmenu,
		.form.form-inline {
			display: none !important;
		}
		#top {
			top: 0 !important;
			display: none;
		}
	</style>
</head>

<body class="page-mapa unregistered-user">
	<div id='top'>
		<nav class="navbar navbar-light bg-faded" style="display:none">
			<ul class="nav navbar-nav">
				<li class="nav-item"><button id='center_on_me' class='btn btn-secondary' tt_title='go_to_my_position'><i class="fa fa-compass" style='font-size:24pt' aria-hidden="true"></i></button></li>
				<li class='nav-item' style='display:none' id='li_authorize'>
					<a class='btn btn-outline-primary' href='api.php?action=authorize' tt='authorize_upload'></a>
				</li>
				<li class="nav-item" id='dropdownUploadsLi'>
					<div class="dropdown" style='display:inline'>
						<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownUploads" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
						<div class="dropdown-menu dropdown-menu-left" id='upload_list' style='margin-top:1em'></div>
					</div>
				</li>
				<li class="nav-item" id="geo_error" style='font-size:7pt'></li>
				<li class="nav-item"><button id='update' class='btn btn-info' tt='update'></button></li>
				<li class="nav-item">
					<div id='busy' tt_title='updating'><i class="fa fa-spinner" style='font-size:24pt' aria-hidden="true"></i></div>
				</li>
			</ul>

			<!-- <ul class="language-ul">
				<li><label><input type="radio" class="language-switch" name="language-switch" value="qom">Qom</label></li>
				<li><label><input type="radio" class="language-switch" name="language-switch" value="wichi">Wichí</label></li>
				<li><label><input type="radio" class="language-switch" name="language-switch" value="moqoit">Moqoit</label></li>
				<li><label><input type="radio" class="language-switch" name="language-switch" value="es" checked>Español</label></li>
			</ul> -->

			<article class="sign-in-map">
				<p class="mobile-version" data-translation-id="instructivo-movil">Mantené presionada la pantalla del <br> mapa para agregar contenido</p>
			</article>
			<article class="sign-in-map">
				<p class="desktop-version" data-translation-id="instructivo-computadora">Hacé click derecho en el mapa para <br> agregar contenido</p>
			</article>
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

	<?php
	// require_once 'footer-Qom.php';
