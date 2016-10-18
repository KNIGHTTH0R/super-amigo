<?php

class AppController extends Controller
{
	var $helpers = array('Html', 'Form', 'Time', 'Javascript','Text','Session', 'Conversions');
	var $components = array('RequestHandler','Session');
	var $uses = array('Usuario','FacebookM','Juego');

	var $SessionUsuario;
	
	function beforeFilter(){
		parent::beforeFilter();
		$this->header('P3P: CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');
        // Prevent the 'Undefined index: facebook_config' notice from being thrown.  
        $GLOBALS['facebook_config']['debug'] = NULL;  
        
		// Create a Facebook client API object. 
        @session_start();
		
		if (isset($_REQUEST['signed_request'])) {
			$_SESSION['signed_request'] = $_REQUEST['signed_request'];
		}
		
		$sr = $this->fbgetSignedRequest();
		
		if( isset($_REQUEST['request_ids']) ) {
			$this->saveInvitations($_REQUEST['request_ids']); //Guardo las requests en sesion
		}
		
		/*else{
			if(isset($sr['app_data'])){
				$this->Session->write('invited',$sr['app_data']);
				$this->invited = $sr['app_data'];
			}else{
				$session_invited = $this->Session->read('invited');
				if ($session_invited != null){
					$this->invited = $session_invited;
					$this->Session->write('invited',null);
				}
			}
		}*/
		
		if (!isset($sr["page"]["liked"])) //No esta en TAB
		{
			echo "<script> window.top.location.href='".APP_FB_TAB."'</script>";
			exit();
		}
	}
	
	function deleteRequestFromCode($code){
		$invitations = $this->Session->read('requests');
		foreach ($invitations as $i => $request){
			if ($request['data'] == $code){//si encontre el elemento que corresponde a este juego
				$this->deleteRequest($request['id']);
				unset($invitations[$i]);//Lo borro del array de la sesion
				//$this->Session->write('requests',array_values($invitations)); No queremos que siga contestando por ahora
				$this->Session->write('requests',NULL);
			}
		}
	}
	
	function deleteRequest($request_id){
		$facebook = $this->fbConnect();
		$user_id = $facebook->getUser();
		if ($user_id){
			$full_request_id = $request_id.'_'.$user_id;
			try {
				$delete_success = $facebook->api("/".$full_request_id,'DELETE');
			} catch (FacebookApiException $e) {
			}
			$this->Session->write('requests',NULL);
		}
	}
	
	function fanGate(){
		$data = $this->fbgetSignedRequest();
		if(!empty($data)){
			if (empty($data["page"]["liked"])) { //No le gusta la page
				return false;
		    }
			else //le gusta la page
	    	{
				return true;
			}
		}
	}
	
	function saveInvitations($request_ids){
		$token_url = "https://graph.facebook.com/oauth/access_token?" .
		"client_id=" . APP_FB_APPID .
		"&client_secret=" . APP_FB_APPSECRET .
		"&grant_type=client_credentials";
		$app_token = file_get_contents($token_url);
		$requests = explode(',',$request_ids);
		foreach($requests as $i => $request_id) {
			$retrieve_data = json_decode(file_get_contents("https://graph.facebook.com/".$request_id."?".$app_token), TRUE);
			if ($retrieve_data['juego_id'] = $this->Juego->getIdFromCodigo($retrieve_data['data'])){ //Si existe este juego
				$request_content[$i] = $retrieve_data;
			}else{$this->deleteRequest($retrieve_data['id']);}
		}
		$this->Session->write('requests',array_values($request_content));
	}
	
	function checkRegistro($onlycheck=true) {
		// busca el usuario de la base de datos
		$fb_user = $this->fbGetUserProfile($onlycheck);
		$error = '';
		if ($usr = $this->Usuario->login($fb_user, $error)) {
			if (empty($usr['Usuario']['dni']) || ($usr['Usuario']['dni']==0)) {
				if (!$onlycheck){
					@ob_clean();
					$this->redirect('/usuarios/add');
				}
			} else {
				$this->SessionUsuario = $usr['Usuario'];
			}
		} else {
			if (!$onlycheck){
				$this->setFlash($error);
				@ob_clean();
				$this->redirect('/usuarios/error');}
		}
	}
	
	function checkLogin($onlycheck=false) {
		// busca el usuario de la base de datos
		$fb_user = $this->fbGetUserProfile($onlycheck);
		$error = '';
		if ($usr = $this->Usuario->login($fb_user, $error)) {
			if (empty($usr['Usuario']['fbid']) || ($usr['Usuario']['fbid']==0)) {
				if (!$onlycheck){
					@ob_clean();
					$this->redirect('/usuarios/add');
				}
			} else {
				$this->SessionUsuario = $usr['Usuario'];
			}
		} else {
			if (!$onlycheck){
				$this->setFlash($error);
				@ob_clean();
				$this->redirect('/usuarios/error');}
		}
	}

	
	function _loginSession($usr) {
		$this->SessionUsuario = $usr;
	}
	
	function _logoutSession() {
        $this->SessionUsuario = null;
	}

	function getUsuario() {
		return $this->SessionUsuario;
	}
	
	function fbGetUserProfile($onlycheck=false) {
		$facebook = $this->fbConnect();
		$user = $facebook->getUser();
		if ($user) {
			try {
				$user_profile = $facebook->api('/me');
				$token = $facebook->getAccessToken();
				$this->Session->write('atoken',$token);
			} catch(Exception $e) {
				$this->Session->write('atoken',null);
				$params = array('scope'=>'email,publish_stream');
				$loginUrl = $facebook->getLoginUrl($params);
				echo "<script type='text/javascript'>top.location.href = '$loginUrl';</script>";
				exit;
			}
			return $user_profile;
		} else {
			if (!$onlycheck){
				if (APP_DEBUGMODE) {
					$this->Session->setFlash('No se puede obtener el token de facebook');
					@ob_clean();
					$this->redirect('/usuarios/error');
				} else {
					$params = array('scope'=>'email,publish_stream');
					$loginUrl = $facebook->getLoginUrl($params);
					echo "<script type='text/javascript'>top.location.href = '$loginUrl';</script>";
					exit; 
				}
			}
			else{return false;}
		}
	}
	
	function fbGetVisitorProfile() {
		$facebook = $this->fbConnect();
		$user = $facebook->getUser();
		
		if ($user) {
			try {
				$user_profile = $facebook->api('/me');
			} catch(Exception $e) {
				return false;
			}
			return $user_profile;
		} else {
			return false;
		}
	}

	function fbgetSignedRequest(){
		$facebook = $this->fbConnect();
		$signed_request = $facebook->getSignedRequest();
		return $signed_request;
	}
	
	function fbgetApplicationAccessToken(){
		$facebook = $this->fbConnect();
		$atoken = $facebook->getApplicationAccessToken();
		return $atoken;
	}

	function fbConnect() {
		// traeme el idfacebook
		include('base_facebook.php');
		include('facebook.php');
		
		$config = array();
		$config['appId'] = APP_FB_APPID;
		$config['secret'] = APP_FB_APPSECRET;
		$config['cookie'] = true;
		$config['fileUpload'] = true;

		$facebook = new Facebook($config);
		
		if (!isset($_REQUEST['signed_request'])) {
			if (isset($_SESSION['signed_request'])) {
				$_REQUEST['signed_request'] = $_SESSION['signed_request'];
			}
		}
		
		$token = $this->Session->read('atoken');
		if ($token!=NULL)
		{
			$facebook->setAccessToken($token);
		}

		if (APP_DEBUGMODE) {
			$facebook->setAccessToken(APP_FB_DEBUGTOKEN);
		}
		
		return $facebook;
	}

	function _getPagina() {
		if( isset($this->params['named']['page']) ) {
			$pagina = intval($this->params['named']['page']);
			$this->Session->write($this->name.'.page', $pagina);
		} else {
			if( $this->Session->check($this->name.'.page') ) {
				$pagina = $this->Session->read($this->name.'.page');
			} else {
				$pagina = 1;
			}
		}
		return $pagina;
		
	}
		
	function _getFormat() {
		$this->config_format	= isset ($this->form['format']) ? $this->form['format'] : 
								(isset($this->params['named']['format']) ? $this->params['named']['format'] : '');
	}
	
	function renderFormat() {
		if ($this->config_format == 'json') {
			$this->layout = null;
			$this->render('/elements/json');
		}
	}
	
	function getRealIP() {
        if (isset($_SERVER['HTTP_CLIENT_IP']) && !empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        }
		
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
       
        return $_SERVER['REMOTE_ADDR'];
    }
}
