<?php
	// Translated langages
	define('I18N_LANG_EN', 0);
	define('I18N_LANG_FR', 1);
	//define('I18N_LANG_ES', 2);
	//define('I18N_LANG_DE', 3);
	//define('I18N_LANG_IT', 4);
	
	define('I18N_TEXT_APPNAME', 0);
	define('I18N_TEXT_BTN_MORE', 1);
	define('I18N_TEXT_BTN_REUSE', 2);
	define('I18N_TEXT_BTN_VIEW', 3);
	define('I18N_TEXT_BTN_SENDTO', 21);
	define('I18N_TEXT_LOADING', 4);
	define('I18N_TEXT_NO_MORE', 5);
	define('I18N_TEXT_STATUSES', 6);
	define('I18N_TEXT_COPYRIGHT', 7);
	define('I18N_TEXT_DATETIME_FORMAT', 8);
	define('I18N_TEXT_DATE_DAYS', 9);
	define('I18N_TEXT_DATE_MONTHS', 10);
	define('I18N_TEXT_DATE_TODAY', 11);
	define('I18N_TEXT_DATE_YESTERDAY', 12);
	define('I18N_TEXT_ERROR_TITLE', 13);
	define('I18N_TEXT_ERROR_DESC', 14);
	define('I18N_TEXT_ERROR_CLOSE', 15);
	define('I18N_TEXT_REQUEST_REUSE_TITLE', 22);
	define('I18N_TEXT_REQUEST_REUSE_BODY', 23);
	define('I18N_TEXT_REQUEST_REUSE_FILTER_ALL', 24);
	define('I18N_TEXT_REQUEST_REUSE_FILTER_LIKED', 25);
	define('I18N_TEXT_REQUEST_REUSE_FILTER_COMMENTED', 26);
	
	$i18nLocales = array(
		'fr_FR' => I18N_LANG_FR,
		'fr_CA' => I18N_LANG_FR,
		/*'es_ES' => I18N_LANG_ES,
		'es_LA' => I18N_LANG_ES,
		'eu_ES' => I18N_LANG_ES,
		'ca_ES' => I18N_LANG_ES,
		'de_DE' => I18N_LANG_DE,
		'it_IT' => I18N_LANG_IT*/
	);
	
	$i18nTexts = array(
		I18N_LANG_EN => array(),
		I18N_LANG_FR => array(),
		/*I18N_LANG_ES => array(),
		I18N_LANG_DE => array(),
		I18N_LANG_IT => array()*/
	);
	
	$i18nCurrent = 'en_US';
