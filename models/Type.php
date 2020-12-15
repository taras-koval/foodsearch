<?php

class Type
{

	public static function add($name)
	{
		$db = Database::getConnection();

		$sql = 'INSERT INTO type (name) VALUES (:name)';

		$result = $db->prepare($sql);
		$result->bindParam(':name', $name, PDO::PARAM_STR);

		return $result->execute();
	}

	public static function delete($id)
	{
		$db = Database::getConnection();

		$sql = 'DELETE FROM type WHERE id = :id';

		$result = $db->prepare($sql);
		$result->bindParam(':id', $id, PDO::PARAM_INT);

		return $result->execute();
	}

	public static function find($name)
	{
		$db = Database::getConnection();

		$sql = 'SELECT COUNT(*) FROM type WHERE name = :name';

		$result = $db->prepare($sql);
		$result->bindParam(':name', $name, PDO::PARAM_STR);
		$result->execute();

		if ($result->fetchColumn())
			return true;

		return false;
	}

	public static function getItemById($id)
	{
		$db = Database::getConnection();

		$sql = 'SELECT * FROM type WHERE id = :id';

		$result = $db->prepare($sql);
		$result->bindParam(':id', $id, PDO::PARAM_INT);

		$result->setFetchMode(PDO::FETCH_ASSOC);

		$result->execute();

		return $result->fetch();
	}

	public static function getList()
	{
		$db = Database::getConnection();

		$result = $db->query('
			SELECT id, name
			FROM type
			ORDER BY id
		');

		$list = array();
		
		$i = 0;
		while ($row = $result->fetch()) {
			$list[$i]['id'] = $row['id'];
			$list[$i]['name'] = $row['name'];
			$i++;
		}
		return $list;
	}
	
}

?>