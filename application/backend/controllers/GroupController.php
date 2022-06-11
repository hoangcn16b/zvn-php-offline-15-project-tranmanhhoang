<?php
class GroupController extends Controller
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
		$this->_view->items = $this->_model->listItems($this->_arrParam,);
		$this->_view->filterStatus = $this->_model->filterStatusFix($this->_arrParam);
		$this->_view->getGroupAcp = $this->_model->getGroupAcp(true);
		$this->_view->render('group/index');
	}

	public function ajaxStatusAction()
	{
		$result = $this->_model->changeStatusAndAcp($this->_arrParam, ['task' => 'change-status']);
		echo json_encode($result);
	}

	public function ajaxGroupAcpAction()
	{
		$result = $this->_model->changeStatusAndAcp($this->_arrParam, ['task' => 'change-group-acp']);
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
		$this->_view->setTitleForm = 'Add Group Admin';
		$data = null;
		$task = 'add';

		if (isset($this->_arrParam['id'])) {
			$this->_view->setTitleForm = 'Edit Group Admin';
			$data = $this->_model->checkItem($this->_arrParam);
			if (empty($data)) {
				URL::redirectLink('backend', 'Group', 'index');
			}
			$task = 'edit';
		}

		if (!empty($this->_arrParam['form'])) {
			$data = $this->_arrParam['form'];
			$validate = new Validate($data);
			$validate->addRule('name', 'string', ['min' => 0, 'max' => 20])
				->addRule('group_acp', 'groupAcp')
				->addRule('status', 'status');
			$validate->run();

			$data = $validate->getResult();
			if ($validate->isValid()) {
				$this->_model->saveItem($data, ['task' => $task]);
				URL::redirectLink('backend', 'Group', 'index');
			} else {
				$this->_view->errors = $validate->showErrors();
			}
		}
		$this->_view->outPut = $data;
		$this->_view->render('group/form');
	}


	// public function clearAction()
	// {
	// 	// Session::unset('keyword');
	// 	URL::redirectLink('backend', 'Group', 'index');
	// }
}
