<?php
class JuegosController extends AppController {

	var $name = 'Juegos';
	var $uses = array('Juego','Cuestionario','Chance'); 

	function index() {

	}
	
	function add(){
		$this->checkLogin(true);
		$user = $this->SessionUsuario;
		$preguntas = $this->Cuestionario->getCuestionario();
		$this->set('preguntas',$preguntas);
		if (!empty($this->data)){
			$data['Pregunta'] = $preguntas['Pregunta'];
			$data['Juego']['respuestas'] = $this->data['Juego'];
			$data['Juego']['usuario_id'] = $user['id'];
			if($this->Juego->save($data)){
				$this->redirect('/juegos/exito/'.$this->Juego->id);
			}
		}
	}
	
	function exito($id){
		$this->FacebookM->creoJuego($this->fbConnect());
		$this->checkRegistro(true);
		$this->set('chances',$this->Chance->getChancesPorUsuario($this->SessionUsuario['id']));
		$this->set('code',$this->Juego->getCode($id));
	}
}