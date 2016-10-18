<style type="text/css">
#botones {
	display: none;
}
#titulo {
	color: #f00;
	font-size: 12px;
	font-weight: normal;
	padding-bottom: 4px;
}
</style>

<div id="cuerpo">
	<div id="error1">
		<div id="titulo"><?php echo $this->Session->flash(); ?></div>
		<a href="<?php echo $html->url('/'); ?>">Reiniciar</a>
	</div>
</div>


