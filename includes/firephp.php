<?php
	require_once 'libraries/FirePHP.class.php';

	$FirePHP = FirePHP::getInstance(true);

	$FirePHP->registerErrorHandler(false);
	$FirePHP->registerExceptionHandler();
	$FirePHP->registerAssertionHandler(true, false);

	$FirePHP->setEnabled(isset($_GET['local_mode']) || !isProd());
