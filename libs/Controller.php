<?php
class Controller
{
	// View Object
	protected $_view;

	// Model Object
	protected $_model;

	// Template object
	protected $_templateObj;

	// Params (GET - POST)
	protected $_arrParam;

	//Params Pagination
	protected $_pagination = [
		'totalItemsPerPage' => 2,
		'pageRange' => 2
	];

	protected $_idLogged;
	protected $_groupAcpLogged;
	protected $_userLogged;

	public function __construct($arrParams)
	{
		$this->setModel($arrParams['module'], $arrParams['controller']);
		$this->setTemplate($this);
		$this->setView($arrParams['module']);
		$this->setUserLogged();
		$this->_pagination['currentPage'] = (isset($arrParams['page'])) ? $arrParams['page'] : 1;
		$arrParams['pagination'] = $this->_pagination;
		$arrParams['idLogged'] = $this->_idLogged;
		$arrParams['groupAcpLogged'] = $this->_groupAcpLogged;
		$arrParams['userLogged'] = $this->_userLogged;
		$this->setParams($arrParams);
		$this->_view->arrParams = $this->_arrParam;
	}

	// SET MODEL
	public function setModel($moduleName, $modelName)
	{
		$modelName = ucfirst($modelName) . 'Model';
		$path = APPLICATION_PATH . $moduleName . DS . 'models' .  DS . $modelName . '.php';
		if (file_exists($path)) {
			require_once $path;
			$this->_model	= new $modelName();
		}
	}

	// GET MODEL
	public function getModel()
	{
		return $this->_model;
	}

	// SET VIEW
	public function setView($moduleName)
	{
		$this->_view = new View($moduleName);
	}

	// GET VIEW
	public function getView()
	{
		return $this->_view;
	}

	// SET TEMPLATE
	public function setTemplate()
	{
		$this->_templateObj = new Template($this);
	}

	// GET TEMPLATE
	public function getTemplate()
	{
		return $this->_templateObj;
	}

	// SET PARAMS
	public function setParams($arrParam)
	{
		$this->_arrParam = $arrParam;
	}

	// GET PARAMS
	public function getParams($arrParam)
	{
		$this->_arrParam = $arrParam;
	}

	// GET Pagination
	public function setPagination($config)
	{
		$this->_pagination['totalItemsPerPage'] = $config['totalItemsPerPage'];
		$this->_pagination['pageRange'] = $config['pageRange'];
		$this->_arrParam['pagination'] = $this->_pagination;
		$this->_view->arrParams = $this->_arrParam;
	}

	public function setUserLogged()
	{
		if (Session::get('user')) {
			$userInfor = Session::get('user');
			$id = $userInfor['info']['id'];
			// $query = "
			// 			SELECT `u`.`id`, `fullname`, `username`, `email`, `birthday`, `address`, `phone`, `group_id`, `g`.`group_acp`
			// 			FROM `user` AS `u`, `group` AS `g`
			// 			WHERE `u`.`group_id` = `g`.`id` AND `u`.`id` = $id
			// 		";
			// $model = new Model();
			// $result = $model->singleRecord($query);

			$groupAcp = $userInfor['group_acp'] ?? '';

			$this->_idLogged = $id;
			$this->_groupAcpLogged = $groupAcp;
			$this->_userLogged = $userInfor['info'];
		}
	}
}
