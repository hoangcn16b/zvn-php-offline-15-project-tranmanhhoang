<?php
class CartController extends Controller
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
		$this->_view->items = $this->_model->listItems($this->_arrParam, ['task' => 'books-in-cart']);
		$this->_view->render('cart/index');
	}

	public function buyAction()
	{

		if ($this->_userLogged == false) {
			Session::set('messageCheckout', MSG_CHECKOUT);
			URL::redirectLink('frontend', 'index', 'login');
		}
		if (isset($this->_arrParam['form'])) {
			$this->_model->saveItems($this->_arrParam);
		}
	}
}
