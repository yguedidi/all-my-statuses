<?php
	function setI18nLocale($locale) {
		global $i18nCurrent;
		
		$i18nCurrent = $locale;
	}
	
	function getI18nLanguage() {
		global $i18nCurrent, $i18nLocales;
		
		return array_key_exists($i18nCurrent, $i18nLocales) ? $i18nLocales[$i18nCurrent] : I18N_LANG_EN;
	}
	
	function getI18nText($id, $params = array()) {
		global $i18nTexts;
		
		$lang = getI18nLanguage();
		
		if(empty($params)) {
			return $i18nTexts[$lang][$id];
		}
		return $i18nTexts[$lang][$id];
	}
