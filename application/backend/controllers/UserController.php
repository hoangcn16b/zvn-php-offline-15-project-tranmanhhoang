<?php
class UserController extends Controller
{

	public function __construct($arrParams)
	{
		parent::__construct($arrParams);
		$this->_templateObj->setFolderTemplate('backend/');
		$this->_templateObj->setFileTemplate('index.php');
		$this->_templateObj->setFileConfig('template.ini');
		$this->_templateObj->load();
	}

	public function indexAction()
	{
		$this->_view->items = $this->_model->listItems($this->_arrParam);
		$this->_view->filterStatus = $this->_model->filterStatusFix($this->_arrParam);
		$this->_view->listGroup = $this->_model->getGroupAdmin();
		$this->_view->render('user/index');
	}

	public function ajaxStatusAction()
	{
		$result = $this->_model->changeStatusAndAcp($this->_arrParam, ['task' => 'change-status']);
		echo json_encode($result);
	}

	public function deleteAction()
	{
		if (isset($this->_arrParam['id'])) {
			$this->_model->deleteItem($this->_arrParam['id']);
			// Session::set('message', ['content' => 'Xoá thành công']);
		} else {
			$this->_view->render('user/error');
		}
		URL::redirectLink('backend', 'user', 'index');
	}

	public function formAction()
	{
		$this->_view->listGroup = $this->_model->getGroupAdmin(true);
		$this->_view->setTitleForm = 'Add User Admin';
		$data = null;
		$task = 'add';
		if (isset($this->_arrParam['id'])) {
			$this->_view->setTitleForm = 'Edit User Admin';
			$data = $this->_model->checkItem($this->_arrParam);
			if (empty($data)) {
				URL::redirectLink('backend', 'User', 'index');
			}
			$task = 'edit';
			$addGroupId = $this->_model->getNameByGroupId($data['group_id']);
			$data['group'] = $addGroupId['name'];
		}
		if (!empty($this->_arrParam['form'])) {
			$data = $this->_arrParam['form'];
			$validate = new Validate($data);
			$flag = false;
			if ($task == 'add') {
				if ($this->_model->checkUserName($this->_arrParam['form']) == 1) {
					$validate->setError('username', 'User đã tồn tại');
					$flag = true;
				}
			}
			$required = $task == 'add' ? true : false;
			$validate->addRule('username', 'username', ['min' => 3, 'max' => 20], $required)
				->addRule('password', 'password', ['min' => 4, 'max' => 20], $required)
				->addRule('email', 'email')
				->addRule('status', 'select')
				->addRule('group', 'select');
			$validate->run();


			$data = $validate->getResult();
			$data['username'] = ($flag == true) ? '' : ($data['username'] ?? '');
			if ($validate->isValid()) {

				$this->_model->saveItem($data, ['task' => $task]);
				URL::redirectLink('backend', 'User', 'index');
			} else {
				$this->_view->errors = $validate->showErrors();
			}
		}
		$data['password'] = $this->_arrParam['form']['password'] ?? '';
		$this->_view->outPut = $data;
		$this->_view->render('user/form');
	}


	// public function clearAction()
	// {
	// 	// Session::unset('keyword');
	// 	URL::redirectLink('backend', 'Group', 'index');
	// }
}
