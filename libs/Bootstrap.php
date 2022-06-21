<?php
class Bootstrap
{

	private $_params;
	private $_controllerObject;

	public function init()
	{
		$this->setParam();

		$controllerName	= ucfirst($this->_params['controller']) . 'Controller';
		$filePath	= APPLICATION_PATH . $this->_params['module'] . DS . 'controllers' . DS . $controllerName . '.php';

		if (file_exists($filePath)) {
			$this->loadExistingController($filePath, $controllerName);
			$this->callMethod();
		} else {
			URL::redirectLink('frontend', 'index', 'error', ['type' => 'file_not_exist']);
		}
	}

	// CALL METHODE
	private function callMethod()
	{
		$actionName = $this->_params['action'] . 'Action';
		if (method_exists($this->_controllerObject, $actionName) == true) {
			$module = $this->_params['module'];
			$controller = $this->_params['controller'];
			$action = $this->_params['action'];
			$userInfor = Session::get('user');
			// Session::unset('user');

			$logged = (($userInfor['login'] ?? false) == true && ((($userInfor['time'] ?? '') + TIME_LOGIN) >= time()));
			// $pageLogin = ($controller == 'index' && $action == 'login');
			if ($module == 'backend') {
				if ($logged == true) {
					if ($userInfor['group_acp'] == 1) {
						$this->_controllerObject->$actionName();
						// if ($pageLogin == true) URL::redirectLink('backend', 'index', 'index');
						// if ($pageLogin == false) $this->_controllerObject->$actionName();
					} else {
						Session::unset('user');
						URL::redirectLink('frontend', 'index', 'error', ['type' => 'decline']);
					}
				} else {
					Session::unset('user');
					$this->callLoginAction($module);
					// if ($pageLogin == true) $this->_controllerObject->$actionName();
					// if ($pageLogin == false) URL::redirectLink($module, 'index', 'login');
				}
			} elseif ($module == 'frontend') {
				if ($controller == 'user') {
					if ($logged == true) {
						$this->_controllerObject->$actionName();
					} else {
						Session::unset('user');
						$this->callLoginAction($module);
					}
				}
				$this->_controllerObject->$actionName();
			}
		} else {
			URL::redirectLink('frontend', 'index', 'error', ['type' => 'file_not_exist']);
			// $this->_error();
		}
	}

	// SET PARAMS
	public function setParam()
	{
		$this->_params 	= array_merge($_GET, $_POST);
		$this->_params['module'] 		= isset($this->_params['module']) ? $this->_params['module'] : DEFAULT_MODULE;
		$this->_params['controller'] 	= isset($this->_params['controller']) ? $this->_params['controller'] : DEFAULT_CONTROLLER;
		$this->_params['action'] 		= isset($this->_params['action']) ? $this->_params['action'] : DEFAULT_ACTION;
	}

	// CALL ACTION LOGIN
	private function callLoginAction($module = 'frontend')
	{
		require_once APPLICATION_PATH . $module . DS . 'controllers' . DS  . 'IndexController.php';
		$indexController = new IndexController($this->_params);
		$indexController->loginAction();
	}

	// LOAD EXISTING CONTROLLER
	private function loadExistingController($filePath, $controllerName)
	{
		require_once $filePath;
		$this->_controllerObject = new $controllerName($this->_params);
	}

	// ERROR CONTROLLER
	public function _error()
	{
		require_once APPLICATION_PATH . 'default' . DS . 'controllers' . DS . 'ErrorController.php';
		$this->_controllerObject = new ErrorController();
		$this->_controllerObject->setView('default');
		$this->_controllerObject->indexAction();
	}
}
