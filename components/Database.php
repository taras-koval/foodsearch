<?php

class Database
{

	public static function getConnection()
	{
		$paramsPath = ROOT.'/config/db_params.php';
		$params = include($paramsPath);

		$dsn = "mysql:host={$params['host']};dbname={$params['dbname']}";

		try {
			$dbh = new PDO($dsn, $params['user'], $params['password']);
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		} catch (PDOException $exception) {
			die($exception->getMessage());
		}

		$dbh->exec("set names utf8");

		return $dbh;
	}

}

?>