<?php
class CartController extends Controller
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
		// $configPagination = ['totalItemsPerPage' => 20, 'pageRange' => 5];
		// $this->setPagination($configPagination);
		// $this->_view->items = $this->_model->listItems($this->_arrParam);
		// $this->_view->filterStatus = $this->_model->filterStatusFix($this->_arrParam);
		// $this->_view->filterGroupCategory = $this->_model->getGroupCategory($this->_arrParam, true);

		// $this->_view->listCategory = $this->_model->getGroupCategory($this->_arrParam, false);
		// $this->totalItems = $this->_model->countItem($this->_arrParam);
		// $this->_view->pagination = new Pagination($this->totalItems, $this->_pagination);
		$this->_view->render($this->_arrParam['controller'] . '/index');
	}

}