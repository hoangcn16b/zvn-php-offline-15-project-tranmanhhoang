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
				$this->_view->errors = $validate->showErrors();
			}
		}
		$this->_view->render($this->_arrParam['controller'] . '/login');
	}

	public function indexAction()
	{
		$this->_templateObj->setFileTemplate('index.php');
		$this->_templateObj->load();
		$this->_view->total = $this->_model->countTotalToIndex();
		echo '<pre>';
		print_r($_SESSION);
		echo '</pre>';
		$this->_view->render($this->_arrParam['controller'] . '/index');
	}
}
