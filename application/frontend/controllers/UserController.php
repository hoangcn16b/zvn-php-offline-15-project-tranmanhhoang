<?php
class UserController extends Controller
{

	public function __construct($arrParams)
	{
		parent::__construct($arrParams);
		$this->_templateObj->setFolderTemplate('frontend/');
		$this->_templateObj->setFileTemplate('index.php');
		$this->_templateObj->setFileConfig('template.ini');
		$this->_templateObj->load();
	}

	public function profileAction()
	{
		$userInfor = Session::get('user');
		$logged = (($userInfor['login'] ?? false) == true && ((($userInfor['time'] ?? '') + TIME_LOGIN) >= time()));
		if ($logged == false) {
			URL::redirectLink('frontend', 'index', 'index');
		}
		$this->_view->titlePage = 'Profile User';
		$this->_view->render($this->_arrParam['controller'] . '/profile');
	}
}
