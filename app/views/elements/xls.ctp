<?php
/* 
si es un array no deberia haber ningun ; entre los datos ya que lo vamos a usar de separador
por ahora es tarea del controller hacer eso
*/

header("Expires: 0");
header("Cache-control: private");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Description: File Transfer");
//header("Content-Type: application/vnd.ms-excel");
header("Content-Type: text/csv;");
header("Content-disposition: attachment; filename=data_exported.csv");

echo implode(';', $rowheaders) . "\n";
foreach ($rows as $r) {
	if (is_array($r)) {
		echo implode(';', $r) . "\n";
	} else if (is_string($r)) {
		echo $r . "\n";
	}
}
