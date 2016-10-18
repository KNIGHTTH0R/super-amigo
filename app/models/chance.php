<?php
class Chance extends AppModel
{
    var $name = 'Chance';
	
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
		),
		'Juegosamigo' => array(
			'className'    => 'Juegosamigo',
    		'foreignKey'   => 'juegosamigo_id',
			'counterCache' => true,
		),
		'Usuario_Amigo' => array(
			'className'    => 'Usuario',
    		'foreignKey'   => 'amigo_usuario_id',
			'counterCache' => true,
		)
    );
	
	function getChancesPorUsuario($user_id){
		return $this->find('count',array('conditions'=>array('Chance.usuario_id'=>$user_id)));
	}
	
	function BeforeSave(){
		if ($this->getChancesPorUsuario($this->data['Chance']['usuario_id']) < 20)
		{
			return true;
		}
	}
	
	function AfterSave(){
		App::import('Model','Usuario');
		$umodel = new Usuario();
		$chances = $this->getChancesPorUsuario($this->data['Chance']['usuario_id']);
		$umodel->id = $this->data['Chance']['usuario_id'];
		$umodel->saveField('chances',$chances);
	}
}