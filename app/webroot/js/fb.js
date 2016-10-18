function shareJuego(codigo) {
  ret = FB.ui({method: 'apprequests',
	title: "El juego de la amistad.",
    message: "Te invito a responder mis preguntas! Entra.",
	/*redirect_uri: "https://www.facebook.com/BancoSupervielle/200175803349193?id=200175803349193&sk=app_492186900851916",*/
	data: codigo,
	max_recipients: 10
  });
}

function postResultToFeed(result) {
	var name = '';
	var caption = '';
	var description = '';
	var picture = '';
	
	name = 'Amigo 2.0 - Banco Supervielle';
	caption = 'Divertite con tus amigos junto a Banco Supervielle. Desafialos y ganate una Tablet.';
	description = 'Acabo de descubrir cuánto sé de mis amigos gracias al juego "Amigo 2.0" de Banco Supervielle. ¿Vos también querés enterarte cuánto saben ellos de vos? Cliqueá acá LINK.';
	picture = 'thumbnail_share.png';
			
	// calling the API ...
	var obj = {
		method: 'feed',
		link: 'https://www.facebook.com/BancoSupervielle/200175803349193?id=200175803349193&sk=app_492186900851916',
		picture: 'https://apps-lanzallamas.com.ar/supervielle-amigos/img/'+picture,
		name: name,
		caption: caption,
		description: description
	};

	function callback(response) {
		document.getElementById('msg').innerHTML = "Post ID: " + response['post_id'];
	}
	FB.ui(obj, callback);
	
}