<?php
class FacebookM extends AppModel
{
	var $useTable = false;
	
	function creoJuego($facebook){
		$params = array(
			'name' => "Amigo 2.0 - Banco Supervielle",
			'description'=>'Divertite con tus amigos junto a Banco Supervielle. Desafialos  y ganate una Tablet. ',
			'message' => '¿Vos sabés qué tan amigos son tus amigos? Yo los estoy desafiando a ver cuánto saben de mi con el juego "Amigo 2.0" de Banco Supervielle.  Cliqueá acá LINK y ganate una Tablet. #amigos #entretenimiento #innovación',
			'link' => APP_FB_TAB,
		);
		$facebook->api('/me/feed', 'post', $params);
	}
	
	function SendNotification($resultado){
		$user_id = $resultado['Juego']['Usuario']['fbid'];
		$url = "https://graph.facebook.com/".$user_id."/notifications";
		$notification_message = /*'@['.$resultado['Usuario']['fbid'].':1:'.$resultado['Usuario']['nombre'].' '.$resultado['Usuario']['apellido'].']*/ 
								$resultado['Usuario']['nombre'].' '.$resultado['Usuario']['apellido'].' respondio tus preguntas, 
								saco '.$resultado['Juegosamigo']['puntaje'].' %, ahora tenes '.$resultado['Juego']['Usuario']['chances'].' chances';
		$app_access_token = APP_FB_APPID . '|' . APP_FB_APPSECRET;
		$attachment = array(
			'access_token' => $app_access_token, // access_token is a combination of the AppID & AppSecret combined
			'href' => '', // Link within your Facebook App to be displayed when a user click on the notification
			'template' => $notification_message, // Message to be displayed within the notification
		);
		// set the target url
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $attachment);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  //to suppress the curl output
		$result = curl_exec($ch);
		curl_close ($ch); 
	}
}