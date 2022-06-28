<?php
class BookController extends Controller
{

	public function __construct($arrParams)
	{
		Auth::checkAuth(Session::get('user') ?? '');
		parent::__construct($arrParams);
		$this->_templateObj->setFolderTemplate('backend/');
		$this->_templateObj->setFileTemplate('index.php');
		$this->_templateObj->setFileConfig('template.ini');
		$this->_templateObj->load();
	}

	public function indexAction()
	{

		$configPagination = ['totalItemsPerPage' => 4, 'pageRange' => 5];
		$this->setPagination($configPagination);
		$this->_view->items = $this->_model->listItems($this->_arrParam);
		$this->_view->filterStatus = $this->_model->filterStatusFix($this->_arrParam);
		$this->_view->filterGroupCategory = $this->_model->getGroupCategory($this->_arrParam, true);

		$this->_view->listCategory = $this->_model->getGroupCategory($this->_arrParam, false);
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

	public function ajaxSpecialAction()
	{
		$result = $this->_model->changeSpecial($this->_arrParam);
		echo $result;
	}
	public function ajaxGroupAction()
	{
		$result = $this->_model->changeCategory($this->_arrParam);
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
		$this->_view->listCategory = $this->_model->getGroupCategory(null, true);
		$this->_view->setTitleForm = 'Add Book';
		$data = null;
		$task = 'add';

		if (isset($this->_arrParam['id'])) {
			$this->_view->setTitleForm = 'Edit Book';
			$data = $this->_model->checkItem($this->_arrParam);
			if (empty($data)) {
				URL::redirectLink($this->_arrParam['module'], $this->_arrParam['controller'], 'index');
			}
			$task = 'edit';
		}
		if (!empty($this->_arrParam['form'])) {
			$data = $this->_arrParam['form'];
			if (!empty($_FILES)) {
				$data['picture'] = $_FILES['picture'];
			}
			if ($task == 'edit') {
				$data['modified_by'] = $this->_arrParam['userLogged']['username'];
			} else {
				$data['created_by'] = $this->_arrParam['userLogged']['username'];
			}
			$validate = new Validate($data);
			$validate->addRule('name', 'acceptUtf8', ['min' => 5, 'max' => 255])
				->addRule('price', 'int', ['min' => 1000, 'max' => 10000000])
				->addRule('sale_off', 'int', ['min' => 0, 'max' => 100], false)
				->addRule('ordering', 'int', ['min' => 0, 'max' => 10], false)
				->addRule('status', 'select')
				->addRule('special', 'select')
				->addRule('category_id', 'select')
				->addRule('picture', 'file', ['min' => 0, 'max' => 1000000, 'extension' => ['jpg', 'jpeg', 'png']], false);
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
}
