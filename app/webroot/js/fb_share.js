  window.fbAsyncInit = function() {
    FB.init({
	  appId      : '238536332916535',
      status     : true, // check login status
      cookie     : true, // enable cookies to allow the server to access the session
      xfbml      : true  // parse XFBML
    });
  };

  // Load the SDK Asynchronously
  (function(d){
     var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement('script'); js.id = id; js.async = true;
     js.src = "//connect.facebook.net/en_US/all.js";
     ref.parentNode.insertBefore(js, ref);
   }(document));

var ret;
function sendRequestViaMultiFriendSelector() {
  ret = FB.ui({method: 'apprequests',
	filters: ['app_non_users'],
	redirect_uri: 'https://k-dreams.com/fb_apps/compumundo_olimpiadas/invitaciones/add',
    message: 'Trivia Compumundo',
	max_recipients: 5
  }, requestCallback);
}

function requestCallback(response) {
	/*
	console.log('callbakc');
	console.log(response);
	console.log(ret);
	*/
}
function sendRequestToRecipients(to) {
	FB.ui({method: 'apprequests',
		redirect_uri: 'https://k-dreams.com/fb_apps/compumundo_olimpiadas/invitaciones/add',
		message: 'Trivia Compumundo',
		to: to
    }, requestCallback);
}
