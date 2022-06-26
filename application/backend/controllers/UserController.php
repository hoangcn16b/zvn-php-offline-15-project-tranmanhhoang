<?php
class UserController extends Controller
{

	public function __construct($arrParams)
	{
		// $userInfor = Session::get('user');
		// $logged = (($userInfor['login'] ?? false) == true && ((($userInfor['time'] ?? '') + TIME_LOGIN) >= time()));
		// if ($logged == false) {
		// 	URL::redirectLink('backend', 'index', 'login');
		// }
		parent::__construct($arrParams);
		$this->_templateObj->setFolderTemplate('backend/');
		$this->_templateObj->setFileTemplate('index.php');
		$this->_templateObj->setFileConfig('template.ini');
		$this->_templateObj->load();
	}

	public function indexAction()
	{
		$configPagination = ['totalItemsPerPage' => 4, 'pageRange' => 3];
		$this->setPagination($configPagination);
		$this->_view->items = $this->_model->listItems($this->_arrParam);
		$this->_view->filterStatus = $this->_model->filterStatusFix($this->_arrParam);
		$this->_view->filterGroupUser = $this->_model->getAdminAcp($this->_arrParam, false, true);
		$this->_view->listGroup = $this->_model->getAdminAcp($this->_arrParam, false, false);
		$this->_view->listGroupExcept = $this->_model->getAdminAcp($this->_arrParam, true, false);
		$this->totalItems = $this->_model->countItem($this->_arrParam);
		$this->_view->pagination = new Pagination($this->totalItems, $this->_pagination);
		$this->_view->render($this->_arrParam['controller'] . '/index');
	}

	public function ajaxStatusAction()
	{
		$result = $this->_model->changeStatus($this->_arrParam);
		echo $result;
		// echo json_encode($result);
	}

	public function ajaxGroupAction()
	{
		$result = $this->_model->changeGroupUser($this->_arrParam);
		echo $result;
	}

	public function deleteAction()
	{
		if (isset($this->_arrParam['id'])) {
			$this->_model->deleteItem($this->_arrParam['id']);
			// Session::set('message', ['content' => 'Xoá thành công']);
		} else {
			$this->_view->render($this->_arrParam['controller'] . '/error');
		}
		URL::redirectLink($this->_arrParam['module'], $this->_arrParam['controller'], 'index');
	}

	public function formAction()
	{
		$this->_view->listGroupExcept = $this->_model->getAdminAcp($this->_arrParam, true, false);
		$this->_view->setTitleForm = 'Add User Admin';
		$data = null;
		$task = 'add';
		if (isset($this->_arrParam['id'])) {
			$this->_view->setTitleForm = 'Edit User Admin';
			$data = $this->_model->checkItem($this->_arrParam);
			if (empty($data)) {
				URL::redirectLink($this->_arrParam['module'], $this->_arrParam['controller'], 'index');
			}
			$task = 'edit';
			$addGroupId = $this->_model->getNameByGroupId($data['group_id']);
			$data['group'] = $addGroupId['name'];
		}
		if (!empty($this->_arrParam['form'])) {
			$data = $this->_arrParam['form'];
			if ($task = 'edit') {
				$data['modified_by'] = $this->_arrParam['userLogged']['username'];
			} else {
				$data['created'] = $this->_arrParam['userLogged']['username'];
			}
			$validate = new Validate($data);

			$query[] = "SELECT `username`, `email` from `user` ";
			$query[] = "WHERE `username` = '{$data['username']}' OR `email` = '{$data['email']}'";
			$query = implode(" ", $query);
			$required = $task == 'add' ? true : false;
			$validate->addRule('fullname', 'string', ['min' => 0, 'max' => 30], false)
				->addRule('username', 'string-notExistRecord', ['min' => 3, 'max' => 20, 'database' => $this->_model, 'query' => $query, 'required' => $required])
				->addRule('email', 'email-notExistRecord', ['min' => 3, 'max' => 20, 'database' => $this->_model, 'query' => $query, 'required' => $required])
				->addRule('status', 'select')
				->addRule('group_id', 'select');
			if (isset($data['password'])) {
				$validate->addRule('password', 'password', ['action' => $task]);
			}
			$validate->run();
			$data = $validate->getResult();
			if ($validate->isValid()) {

				$this->_model->saveItem($data, ['task' => $task]);
				URL::redirectLink($this->_arrParam['module'], $this->_arrParam['controller'], 'index');
			} else {
				$this->_view->errors = $validate->showErrors();
			}
		}

		$this->_view->outPut = $data;
		$this->_view->render($this->_arrParam['controller'] . '/form');
	}

	public function changePasswordAction()
	{
		if (isset($this->_arrParam['id'])) {
			$this->_view->setTitleForm = 'Change User Password';
			$data = $this->_model->checkItem($this->_arrParam);
			if (empty($data)) {
				URL::redirectLink($this->_arrParam['module'], $this->_arrParam['controller'], 'index');
			}
		}
		if (!empty($this->_arrParam['form'])) {
			$data = $this->_arrParam['form'];
			$data['modified_by'] = $this->_arrParam['userLogged']['username'];
			$validate = new Validate($data);
			$validate->addRule('password', 'password', ['action' => 'add']);
			$validate->run();
			$data = $validate->getResult();
			if ($validate->isValid()) {
				$this->_model->savePassword($data);
				URL::redirectLink($this->_arrParam['module'], $this->_arrParam['controller'], 'index');
			} else {
				$this->_view->errors = $validate->showErrors();
			}
		}
		$data['password'] = '';
		$this->_view->outPut = $data;
		$this->_view->render($this->_arrParam['controller'] . '/form-password');
	}

	public function myPasswordAction()
	{
		$this->_view->outPut = $this->_arrParam['userLogged'];
		$this->_view->setTitleForm = 'Change My Password';
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
		$this->_view->render($this->_arrParam['controller'] . '/chang-my-password');
	}

	// if (($data['password'] == $data['new password']) || ($data['password'] !== $data['new password confirm'])) {
	// 	$errorsPassword = 'Mật khẩu cũ và mới không được phép trùng!';
	// } elseif ($data['new password'] !== $data['new password confirm']) {
	// 	$errorsPassword = 'Nhập lại mật khẩu không trùng khớp!';
	// }

	// public function clearAction()
	// {
	// 	// Session::unset('keyword');
	// 	URL::redirectLink('backend', 'Group', 'index');
	// }
}
