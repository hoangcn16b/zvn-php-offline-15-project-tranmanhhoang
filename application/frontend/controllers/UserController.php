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
		$this->_view->titlePage = 'Thông Tin Tài khoản';

		$this->_view->profileUser = $this->_userLogged;
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
				// $this->_view->test = $data;
				URL::redirectLink($this->_arrParam['module'], $this->_arrParam['controller'], 'profile');
			} else {
				$this->_view->errors = $validate->showErrors();
			}
		}
		$this->_view->outPut = $data;

		$this->_view->render($this->_arrParam['controller'] . '/profile');
	}

	public function passwordAction()
	{
		$this->_view->titlePage = 'Change My Password';
		// $this->_view->outPut = $this->_arrParam['userLogged'];
		$data = [];

		if (!empty($this->_arrParam['form'])) {
			$data = $this->_arrParam['form'];
			$password = md5($data['password']);
			$queryPass = "SELECT `id` FROM `" . TABLE_USER . "` WHERE `id` = '" . $data['id'] . "' AND `password` = '" . $password . "'";
			$validate = new Validate($data);
			$errorsPassword = '';

			if (empty($data['password']) || empty($data['new password']) || empty($data['new password confirm'])) {
				$errorsPassword = 'Không được phép bỏ trống các trường!';
			} else {
				if (($data['new password'] == $data['new password confirm'])) {
					if (($data['password'] == $data['new password']) || ($data['password'] == $data['new password confirm'])) {
						$errorsPassword = 'Mật khẩu cũ và mới không được phép trùng!';
					}
				} else {
					$errorsPassword = 'Nhập lại mật khẩu không trùng khớp!';
				}
			}
			if (empty($errorsPassword)) {
				$validate->addRule('password', 'string-existRecord', ['min' => 4, 'max' => 20, 'database' => $this->_model, 'query' => $queryPass, 'required' => true]);
				$validate->addRule('new password', 'password', ['action' => 'add'])
					->addRule('new password confirm', 'password', ['action' => 'add']);
				$validate->run();
				$errorsPassword = $validate->showErrors();
			}
			if ($validate->isValid() && empty($errorsPassword)) {
				unset($data['password']);
				unset($data['new password confirm']);
				$result = $this->_model->changeMyPassword($data);
				if ($result) {
					Session::set('messageChangePass', ['class' => 'success', 'content' => CHANGEPASS_SUCCESS]);
					Session::unset('user');
					URL::redirectLink($this->_arrParam['module'], 'index', 'login');
				}
			} else {
				$this->_view->errors = $errorsPassword;
			}
		}
		$data['password'] = '';
		$this->_view->render($this->_arrParam['controller'] . '/password');
	}

	public function activeAccountAction()
	{
		echo '<pre>';
		print_r($this->_arrParam);
		echo '</pre>';
		$this->_view->render('index/index');
	}
}
