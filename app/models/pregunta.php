<?php
class Pregunta extends AppModel
{
    var $name = 'Pregunta';
    
	var $belongsTo = array(
    	'Cuestionario' => array(
			'className'    => 'Cuestionario',
    		'foreignKey'   => 'cuestionario_id',
			'counterCache' => true,
		)
    );
	
	var $hasMany = array(
		'Opcion' => array(
			'className' => 'Opcion',
            'conditions' => '',
            'order' => '',
            'foreignKey' => 'pregunta_id'
        ),
    );
}