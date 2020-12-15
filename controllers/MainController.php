<?php

class MainController extends Controller
{

	public function actionIndex()
	{
		$objects = [];
		$query = '';

		if (isset($_POST['search'])) {

			$query = trim($_POST['query']);

			if (!empty($query)) {

				$objects = Object_::search($query);

				for ($i = 0; $i < count($objects); $i++) {
					$kitchensList = Object_::getKitchensAsArray($objects[$i]['id']);
					$objects[$i]['kitchen'] = implode(", ", $kitchensList);
				}
			}
		}
		
		require_once(ROOT.'/views/main/index.php');
		return true;
	}

	public function actionNotFound()
	{
		header('HTTP/1.1 404 Not Found');
		header("Status: 404 Not Found");

		require_once(ROOT.'/views/main/404.php');
		return true;
	}

}

?>