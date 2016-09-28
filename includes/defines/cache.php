<?php
	define('CACHE_WHEN', isMyProd() || isProd());
	
	define('PAGE_CACHE', 180);
	define('STYLE_CACHE', 31557600);
	define('SCRIPT_CACHE', 31557600);
	define('IMAGE_CACHE', 31557600);
