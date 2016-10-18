<?php
class UsuariosController extends AppController {

	var $name = 'Usuarios';
	var $uses = array('Usuario'); 

	function index() {

	}
	
	function add(){
		$this->checkRegistro(true);
		if (isset($this->SessionUsuario)){
			$this->redirect('/juegos/add');
		}
		$fb_user = $this->fbGetUserProfile();
		if (!empty($this->data)) {
			//var_dump($this->data);Exit;
			$error = '';
			$this->data['Usuario']['nombre']=$this->data['Usuario']['nombre'];
			$this->data['Usuario']['apellido']=$this->data['Usuario']['apellido'];
			$this->Usuario->set($this->data);
			if ($this->Usuario->validates()){
				if ($usr = $this->Usuario->login($fb_user, $error)) {
					// grabo los datos
					if (!empty($usr['Usuario']['id'])) {
						$this->Usuario->create();
						$this->Usuario->id = $usr['Usuario']['id'];
						if($this->Usuario->save($this->data)){
							$facebook = $this->fbConnect();
							$this->redirect('/juegos/add');
						}else{
							$this->set('errores',$this->Usuario->invalidFields());
							$this->Session->setFlash('No se ha podido inscribir correctamente',true);
						}			
					}
				} else {
					$this->Session->setFlash($error);
					$this->redirect('/usuarios/error');
				}
			} else {
				$this->set('errores',$this->Usuario->invalidFields());
				$this->Session->setFlash('No se ha podido inscribir correctamente',true);
			}
			
		}
		
		$this->set('documentos',array('D.N.I.'=>'D.N.I.','L.E.'=>'L.E.','L.C.'=>'L.C.','C.I.'=>'C.I.'));
		
		$this->set('provincias',array(
		'Buenos Aires'=>'Buenos aires',
		'Catamarca'=>'Catamarca',
		'Chaco'=>'Chaco',
		'Chubut'=>'Chubut',
		'Córdoba'=>'Córdoba',
		'Corrientes'=>'Corrientes',
		'Entre Ríos'=>'Entre Ríos',
		'Formosa'=>'Formosa',
		'Jujuy'=>'Jujuy',
		'La Pampa'=>'La Pampa',
		'La Rioja'=>'La Rioja',
		'Mendoza'=>'Mendoza',
		'Misiones'=>'Misiones',
		'Neuquén'=>'Neuquén',
		'Río Negro'=>'Río Negro',
		'Salta'=>'Salta',
		'San Juan'=>'San Juan',
		'San Luis'=>'San Luis',
		'Santa Cruz'=>'Santa Cruz',
		'Santa Fe'=>'Santa Fe',
		'Santiago del Estero'=>'Santiago del Estero',
		'Tierra del Fuego'=>'Tierra del Fuego',
		'Tucumán'=>'Tucumán'
		));
		
		$this->set('fb_user', $fb_user);
		
		if (empty($this->data['Usuario']['nombre_completo']) && isset($fb_user['name'])) {
			$this->data['Usuario']['nombre_completo'] = $fb_user['name'];
		}
		if (empty($this->data['Usuario']['email']) && isset($fb_user['email'])) {
			$this->data['Usuario']['email'] = $fb_user['email'];
		}
	}
}