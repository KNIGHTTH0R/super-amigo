<script>
var nombres = new Array();
var game_ids = new Array();
var selected = 0;
var cant = <?php echo count($data); ?>;
$(document).ready(function() {
	 $('#header-'+selected).fadeIn('slow', function() {});
	 $('#nombre-usuario').html(nombres[selected]);
});

function changeAmigo(direction){
	$('#header-'+selected).fadeOut('slow', function() {});
	if (selected + direction > cant - 1){selected = 0;}
	else if(selected + direction < 0){selected = cant - 1;}
	else{selected += direction;}
	$('#header-'+selected).fadeIn('slow', function() {});
	$('#nombre-usuario').html(nombres[selected]);
}

function submit(){
	$("#FrontJuegoId").val(game_ids[selected]);
	$("#FrontHomeAmigoForm").submit();
}

function deleteRequest(){
	$.post('deleteRequestFromFront',{'data[Request][id]':selected}, function(data) {top.location.reload();});
}
</script>
<div class="texto-home-titulo"></div>

<div class="amigos-slider">
	<?php foreach ($data as $i => $output){ ?>
		<script>nombres[<?php echo $i; ?>] = '<?php echo $output['Usuario']['nombre']; ?>';</script>
		<script>game_ids[<?php echo $i; ?>] = <?php echo $output['Juego']['id']; ?>;</script>
		<div class="header-amigo" id="header-<?php echo $i; ?>">
			<div class="profile-image" style="background:url(http://graph.facebook.com/<?php echo $output['Usuario']['fbid']; ?>/picture);"></div>
			<p><b><?php echo $output['Usuario']['nombre']; ?></b> quiere que lo sorprendas. descubrilo contestando estas preguntas, para también ganarte una tablet.</p>
		</div>
	<?php } ?>
	<?php //echo $this->Html->link('Eliminar invitación','javascript:void(0);',array('onClick'=>'deleteRequest();','class'=>'')); ?>
	<?php if (count($data)>1){ ?>
	<?php echo $this->Html->link('','javascript:void(0);',array('onClick'=>'changeAmigo(-1)','class'=>'btn-flecha-back')); ?>
	<?php if(count($data)>1){ ?><div class="amigos-count"><?php echo count($data); ?></div><?php } ?>
	<?php echo $this->Html->link('','javascript:void(0);',array('onClick'=>'changeAmigo(1)','class'=>'btn-flecha-forward')); ?>
	<?php } ?>
</div>

<h1>SI LAS RESPONDES BIEN, <span id="nombre-usuario"></span> TIENE 2 CHANCES<br>MÁS DE GANAR.</h1>
<?php echo $this->Html->link('','javascript:void(0);',array('onClick'=>'submit();','class'=>'btn-responder')); ?>
<div class="icono-tablet"></div>
<?php if (!$fan){ ?><div class="fangate"></div><?php } ?>
<?php
echo $form->create('Front');
echo $form->hidden('juego_id');
echo $form->end();
?>