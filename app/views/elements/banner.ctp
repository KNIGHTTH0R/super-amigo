<?php 
/*
Puede recibir un parametro $zona
*/
if (isset($zona) && ($zona == 'fangate')) {
	//echo $html->link($html->image('banner-2.jpg'),'http://todoslosdias.supervielle.com.ar/',array('escape'=>false,'target'=>'_blank'));
	echo $html->link($html->image('banner-3-v2.jpg'),'/fotos/gallery/',array('escape'=>false));
	//echo "<br />";
} else {
	echo $html->link($html->image('banner-1.gif'),'http://todoslosdias.supervielle.com.ar/',array('escape'=>false,'target'=>'_blank'));
}
?>