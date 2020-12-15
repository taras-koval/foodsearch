<?php

class ObjectController extends Controller
{

	public function actionIndex($page = 1)
	{
		$objects = Object_::getLatestObjects($page);

		for ($i = 0; $i < count($objects); $i++)
			$objects[$i]['kitchen'] = Object_::getKitchensAsString($objects[$i]['id']);

		$total = Object_::getTotalObjects();
		$pagination = new Pagination($total, $page, Object_::SHOW_BYDEFAULT, 'page-');
		
		require_once(ROOT.'/views/object/index.php');
		return true;
	}

	public function actionView($objectId, $page = 1)
	{
		$object = Object_::getObjectById($objectId);

		if (!$object) {
			header('HTTP/1.1 404 Not Found');
			header("Status: 404 Not Found");

			require_once(ROOT.'/views/main/404.php');
			return true;
		}

		$object['type'] = Type::getItemById($object['type_id'])['name'];

		$object['kitchen'] = Object_::getKitchensAsString($objectId);
		$object['service'] = Object_::getServicesAsString($objectId);

		if (!isset($object['service']) || empty($object['service']))
			$object['service'] = '-';

		$isFavorite = false;

		if (User::issetSession())
			if (User::isFavorite($_SESSION['user']['id'], $objectId))
				$isFavorite = true;

		$result = false;
		$errors = false;

		$form['rating'] = '';
		$form['comment'] = '';

		if (isset($_POST['submit'])) {

			if (!User::issetSession()) {
				header("Location: /login/");
				return true;
			}

			$form = $_POST;

			if (empty($form['rating'])) {
				$errors[] = "Оберіть оцінку для закладу";
				$form['rating'] = '';
			}

			if (empty($form['comment'])) {
				$errors[] = "Заповніть поле відгуку";
				$form['comment'] = '';
			}

			if ($errors == false) {

				if ($commentntExistence = Comment::existence($_SESSION['user']['id'], $objectId))
					Comment::delete($commentntExistence);

				$result = Comment::create($_SESSION['user']['id'], 
					$objectId, 
					$form['comment'],
					$form['rating']
				);

				if (!$result)
					$errors[] = 'Database error';

				$result = Object_::updateRating($objectId);
				$object['rating'] = Object_::getRating($objectId);

				if (!$result)
					$errors[] = 'Database error';
			}

			if ($errors == false) {
				unset($form);
				$form['rating'] = '';
				$form['comment'] = '';
			}
		}

		$userComment = false;

		if (User::issetSession()) {
			if ($commentExistence = Comment::existence($_SESSION['user']['id'], $objectId))
				$userComment = Comment::get($commentExistence);
		}

		$comments = Comment::read($objectId, $page);

		$total = Comment::count($objectId);
		$pagination = new Pagination($total, $page, Comment::SHOW_BYDEFAULT, 'page-');
		
		require_once(ROOT.'/views/object/view.php');
		return true;
	}

	public function actionSelection()
	{
		$typesList = Type::getList();
		$kitchensList = Kitchen::getList();
		$servicesList = Service::getList();

		$objects = [];

		$form['type'] = '';

		if (isset($_POST['submit'])) {

			$form = $_POST;

			$objects = Object_::getSelection($form);

			for ($i = 0; $i < count($objects); $i++) {
				$kitchens = Object_::getKitchensAsArray($objects[$i]['id']);
				$objects[$i]['kitchen'] = implode(", ", $kitchens);
			}
		}

		require_once(ROOT.'/views/object/selection.php');
		return true;
	}

	public function actionRecommendations()
	{
		$liked = [];
		$recommendations = [];

		if (!User::issetSession()) {
			require_once(ROOT.'/views/object/recommendations.php');
			return true;
		}

		$liked = Object_::getLiked($_SESSION['user']['id']);

		for ($i = 0; $i < count($liked); $i++)
			$liked[$i]['kitchen'] = Object_::getKitchensAsString($liked[$i]['id']);

		if (isset($_POST['submit'])) {

			$recommendations = Object_::getRecommendations($_SESSION['user']['id']);

			for ($i = 0; $i < count($recommendations); $i++)
				$recommendations[$i]['kitchen'] = Object_::getKitchensAsString($recommendations[$i]['id']);
		}
		
		require_once(ROOT.'/views/object/recommendations.php');
		return true;
	}

}

?>