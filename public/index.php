<?php
    use Facebook\Exceptions\FacebookResponseException;
    use Facebook\Exceptions\FacebookSDKException;
    use Symfony\Component\Dotenv\Dotenv;

	require __DIR__ . '/../vendor/autoload.php';

	if (file_exists(__DIR__.'/../.env')) {
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__.'/../.env');
	}

    header('P3P:CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');

	// Requis généraux
	require_once '../includes/app.php';
	require_once '../includes/server.php';
	require_once '../includes/fb.php';
	require_once '../includes/cache.php';
	require_once '../includes/i18n.php';

	define('USE_CACHE', CACHE_WHEN);

	define('NB_STATUSES_BY_PAGE', 25);

	// Ressource demandée
	if(isset($_GET['resource']) && isset($_GET['type'])) {
        $mime = 'text/plain';
		$utf8 = true;
		$filename = $_GET['resource'].'.'.$_GET['type'];
		$dir = 'resources/';
		$maxage = 31557600; // 1 an
		switch($_GET['type']) {
			case 'css':
				$mime = 'text/css';
				$maxage = STYLE_CACHE;
				$filename = 'style.'.$_GET['type'];
				break;
			case 'js':
				$mime = 'text/javascript';
				$maxage = SCRIPT_CACHE;
				$filename = 'script.'.$_GET['type'];
				break;
			case 'gif':
				$mime = 'image/gif';
				$utf8 = false;
				$maxage = IMAGE_CACHE;
				$dir .= 'images/';
				break;
			default:
				$utf8 = false;
				$dir .= 'images/';
				break;
		}

		// Gestion de l'Unicode
		header('Content-Type: '.$mime.($utf8 ? '; charset=utf-8' : ''));

		if(USE_CACHE) {
			$last_timestamp = @filemtime($dir.$filename);

			if ($last_timestamp !== false) {
                $last_etag = md5($filename.'.|'.$last_timestamp);

                setCacheHeaders($last_timestamp, $last_etag, $maxage);
            } else {
                setNoCacheHeaders();
            }
		} else {
			setNoCacheHeaders();
		}

		$gzip = false;
		$content = file_get_contents(realpath(__DIR__.'/../'.$dir.$filename));
		switch($_GET['type']) {
			case 'css':
				$gzip = true;
				$content = preg_replace('`url\([\'"]{1}(.*)[\'"]{1}\)`', 'url("'.APP_URL.'\1")', $content);
				$content = getCSS($content);
				break;
			case 'js':
				$gzip = true;
				$content = 	'if(typeof AllMyStatuses == "undefined" || !AllMyStatuses) AllMyStatuses = {};'.PHP_EOL.
							'if(typeof AllMyStatuses.Urls == "undefined" || !AllMyStatuses.Urls) AllMyStatuses.Urls = {};'.PHP_EOL.
							'if(typeof AllMyStatuses.FB == "undefined" || !AllMyStatuses.FB) AllMyStatuses.FB = {};'.PHP_EOL.
							'if(typeof I18n == "undefined" || !I18n) I18n = {};'.
							'if(typeof Tools == "undefined" || !Tools) Tools = {};'.
							'AllMyStatuses.FB.UserID = null;'.
							'AllMyStatuses.FB.Locale = "en_US";'.
							'AllMyStatuses.Urls.home = "'.APP_URL.'";'.PHP_EOL.
							'AllMyStatuses.Urls.canvas = "'.FB_CANVAS.'";'.PHP_EOL.
							'AllMyStatuses.FB.AppID = "'.FB_ID.'";'.PHP_EOL.
							'AllMyStatuses.FB.CanvasURL = "'.FB_CANVAS.'";'.PHP_EOL.
							'AllMyStatuses.FB.Perms = "'.implode(',', FB_PERMS).'";'.PHP_EOL.
							'AllMyStatuses.FB.Params = {"limit": 5, "offset": 0};'.PHP_EOL.
							'I18n.currentLocale = "en_US";'.PHP_EOL.
							'I18n.currentLanguage = '.I18N_LANG_EN.';'.PHP_EOL.
							'I18n.texts = '.json_encode($i18nTexts).';'.PHP_EOL.
							'I18n.languages = {};'.PHP_EOL.
							'I18n.languages.EN = '.I18N_LANG_EN.';'.PHP_EOL.
							'I18n.languages.FR = '.I18N_LANG_FR.';'.PHP_EOL.
							'I18n.locales = '.json_encode($i18nLocales).';'.PHP_EOL.
							'I18n.ids = {};'.PHP_EOL.
							'I18n.ids.APPNAME = '.I18N_TEXT_APPNAME.';'.PHP_EOL.
							'I18n.ids.BTN_MORE = '.I18N_TEXT_BTN_MORE.';'.PHP_EOL.
							'I18n.ids.BTN_SHARE = '.I18N_TEXT_BTN_SHARE.';'.PHP_EOL.
							'I18n.ids.BTN_VIEW = '.I18N_TEXT_BTN_VIEW.';'.PHP_EOL.
							'I18n.ids.LOADING = '.I18N_TEXT_LOADING.';'.PHP_EOL.
							'I18n.ids.NO_MORE = '.I18N_TEXT_NO_MORE.';'.PHP_EOL.
							'I18n.ids.COPYRIGHT = '.I18N_TEXT_COPYRIGHT.';'.PHP_EOL.
							'I18n.ids.DATETIME_FORMAT = '.I18N_TEXT_DATETIME_FORMAT.';'.PHP_EOL.
							'I18n.ids.DATE_TODAY = '.I18N_TEXT_DATE_TODAY.';'.PHP_EOL.
							'I18n.ids.DATE_YESTERDAY = '.I18N_TEXT_DATE_YESTERDAY.';'.PHP_EOL.
							'I18n.ids.DATE_DAYS = '.I18N_TEXT_DATE_DAYS.';'.PHP_EOL.
							'I18n.ids.DATE_MONTHS = '.I18N_TEXT_DATE_MONTHS.';'.PHP_EOL.
							//'I18n.today = "'.getI18nText(I18N_TEXT_DATE_TODAY).'";'.PHP_EOL.
							//'I18n.yesterday = "'.getI18nText(I18N_TEXT_DATE_YESTERDAY).'";'.PHP_EOL.
							//'I18n.days = '.json_encode(getI18nText(I18N_TEXT_DATE_DAYS)).';'.PHP_EOL.
							//'I18n.months = '.json_encode(getI18nText(I18N_TEXT_DATE_MONTHS)).';'.PHP_EOL.
							$content;
				$content = getJS($content);
				break;
			default:

		}

		ob_start();
		if(!isLocal() && $gzip) {
			ob_start('ob_gzhandler');
		}

		echo $content;

		if(!isLocal() && $gzip) {
			ob_end_flush();
		}
		header('Content-Length: '.ob_get_length());
		ob_end_flush();
	} else {
        try {
            $accessToken = $canvasHelper->getAccessToken();

            if (!$accessToken) {
                echo '<script type="text/javascript">window.location.href = "'.$loginUrl.'";</script>';
                exit();
            }
        } catch(FacebookResponseException $e) {
            echo '<script type="text/javascript">window.location.href = "'.$loginUrl.'";</script>';
            exit();
        } catch(FacebookSDKException $e) {
            echo '<script type="text/javascript">window.location.href = "'.$loginUrl.'";</script>';
            exit();
        }

        $userLocale = $canvasHelper->getSignedRequest()->get('user')['locale'];
        $userId = $canvasHelper->getSignedRequest()->get('user_id');

        setI18nLocale($userLocale);

		// Date de dernière modification :
		if(USE_CACHE) {
			// Du script
			$last_timestamp = filemtime($_SERVER['SCRIPT_FILENAME']);
			$last_etag = md5($_SERVER['SCRIPT_FILENAME'].'|'.$userId.'|'.$userLocale.'|'.$last_timestamp);

			// Gère le cache
			setCacheHeaders($last_timestamp, $last_etag, PAGE_CACHE);
		} else {
			setNoCacheHeaders();
		}

		// Début du tampon de sortie
		ob_start();
		if(!isLocal()) {
			ob_start('ob_gzhandler');
		}

		// Gestion de l'Unicode
		header('Content-Type: text/html; charset=utf-8');

		$min = isProd() ? '.min' : '';

		// Corps de page
		echo 	'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'.
				'<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml" xml:lang="fr">'.
					'<head>'.
						'<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />'.
				 		'<link rel="stylesheet" type="text/css" href="'.APP_URL.'20180527182626.css" />'.
						'<title>'.APP_NAME.'</title>'.
					'</head>'.
					'<body>'.
						'<h2>'.
							getI18nText(I18N_TEXT_APPNAME).
							'<span>'.APP_VERSION.(isLocal() ? ' [Local]'.(isCanvas() ? '[Canvas]' : '[Site]') : '').'</span>'.
							'<div id="btnLikeTop"><fb:like href="'.FB_PAGE.'" ref="like_top" show_faces="false" action="like" layout="button_count" font="lucida grande"></fb:like></div>'.
						'</h2>'.
						'<div id="body">'.
							'<ul id="listStatuses"></ul>'.
							'<div id="boxFooter" class="loading">'.
								'<span class="nbStatuses"><span id="nbStatuses">0</span> '.getI18nText(I18N_TEXT_STATUSES).'</span>'.
								'<a id="btnMore" href="#">'.getI18nText(I18N_TEXT_BTN_MORE).'</a>'.
								'<span id="lbLoading">'.getI18nText(I18N_TEXT_LOADING).'</span>'.
								'<span id="lbNoMore">'.getI18nText(I18N_TEXT_NO_MORE).'</span>'.
							'</div>'.
						'</div>'.
						'<div id="btnLikeBottom"><fb:like href="'.FB_PAGE.'" ref="like_bottom" width="550" show_faces="true" action="like" font="lucida grande"></fb:like></div>'.
						'<p id="copyright">'.getI18nText(I18N_TEXT_COPYRIGHT).'</p>'.
						'<div id="fb-root"></div>'.
						'<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery'.$min.'.js"></script>'.
						'<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/jquery-ui'.$min.'.js"></script>'.
						'<script type="text/javascript" src="'.APP_URL.'20180527182626.js"></script>'.
						'<script type="text/javascript">'.
							getJS(	'AllMyStatuses.FB.UserID = "'.$userId.'";'.
									'AllMyStatuses.FB.Locale = "'.$userLocale.'";'.
									'AllMyStatuses.FB.Params.limit = '.NB_STATUSES_BY_PAGE.';'.
									'AllMyStatuses.FB.Debug = '.(!isProd() ? 'true' : 'false').';'.
									'I18n.currentLocale = "'.$userLocale.'";'.
									'I18n.currentLanguage = '.getI18nLanguage().';').
						'</script>'.
					'</body>'.
				'</html>';

		if(!isLocal()) {
			ob_end_flush();
		}
		header('Content-Length: '.ob_get_length());

		// Affichage
		ob_end_flush();
	}
