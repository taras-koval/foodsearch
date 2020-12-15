<?php

class User
{

	/*----------USER REGISTER----------*/


	public static function register($username, $email, $password)
	{
		$db = Database::getConnection();

		$sql = 'INSERT INTO user (username, email, password)
			VALUES (:username, :email, :password)';

		$result = $db->prepare($sql);
		$result->bindParam(':username', $username, PDO::PARAM_STR);
		$result->bindParam(':email', $email, PDO::PARAM_STR);
		$result->bindParam(':password', $password, PDO::PARAM_STR);

		return $result->execute();
	}


	public static function findEmail($email)
	{
		$db = Database::getConnection();

		$sql = 'SELECT COUNT(*) FROM user WHERE email = :email';

		$result = $db->prepare($sql);
		$result->bindParam(':email', $email, PDO::PARAM_STR);
		$result->execute();

		if ($result->fetchColumn())
			return true;

		return false;
	}


	/*----------USER LOGIN----------*/


	public static function login($email, $password)
	{
		$db = Database::getConnection();

		$sql = 'SELECT id FROM user 
			WHERE email = :email AND password = :password';

		$result = $db->prepare($sql);
		$result->bindParam(':email', $email, PDO::PARAM_STR);
		$result->bindParam(':password', $password, PDO::PARAM_STR);
		$result->execute();

		$userId = $result->fetchColumn();

		if ($userId)
			return $userId;

		return false;
	}


	/*----------USER GETDATA---------*/


	public static function getUserDataById($id)
	{
		if ($id) {

			$db = Database::getConnection();

			$sql = 'SELECT id, username, email, role FROM user WHERE id = :id';

			$result = $db->prepare($sql);
			$result->bindParam(':id', $id, PDO::PARAM_INT);

			$result->setFetchMode(PDO::FETCH_ASSOC);
			$result->execute();

			return $result->fetch();
		}
	}

	public static function getUserPasswordById($id)
	{
		if ($id) {

			$db = Database::getConnection();

			$sql = 'SELECT password FROM user WHERE id = :id';

			$result = $db->prepare($sql);
			$result->bindParam(':id', $id, PDO::PARAM_INT);

			$result->execute();

			return $result->fetchColumn();
		}
	}
	
	/*----------USER SESSION---------*/


	public static function setSession($id) 
	{
		$_SESSION['user'] = self::getUserDataById($id);
	}

	public static function resetSession($id) 
	{
		unset($_SESSION['user']);
		$_SESSION['user'] = self::getUserDataById($id);
	}

	public static function unsetSession() 
	{
		unset($_SESSION['user']);
	}

	public static function issetSession()
	{
		if (isset($_SESSION['user']))
			return $_SESSION['user']['id'];
		return false;
	}


	/*----------USER UPDATE----------*/


	public static function updatePassword($id, $password) 
	{
		$db = Database::getConnection();

		$sql = 'UPDATE user SET password = :password WHERE id = :id';

		$result = $db->prepare($sql);                                  
		$result->bindParam(':id', $id, PDO::PARAM_INT);       
		$result->bindParam(':password', $password, PDO::PARAM_STR);

		return $result->execute();
	}

	public static function updateUserData($id, $username, $email)
	{
		$db = Database::getConnection();

		$sql = "UPDATE user 
			SET username = :username, email = :email
			WHERE id = :id";
		
		$result = $db->prepare($sql);                                  
		$result->bindParam(':id', $id, PDO::PARAM_INT);       
		$result->bindParam(':username', $username, PDO::PARAM_STR);
		$result->bindParam(':email', $email, PDO::PARAM_STR); 
		
		return $result->execute();
	}

	/*----------USER GENERAL---------*/


	public static function isAdmin($id)
	{
		$user = User::getUserDataById($id);

		if ($user['role'] == 'admin')
			return true;
		
		return false;
	}

	/*----------USER FAVORITE---------*/


	public static function addToFavorite($userId, $objectId)
	{
		$db = Database::getConnection();

		$sql = 'INSERT INTO favorite (user_id, object_id) 
			VALUES (:user_id, :object_id);';


		$result = $db->prepare($sql);
		$result->bindParam(':user_id', $userId, PDO::PARAM_INT);
		$result->bindParam(':object_id', $objectId, PDO::PARAM_INT);

		return $result->execute();
	}

	public static function getFavoriteList($userId, $page = 1)
	{
		$db = Database::getConnection();

		$count = Object_::SHOW_BYDEFAULT;
		$page = intval($page);

		$offset = ($page - 1) * $count;

		$result = $db->query("
			SELECT 
				object.id,
				object.name,
				object.address,
				object.hours,
				type.name as type
			FROM object
			JOIN favorite on favorite.object_id = object.id
			JOIN type on type.id = object.type_id
			JOIN user on user.id = favorite.user_id
			WHERE user.id = $userId
			LIMIT $count
			OFFSET $offset
		");

		$list = array();
		
		$i = 0;
		while ($row = $result->fetch()) {
			$list[$i]['id'] = $row['id'];
			$list[$i]['name'] = $row['name'];
			$list[$i]['address'] = $row['address'];
			$list[$i]['hours'] = $row['hours'];
			$list[$i]['type'] = $row['type'];
			$i++;
		}
		return $list;
	}

	public static function getTotalFavorites($userId)
	{
		$db = Database::getConnection();

		$sql = "SELECT COUNT(object.id) AS count
			FROM object
			JOIN favorite on favorite.object_id = object.id
			JOIN user on user.id = favorite.user_id
			WHERE user.id = $userId 
		";

		$result = $db->query($sql);

		$result->setFetchMode(PDO::FETCH_ASSOC);
		$row = $result->fetch();

		return $row['count'];
	}

	public static function isFavorite($userId, $objectId)
	{
		if (!$userId || !$objectId)
			return false;

		$db = Database::getConnection();

		$result = $db->query("
			SELECT COUNT(*) 
			FROM favorite
			JOIN object on object.id = favorite.object_id
			JOIN user on user.id = favorite.user_id
			WHERE favorite.user_id = $userId and favorite.object_id = $objectId");

		if ($result->fetchColumn())
			return true;

		return false;
	}

	public static function deleteFavorite($userId, $objectId)
	{
		$db = Database::getConnection();

		$sql = 'DELETE FROM favorite
			WHERE favorite.user_id = :userId AND favorite.object_id = :objectId';

		$result = $db->prepare($sql);
		$result->bindParam(':userId', $userId, PDO::PARAM_INT);
		$result->bindParam(':objectId', $objectId, PDO::PARAM_INT);
		return $result->execute();
	}

}

?>