<?php

class UserController extends Controller
{
	public function __construct()
	{
		$this->title = 'Особистий кабінет - Food Factory';

	}

	public function actionIndex()
	{
		// Get user ID from session
		// $userId = User::issetSession();

		// Get information about the user from the database
		// $user = User::getUserDataById($userId);

		if (!User::issetSession()) {
			header("Location: /login/");
			return true;
		}

		require_once(ROOT.'/views/user/index.php');
		return true;
	}

	public function actionRegister()
	{
		if (User::issetSession()) {
			header("Location: /user/");
			return true;
		}

		$this->title = 'Реєстрація користувача - Food Factory';
		
		$username = '';
		$email = '';
		$password = '';
		$confirm = '';
		$result = false;

		if (isset($_POST['submit'])) {

			$username = $_POST['username'];
			$email = $_POST['email'];
			$password = $_POST['password'];
			$confirm = $_POST['confirm'];

			$errors = false;
			// Data validation

			if (User::findEmail($email))
				$errors[] = 'Такий e-mail вже зареєстрований в системі';

			if ($password != $confirm)
				$errors[] = 'Паролі не співпадають';

			if ($errors == false)
				$result = User::register($username, $email, $password);

			if (!$result) {
				$errors[] = 'Помилка реєстрації';
			}
			else {
				$userId = User::login($email, $password);
				User::setSession($userId);
				header("Location: /user/");
			}

		}

		require_once(ROOT.'/views/user/register.php');
		return true;
	}

	public function actionLogin()
	{
		if (User::issetSession()) {
			header("Location: /user/");
			return true;
		}

		$this->title = 'Авторизація користувача - Food Factory';

		$email = '';
		$password = '';

		if (isset($_POST['submit'])) {

			$email = $_POST['email'];
			$password = $_POST['password'];

			$errors = false;
			// Data validation

			$userId = User::login($email, $password);

			if ($userId == false) {
				$errors[] = 'Невірний e-mail або пароль';
			}
			else {
				User::setSession($userId);
				header("Location: /user/");
			}
		}

		require_once(ROOT.'/views/user/login.php');
		return true;
	}

	public function actionEdit() 
	{
		if (!User::issetSession()) {
			header("Location: /login/");
			return true;
		}

		$username = '';
		$email = '';
		$result = false;

		$form['username'] = $_SESSION['user']['username'];
		$form['email'] = $_SESSION['user']['email'];

		if (isset($_POST['submit'])) {

			$form = $_POST;

			$username = $_POST['username'];
			$email = $_POST['email'];

			$errors = false;

			if ($email != $_SESSION['user']['email'])
				if (User::findEmail($email))
					$errors[] = 'Такий e-mail вже зареєстрований в системі';

			if ($errors == false) {
				$result = User::updateUserData($_SESSION['user']['id'], $username, $email);
				User::resetSession($_SESSION['user']['id']);
			}

			if (!$result)
				$errors[] = 'Помилка бази даних';
		}

		require_once(ROOT.'/views/user/edit.php');
		return true;
	}

	public function actionPassword()
	{
		if (!User::issetSession()) {
			header("Location: /login/");
			return true;
		}

		$password = '';
		$new_password = '';
		$confirm = '';
		$result = false;

		if (isset($_POST['submit'])) {

			$password = $_POST['password'];
			$new_password = $_POST['new_password'];
			$confirm = $_POST['confirm'];

			$errors = false;

			if ($password != User::getUserPasswordById($_SESSION['user']['id']))
				$errors[] = 'Невірний старий пароль';

			if ($new_password != $confirm)
				$errors[] = 'Новий пароль і підтвердження не співпадають';

			if ($errors == false)
				$result = User::updatePassword($_SESSION['user']['id'], $new_password);

			if (!$result)
				$errors[] = 'Помилка бази даних';
		}

		require_once(ROOT.'/views/user/password.php');
		return true;
	}

	public function actionFavorite($page = 1) 
	{
		if (!User::issetSession()) {
			header("Location: /login/");
			return true;
		}

		$favorites = User::getFavoriteList($_SESSION['user']['id'], $page);

		for ($i = 0; $i < count($favorites); $i++)
			$favorites[$i]['kitchen'] = Object_::getKitchensAsString($favorites[$i]['id']);

		$total = User::getTotalFavorites($_SESSION['user']['id']);
		$pagination = new Pagination($total, $page, Object_::SHOW_BYDEFAULT, 'page-');

		require_once(ROOT.'/views/user/favorite.php');
		return true;
	}

	public function actionFavoriteAdd($objectId)
	{
		if (!User::issetSession()) {
			header("Location: /login/");
			return true;
		}

		if (User::isFavorite($_SESSION['user']['id'], $objectId)) {
			header("Location: /object/$objectId");
		} else {
			User::addToFavorite($_SESSION['user']['id'], $objectId);
			header("Location: /object/$objectId");
		}

		return true;
	}

	public function actionFavoriteDelete($objectId)
	{
		if (!User::issetSession()) {
			header("Location: /login/");
			return true;
		}
		
		if (User::isFavorite($_SESSION['user']['id'], $objectId)) {
			User::deleteFavorite($_SESSION['user']['id'], $objectId);
			header("Location: /object/$objectId");
		} else {
			header("Location: /object/$objectId");
		}

		return true;
	}

	public function actionDeleteComment($objectId, $commentId)
	{
		if (!User::issetSession()) {
			header("Location: /login/");
			return true;
		}

		if (Comment::isOwner($commentId, $_SESSION['user']['id']) ||
				User::isAdmin($_SESSION['user']['id'])) {
			
			Comment::delete($commentId);
			Object_::updateRating($objectId);
		}

		header("Location: /object/$objectId/");
		return true;
	}

	public function actionLogout()
	{
		User::unsetSession();
		header("Location: /login/");
		return true;
	}
}

?>