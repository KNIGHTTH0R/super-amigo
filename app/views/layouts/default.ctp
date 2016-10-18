<?php
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en"  xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<title>Supervielle Amigos</title>
<link rel="stylesheet" type="text/css" href="<?php echo $html->url('/css/style.css?v20121030'); ?>" />
<link rel="stylesheet" type="text/css" href="css/style.css">	
<?php
	echo $javascript->link('jquery-1.7.1.min.js');
	echo $javascript->link('jquery-ui-1.8.21.custom.min.js');
	echo $javascript->link('fb.js'); 
?>
</head>
<body>
	<div id="container">
		<div id="nav">
			<div id="header">
				<div class="logo-supervielle"></div>
			</div>
			<div id="content" class="<?php echo strtolower($this->params['controller'].'-'.$this->action); ?>">
				<div class="logo-app"></div>
				<?php echo $content_for_layout; ?>
			</div>
			<div id="footer">
				<?php /*if ($this->params['controller']=='front'){*/ ?>
				<div class="disclaimer" align="justify">
					Promoción sin obligación de compra. Válida en la República Argentina a excepción de la Provincia de Salta entre las 12 hs  del  día 16 de Julio de 2013 y  las 12 hs  del día 31 de Julio de 2013.  Consultar bases y condiciones en www.supervielle.com.ar y en las sucursales de Banco Supervielle S.A.- . No participa de la Promoción personal de Banco Supervielle  S.A., ni del Grupo Supervielle S.A., ni de ninguna de las empresas que integran el Grupo Supervielle S..A, ni sus agencias de publicidad y/o promoción, ni tampoco sus familiares directos hasta el segundo grado de consaguinidad de los nombrados.  El premio consistirá en una tablet (Polaroid PTAB7XC).   Facebook no patrocina, avala ni administra de modo alguno esta Promoción, ni tampoco está asociada a ella.
				</div>
				<?php //} ?>
				<div class="logo-supervielle"></div>
			</div>		
		<div class="clear"></div>
		</div><!-- #nav -->
	</div><!-- #container -->
<div id="fb-root"></div>
<script type="text/javascript">
	window.fbAsyncInit = function() {
  		FB.init({appId: '492186900851916', status: true, cookie: true, xfbml: true, oauth: true});

			FB.Event.subscribe('edge.create', function(response) {
				console.log('user just clicked Liked on your page');
			});
			
			FB.Event.subscribe('auth.authResponseChange', function(response) {
				console.log('cambia la sessiokn');
			}); 
	};

	(function() { var e = document.createElement('script');
	e.async = true;
	e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
	document.getElementById('fb-root').appendChild(e); }());
  
	window.onload = function() {
		FB.Canvas.setSize({height:600});
		setTimeout("FB.Canvas.setAutoGrow(100)",500);
  		//FB.Canvas.setAutoGrow(100); //Run the timer every 100 milliseconds, you can increase this if you want to save CPU cycles
	}
</script>
</body>
</html>