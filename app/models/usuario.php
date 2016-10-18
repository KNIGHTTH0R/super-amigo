<?php
class Usuario extends AppModel
{
    var $name = 'Usuario';
    
	var $validate = array(
   		'nombre' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'required' => true,
				'allowEmpty' => false,
				'message' => 'El Nombre no puede estar vacios.'
			)		
   		),
		'apellido' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'required' => true,
				'allowEmpty' => false,
				'message' => 'El Apellido no puede estar vacios.'
			)		
   		),
		'email' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'required' => true,
				'allowEmpty' => false,
				'message' => 'La direccion de E-mail no puede estar vacia.'
			),
			'email' => array(
				'rule' => array('email',true),
				'required' => true,
				'allowEmpty' => true,
				'message' => 'La direccion de E-mail no es valida.'
			)
		),
		'telefono' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'required' => false,
				'allowEmpty' => false,
				'message' => 'El Teléfono no puede estar vacio.'
			)			
		),
		'dni'=> array(
			'numeric' => array(
				'rule' => 'numeric',
				'required' => true,	
				'allowEmpty' => false,
				'message' => 'El DNI no es válido.'
			),
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'required' => true,
				'allowEmpty' => false,
				'message' => 'El DNI no puede estar vacio.'
			),
		),
		'cliente' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'required' => false,
				'allowEmpty' => false,
				'message' => 'Debe especificar si es cliente o no.'
			)			
		),
		'bases' => array(
			'notEmpty' => array(
				'rule' => array('comparison', '>', 0),
				'required' => true,
				'allowEmpty' => false,
				'message' => 'Debe aceptar las bases y condiciones.'
			)			
		)
	);
	
	var $hasOne = array(
		'Juego' => array(
			'className' => 'Juego',
            'conditions' => '',
            'order' => '',
            'foreignKey' => 'usuario_id'
        )
    );
	
	var $hasMany = array(
		'Juegosamigo' => array(
			'className' => 'Juegosamigo',
            'conditions' => '',
            'order' => '',
            'foreignKey' => 'usuario_id'
        )
    );
	
	// devuelve Usuario o false
	function login($fb_user, &$error, $onlycheck=false) {
		$usr = $this->find('first', array(
			'conditions' => array(
				'Usuario.fbid' => $fb_user['id'],
			),
			'recursive' => -1,
		));
		if (empty($usr)) {
			if ($onlycheck){
				return false;
			}
			// aca lo registro
			if (intval($fb_user['id']) == 0) {
				$error = 'No se puede obtener el usuario de facebook';
				return false;
			}
			
			if (empty($fb_user['email']))
			{
				$fb_user['email']='';
			}
			
			$Datos = array(
				'nombre' => $fb_user['first_name'],
				'apellido' => $fb_user['last_name'],
				'email' => $fb_user['email'],
				'genero' => (isset($fb_user['gender'])?($fb_user['gender'] == 'male' ? 'm' : 'f'):''),
				'fbid' => $fb_user['id'],
				'ip' => $_SERVER['REMOTE_ADDR'],
				'fecha_nacimiento' => (isset($fb_user['birthday'])?$fb_user['birthday']:''),
				'navegador' => $_SERVER['HTTP_USER_AGENT'],
				'extra_data' => json_encode($fb_user),
			);
			if ($this->save($Datos, false)) {
				$Datos['id'] = $this->id;
				return $this->read(null,$this->id);
			} else {
				// TODO que hacemos aca?
				$error = 'No se pudo registrar el usuario';
				return false;
			}
		}
		if ($onlycheck){
			return true;
		}

		return $usr;
	
	}

}