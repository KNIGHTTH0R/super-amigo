<?php
/*
 * muy similar funcionalmente al componente Conversions
 * permite pasar cosas de un formato a otro
 * 
 */


class ConversionsHelper extends Helper {

	/*
	 * @param	string	$date		una fecha expresada en el formato $format
	 * @param	string	$format		{ 'dd/mm/yyyy' }
	 * 
	 * @return	string				la fecha expresada en el formato mysql (yyyy-mm-dd)
	 */
	function formated2mysql( $date, $format = 'dd/mm/yyyy') {
		$ret = $date;
		switch( $format ) {
		
			case 'dd/mm/yyyy':
			
				if( $Date = explode('/',$date) ) {
					if( ($Date[0] != 0) && ($Date[1] != 0) && ($Date[2] != 0) ) {
			    		$ret = date('Y-m-d', mktime(null,null,null,$Date[1],$Date[0],$Date[2],0));
					}
				}
				break;

		}
		return $this->output( $ret );
	}
	
	/*
	 * @param	string	$date		una fecha expresada en el formato mysql
	 * @param	string	$format		{ 'dd/mm/yyyy', 'dd/mm/yyyy hh:mm', 'styled dd/mm/yyyy' }
	 * 								'styled' devuelve un <span class="futuro">dd/mm/yyyy</span> si la fecha no paso aun
	 * 
	 * @return	string				la fecha expresada en el formato $format
	 */
	function mysql2formated( $date, $format = 'dd/mm/yyyy' ) {
		$ret = $date;
		switch( $format ) {
		
			case 'dd/mm/yyyy':
			
				if( $DateTime = explode(' ',$date) ) {
					if( $Date = explode('-',$DateTime[0]) ) {
						if( ($Date[0] != 0) && ($Date[1] != 0) && ($Date[2] != 0) ) {
				    		$ret = date('d/m/Y', mktime(null,null,null,$Date[1],$Date[2],$Date[0],0));
						}
					}
				}
				break;
				
				
			case 'styled':
			
				if( $DateTime = explode(' ',$date) ) {
					if( $Date = explode('-',$DateTime[0]) ) {
						if( ($Date[0] != 0) && ($Date[1] != 0) && ($Date[2] != 0) ) {
							$f = mktime(null,null,null,$Date[1],$Date[2],$Date[0],0);
				    		$ret = date('d/m/Y', $f);
				    		if( $f > time() ) {
				    			$ret = '<span class="futuro">' . $ret . '</span>';
				    		}
						}
					}
				}
				break;
				
		
			case 'dd/mm/yyyy hh:mm':
			
				if( !empty($date) ) {
					if( $DateTime = explode(' ',$date) ) {
						if( $Date = explode('-',$DateTime[0]) ) {
							if( ($Date[0] != 0) && ($Date[1] != 0) && ($Date[2] != 0) ) {
					    		$ret = date('d/m/Y', mktime(null,null,null,$Date[1],$Date[2],$Date[0],0));
							}
						}
						if( $Time = explode(':',$DateTime[1]) ) {
							$ret .= " {$Time[0]}:{$Time[1]}";
						}
					}
				}
				break;
		}
		return $this->output( $ret );
	}

	
	/*
	 * @param	associative array	$arr	las claves son los unix timestamp
	 * 										las transforma en YYYYMMDD , respeta el value de cada una
	 * @return 	associative array 							
	 */
	function arr_timestamp2day( $arr ) {
		$ret = array();
		foreach( $arr as $key => $val ) {
			$day = getdate($key); 
			$ret[ $day['year'].str_pad($day['mon'],2,'0',STR_PAD_LEFT).str_pad($day['mday'],2,'0',STR_PAD_LEFT) ] = $val;
		}
		return $ret;
	}
	
}
?>