<?php
class IndexController extends Controller
{

	public function __construct($arrParams)
	{
		parent::__construct($arrParams);
		$this->_templateObj->setFolderTemplate('frontend/');
		$this->_templateObj->setFileTemplate('index.php');
		$this->_templateObj->setFileConfig('template.ini');
		$this->_templateObj->load();
	}

	public function indexAction()
	{
		$this->_view->render($this->_arrParam['controller'] . '/index');
	}

	public function loginAction()
	{
		$this->_view->titlePage = 'Đăng Nhập';
		$data = null;
		$userInfor = Session::get('user');
		$logged = (($userInfor['login'] ?? false) == true && ((($userInfor['time'] ?? '') + TIME_LOGIN) >= time()));
		if ($logged) {
			URL::redirectLink('frontend', 'user', 'profile');
		}

		if (!empty($this->_arrParam['form']['submit'])) {
			$data = $this->_arrParam['form'];
			$validate = new Validate($data);
			$email = $data['email'];
			$password = md5($data['password']);
			$queryEmail = "SELECT `id` FROM `" . TABLE_USER . "` WHERE `email` = '$email'";
			$query = "SELECT `id` FROM `" . TABLE_USER . "` WHERE `email` = '$email' AND `password` = '$password' ";
			$validate->addRule('email', 'email-existRecord', ['database' => $this->_model, 'query' => $queryEmail, 'required' => true])
				->addRule('password', 'string-existRecord', ['min' => 4, 'max' => 20, 'database' => $this->_model, 'query' => $query, 'required' => true]);
			$validate->run();
			if ($validate->isValid()) {
				unset($data['submit']);
				$inforUser = $this->_model->inforItem($data);
				$arrSession = [
					'login' => true,
					'info' => $inforUser,
					'time' => time(),
					'group_acp' => $inforUser['group_acp']
				];
				Session::set('user', $arrSession);
				URL::redirectLink($this->_arrParam['module'], 'index', 'index');
			} else {
				$this->_view->errors = $validate->showErrors();
			}
		}
		$this->_view->outPut = $data;
		$this->_view->render($this->_arrParam['controller'] . '/login');
	}

	public function registerAction()
	{
		$userInfor = Session::get('user');
		$logged = (($userInfor['login'] ?? false) == true && ((($userInfor['time'] ?? '') + TIME_LOGIN) >= time()));
		if ($logged) {
			URL::redirectLink('frontend', 'user', 'profile');
		}
		$this->_view->titlePage = 'Đăng ký tài khoản';
		$data = null;
		if (!empty($this->_arrParam['form'])) {
			$data = $this->_arrParam['form'];
			$validate = new Validate($data);
			$email	= $data['email'];
			$username = $data['username'];
			$password	= md5($data['password']);
			$queryUser = "SELECT * FROM `user` WHERE `username` = '$username'";
			$queryEmail = "SELECT * FROM `user` WHERE `email` = '$email'";

			$validate
				->addRule('username', 'string-notExistRecord', ['min' => 4, 'max' => 20, 'database' => $this->_model, 'query' => $queryUser])
				->addRule('email', 'email-notExistRecord', ['database' => $this->_model, 'query' => $queryEmail])
				->addRule('password', 'password', ['action' => 'add']);

			$validate->run();
			$data = $validate->getResult();
			if ($validate->isValid()) {
				$this->_model->saveItem($data, ['task' => 'add']);
				Session::set('messageRegister', ['class' => 'success', 'content' => REGISTER_SUCCESS]);
				URL::redirectLink($this->_arrParam['module'], $this->_arrParam['controller'], 'login');
			} else {
				$this->_view->errors = $validate->showErrors();
			}
		}
		$this->_view->outPut = $data;
		$this->_view->render($this->_arrParam['controller'] . '/register');
	}

	public function errorAction()
	{
		$this->_view->render('error/error');
	}

	public function logoutAction()
	{
		Session::unset('user');
		URL::redirectLink($this->_arrParam['module'], $this->_arrParam['controller'], 'index');
	}
}