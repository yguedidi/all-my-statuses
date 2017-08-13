<?php
	/**
	 * Définis les entêtes de cache et renvois un code 304 en cas de non modification
	 * @param $page Page courante
	 * @param $type Type de cache (page, styles, scripts)
	 * @param $last_timestamp Timestamp de dernière mise a jour de la page
	 * @return bool
	 */
	function setCacheHeaders($last_timestamp = null, $last_etag = null, $max_age = 0) {
		header('Pragma: ', true);
                if(!is_null($last_timestamp)) {
			header('Last-Modified: '.
					gmdate("D, d M Y H:i:s", $last_timestamp).' GMT');
			header('Expires: '.
					gmdate("D, d M Y H:i:s", $last_timestamp + 31557600).' GMT'); // 1 an
		}
		if(!is_null($last_etag)) {
			header('ETag: '.$last_etag);
		}
		header('Cache-Control: '.
					'public, '.
					//'must-revalidate, '.
					//'proxy-revalidate, '.
					'max-age='.$max_age.', '.
					's-maxage='.$max_age);

			// Fichier non modifié
		if(	!(isset($_SERVER['HTTP_PRAGMA']) && $_SERVER['HTTP_PRAGMA'] == 'no-cache') &&
			(isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) === $last_timestamp) &&
			(isset($_SERVER['HTTP_IF_NONE_MATCH']) && $_SERVER['HTTP_IF_NONE_MATCH'] === $last_etag)) {
            header('Status: 304 Not Modified', true, 304);

			exit();
		}
	}

	function setNoCacheHeaders() {
		header('Cache-Control: '.
					'max-age=0, '.
					's-maxage=0, '.
					'must-revalidate, '.
					'proxy-revalidate, '.
					'no-store, '.
					'no-cache');
		header('Expires: Thu, 01-Jan-70 00:00:01 GMT');
	}

	function getJS($js) {
		if(class_exists('JSMin')) {
			// On minifie le JS
			return JSMin::minify($js);
		} else {
			return $js;
		}
	}

	function printJS($js) {
		echo getJS($js);
	}

	function getCSS($css) {
		if(class_exists('CssMin')) {
			return CssMin::minify(
				$css,
				array(
					"ImportImports"                 => false,
					"RemoveComments"                => true,
					"RemoveEmptyRulesets"           => true,
					"RemoveEmptyAtBlocks"           => true,
					"ConvertLevel3AtKeyframes"      => false,
					"ConvertLevel3Properties"       => false,
					"Variables"                     => true,
					"RemoveLastDelarationSemiColon" => true),
				array(
					"Variables"                     => true,
					"ConvertFontWeight"             => false,
					"ConvertHslColors"              => false,
					"ConvertRgbColors"              => false,
					"ConvertNamedColors"            => false,
					"CompressColorValues"           => false,
					"CompressUnitValues"            => false,
					"CompressExpressionValues"      => false)
				);
		} else {
			return $css;
		}
	}

	function printCSS($css) {
		echo getCSS($css);
	}
