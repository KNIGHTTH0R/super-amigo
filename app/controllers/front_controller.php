<?php

class FrontController extends AppController {

	public $name = 'Front';

	public $uses = array('Juego','Chance');

	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->layout = 'default';
	}

	public function home()
	{
		$invitations = $this->Session->read('requests');
		if ($invitations != null){ //si fue invitado
			$this->redirect(array('controller' => 'front', 'action' => 'home_amigo')); //lo redirijo a la home de amigos
		}
		$this->checkRegistro(true);//Se fija si el usuario esta registrado en la base de datos
		if (isset($this->SessionUsuario['id'])){//Si lo encontro en la base de datos
			$this->set('registered',true);
			if ($this->Juego->checkPlayed($this->SessionUsuario['id'])) //si ya jugo
			{
				$this->set('ya_jugo',$this->Juego->checkPlayed($this->SessionUsuario['id']));
				$this->set('code',$this->Juego->getUserGameCode($this->SessionUsuario['id']));
				$this->set('chances',$this->Chance->getChancesPorUsuario($this->SessionUsuario['id']));
			}
		}
		$this->set('fan',$this->fanGate());
	}
	
	function home_amigo(){
		$this->checkLogin(true); //Verifico si tiene permisos
		if (isset($this->data)){ //Si viene con la id de juego a tomar
			$this->redirect(array('controller' => 'Juegosamigos', 'action' => 'add',$this->data['Front']['juego_id'])); //lo redirijo a la home de amigos
		}
		$invitations = $this->Session->read('requests');
		$data = $this->Juego->getUserProfilesByRequests($invitations);// recibo los datos del usuario que lo invito

		$this->set('invitations',$invitations);
		$this->set('fan',$this->fanGate());
		$this->set('data',$data);
	}
	
	function deleteRequestFromFront(){
		$invitations = $this->Session->read('requests');
		$this->deleteRequestFromCode($invitations[$this->data['Request']['id']]['data']);
		unset($invitations[$this->data['Request']['id']]);
		$this->Session->write('requests',$invitations);
		echo 'ok';exit;
	}
}