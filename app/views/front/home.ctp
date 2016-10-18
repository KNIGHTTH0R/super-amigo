<div class="texto-home-titulo"></div>
<?php
	if (isset($ya_jugo)){
		?><div class="texto-ya-participaste"></div>
		<div class="texto-chances">TENÉS <?php echo $chances; ?> CHANCE<?php echo (($chances == 1)?'':'S')?> DE GANAR. INVITÁ A NUEVOS<br>AMIGOS A CONTESTAR TUS PREGUNTAS.Y ACUMULÁ<br>MÁS CHANCES DE GANAR EL CONCURSO.</div><?php
		echo $this->Html->link('','javascript:shareJuego("'.$code.'");',array('class'=>'btn-invita-amigos'));
	}else{
		?><div class="texto-home"></div><?php
		echo $this->Html->link('',array('controller' => 'usuarios', 'action' => 'add'),array('class'=>'btn-participar'));
		?><div class="icono-tablet"></div><?php
	}
?>
<?php if (!$fan){ ?><div class="fangate"></div><?php } ?>