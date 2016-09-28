<?php
	require_once 'defines/server.php';
	require_once 'functions/server.php';
	
	/**
	 * Host de l'application
	 * @var string
	 */
	define('APP_HOST', isLocal() ? APP_LOCAL_HOST : APP_WEB_HOST);
	
	/**
	 * URL de l'application
	 * @var string
	 */
	define('APP_URL', isLocal() ? APP_LOCAL_URL : APP_WEB_URL);
