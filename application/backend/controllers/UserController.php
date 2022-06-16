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
		$configPagination = ['totalItemsPerPage' => 2, 'pageRange' => 2];
		$this->setPagination($configPagination);
		$this->_view->items = $this->_model->listItems($this->_arrParam);
		$this->_view->filterStatus = $this->_model->filterStatusFix($this->_arrParam);
		$this->_view->filterGroupUser = $this->_model->getGroupAdmin(true);
		$this->_view->listGroup = $this->_model->getGroupAdmin();

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
		$this->_model->changeGroupUser($this->_arrParam);
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
		$this->_view->listGroup = $this->_model->getGroupAdmin(true);
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
			$validate = new Validate($data);

			$required = $task == 'add' ? true : false;
			$validate->addRule('username', 'username', ['min' => 3, 'max' => 20], $required)
				// ->addRule('password', 'password', ['action' => $task])
				->addRule('email', 'email')
				->addRule('status', 'select')
				->addRule('group_id', 'select');
			if (isset($data['password'])) {
				$validate->addRule('password', 'password', ['action' => $task]);
			}
			if ($task == 'add') {
				if ($this->_model->checkUserNameEmail($data) == 1) {
					$validate->setError('Errors', 'UserName or Email is exist');
				}
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


	// public function clearAction()
	// {
	// 	// Session::unset('keyword');
	// 	URL::redirectLink('backend', 'Group', 'index');
	// }
}
