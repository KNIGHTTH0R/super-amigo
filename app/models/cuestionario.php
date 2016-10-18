<?php
class Cuestionario extends AppModel
{
    var $name = 'Cuestionario';
 
	var $hasMany = array(
		'Pregunta' => array(
			'className' => 'Pregunta',
            'conditions' => '',
            'order' => '',
            'foreignKey' => 'cuestionario_id'
        )
    );

	function getCuestionario($id = 1){
		$this->Behaviors->attach('Containable');
		$contain = array('Pregunta'=>array('Opcion'));
		$data = $this->find('first',array('contain'=>$contain,'conditions'=>array('Cuestionario.id'=>$id)));
		return $data;
	}
}