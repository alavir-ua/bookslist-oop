<?php

/**
 * Класс User - модель для работы с пользователями
 */
class User
{
	public static function checkAddress($address)
	{
		if (strlen($address) >= 10) {
			return true;
		}
		return false;
	}

	public static function checkFullName($name)
	{
		if (strlen($name) >= 6) {
			return true;
		}
		return false;
	}

}
