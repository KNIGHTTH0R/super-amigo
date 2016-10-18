<?php
class Juegosamigorespuesta extends AppModel
{
    var $name = 'Juegosamigorespuesta';
	var $useTable = 'juegosamigos_respuestas';
    
	var $belongsTo = array(
    	'Juegosamigo' => array(
			'className'    => 'Juegosamigo',
    		'foreignKey'   => 'juegosamigo_id',
			'counterCache' => true,
		),
		'Juegosrespuesta' => array(
			'className'    => 'Juegosrespuesta',
    		'foreignKey'   => 'juegos_respuesta_id',
			'counterCache' => true,
		),
		'Opcion' => array(
			'className'    => 'Opcion',
    		'foreignKey'   => 'opcion_id',
			'counterCache' => true,
		)
    );
}