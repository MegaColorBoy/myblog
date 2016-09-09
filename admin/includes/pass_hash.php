<?php
//Password hash class
class PASS_HASH
{
	private static $algo = '$2a';
	private static $cost = '$10';

	//constructor
	function __construct(){}

	//Unique salt
	public static function unique_salt()
	{
		return substr(sha1(mt_rand()),0,22);
	}

	//Hashing
	public static function hash($password)
	{
		return crypt($password, self::$algo . self::$cost . '$' . self::unique_salt());
	}

	//Check password
	public static function checkPassword($hash, $password)
	{
		$full_salt = substr($hash,0,29);
		$new_hash = crypt($password, $full_salt);
		return ($hash == $new_hash);
	}
}
?>