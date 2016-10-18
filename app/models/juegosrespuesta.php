<?php
class Juegosrespuesta extends AppModel
{
    var $name = 'Juegosrespuesta';
	var $useTable = 'juegos_respuestas';
    
	var $belongsTo = array(
    	'Juego' => array(
			'className'    => 'Juego',
    		'foreignKey'   => 'juego_id',
			'counterCache' => true,
		),
		'Pregunta' => array(
			'className'    => 'Pregunta',
    		'foreignKey'   => 'pregunta_id',
			'counterCache' => true,
		),
		'Opcion' => array(
			'className'    => 'Opcion',
    		'foreignKey'   => 'opcion_id',
			'counterCache' => true,
		)
    );
}