<?php
class JuegosamigosController extends AppController {

	var $name = 'Juegosamigos';
	var $uses = array('Juegosamigo','Juego'); 

	function index() {

	}
	
	function add($id_juego=null){
		$this->checkLogin(false);//Si no tiene permisos le damos
		$user = $this->SessionUsuario; //asignamos los datos del usuario a esta variable
		
		if ($id_juego == null){
			$id_juego = $this->data['Juegosamigo']['juego_id'];
		}
		
		$data = $this->Juego->getPreguntasJuego($id_juego);

		if (empty($this->data)){
			$this->deleteRequestFromCode($this->Juego->getCode($id_juego));
			if (!$this->Juego->validateInvitation($id_juego,$user['id'])){
				echo "<script> window.top.location.href='".APP_FB_TAB."'</script>";
			}
		}
		else{
			$data['Respuesta_amigo'] = $this->data;
			$data['Juegosamigo']['usuario_id'] = $user['id'];
			$data['Juegosamigo']['juego_id'] = $data['Juego']['id'];
			if($this->Juegosamigo->save($data)){
				$this->redirect('/juegosamigos/exito/'.$this->Juegosamigo->id);
			}
		}
		$this->set('user',$data['Usuario']);
		$this->set('preguntas',$data);
	}

	function exito($id){
		$this->checkRegistro(true); //Se fija si el usuario esta registrado en la base de datos
		$resultado = $this->Juegosamigo->getResultado($id);
		$this->FacebookM->SendNotification($resultado);
		if (isset($this->SessionUsuario['id'])){
			$this->set('registered',true);
			App::import('Model','Juego');
			$jmodel = new Juego();
			$this->set('ya_jugo',$jmodel->checkPlayed($this->SessionUsuario['id']));
		}
		$this->set('str_resultado',$this->Juegosamigo->getResultText($resultado));
		$this->set('resultado',$resultado);
	}
}