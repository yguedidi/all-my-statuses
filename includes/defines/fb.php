<?php
	/**
	 * ID de l'application
	 * @var string
	 */
	define('FB_ID', getenv('AMS_FB_ID'));

	/**
	 * Clé d'API de l'application
	 * @var string
	 */
	define('FB_APIKEY', getenv('AMS_FB_APIKEY'));

	/**
	 * Clé secrète de l'application
	 * @var string
	 */
	define('FB_SECRET', getenv('AMS_FB_SECRET'));

	/**
	 * URL de canvas Facebook de l'application
	 * @var string
	 */
	define('FB_CANVAS', getenv('AMS_FB_CANVAS'));

	/**
	 * URL de callback Facebook de l'application
	 * @var string
	 */
	define('FB_CALLBACK', APP_URL /* .'callback/' */);

	/**
	 * URL de la page Facebook de l'application
	 * @var string
	 */
	define('FB_PAGE', 'http://www.facebook.com/All.My.Statuses');

	/**
	 * Permissions Facebook requises par l'application
	 * @var string
	 * @example publish_stream,read_stream
	 */
	define('FB_PERMS', ['user_posts']);

	/**
	 * Mon ID Facebook
	 * @var string
	 */
	define('FB_MY_UID', getenv('AMS_FB_MY_UID'));

	/**
	 * ID de l'utilisateur
	 * @var string
	 */
	$FbUserID = 0;
