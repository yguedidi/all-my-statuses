<?php
	/**
	 * Nom de l'application
	 * @var string
	 */
	define('APP_NAME', 'All My Statuses');

	/**
	 * Version de l'application
	 * @var string
	 */
	define('APP_VERSION', '');

	/**
	 * Host distant de l'application
	 * @var string
	 */
	define('APP_WEB_HOST', getenv('AMS_APP_WEB_HOST'));

	/**
	 * URL distante de l'application
	 * @var string
	 */
	define('APP_WEB_URL', 'https://'.APP_WEB_HOST.'/');

	/**
	 * Host local de l'application
	 * @var string
	 */
    define('APP_LOCAL_HOST', getenv('AMS_APP_LOCAL_HOST'));

	/**
	 * URL locale de l'application
	 * @var string
	 */
	define('APP_LOCAL_URL', 'http://'.APP_LOCAL_HOST.'/');
