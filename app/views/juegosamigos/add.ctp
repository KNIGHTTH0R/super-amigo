<script>
	var npreguntas = <?php echo count($preguntas['Juegosrespuesta']); ?>;
	var pregunta_activa = 0;
	var opcion_activa = null;
	var respuestas = new Array();
	$(document).ready(function() {
		$('#pregunta-0').show();
		adaptContent(0);
	});
	
	function adaptContent(pregunta){
		var height = $('#pregunta-'+pregunta).height();
		$('#content').height(height+150);
	}
	
	
	function nextPregunta(){
		if (opcion_activa!=null){
			respuestas[pregunta_activa] = opcion_activa;
			if (pregunta_activa+1 < npreguntas){
				$('#pregunta-'+pregunta_activa).hide();
				pregunta_activa++;
				$('#pregunta-'+pregunta_activa).show();
				adaptContent(pregunta_activa);
				opcion_activa = null;
			}
			else{
				submit();
			}
		}
	}
	
	function selectOption(id){
		$('#opcion-'+pregunta_activa+'-'+opcion_activa).removeClass('selected');
		opcion_activa = id;
		$('#opcion-'+pregunta_activa+'-'+id).addClass('selected');
		timeout = setTimeout('nextPregunta()',1000);
	}
	
	function submit(){
		$("#JuegosamigoData").val(JSON.stringify(respuestas));
		$("#JuegosamigoAddForm").submit();
	}
</script>
<div class="header-amigo">
<div class="profile-image" style="background:url(http://graph.facebook.com/<?php echo $user['fbid']; ?>/picture);"></div>
<span><?php echo $user['nombre'].' '.$user['apellido']; ?></span>
</div>
<?php 
foreach($preguntas['Juegosrespuesta'] as $i => $pregunta){?>
	<div class="pregunta" id="pregunta-<?php echo $i; ?>">
		<!--<h1>PREGUNTA <?php //echo $i+1; ?></h1>-->
		<h2><?php echo $pregunta['Pregunta']['pregunta-para-amigo']; ?></h2>
		<div class="opciones"><?php
			if(count($pregunta['Pregunta']['Opcion'])%4 == 0)//es multiplo de 4
			{
				$offset = 0;
				$limit = 4;
				$f = 0;
				$nfilas = count($pregunta['Pregunta']['Opcion']) / 4;
				while ($f < $nfilas){
					?><div class="fila-opciones 4"><?php
					foreach ($pregunta['Pregunta']['Opcion'] as $j => $opcion){
						if ($j < $offset){continue;}
						if ($j >= $offset + $limit){$offset = $j; break;}
						?><div class="opcion"><?php
							?><div class="img" style="background:url(../../img/opciones/<?php echo $opcion['image']; ?>);"><?php
								echo $this->Html->link('','javascript:void(0);',array('onClick'=>'selectOption('.$j.');','id'=>'opcion-'.$i.'-'.$j));
							?></div><?php
							?><p><?php echo (($opcion['opcion-amigo']!=null)?$opcion['opcion-amigo']:$opcion['opcion']); ?></p><?php
						?></div><?php
					}
					?></div><?php
					$f++;
				}
			}
			else if(count($pregunta['Pregunta']['Opcion'])%3 == 0)//es multiplo de 3
			{
				$offset = 0;
				$limit = 3;
				$f = 0;
				$nfilas = count($pregunta['Pregunta']['Opcion']) / 3;
				while ($f < $nfilas){
					?><div class="fila-opciones 3"><?php
					foreach ($pregunta['Pregunta']['Opcion'] as $j => $opcion){
						if ($j < $offset){continue;}
						if ($j >= $offset + $limit){$offset = $j; break;}
						?><div class="opcion"><?php
							?><div class="img" style="background:url(../../img/opciones/<?php echo $opcion['image']; ?>);"><?php
								echo $this->Html->link('','javascript:void(0);',array('onClick'=>'selectOption('.$j.');','id'=>'opcion-'.$i.'-'.$j));
							?></div><?php
							?><p><?php echo (($opcion['opcion-amigo']!=null)?$opcion['opcion-amigo']:$opcion['opcion']); ?></p><?php
						?></div><?php
					}
					?></div><?php
					$f++;
				}
			}
			else if(count($pregunta['Pregunta']['Opcion'])%5 == 0)//es multiplo de 5
			{
				$nopciones = count($pregunta['Pregunta']['Opcion']);
				if ($nopciones == 5){
					$offset = 0;
					$limit = 3;
					$f = 0;
					$nfilas = 2;
					while ($f < $nfilas){
						?><div class="fila-opciones 5"><?php
						foreach ($pregunta['Pregunta']['Opcion'] as $j => $opcion){
							if ($j < $offset){continue;}
							if ($j >= $offset + $limit){$limit = 2; $offset = $j; break;}
							?><div class="opcion"><?php
								?><div class="img" style="background:url(../../img/opciones/<?php echo $opcion['image']; ?>);"><?php
									echo $this->Html->link('','javascript:void(0);',array('onClick'=>'selectOption('.$j.');','id'=>'opcion-'.$i.'-'.$j));
								?></div><?php
								?><p><?php echo (($opcion['opcion-amigo']!=null)?$opcion['opcion-amigo']:$opcion['opcion']); ?></p><?php
							?></div><?php
						}
						?></div><?php
						$f++;
					}
				}
				else{
					$offset = 0;
					$limit = 4;
					$f = 0;
					$nfilas = 3;
					while ($f < $nfilas){
						?><div class="fila-opciones 5"><?php
						foreach ($pregunta['Pregunta']['Opcion'] as $j => $opcion){
							if ($j < $offset){continue;}
							if ($j >= $offset + $limit){$limit = 3; $offset = $j; break;}
							?><div class="opcion"><?php
								?><div class="img" style="background:url(../../img/opciones/<?php echo $opcion['image']; ?>);"><?php
									echo $this->Html->link('','javascript:void(0);',array('onClick'=>'selectOption('.$j.');','id'=>'opcion-'.$i.'-'.$j));
								?></div><?php
								?><p><?php echo (($opcion['opcion-amigo']!=null)?$opcion['opcion-amigo']:$opcion['opcion']); ?></p><?php
							?></div><?php
						}
						?></div><?php
						$f++;
					}
				}
			
			}
			else if(count($pregunta['Pregunta']['Opcion'])%7 == 0)//es multiplo de 7
			{
				$offset = 0;
				$limit = 4;
				$f = 0;
				$nfilas = 2;
				while ($f < $nfilas){
					?><div class="fila-opciones 7"><?php
					foreach ($pregunta['Pregunta']['Opcion'] as $j => $opcion){
						if ($j < $offset){continue;}
						if ($j >= $offset + $limit){$limit = 3; $offset = $j; break;}
						?><div class="opcion"><?php
							?><div class="img" style="background:url(../../img/opciones/<?php echo $opcion['image']; ?>);"><?php
								echo $this->Html->link('','javascript:void(0);',array('onClick'=>'selectOption('.$j.');','id'=>'opcion-'.$i.'-'.$j));
							?></div><?php
							?><p><?php echo (($opcion['opcion-amigo']!=null)?$opcion['opcion-amigo']:$opcion['opcion']); ?></p><?php
						?></div><?php
					}
					?></div><?php
					$f++;
				}
			}
		
		
		
		
		
		?></div>
	</div><?php
}
echo $form->create('Juegosamigo');
echo $form->hidden('data');
echo $form->hidden('juego_id',array('value'=>$preguntas['Juego']['id']));
echo $form->end();
//echo $this->Html->link('','javascript:void(0);',array('onClick'=>'','class'=>'btn-siguiente'));
?>