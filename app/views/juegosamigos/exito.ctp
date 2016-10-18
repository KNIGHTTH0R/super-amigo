<h1>¡SABES UN <?php echo $resultado['Juegosamigo']['puntaje']; ?>% DE LOS GUSTOS DE TU AMIGO!</h1>
<div class="texto-resultado"><?php echo $str_resultado; ?></div>
<?php echo $this->Html->link('','javascript:void(0);',array('class'=>'btn-compartir','onClick'=>'postResultToFeed("'.$resultado['Juegosamigo']['puntaje'].'");')); ?>
<?php 
	if ((!isset($ya_jugo))||(!$ya_jugo)){
		?><div class="texto-participar"></div><?php
		echo $this->Html->link('',array('controller' => 'usuarios', 'action' => 'add'),array('class'=>'btn-participar'));
		?><div class="icono-tablet"></div><?php
	}
 ?>
 