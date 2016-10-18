<?php
class Opcion extends AppModel
{
    var $name = 'Opcion';
	var $useTable = 'opciones';
	
	var $belongsTo = array(
    	'Pregunta' => array(
			'className'    => 'Pregunta',
    		'foreignKey'   => 'pregunta_id',
			'counterCache' => true,
		)
    );
	
	function getOpcionesPorPregunta($pregunta_id){
		$data = $this->find('all',array('contain'=>array(),'conditions'=>array('Opcion.pregunta_id'=>$pregunta_id)));
		return $data;
	}
}