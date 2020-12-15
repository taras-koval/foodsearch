<?php

class Object_
{
	const SHOW_BYDEFAULT = 8;
	const SHOW_BYDEFAULT_ADMIN_LIST = 20;

	public static function getLatestObjects($page = 1)
	{
		$db = Database::getConnection();

		$count = self::SHOW_BYDEFAULT;
		$page = intval($page);

		$offset = ($page - 1) * $count;

		$list = array();

		$result = $db->query("
			SELECT 
				object.id,
				object.name,
				object.address,
				object.hours,
				object.rating,
				type.name as type
			FROM object
			JOIN type on type.id = object.type_id
			ORDER BY id DESC
			LIMIT $count
			OFFSET $offset
		");

		$i = 0;
		while ($row = $result->fetch()) {
			$list[$i]['id'] = $row['id'];
			$list[$i]['name'] = $row['name'];
			$list[$i]['address'] = $row['address'];
			$list[$i]['hours'] = $row['hours'];
			$list[$i]['rating'] = $row['rating'];
			$list[$i]['type'] = $row['type'];
			$i++;
		}

		return $list;
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

	public static function add($formData)
	{
		$db = Database::getConnection();

		$sql = 'INSERT INTO object (name, type_id, address, phone, hours, link, description)
			VALUES (:name, :type_id, :address, :phone, :hours, :link, :description)';

		$result = $db->prepare($sql);
		$result->bindParam(':name', $formData['name'], PDO::PARAM_STR);
		$result->bindParam(':type_id', $formData['type'], PDO::PARAM_INT);
		$result->bindParam(':address', $formData['address'], PDO::PARAM_STR);
		$result->bindParam(':phone', $formData['phone'], PDO::PARAM_STR);
		$result->bindParam(':hours', $formData['hours'], PDO::PARAM_STR);
		$result->bindParam(':link', $formData['link'], PDO::PARAM_STR);
		$result->bindParam(':description', $formData['description'], PDO::PARAM_STR);

		if ($result->execute())
			return $db->lastInsertId();
		return 0;
	}

	public static function edit($id, $formData)
	{
		$db = Database::getConnection();

		$sql = 'UPDATE object
				SET
					name = :name, 
					type_id = :type_id, 
					address = :address, 
					phone = :phone, 
					hours = :hours, 
					link = :link, 
					description = :description
				WHERE id = :id';

		$result = $db->prepare($sql);
		$result->bindParam(':id', $id, PDO::PARAM_INT);
		$result->bindParam(':name', $formData['name'], PDO::PARAM_STR);
		$result->bindParam(':type_id', $formData['type'], PDO::PARAM_INT);
		$result->bindParam(':address', $formData['address'], PDO::PARAM_STR);
		$result->bindParam(':phone', $formData['phone'], PDO::PARAM_STR);
		$result->bindParam(':hours', $formData['hours'], PDO::PARAM_STR);
		$result->bindParam(':link', $formData['link'], PDO::PARAM_STR);
		$result->bindParam(':description', $formData['description'], PDO::PARAM_STR);

		return $result->execute();
	}

	public static function deleteObjectById($id)
	{
		$db = Database::getConnection();

		$sql = 'DELETE FROM object WHERE id = :id';

		$result = $db->prepare($sql);
		$result->bindParam(':id', $id, PDO::PARAM_INT);
		return $result->execute();
	}

	public static function isUniqueName($name)
	{
		$db = Database::getConnection();

		$sql = 'SELECT COUNT(*) FROM object WHERE name = :name';

		$result = $db->prepare($sql);
		$result->bindParam(':name', $name, PDO::PARAM_STR);
		$result->execute();

		if ($result->fetchColumn())
			return false;

		return true;
	}

	public static function getList($page = 1)
	{
		$db = Database::getConnection();

		$count = self::SHOW_BYDEFAULT_ADMIN_LIST;
		$page = intval($page);

		$offset = ($page - 1) * $count;

		/*$result = $db->query("
			SELECT id, name
			FROM object
			ORDER BY id
			LIMIT $count
			OFFSET $offset
		");

		$list = array();
		
		$i = 0;
		while ($row = $result->fetch()) {
			$list[$i]['id'] = $row['id'];
			$list[$i]['name'] = $row['name'];
			$i++;
		}*/

		$result = $db->prepare('
			SELECT id, name
			FROM object
			ORDER BY id
			LIMIT :count
			OFFSET :offset
		');

		$result->bindValue(':count', $count, PDO::PARAM_INT);
		$result->bindValue(':offset', $offset, PDO::PARAM_INT);
		$result->execute();

		$result->setFetchMode(PDO::FETCH_ASSOC);
		$list = $result->fetchAll();

		/*var_dump($list);
		exit;*/

		return $list;
	}

	public static function search($name, $page = 1, 
		$count = self::SHOW_BYDEFAULT_ADMIN_LIST)
	{
		$db = Database::getConnection();

		$page = intval($page);
		$offset = ($page - 1) * $count;

		$result = $db->query("
			SELECT 
				object.id, 
				object.name,
				object.address,
				object.hours,
				object.rating,
				type.name AS type
			FROM object
			JOIN type ON type.id = object.type_id
			WHERE object.name LIKE '%" . $name . "%' 
			ORDER BY object.id
			LIMIT $count
			OFFSET $offset
		");

		$list = [];
		
		$i = 0;
		while ($row = $result->fetch()) {
			$list[$i]['id'] = $row['id'];
			$list[$i]['name'] = $row['name'];
			$list[$i]['address'] = $row['address'];
			$list[$i]['hours'] = $row['hours'];
			$list[$i]['rating'] = $row['rating'];
			$list[$i]['type'] = $row['type'];
			$i++;
		}
		return $list;
	}

	public static function getFullList()
	{
		$db = Database::getConnection();

		$result = $db->query('
			SELECT id, name
			FROM object
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

	public static function getTotalObjects()
	{
		$db = Database::getConnection();

		$sql = "SELECT COUNT(id) AS count FROM object";
		$result = $db->query($sql);

		$result->setFetchMode(PDO::FETCH_ASSOC);
		$row = $result->fetch();

		return $row['count'];
	}

	public static function getSearchTotal($name)
	{
		$db = Database::getConnection();

		$sql = "SELECT COUNT(id) AS count 
			FROM object 
			WHERE name LIKE '%" . $name . "%'
		";

		$result = $db->query($sql);

		$result->setFetchMode(PDO::FETCH_ASSOC);
		$row = $result->fetch();

		return $row['count'];
	}

	public static function getStartForm() 
	{
		$form['name'] = '';
		$form['type'] = '';
		$form['kitchen'] = [];
		$form['service'] = [];
		$form['address'] = '';
		$form['phone'] = '';
		$form['hours'] = '';
		$form['link'] = '';
		$form['description'] = '';

		return $form;
	}

	public static function addKitchen($objectId, $kitchenId)
	{
		$db = Database::getConnection();

		$sql = 'INSERT INTO object_kitchen (object_id, kitchen_id) 
			VALUES (:object_id, :kitchen_id);';

		$result = $db->prepare($sql);
		$result->bindParam(':object_id', $objectId, PDO::PARAM_INT);
		$result->bindParam(':kitchen_id', $kitchenId, PDO::PARAM_INT);

		return $result->execute();
	}

	public static function getKitchensList($objectId)
	{
		$db = Database::getConnection();

		$result = $db->query("
			SELECT kitchen.id, kitchen.name
			FROM kitchen
			JOIN object_kitchen on object_kitchen.kitchen_id = kitchen.id
			JOIN object on object.id = object_kitchen.object_id
			WHERE object.id = $objectId
		");

		$list = array();
		
		$i = 0;
		while ($row = $result->fetch()) {
			$list[$i] = $row['id'];
			$i++;
		}
		return $list;
	}

	public static function getKitchensAsArray($objectId)
	{
		$db = Database::getConnection();

		$result = $db->query("
			SELECT kitchen.name
			FROM kitchen
			JOIN object_kitchen on object_kitchen.kitchen_id = kitchen.id
			JOIN object on object.id = object_kitchen.object_id
			WHERE object.id = $objectId
		");

		$list = array();
		
		$i = 0;
		while ($row = $result->fetch()) {
			$list[$i] = $row['name'];
			$i++;
		}
		return $list;
	}

	public static function getKitchensAsString($objectId)
	{
		return implode(', ', self::getKitchensAsArray($objectId));
	}

	public static function deleteKitchen($objectId, $kitchenId)
	{
		$db = Database::getConnection();

		$sql = 'DELETE FROM object_kitchen
			WHERE object_kitchen.object_id = :objectId AND 
				object_kitchen.kitchen_id = :kitchenId';

		$result = $db->prepare($sql);
		$result->bindParam(':objectId', $objectId, PDO::PARAM_INT);
		$result->bindParam(':kitchenId', $kitchenId, PDO::PARAM_INT);
		return $result->execute();
	}

	public static function deleteAllKitchens($objectId)
	{
		$db = Database::getConnection();

		$sql = 'DELETE FROM object_kitchen
			WHERE object_kitchen.object_id = :objectId';

		$result = $db->prepare($sql);
		$result->bindParam(':objectId', $objectId, PDO::PARAM_INT);
		return $result->execute();
	}

	public static function addService($objectId, $serviceId)
	{
		$db = Database::getConnection();

		$sql = 'INSERT INTO object_service (object_id, service_id) 
			VALUES (:object_id, :service_id);';

		$result = $db->prepare($sql);
		$result->bindParam(':object_id', $objectId, PDO::PARAM_INT);
		$result->bindParam(':service_id', $serviceId, PDO::PARAM_INT);

		return $result->execute();
	}

	public static function getServicesList($objectId)
	{
		$db = Database::getConnection();

		$result = $db->query("
			SELECT service.id, service.name
			FROM service
			JOIN object_service on object_service.service_id = service.id
			JOIN object on object.id = object_service.object_id
			WHERE object.id = $objectId
		");

		$list = array();
		
		$i = 0;
		while ($row = $result->fetch()) {
			$list[$i] = $row['id'];
			$i++;
		}
		return $list;
	}

	public static function getServicesAsArray($objectId)
	{
		$db = Database::getConnection();

		$result = $db->query("
			SELECT service.name
			FROM service
			JOIN object_service on object_service.service_id = service.id
			JOIN object on object.id = object_service.object_id
			WHERE object.id = $objectId
		");

		$list = array();
		
		$i = 0;
		while ($row = $result->fetch()) {
			$list[$i] = $row['name'];
			$i++;
		}
		return $list;
	}

	public static function getServicesAsString($objectId)
	{
		return implode(', ', self::getServicesAsArray($objectId));
	}

	public static function deleteService($objectId, $serviceId)
	{
		$db = Database::getConnection();

		$sql = 'DELETE FROM object_service
			WHERE object_service.object_id = :objectId AND 
				object_service.service_id = :serviceId';

		$result = $db->prepare($sql);
		$result->bindParam(':objectId', $objectId, PDO::PARAM_INT);
		$result->bindParam(':serviceId', $serviceId, PDO::PARAM_INT);
		return $result->execute();
	}

	public static function deleteAllServices($objectId)
	{
		$db = Database::getConnection();

		$sql = 'DELETE FROM object_service
			WHERE object_service.object_id = :objectId';

		$result = $db->prepare($sql);
		$result->bindParam(':objectId', $objectId, PDO::PARAM_INT);
		return $result->execute();
	}

	public static function getImage($id)
	{
		$noImage = '/template/images/no-image.jpg';

		$path = '/upload/images/objects/';

		$pathToObjectImage = $path . $id . '.jpg';

		if (file_exists($_SERVER['DOCUMENT_ROOT'].$pathToObjectImage)) {
			return $pathToObjectImage;
		}

		return $noImage;
	}

	public static function deleteImage($id)
	{
		$path = '/upload/images/objects/';

		$pathToObjectImage = $path . $id . '.jpg';

		if (file_exists($_SERVER['DOCUMENT_ROOT'].$pathToObjectImage))
			unlink($_SERVER['DOCUMENT_ROOT'].$pathToObjectImage);
	}

	public static function updateRating($objectId)
	{
		$db = Database::getConnection();

		$result = $db->query("
			SELECT AVG(comment.rating) AS avg
			FROM comment
			WHERE comment.object_id = $objectId
		");

		$avg = round($result->fetchColumn(), 1);

		$sql = "
			UPDATE object SET
				object.rating = :avg
			WHERE object.id = :object_id
		";

		$result = $db->prepare($sql);
		$result->bindParam(':object_id', $objectId, PDO::PARAM_INT);
		$result->bindParam(':avg', $avg);

		return $result->execute();
	}

	public static function getRating($objectId)
	{
		$db = Database::getConnection();

		$result = $db->query("
			SELECT object.rating
			FROM object
			WHERE object.id = $objectId
		");

		return $result->fetchColumn();
	}

	public static function getSelection($options)
	{
		$db = Database::getConnection();

		$sql_type = '';
		$sql_kitchen = '';
		$sql_service = '';

		$sql_fields = "
			SELECT DISTINCT
				object.id, 
				object.name,
				object.address,
				object.hours,
				object.rating,
				type.id AS type_id,
				type.name AS type
			FROM object
			JOIN type ON type.id = object.type_id
			JOIN object_kitchen on object_kitchen.object_id = object.id
			JOIN object_service on object_service.object_id = object.id
		";

		if (isset($options['type'])) {
			$type = $options['type'];
			$sql_type = "WHERE type.id = $type ";
		}

		if (isset($options['kitchen'])) {
			$kitchens = implode(', ', $options['kitchen']);
			$sql_kitchen = "AND object_kitchen.kitchen_id IN ($kitchens) ";
		}

		if (isset($options['service'])) {
			$services = implode(', ', $options['service']);
			$sql_service = "AND object_service.service_id IN ($services) ";
		}

		$sql = $sql_fields . $sql_type . $sql_kitchen . $sql_service;
		$result = $db->query($sql . "ORDER BY id DESC");

		$list = [];
		
		$i = 0;
		while ($row = $result->fetch()) {
			$list[$i]['id'] = $row['id'];
			$list[$i]['name'] = $row['name'];
			$list[$i]['address'] = $row['address'];
			$list[$i]['hours'] = $row['hours'];
			$list[$i]['rating'] = $row['rating'];
			$list[$i]['type_id'] = $row['type_id'];
			$list[$i]['type'] = $row['type'];
			$i++;
		}
		return $list;
	}

	/*SELECT comment.user_id, COUNT(comment.user_id) AS count
	FROM comment

	JOIN 
	(SELECT comment.object_id
		FROM comment 
		WHERE comment.user_id = 4
			AND comment.rating IN (4, 5)
		ORDER BY comment.rating DESC
		LIMIT 2) AS liked
	ON comment.object_id = liked.object_id

	WHERE comment.rating IN (4, 5)
		AND comment.user_id != 4
		
	GROUP BY comment.user_id
	HAVING count >= 2
	ORDER BY count DESC
	LIMIT 1*/

	public static function getLiked($userId, $count = 2)
	{
		$db = Database::getConnection();

		$result = $db->query("
			SELECT 
				object.id,
				object.name,
				object.address,
				object.hours,
				object.rating,
				type.name as type
			FROM object
			JOIN type ON type.id = object.type_id
			JOIN comment ON comment.user_id = $userId AND
				comment.object_id = object.id
			WHERE comment.rating > 3
			ORDER BY comment.rating DESC
			LIMIT $count
		");

		return $result->fetchAll(PDO::FETCH_ASSOC);
	}

	public static function getSimilarUser($userId, $objects)
	{
		$db = Database::getConnection();

		$result = null;

		return $result->fetchAll(PDO::FETCH_ASSOC);
	}

	public static function getRecommendations($userId, $count = 2)
	{
		$db = Database::getConnection();

		$recommendations = [];

		// 2 liked objects by user
		$result = $db->query("
			SELECT comment.object_id
			FROM comment 
			WHERE comment.user_id = $userId
				AND comment.rating IN (4, 5)
			ORDER BY comment.rating DESC
			LIMIT 2
		");

		$liked = $result->fetchAll(PDO::FETCH_COLUMN);
		$liked = implode(', ', $liked);

		// all rated objects by user
		$result = $db->query("
			SELECT comment.object_id
			FROM comment
			WHERE comment.user_id = $userId
		");

		$rated = $result->fetchAll(PDO::FETCH_COLUMN);
		$rated = implode(', ', $rated);

		// another user who also liked these 2 objects
		$result = $db->query("
			SELECT comment.user_id, COUNT(comment.user_id) AS count
			FROM comment

			WHERE comment.object_id IN ($liked)
				AND comment.rating IN (4, 5)
				AND comment.user_id != $userId

			GROUP BY comment.user_id
			HAVING count >= 2
			ORDER BY count DESC
			LIMIT 1
		");

		$similarUserId = $result->fetch(PDO::FETCH_COLUMN);

		// the other 2 objects that another user liked and not rated by the user
		$result = $db->query("
			SELECT comment.object_id
			FROM comment
			WHERE comment.user_id = 6
				AND comment.rating IN (4, 5)
				AND comment.object_id NOT IN ($rated)
			ORDER BY comment.rating DESC
			LIMIT 2
		");

		$recommendations = $result->fetchAll(PDO::FETCH_COLUMN);
		$recommendations = implode(', ', $recommendations);


		if (!empty($recommendations)) {

			// full information about this objects
			$result = $db->query("
				SELECT
					object.id,
					object.name,
					object.address,
					object.hours,
					object.rating,
					type.name as type
				FROM object
				JOIN type ON type.id = object.type_id
				WHERE object.id IN ($recommendations)
			");

			$recommendations = $result->fetchAll(PDO::FETCH_ASSOC);

			if (count($recommendations) >= 2)
				return $recommendations;

		}

		// top objects that are not rated by the user
		$result = $db->query("
			SELECT object.id
			FROM object
			WHERE object.id NOT IN ($rated)
			ORDER BY object.rating DESC
			LIMIT 2
		");

		$top = $result->fetchAll(PDO::FETCH_COLUMN);
		$top = implode(', ', $top);

		// full information about top objects
		$result = $db->query("
			SELECT
				object.id,
				object.name,
				object.address,
				object.hours,
				object.rating,
				type.name as type
			FROM object
			JOIN type ON type.id = object.type_id
			WHERE object.id IN ($top)
		");

		$topObjects = $result->fetchAll(PDO::FETCH_ASSOC);
		
		
		if (!empty($recommendations)) {
			$recommendations = array_merge($recommendations, $topObjects);

			if ($recommendations[0]['id'] == $recommendations[1]['id'])
				array_shift($recommendations);
		} else {
			$recommendations = $topObjects;
		}

		
		if (count($recommendations) > 2)
			array_splice($recommendations, 2);

		return $recommendations;
	}

}

?>