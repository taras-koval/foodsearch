<?php

class Comment
{
	const SHOW_BYDEFAULT = 8;

	public static function create($user, $object, $comment, $rating) 
	{
		$db = Database::getConnection();

		$sql = "INSERT INTO comment (user_id, object_id, text, rating)
			VALUES (:user_id, :object_id, :text, :rating)";

		$result = $db->prepare($sql);
		$result->bindParam(':user_id', $user, PDO::PARAM_INT);
		$result->bindParam(':object_id', $object, PDO::PARAM_INT);
		$result->bindParam(':text', $comment, PDO::PARAM_STR);
		$result->bindParam(':rating', $rating, PDO::PARAM_INT);

		return $result->execute();
	}

	public static function read($object, $page = 1)
	{
		$db = Database::getConnection();

		$count = self::SHOW_BYDEFAULT;
		$page = intval($page);

		$offset = ($page - 1) * $count;

		$result = $db->query("
			SELECT
				user.id AS user_id,
				user.username AS username, 
				comment.id, 
				comment.date, 
				comment.text, 
				comment.rating
			FROM comment
			JOIN user on user.id = comment.user_id
			JOIN object on object.id = comment.object_id
			WHERE object.id = $object
			ORDER BY comment.id DESC
			LIMIT $count
			OFFSET $offset
		");

		$list = [];

		$i = 0;
		while ($row = $result->fetch()) {
			$list[$i]['user_id'] = $row['user_id'];
			$list[$i]['username'] = $row['username'];
			$list[$i]['id'] = $row['id'];
			$list[$i]['date'] = $row['date'];
			$list[$i]['text'] = $row['text'];
			$list[$i]['rating'] = $row['rating'];
			$i++;
		}

		return $list;
	}

	public static function delete($id)
	{
		$db = Database::getConnection();

		$sql = "DELETE FROM comment WHERE comment.id = :id";

		$result = $db->prepare($sql);
		$result->bindParam(':id', $id, PDO::PARAM_INT);

		return $result->execute();
	}

	public static function get($id)
	{
		$db = Database::getConnection();

		$result = $db->query("
			SELECT
				user.id AS user_id,
				user.username AS username, 
				comment.id, 
				comment.date, 
				comment.text, 
				comment.rating
			FROM comment
			JOIN user on user.id = comment.user_id
			JOIN object on object.id = comment.object_id
			WHERE comment.id = $id
		");

		$result->setFetchMode(PDO::FETCH_ASSOC);
		return $result->fetch();
	}

	public static function getObjectById($id)
	{
		$id = intval($id);

		if ($id) {
			$db = Database::getConnection();

			$result = $db->query("SELECT * FROM object 
				WHERE id = $id");
			$result->setFetchMode(PDO::FETCH_ASSOC);
			
			return $result->fetch();
		}
	}

	public static function count($object)
	{
		$db = Database::getConnection();

		$sql = "SELECT COUNT(comment.id) AS count 
			FROM comment
			JOIN user ON user.id = comment.user_id
			JOIN object ON object.id = comment.object_id
			WHERE object.id = $object
		";

		$result = $db->query($sql);

		$result->setFetchMode(PDO::FETCH_ASSOC);
		$row = $result->fetch();

		return $row['count'];
	}

	public static function isOwner($id, $user)
	{
		$db = Database::getConnection();

		$sql = "SELECT COUNT(comment.id) AS count 
			FROM comment
			JOIN user ON user.id = comment.user_id
			WHERE user.id = $user
		";

		$result = $db->query($sql);

		$result->setFetchMode(PDO::FETCH_ASSOC);
		$row = $result->fetch();

		return $row['count'];
	}

	public static function existence($user, $object)
	{
		$db = Database::getConnection();

		$sql = "SELECT comment.id
			FROM comment
			WHERE comment.user_id = $user
				AND comment.object_id = $object
		";

		$result = $db->query($sql);

		$result->setFetchMode(PDO::FETCH_ASSOC);
		$row = $result->fetch();

		if ($row['id'])
			return $row['id'];

		return false;
	}
	
}

?>