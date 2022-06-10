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
		// $this->_view->nameGroup = $this->_model->getGroupId('');
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
			$this->_view->render('group/error');
		}
		URL::redirectLink('backend', 'Group', 'index');
	}

	public function formAction()
	{
		$this->_view->listGroup = $this->_model->getGroupAdmin();
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

			$validate->addRule('username', 'string', ['min' => 0, 'max' => 20])
				->addRule('password', 'password', ['action' => $task])
				->addRule('email', 'email')
				->addRule('status', 'select')
				->addRule('group', 'select');
			$validate->run();

			$data = $validate->getResult();

			if ($validate->isValid()) {
				$this->_model->saveItem($data, ['task' => $task]);
				URL::redirectLink('backend', 'User', 'index');
			} else {
				$this->_view->errors = $validate->showErrors();
			}
		}
		echo '<pre>';
		print_r($data);
		echo '</pre>';
		$this->_view->outPut = $data;
		$this->_view->render('user/form');
	}


	// public function clearAction()
	// {
	// 	// Session::unset('keyword');
	// 	URL::redirectLink('backend', 'Group', 'index');
	// }
}
