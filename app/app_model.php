<?php
class AppModel extends Model
{

	function borrar( $id ) {
		if( intval($id) ) {
// NOTE hay un problema con este execute en cakephp 1.2.0.7296
//        	$this->execute('UPDATE ' . $this->useTable . ' SET deleted = NOW() WHERE id = ' . intval($id) );
        	$this->query('UPDATE ' . $this->useTable . ' SET deleted = NOW() WHERE id = ' . intval($id) );
        	return ( $this->getAffectedRows() > 0 );
		} else {
			return false;
		}
	}
	
	function recuperar( $id ) {
		if( intval($id) ) {
// NOTE hay un problema con este execute en cakephp 1.2.0.7296
//        	$this->execute('UPDATE ' . $this->useTable . ' SET deleted = null WHERE id = ' . intval($id) );
        	$this->query('UPDATE ' . $this->useTable . ' SET deleted = null WHERE id = ' . intval($id) );
        	return ( $this->getAffectedRows() > 0 );
		} else {
			return false;
		}
	}
	
	// @param boolean	valor		si false, lo bannea
	function bannear( $id, $valor ) {
		$valor = $valor ? 'NULL' : 'NOW()';
		if( intval($id) ) {
// NOTE hay un problema con este execute en cakephp 1.2.0.7296
//        	$this->execute('UPDATE ' . $this->useTable . ' SET banned = ' . $valor . ' WHERE id = ' . intval($id) );
        	$this->query('UPDATE ' . $this->useTable . ' SET banned = ' . $valor . ' WHERE id = ' . intval($id) );
        	return ( $this->getAffectedRows() > 0 );
		} else {
			return false;
		}
	}

	
	
	function _getDate($objeto, $campo)
	{
		$dia  = isset($objeto[$campo.'_day']) ? intval ($objeto[$campo.'_day']) : 0; 
		$mes  = isset($objeto[$campo.'_month']) ? intval ($objeto[$campo.'_month']) : 0; 
		$anio = isset($objeto[$campo.'_year']) ? intval ($objeto[$campo.'_year']) : 0;
		if( $dia != 0 && $mes != 0 && $anio != 0 ) {
		    return date('Y-m-d', mktime(null,null,null,$mes,$dia,$anio));
		} else {
			return null;
		}
	}	
	
	
	/*
	 * agrega en $object[modeloExtra] los campos con la fecha desarmada
	 * 
	 */
	function _setDate(&$object,$modelo,$campo)
	{
		if( isset($object[$modelo][$campo]) ) {
			$fecha = strtotime($object[$modelo][$campo]);
			$object[$modelo.'Extra'][$campo.'_month'] = date('n',$fecha);
			$object[$modelo.'Extra'][$campo.'_year'] = date('Y',$fecha);
			$object[$modelo.'Extra'][$campo.'_day'] = date('j',$fecha);
		}
	}	


	
}
