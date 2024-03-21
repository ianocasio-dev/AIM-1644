<?php
/**
 * Cookie class
 *
 * This class contains various static functions and constants pertaining to the handling of cookies.
 */

final class Cookie
{
	private function __construct() {}

	public static function Set($name, $value, $expires = 0, $sameSite = 'Strict')
	{
		if (!is_numeric($expires))
		{
			if (is_string($expires))
			{
				$expires = strtotime($expires);
			}

			if (!is_numeric($expires))
			{
				BloodyMurder('Invalid Cookie Set expires.' . $expires);
			}
		}

		$config = Configuration::That();
		$secure = ($config && $config->ForceSecureProtocol);
		$httpOnly = true;

		if (PHP_VERSION_ID < 70300)
		{
			setcookie(
				$name,
				$value,
				$expires,
				'; samesite=' . $sameSite,
				null,
				$secure,
				$httpOnly
			);
		}
		else
		{
			setcookie(
				$name,
				$value,
				array(
					'expires' => $expires,
//					'path' => $path,
//					'domain' => $domain,
					'secure' => $secure,
					'httponly' => $httpOnly,
					'samesite' => $sameSite
				)
			);
		}
	}

	public static function Delete($name)
	{
		setcookie($name, null, 1);
		unset($_COOKIE[$name]);
	}

	public static function SetSessionParams()
	{
		$config = Configuration::That();

		$maxLifeTime = 0;	// Until the browser is closed
		$sameSite = 'Strict';
		$secure = ($config && $config->ForceSecureProtocol);
		$httpOnly = true;

		// Inspired by https://www.php.net/manual/en/function.session-set-cookie-params.php#125072
		if (PHP_VERSION_ID < 70300)
		{
			session_set_cookie_params(
				$maxLifeTime,
				'; samesite=' . $sameSite,
				null,
				$secure,
				$httpOnly
			);
		}
		else
		{
			session_set_cookie_params(array(
				'lifetime' => $maxLifeTime,
//				'path' => $path,
//				'domain' => $domain,
				'secure' => $secure,
				'httponly' => $httpOnly,
				'samesite' => $sameSite
			));
		}
	}
}