<?php
	require_once 'defines/i18n.php';
	require_once 'functions/i18n.php';

	// English (Default)
	$i18nTexts[I18N_LANG_EN][I18N_TEXT_APPNAME] = '<fb:intl desc="App title">'.APP_NAME.'</fb:intl>';
	$i18nTexts[I18N_LANG_EN][I18N_TEXT_BTN_MORE] = '<fb:intl desc="More statuses button label">More</fb:intl>';
	$i18nTexts[I18N_LANG_EN][I18N_TEXT_BTN_REUSE] = '<fb:intl desc="Reuse status button label">Reuse</fb:intl>';
	$i18nTexts[I18N_LANG_EN][I18N_TEXT_BTN_VIEW] = '<fb:intl desc="View status button label">View</fb:intl>';
	$i18nTexts[I18N_LANG_EN][I18N_TEXT_BTN_SENDTO] = '<fb:intl desc="Send to button label">Send</fb:intl>';
	$i18nTexts[I18N_LANG_EN][I18N_TEXT_LOADING] = '<fb:intl desc="Loading text">Loading</fb:intl>';
	$i18nTexts[I18N_LANG_EN][I18N_TEXT_NO_MORE] = '<fb:intl desc="No more statuses text">No more statuses</fb:intl>';
	$i18nTexts[I18N_LANG_EN][I18N_TEXT_STATUSES] = '<fb:intl desc="XX statuses">statuses</fb:intl>';
	$i18nTexts[I18N_LANG_EN][I18N_TEXT_COPYRIGHT] = '<fb:intl desc="Copyright text">Copyright &copy; 2011-2012 <a href="http://www.facebook.com/profile.php?id=1058447831" target="_blank">Yassine \'Matik\' Guedidi</a>. All rights reserved.</fb:intl>';
	$i18nTexts[I18N_LANG_EN][I18N_TEXT_DATETIME_FORMAT] = '{#date#} at {#time#}';
	$i18nTexts[I18N_LANG_EN][I18N_TEXT_DATE_DAYS] = array('Monday', 'Tuesday', 'Wednesday', 'Thurday', 'Friday', 'Saturday', 'Sunday');
	$i18nTexts[I18N_LANG_EN][I18N_TEXT_DATE_MONTHS] = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
	$i18nTexts[I18N_LANG_EN][I18N_TEXT_DATE_TODAY] = 'Today';
	$i18nTexts[I18N_LANG_EN][I18N_TEXT_DATE_YESTERDAY] = 'Yesterday';
	$i18nTexts[I18N_LANG_EN][I18N_TEXT_ERROR_TITLE] = '<fb:intl desc="Error label">Error</fb:intl>';
	$i18nTexts[I18N_LANG_EN][I18N_TEXT_ERROR_DESC] = '<fb:intl desc="Error description">You reached your publish limit! Try later.</fb:intl>';
	$i18nTexts[I18N_LANG_EN][I18N_TEXT_ERROR_CLOSE] = '<fb:intl desc="Error close button label">Close</fb:intl>';
	$i18nTexts[I18N_LANG_EN][I18N_TEXT_INVITE_TITLE] = '<fb:intl desc="Invite bold text">Do you think this app can be useful for your friends ?</fb:intl>';
	$i18nTexts[I18N_LANG_EN][I18N_TEXT_INVITE_DESC] = '<fb:intl desc="Invite link desc">Invite them</fb:intl>';
	$i18nTexts[I18N_LANG_EN][I18N_TEXT_INVITE_CLOSE] = '<fb:intl desc="Invite close button label">Close</fb:intl>';
	$i18nTexts[I18N_LANG_EN][I18N_TEXT_REQUEST_INVITE_TITLE] = 'Invite your friends to use '.APP_NAME;
	$i18nTexts[I18N_LANG_EN][I18N_TEXT_REQUEST_INVITE_BODY] = 'Come remember your statuses!';
	$i18nTexts[I18N_LANG_EN][I18N_TEXT_REQUEST_REUSE_TITLE] = 'Notify your friends who liked and/or commented?';
	$i18nTexts[I18N_LANG_EN][I18N_TEXT_REQUEST_REUSE_BODY] = 'I reused a status that you liked and/or commented!';
	$i18nTexts[I18N_LANG_EN][I18N_TEXT_REQUEST_REUSE_FILTER_ALL] = 'All';
	$i18nTexts[I18N_LANG_EN][I18N_TEXT_REQUEST_REUSE_FILTER_LIKED] = 'Who liked';
	$i18nTexts[I18N_LANG_EN][I18N_TEXT_REQUEST_REUSE_FILTER_COMMENTED] = 'Who commented';
	
	// French
	$i18nTexts[I18N_LANG_FR][I18N_TEXT_APPNAME] = 'Tous Mes Statuts';
	$i18nTexts[I18N_LANG_FR][I18N_TEXT_BTN_MORE] = 'Plus';
	$i18nTexts[I18N_LANG_FR][I18N_TEXT_BTN_REUSE] = 'Réutiliser';
	$i18nTexts[I18N_LANG_FR][I18N_TEXT_BTN_VIEW] = 'Voir';
	$i18nTexts[I18N_LANG_FR][I18N_TEXT_BTN_SENDTO] = 'Envoyer';
	$i18nTexts[I18N_LANG_FR][I18N_TEXT_LOADING] = 'Chargement';
	$i18nTexts[I18N_LANG_FR][I18N_TEXT_NO_MORE] = 'Il n\'y a plus de statuts';
	$i18nTexts[I18N_LANG_FR][I18N_TEXT_STATUSES] = 'statuts';
	$i18nTexts[I18N_LANG_FR][I18N_TEXT_COPYRIGHT] = 'Copyright &copy; 2011-2012 <a href="http://www.facebook.com/profile.php?id=1058447831" target="_blank">Yassine \'Matik\' Guedidi</a>. Tous droits réservés.';
	$i18nTexts[I18N_LANG_FR][I18N_TEXT_DATETIME_FORMAT] = '{#date#} à {#time#}';
	$i18nTexts[I18N_LANG_FR][I18N_TEXT_DATE_DAYS] = array('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche');
	$i18nTexts[I18N_LANG_FR][I18N_TEXT_DATE_MONTHS] = array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Décembre');
	$i18nTexts[I18N_LANG_FR][I18N_TEXT_DATE_TODAY] = 'Aujourd\'hui';
	$i18nTexts[I18N_LANG_FR][I18N_TEXT_DATE_YESTERDAY] = 'Hier';
	$i18nTexts[I18N_LANG_FR][I18N_TEXT_ERROR_TITLE] = 'Erreur';
	$i18nTexts[I18N_LANG_FR][I18N_TEXT_ERROR_DESC] = 'Vous avez atteint votre limite de publication ! Essayer plus tard.';
	$i18nTexts[I18N_LANG_FR][I18N_TEXT_ERROR_CLOSE] = 'Fermer';
	$i18nTexts[I18N_LANG_FR][I18N_TEXT_INVITE_TITLE] = 'Pensez-vous que cette application peut être utile à vos amis ?';
	$i18nTexts[I18N_LANG_FR][I18N_TEXT_INVITE_DESC] = 'Invitez les';
	$i18nTexts[I18N_LANG_FR][I18N_TEXT_INVITE_CLOSE] = 'Fermer';
	$i18nTexts[I18N_LANG_FR][I18N_TEXT_REQUEST_INVITE_TITLE] = 'Invitez vos amis à utiliser '.$i18nTexts[I18N_LANG_FR][I18N_TEXT_APPNAME];
	$i18nTexts[I18N_LANG_FR][I18N_TEXT_REQUEST_INVITE_BODY] = 'Venez vous rappeler vos statuts !';
	$i18nTexts[I18N_LANG_FR][I18N_TEXT_REQUEST_REUSE_TITLE] = 'Prévenir les amis qui ont aimé et/ou commenté ?';
	$i18nTexts[I18N_LANG_FR][I18N_TEXT_REQUEST_REUSE_BODY] = 'Je viens de réutiliser un statut que tu as aimé et/ou commenté !';
	$i18nTexts[I18N_LANG_FR][I18N_TEXT_REQUEST_REUSE_FILTER_ALL] = 'Tous';
	$i18nTexts[I18N_LANG_FR][I18N_TEXT_REQUEST_REUSE_FILTER_LIKED] = 'Ceux qui ont aimé';
	$i18nTexts[I18N_LANG_FR][I18N_TEXT_REQUEST_REUSE_FILTER_COMMENTED] = 'Ceux qui ont commenté';
	
	// Espagnol
	/*$i18nTexts[I18N_LANG_ES][I18N_TEXT_APPNAME] = '';
	$i18nTexts[I18N_LANG_ES][I18N_TEXT_BTN_MORE] = '';
	$i18nTexts[I18N_LANG_ES][I18N_TEXT_BTN_REUSE] = '';
	$i18nTexts[I18N_LANG_ES][I18N_TEXT_BTN_VIEW] = '';
	$i18nTexts[I18N_LANG_ES][I18N_TEXT_BTN_SENDTO] = '';
	$i18nTexts[I18N_LANG_ES][I18N_TEXT_LOADING] = '';
	$i18nTexts[I18N_LANG_ES][I18N_TEXT_NO_MORE] = '';
	$i18nTexts[I18N_LANG_ES][I18N_TEXT_STATUSES] = '';
	$i18nTexts[I18N_LANG_ES][I18N_TEXT_COPYRIGHT] = '';
	$i18nTexts[I18N_LANG_ES][I18N_TEXT_DATETIME_FORMAT] = '';
	$i18nTexts[I18N_LANG_ES][I18N_TEXT_DATE_DAYS] = array();
	$i18nTexts[I18N_LANG_ES][I18N_TEXT_DATE_MONTHS] = array();
	$i18nTexts[I18N_LANG_ES][I18N_TEXT_DATE_TODAY] = '';
	$i18nTexts[I18N_LANG_ES][I18N_TEXT_DATE_YESTERDAY] = '';
	$i18nTexts[I18N_LANG_ES][I18N_TEXT_ERROR_TITLE] = '';
	$i18nTexts[I18N_LANG_ES][I18N_TEXT_ERROR_DESC] = '';
	$i18nTexts[I18N_LANG_ES][I18N_TEXT_ERROR_CLOSE] = '';
	$i18nTexts[I18N_LANG_ES][I18N_TEXT_INVITE_TITLE] = '';
	$i18nTexts[I18N_LANG_ES][I18N_TEXT_INVITE_DESC] = '';
	$i18nTexts[I18N_LANG_ES][I18N_TEXT_INVITE_CLOSE] = '';
	$i18nTexts[I18N_LANG_ES][I18N_TEXT_REQUEST_TITLE] = '';
	$i18nTexts[I18N_LANG_ES][I18N_TEXT_REQUEST_BODY] = '';
	
	// German
	$i18nTexts[I18N_LANG_DE][I18N_TEXT_APPNAME] = '';
	$i18nTexts[I18N_LANG_DE][I18N_TEXT_BTN_MORE] = '';
	$i18nTexts[I18N_LANG_DE][I18N_TEXT_BTN_REUSE] = '';
	$i18nTexts[I18N_LANG_DE][I18N_TEXT_BTN_VIEW] = '';
	$i18nTexts[I18N_LANG_DE][I18N_TEXT_BTN_SENDTO] = '';
	$i18nTexts[I18N_LANG_DE][I18N_TEXT_LOADING] = '';
	$i18nTexts[I18N_LANG_DE][I18N_TEXT_NO_MORE] = '';
	$i18nTexts[I18N_LANG_DE][I18N_TEXT_STATUSES] = '';
	$i18nTexts[I18N_LANG_DE][I18N_TEXT_COPYRIGHT] = '';
	$i18nTexts[I18N_LANG_DE][I18N_TEXT_DATETIME_FORMAT] = '';
	$i18nTexts[I18N_LANG_DE][I18N_TEXT_DATE_DAYS] = array();
	$i18nTexts[I18N_LANG_DE][I18N_TEXT_DATE_MONTHS] = array();
	$i18nTexts[I18N_LANG_DE][I18N_TEXT_DATE_TODAY] = '';
	$i18nTexts[I18N_LANG_DE][I18N_TEXT_DATE_YESTERDAY] = '';
	$i18nTexts[I18N_LANG_DE][I18N_TEXT_ERROR_TITLE] = '';
	$i18nTexts[I18N_LANG_DE][I18N_TEXT_ERROR_DESC] = '';
	$i18nTexts[I18N_LANG_DE][I18N_TEXT_ERROR_CLOSE] = '';
	$i18nTexts[I18N_LANG_DE][I18N_TEXT_INVITE_TITLE] = '';
	$i18nTexts[I18N_LANG_DE][I18N_TEXT_INVITE_DESC] = '';
	$i18nTexts[I18N_LANG_DE][I18N_TEXT_INVITE_CLOSE] = '';
	$i18nTexts[I18N_LANG_DE][I18N_TEXT_REQUEST_TITLE] = '';
	$i18nTexts[I18N_LANG_DE][I18N_TEXT_REQUEST_BODY] = '';
	
	// Italian
	$i18nTexts[I18N_LANG_IT][I18N_TEXT_APPNAME] = '';
	$i18nTexts[I18N_LANG_IT][I18N_TEXT_BTN_MORE] = '';
	$i18nTexts[I18N_LANG_IT][I18N_TEXT_BTN_REUSE] = '';
	$i18nTexts[I18N_LANG_IT][I18N_TEXT_BTN_VIEW] = '';
	$i18nTexts[I18N_LANG_IT][I18N_TEXT_BTN_SENDTO] = '';
	$i18nTexts[I18N_LANG_IT][I18N_TEXT_LOADING] = '';
	$i18nTexts[I18N_LANG_IT][I18N_TEXT_STATUSES] = '';
	$i18nTexts[I18N_LANG_IT][I18N_TEXT_COPYRIGHT] = '';
	$i18nTexts[I18N_LANG_IT][I18N_TEXT_NO_MORE] = '';
	$i18nTexts[I18N_LANG_IT][I18N_TEXT_DATETIME_FORMAT] = '';
	$i18nTexts[I18N_LANG_IT][I18N_TEXT_DATE_DAYS] = array();
	$i18nTexts[I18N_LANG_IT][I18N_TEXT_DATE_MONTHS] = array();
	$i18nTexts[I18N_LANG_IT][I18N_TEXT_DATE_TODAY] = '';
	$i18nTexts[I18N_LANG_IT][I18N_TEXT_DATE_YESTERDAY] = '';
	$i18nTexts[I18N_LANG_IT][I18N_TEXT_ERROR_TITLE] = '';
	$i18nTexts[I18N_LANG_IT][I18N_TEXT_ERROR_DESC] = '';
	$i18nTexts[I18N_LANG_IT][I18N_TEXT_ERROR_CLOSE] = '';
	$i18nTexts[I18N_LANG_IT][I18N_TEXT_INVITE_TITLE] = '';
	$i18nTexts[I18N_LANG_IT][I18N_TEXT_INVITE_DESC] = '';
	$i18nTexts[I18N_LANG_IT][I18N_TEXT_INVITE_CLOSE] = '';
	$i18nTexts[I18N_LANG_IT][I18N_TEXT_REQUEST_TITLE] = '';
	$i18nTexts[I18N_LANG_IT][I18N_TEXT_REQUEST_BODY] = '';*/