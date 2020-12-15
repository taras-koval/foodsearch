<?php

class AdminController extends Controller
{

	public function __construct()
	{
		$userId = User::issetSession();

		if (User::isAdmin($userId)) {
			
			$this->title = 'Адміністрування Food Factory';
			return true;
		}

		header('HTTP/1.1 404 Not Found');
		header("Status: 404 Not Found");

		require_once(ROOT.'/views/main/404.php');
		exit();
	}

	public function actionObject_($page = 1)
	{
		$objects = Object_::getList($page);
		$total = Object_::getTotalObjects();

		$query = '';

		$count = Object_::SHOW_BYDEFAULT_ADMIN_LIST;

		if (isset($_POST['search'])) {

			$query = trim($_POST['query']);

			if (!empty($query)) {
				$objects = Object_::search($query, $page, $count);
				$total = Object_::getSearchTotal($query);
			}

		}
		
		$pagination = new Pagination($total, $page, $count, 'page-');

		require_once(ROOT.'/views/admin/object.php');
		return true;
	}

	public function actionObjectAdd() 
	{
		$result = false;
		
		$typesList = Type::getList();
		$kitchensList = Kitchen::getList();
		$servicesList = Service::getList();

		$form = Object_::getStartForm();

		$errors = false;


		if (isset($_POST['submit'])) {

			$form = $_POST;

			if (!Object_::isUniqueName($form['name']))
				$errors[] = "Заклад з такою назвою вже існує";

			if (!isset($form['kitchen']) || empty($form['kitchen']))
				$errors[] = "Не вибрано жодної кухні";

			if ($errors == false) {

				$result = Object_::add($form);

				foreach ($form['kitchen'] as $item)
					Object_::addKitchen($result, $item);

				if (isset($form['service']) || !empty($form['service']))
					foreach ($form['service'] as $item)
						Object_::addService($result, $item);
			}

			if ($result) {

				if (is_uploaded_file($_FILES["photo"]["tmp_name"])) {
					move_uploaded_file($_FILES["photo"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . "/upload/images/objects/{$result}.jpg");
				}

				unset($form);
				$form = Object_::getStartForm();
			}
			else {
				$errors[] = 'Database error';
			}
		}


		require_once(ROOT.'/views/admin/object_add.php');
		return true;
	}

	public function actionObjectEdit($id) 
	{
		$result = false;
		
		$typesList = Type::getList();
		$kitchensList = Kitchen::getList();
		$servicesList = Service::getList();

		$form = Object_::getObjectById($id);

		$form['id'] = $id;
		$form['kitchen'] = Object_::getKitchensList($id);
		$form['service'] = Object_::getServicesList($id);
		$form['type'] = $form['type_id'];


		if (isset($_POST['submit'])) {

			$form = $_POST;
			$form['id'] = $id;

			$errors = false;

			if (!isset($form['kitchen']) || empty($form['kitchen']))
				$errors[] = "Не вибрано жодної кухні";

			if ($errors == false) {

				$result = Object_::edit($id, $form);

				Object_::deleteAllKitchens($id);
				Object_::deleteAllServices($id);

				foreach ($form['kitchen'] as $item)
					Object_::addKitchen($id, $item);

				if (isset($form['service']) || !empty($form['service']))
					foreach ($form['service'] as $item)
						Object_::addService($id, $item);
			}

			if ($result) {

				if (is_uploaded_file($_FILES["photo"]["tmp_name"])) {
					// Object_::deleteImage($id);
					move_uploaded_file($_FILES["photo"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . "/upload/images/objects/{$id}.jpg");
				}

			}
			else {
				$errors[] = 'Database error';
			}
		}
		

		require_once(ROOT.'/views/admin/object_edit.php');
		return true;
	}

	public function actionObjectDelete($id)
	{
		Object_::deleteObjectById($id);
		Object_::deleteImage($id);

		header("Location: /admin/object/");
		return true;
	}

	public function actionKitchen() 
	{
		$name = '';
		$result = false;

		$kitchens = Kitchen::getList();

		if (isset($_POST['submit'])) {

			$name = $_POST['name'];
			$errors = false;

			if (empty(trim($name))) {
				$errors[] = 'Заповніть поле';
				$name = '';
			}

			if (Kitchen::find($name))
				$errors[] = 'Помилка унікальності';

			if ($errors == false) {
				$result = Kitchen::add($name);
				$name = '';
			}

			if (!$result)
				$errors[] = 'Помилка БД';
		}

		unset($kitchens);
		$kitchens = Kitchen::getList();

		require_once(ROOT.'/views/admin/kitchen.php');
		return true;
	}

	public function actionKitchenDelete($id) {

		Kitchen::delete($id);

		header("Location: /admin/kitchen/");
		return true;
	}

	public function actionService() 
	{
		$name = '';
		$result = false;

		$services = Service::getList();

		if (isset($_POST['submit'])) {

			$name = $_POST['name'];
			$errors = false;

			if (Service::find($name))
				$errors[] = 'Помилка унікальності';

			if (empty(trim($name))) {
				$errors[] = 'Заповніть поле';
				$name = '';
			}

			if ($errors == false) {
				$result = Service::add($name);
				$name = '';
			}

			if (!$result)
				$errors[] = 'Помилка БД';
		}

		unset($services);
		$services = Service::getList();

		require_once(ROOT.'/views/admin/service.php');
		return true;
	}

	public function actionServiceDelete($id) {

		Service::delete($id);

		header("Location: /admin/service/");
		return true;
	}

	public function actionType() 
	{
		$name = '';
		$result = false;

		$types = Type::getList();

		if (isset($_POST['submit'])) {

			$name = $_POST['name'];
			$errors = false;

			if (Type::find($name))
				$errors[] = 'Помилка унікальності';

			if (empty(trim($name))) {
				$errors[] = 'Заповніть поле';
				$name = '';
			}

			if ($errors == false) {
				$result = Type::add($name);
				$name = '';
			}

			if (!$result)
				$errors[] = 'Помилка БД';
		}

		unset($types);
		$types = Type::getList();

		require_once(ROOT.'/views/admin/type.php');
		return true;
	}

	public function actionTypeDelete($id) {

		Type::delete($id);

		header("Location: /admin/type/");
		return true;
	}

}

?>