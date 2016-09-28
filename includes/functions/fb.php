<?php
	class CFacebook extends Facebook {
		private $FirePHP, $_restCalls, $_graphCalls, $useSession;
		
		public function CFacebook() {
			$this->FirePHP = FirePHP::getInstance(true);
			
			if(isLocal()) {
				parent::$CURL_OPTS[CURLOPT_SSL_VERIFYPEER] = false;
				parent::$CURL_OPTS[CURLOPT_SSL_VERIFYHOST] = 2;
			}
			
			parent::__construct(array(
									'appId'  => FB_APIKEY,
									'secret' => FB_SECRET,
									'cookie' => true,
								));
			
			if(!isset($_SESSION['_restCalls'])) {
				$_SESSION['_restCalls'] = array();
			}
			$this->_restCalls = & $_SESSION['_restCalls'];
			
			if(!isset($_SESSION['_graphCalls'])) {
				$_SESSION['_graphCalls'] = array();
			}
			$this->_graphCalls = & $_SESSION['_graphCalls'];
			
			$this->useSession = true;
		}
		
		public function getLoginUrl($params=array()) {
			return parent::getLoginUrl(
						array(
							'display' => 'page',
							'redirect_uri' => FB_CANVAS.'?'.$_SERVER['QUERY_STRING'],
							'scope' => FB_PERMS));
		}
		
		public function api(/* polymorphic */) {
			try {
				return call_user_func_array('parent::api', func_get_args());
			} catch(FacebookApiException $e) {
				if($e->getType() === 'OAuthException') {
					echo '<script type="text/javascript">top.location.href = "'.$this->getLoginUrl().'";</script>';
					exit();
				} else {
					throw $e;
				}
			}
		}
		
		public function apiNoSession(/* polymorphic */) {
			$this->useSession = false;
			return call_user_func_array(array($this, 'api'), func_get_args());
		}
		
		protected function _restserver($params) {
			if($this->useSession) {
				$call = md5(http_build_query($params));
				if(!isset($this->_restCalls[$call])) {
					$this->FirePHP->log($params, 'Appel au REST API');
					$this->_restCalls[$call] = parent::_restserver($params);
				}
				return $this->_restCalls[$call];
			} else {
				$this->useSession = true;
				$this->FirePHP->log($params, 'Appel sans session au REST API');
				return parent::_restserver($params);
			}
		}
		
		protected function _graph($path, $method='GET', $params=array()) {
			if($this->useSession) {
				$call = md5($method.'|'.$path.'|'.http_build_query($params));
				if(!isset($this->_graphCalls[$call])) {
					$this->FirePHP->log(array('Path' => $path, 'Params' => $params), 'Appel au Graph API');
					$this->_graphCalls[$call] = parent::_graph($path, $method, $params);
				}
				return $this->_graphCalls[$call];
			} else {
				$this->useSession = true;
				$this->FirePHP->log(array('Path' => $path, 'Params' => $params), 'Appel sans session au Graph API');
				return parent::_graph($path, $method, $params);
			}
		}
		
		public function getUser() {
			$u = parent::getUser();
			
			if(!$u) {
				echo '<script type="text/javascript">top.location.href = "'.$this->getLoginUrl().'";</script>';
				exit();
			}
			
			// Récupère les permissions
			/*$perms = $this->apiNoSession('/me/permissions?fields='.FB_PERMS);
			
			// Si une des permissions n'est pas accordée par l'utilisateur
			if(count(explode(',', FB_PERMS)) != count($perms['data'][0]) && isCanvas()) {
				// On le redirige vers la page d'authentification
				echo '<script type="text/javascript">top.location.href = "'.$this->getLoginUrl().'";</script>';
				exit();
			}*/
			
			return $u;
		}
		
		public function getUserLocale() {
			if ($user = $this->getPersistentData('user')) {
				return $user['locale'];
			}
			return 'en_US';
		}
		
		public function getUserMinAge() {
			if ($user = $this->getPersistentData('user')) {
				return $user['age']['min'];
			}
			return 0;
		}
	}
