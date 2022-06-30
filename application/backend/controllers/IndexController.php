<?php
class IndexController extends Controller
{

	public function __construct($arrParams)
	{
		parent::__construct($arrParams);
		$this->_templateObj->setFolderTemplate('backend/');
		$this->_templateObj->setFileTemplate('login.php');
		$this->_templateObj->setFileConfig('template.ini');
		$this->_templateObj->load();
	}

	public function loginAction()
	{

		$userInfor = Session::get('user');
		$logged = (($userInfor['login'] ?? false) == true && ((($userInfor['time'] ?? '') + TIME_LOGIN) >= time()));
		if ($logged) {
			URL::redirectLink('backend', 'index', 'index');
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
				URL::redirectLink($this->_arrParam['module'], $this->_arrParam['controller'], 'index');
			} else {
				// $errors = $validate->showErrors();
				$this->_view->errors = 'Email or password is invalid!';
			}
		}
		$this->_view->render($this->_arrParam['controller'] . '/login');
	}

	public function indexAction()
	{

		$this->_templateObj->setFileTemplate('index.php');
		$this->_templateObj->load();
		$this->_view->total = $this->_model->countTotalToIndex();
		$this->_view->render($this->_arrParam['controller'] . '/index');
	}

	public function profileAction()
	{
		$this->_view->setTitleForm = 'Profile User';
		
		$this->_view->profileUser = $this->_userLogged;
		$this->_templateObj->setFileTemplate('index.php');
		$this->_templateObj->load();
		$data = $this->_userLogged;
		if (!empty($this->_arrParam['form'])) {
			$data = $this->_arrParam['form'];
			$validate = new Validate($data);
			$nowDate = date('Y-m-d', time());
			$validate->addRule('fullname', 'string', ['min' => 0, 'max' => 30], false)
				->addRule('birthday', 'date', ['start' => '1900-01-01', 'end' => $nowDate], false)
				->addRule('phone', 'phone', ['required' => true], false)
				->addRule('address', 'string', ['min' => 0, 'max' => 255], false);
			$validate->run();
			$data = $validate->getResult();
			if ($validate->isValid()) {
				$this->_model->saveProfile($data);
				URL::redirectLink($this->_arrParam['module'], $this->_arrParam['controller'], 'profile');
			} else {
				$this->_view->errors = $validate->showErrors();
			}
		}
		$this->_view->outPut = $data;
		$this->_view->render('index/profile');
	}

	public function logoutAction()
	{
		Session::unset('user');
		URL::redirectLink($this->_arrParam['module'], 'index', 'login');
	}
}
