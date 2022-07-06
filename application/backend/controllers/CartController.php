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
		$configPagination = ['totalItemsPerPage' => 3, 'pageRange' => 5];
		$this->setPagination($configPagination);
		$this->_view->items = $this->_model->listItems($this->_arrParam);

		$this->totalItems = $this->_model->countItem($this->_arrParam);
		$this->_view->totalDeals = $this->totalItems;
		$this->_view->pagination = new Pagination($this->totalItems, $this->_pagination);
		$this->_view->render($this->_arrParam['controller'] . '/index');
	}

	public function ajaxStatusAction()
	{
		$result = $this->_model->changeStatus($this->_arrParam);
		echo $result;
		// echo json_encode($result);
	}

	public function viewAction(){
		
		$this->_view->getItem = $this->_model->getItem($this->_arrParam);
		$this->_view->render('cart/view');
	}
}
