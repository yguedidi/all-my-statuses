<?php
	function addUser($uid, $locale = 'en_US', $ref = null) {
		global $PDO;

		if(getUser($uid)) {
			if($ref) {
				return $PDO->exec('UPDATE users SET ref = "'.$ref.'" deleted = 0, date = CURRENT_TIMESTAMP WHERE uid = '.$uid.';');
			} else {
				return $PDO->exec('UPDATE users SET deleted = 0, date = CURRENT_TIMESTAMP WHERE uid = '.$uid.';');
			}
		} else {
			if($ref) {
				return $PDO->exec('INSERT INTO users (uid, locale, ref) VALUES('.$uid.', "'.$locale.'", "'.$ref.'");');
			} else {
				return $PDO->exec('INSERT INTO users (uid, locale) VALUES('.$uid.', "'.$locale.'");');
			}
		}
	};

	function getUser($uid) {
		global $PDO;

		$result = $PDO->query('SELECT * FROM users WHERE uid = '.$uid.';');

		return $result->fetch(PDO::FETCH_ASSOC);
	};

	function setUserLike($uid) {
		global $PDO;

		return $PDO->exec('UPDATE users SET `like` = 1 WHERE uid = '.$uid.';');
	};

	function setUserUnlike($uid) {
		global $PDO;

		return $PDO->exec('UPDATE users SET `like` = 0 WHERE uid = '.$uid.';');
	};

	function deleteUser($uid) {
		global $PDO;

		return $PDO->exec('UPDATE users SET deleted = 1 WHERE uid = '.$uid.';');
	};

	function undeleteUser($uid) {
		global $PDO;

		return $PDO->exec('UPDATE users SET deleted =0 WHERE uid = '.$uid.';');
	};
