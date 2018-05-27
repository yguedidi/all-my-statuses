<?php
	require_once 'defines/fb.php';
	require_once 'functions/fb.php';

    $canvasHelper = $fb->getCanvasHelper();
    $loginUrl = $fb->getRedirectLoginHelper()->getLoginUrl(FB_CANVAS, FB_PERMS);
