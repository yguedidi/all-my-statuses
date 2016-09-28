<?php
	/**
	 * Est-ce qu'on est en Préprod ?
	 * @return bool
	 */
	function isPreprod() {
		return $_SERVER['HTTP_HOST'] === APP_WEB_HOST
				&& substr($_SERVER['HTTP_USER_AGENT'], -7) === 'Preprod';
	}
	
	/**
	 * Est-ce que JE suis en Prod ?
	 * @return bool
	 */
	function isMyProd() {
		return $_SERVER['HTTP_HOST'] === APP_WEB_HOST
				&& substr($_SERVER['HTTP_USER_AGENT'], -4) === 'Prod';
	}
	
	/**
	 * Est-ce qu'on est sur le serveur local ?
	 * @return bool
	 */
	function isLocal() {
		return $_SERVER['HTTP_HOST'] === APP_LOCAL_HOST
				&& substr($_SERVER['HTTP_USER_AGENT'], -11) === 'Development';
	}
	
	/**
	 * Est-ce qu'on est en Prod ?
	 * @return bool
	 */
	function isProd() {
		return !isPreprod() && !isLocal() && !isMyProd();
	}
	
	function isAlwaysData() {
		return !isLocal() && strpos($_SERVER['DOCUMENT_ROOT'], '/home/yguedidi/') === 0;
	}
	
	function isPlanetHoster() {
		return !isLocal() && strpos($_SERVER['DOCUMENT_ROOT'], '/home/matikpro/') === 0;
	}
	
	/**
	 * Est-ce qu'on est sur le canvas Facebook ?
	 * @return bool
	 */
	function isCanvas() {
		return isset($_POST['signed_request']) && !empty($_POST['signed_request']);
	}
	
	/**
	 * Est-ce qu'on est sur le site web (non-Facebook) ?
	 * @return bool
	 */
	function isWebSite() {
		return !isCanvas();
	}
