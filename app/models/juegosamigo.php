<?php
class Juegosamigo extends AppModel
{
    var $name = 'Juegosamigo';
	var $useTable = 'juegosamigos';
	
	var $belongsTo = array(
    	'Usuario' => array(
			'className'    => 'Usuario',
    		'foreignKey'   => 'usuario_id',
			'counterCache' => true,
		),
		'Juego' => array(
			'className'    => 'Juego',
    		'foreignKey'   => 'juego_id',
			'counterCache' => true,
		)
    );
	
	var $hasMany = array(
		'Juegosamigorespuesta' => array(
			'className' => 'Juegosamigorespuesta',
            'conditions' => '',
            'order' => '',
            'foreignKey' => 'juegosamigo_id'
        )
    );
	
	function getResultado($id){
		$this->recursive = 2;
		$contain = array('Juego'=>array('Usuario'));
		return $this->find('first',array('conditions'=>array('Juegosamigo.id'=>$id)));
	}
	
	function getOriginJuegoUser($id){
		$this->recursive = 2;
		$contain = array('Juego'=>array('Usuario'));
		$data = $this->find('first',array('contain'=>$contain,'conditions'=>array('Juegosamigo.id'=>$id)));
		return $data['Juego']['Usuario'];
	}
	
	function getResultText($result){
		$nombre_amigo = $result['Juego']['Usuario']['nombre'].' '.$result['Juego']['Usuario']['apellido'];
		if($result['Juegosamigo']['puntaje'] <= 20){
			$str = '¿Realmente te considerás su amigo? ¡Urgente una charla de café para ponerse al día con la amistad!';
		}else if ($result['Juegosamigo']['puntaje'] <= 50){
			$str = 'Si fuera tu amigo, no estaría tan orgulloso de la relación. Pero… ¡todo puede mejorar! ¡Apurate!';
		}else if ($result['Juegosamigo']['puntaje'] <= 80){
			$str = '¡Alegría! Tanta coincidencia es sinónimo de momento para pedirle un favor!';
		}else if ($result['Juegosamigo']['puntaje'] > 80){
			$str = 'Un honor. Tu amigo no lo va a poder creer. ¿Son hermanos? Podrían ser la misma persona? ¡Salgan a festejar!';
		}
		return $str;
	}
	
	function beforeSave(){
		$cantidad_preguntas = count($this->data['Juegosrespuesta']);
		$respuestas_decoded = json_decode($this->data['Respuesta_amigo']['Juegosamigo']['data']);
		$cantidad_correctas = 0;
		foreach ($this->data['Juegosrespuesta'] as $i => $respuesta){
			if($respuesta['Pregunta']['Opcion'][$respuestas_decoded[$i]]['id'] == $respuesta['opcion_id']){
				$cantidad_correctas ++;
			}
		}
		$this->data['Juegosamigo']['puntaje'] = ($cantidad_correctas * 100)/$cantidad_preguntas;
		return true;
	}
	
	function afterSave(){
		App::import('Model','Chance');
		$cmodel = new Chance();
		App::import('Model','Juegosamigorespuesta');
		$jmodel = new Juegosamigorespuesta();
		$data['Juegosamigorespuesta']['juegosamigo_id'] = $this->id;
		$respuestas_decoded = json_decode($this->data['Respuesta_amigo']['Juegosamigo']['data']);
		foreach($this->data['Juegosrespuesta'] as $i => $respuesta){
			$data['Juegosamigorespuesta']['juegos_respuesta_id'] = $respuesta['id'];
			$data['Juegosamigorespuesta']['opcion_id'] = $respuesta['Pregunta']['Opcion'][$respuestas_decoded[$i]]['id'];
			$jmodel->create();
			$jmodel->save($data);
		}
		$loop=1;
		if ($this->data['Juegosamigo']['puntaje']==100){$loop=2;}
		while($loop>0){
			$loop--;
			$data = null;
			$cmodel->create();
			$data['Chance']['usuario_id'] = $this->data['Juego']['usuario_id'];
			$data['Chance']['juego_id'] = $this->data['Juego']['id'];
			$cmodel->save($data);//creo la chance para el que le mando la invitacion
			$cmodel->create();
			$data['Chance']['usuario_id'] = $this->data['Juegosamigo']['usuario_id'];
			$data['Chance']['juego_id'] = $this->data['Juego']['id'];
			$data['Chance']['juegosamigo_id'] = $this->id;
			$data['Chance']['amigo_usuario_id'] = $this->data['Juego']['usuario_id'];
			$cmodel->save($data);//creo la chance para el que completo el juego
		}
	}
}