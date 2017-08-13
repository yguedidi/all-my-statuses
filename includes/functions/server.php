<?php
	/**
	 * Est-ce qu'on est sur le serveur local ?
	 * @return bool
	 */
	function isLocal() {
		return getenv('AMS_ENV') !== 'prod';
	}
	
	/**
	 * Est-ce qu'on est en Prod ?
	 * @return bool
	 */
	function isProd() {
		return !isLocal();
	}

	/**
	 * Est-ce qu'on est sur le canvas Facebook ?
	 * @return bool
	 */
	function isCanvas() {
		return isset($_POST['signed_request']) && !empty($_POST['signed_request']);
	}
