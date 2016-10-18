<?php
class Juego extends AppModel
{
    var $name = 'Juego';
	
    var $belongsTo = array(
    	'Usuario' => array(
			'className'    => 'Usuario',
    		'foreignKey'   => 'usuario_id',
			'counterCache' => true,
		)
    );
	
	var $hasMany = array(
		'Juegosrespuesta' => array(
			'className' => 'Juegosrespuesta',
            'conditions' => '',
            'order' => '',
            'foreignKey' => 'juego_id'
        ),
		'Juegosamigo' => array(
			'className' => 'Juegosamigo',
            'conditions' => '',
            'order' => '',
            'foreignKey' => 'juego_id'
        ),
    );
	
	function getUserProfilesByRequests($requests){
		$this->Behaviors->attach('Containable');
		$contain = array('Usuario');
		foreach ($requests as $i => $request)
		{
			$juegos_id[$i] = $this->getIdFromCodigo($request['data']);
		}
		foreach ($juegos_id as $i => $juego_id)
		{
			$data[$i] = $this->find('first',array('contain'=>$contain,'conditions'=>array('Juego.id'=>$juego_id)));
		}
		return $data;
	}
	
	function getPreguntasJuego($juego_id){
		$this->Behaviors->attach('Containable');
		$contain = array('Juegosrespuesta'=>array('Pregunta'=>array('Opcion')),'Usuario');
		$data = $this->find('first',array('contain'=>$contain,'conditions'=>array('Juego.id'=>$juego_id)));
		return $data;
	}
	
	function checkPlayed($user_id){
		$cant = $this->find('count',array('conditions'=>array('Juego.usuario_id'=>$user_id)));
		if ($cant > 0){ //Ya jugo
			return true;
		}
		return false;
	}
	
	function getIdFromCodigo($codigo){
		$data = $this->find('first',array('conditions'=>array('Juego.codigo'=>$codigo)));
		if ($data==null){//Si no existe
			return false;
		}
		return $data['Juego']['id'];
	}
	
	function validateInvitation($juego_id,$user_id){
		$contain = array('Juegosamigo');
		$data = $this->find('first',array('contain'=>$contain,'conditions'=>array('Juego.id'=>$juego_id)));
		
		if ($data['Juego']['usuario_id']==$user_id){//Es su propio juego
			return false;
		}
		foreach ($data['Juegosamigo'] as $juegos_amigo){
			if ($juegos_amigo['usuario_id'] == $user_id){//Ya jugo este juego
				return false;
			}
		}
		return true;
	}
	
	function getCode($juego_id){
		$data = $this->find('first',array('conditions'=>array('Juego.id'=>$juego_id)));
		return $data['Juego']['codigo'];
	}
	
	function getUserGameCode($user_id){
		$data = $this->find('first',array('conditions'=>array('Juego.usuario_id'=>$user_id)));
		return $data['Juego']['codigo'];
	}
	
	function BeforeSave(){
		$last = $this->find('first',array('order'=>'Juego.id DESC'));
		$codigo = $last['Juego']['id'];
		$codigo++;
		$codigo = $codigo.'palabra';
		$codigo = md5($codigo);
		$this->data['Juego']['codigo'] = $codigo;
		return true;
	}
	
	function AfterSave(){
		App::import('Model','Juegosrespuesta');
		App::import('Model','Chance');
		$cmodel = new Chance();
		$jmodel = new Juegosrespuesta();
		$data['Juegosrespuesta']['juego_id'] = $this->id;
		$respuestas = $this->formatRespuestas($this->data['Juego']['respuestas']);
		foreach($respuestas as $id => $respuesta){
			$data['Juegosrespuesta']['pregunta_id'] = $this->data['Pregunta'][$id]['id'];
			$data['Juegosrespuesta']['opcion_id'] = $this->data['Pregunta'][$id]['Opcion'][$respuesta]['id'];
			$jmodel->create();
			$jmodel->save($data);
		}
		$data['Chance']['usuario_id'] = $this->data['Juego']['usuario_id'];
		$data['Chance']['juego_id'] = $this->id;
		$cmodel->save($data);
	}
	
	function formatRespuestas($data){
		$datos = json_decode($data['data']);
		return $datos;
	}
}