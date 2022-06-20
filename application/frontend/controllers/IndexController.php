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
		if (!empty($this->_arrParam['form'])) {
			$data = $this->_arrParam['form'];
			$validate = new Validate($data);
			$email	= $data['email'];
			$password	= md5($data['password']);

			$query[] = "SELECT `username`, `fullname`, `email` FROM `user`";
			$query[] = "WHERE `email` = '" . $email . "' AND `password` = '" . $password . "' AND `status` = 'active' ";

			echo $query = implode(" ", $query);
			$this->_view->query = $query;
			$validate->addRule('email', 'email')
				->addRule('email', 'notExistRecord', ['database' => $this->_model, 'query' => $query], true)
				->addRule('password', 'string-notExistRecord', ['min' => 4, 'max' => 20, 'database' => $this->_model, 'query' => $query], true);
			$validate->run();
			$data = $validate->getResult();
			if ($validate->isValid()) {

				// $this->_model->saveItem($data, ['task' => 'add']);
				// URL::redirectLink($this->_arrParam['module'], $this->_arrParam['controller'], 'index');
			} else {

				$this->_view->errors = $validate->showErrors();
			}
		}
		$this->_view->outPut = $data;
		$this->_view->render($this->_arrParam['controller'] . '/login');
	}

	public function registerAction()
	{
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
}
