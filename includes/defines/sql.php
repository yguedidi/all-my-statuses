<?php
	if(isLocal()) {
		define('SQL_HOST', 'localhost');
		define('SQL_PORT', '3306');
		define('SQL_USER', 'root');
		define('SQL_PASS', 'EDIT_ME');
		define('SQL_DB', 'all-my-statuses');
	} else {
		define('SQL_HOST', 'EDIT_ME');
		define('SQL_PORT', '3306');
		define('SQL_USER', 'EDIT_ME');
		define('SQL_PASS', 'EDIT_ME');
		define('SQL_DB', 'EDIT_ME');
	}
