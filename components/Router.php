<?php

class Router
{
	private $routes;

	public function __construct()
	{
		$routesPath = ROOT.'/config/routes.php';
		$this->routes = include($routesPath);
	}

	// Returns request string
	private function getURI()
	{
		if (!empty($_SERVER['REQUEST_URI']))
			return trim($_SERVER['REQUEST_URI'], '/');
	}

	public function run()
	{
		$uri = $this->getURI();

		// Check request uri in routes.php
		foreach($this->routes as $uriPattern => $path) {

			// Compare $uriPattern and $uri
			if (preg_match("~^$uriPattern$~", $uri)) {

				// Get internal route
				$internalRoute = preg_replace("~$uriPattern~", $path, $uri);


				$segments = explode('/', $internalRoute);

				// Get controller name
				$controllerName = ucfirst(array_shift($segments).'Controller');
				// Get action name
				$actionName = 'action'.ucfirst(array_shift($segments));
				// Get parameters for action
				$parameters = $segments;


				// Include controller class file
				$controllerFile = ROOT.'/controllers/'.$controllerName.'.php';

				if (file_exists($controllerFile))
					include_once($controllerFile);
				else
					die("The file $controllerFile does not exists");

				// Create controller object, call action
				$controllerObject = new $controllerName;
				

				$result = call_user_func_array(
					array($controllerObject, $actionName), 
					$parameters
				);


				if ($result != null)
					break;
			}

		}
	}

	
}

?>