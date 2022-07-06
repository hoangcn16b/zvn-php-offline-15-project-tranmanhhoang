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

			Session::set('messageCheckout', ['class' => 'success', 'content' => 'Bạn đã đặt hàng thành công! Hãy kiểm tra email để xem lại hoá đơn và thời gian nhận hàng!']);
			URL::redirectLink($this->_arrParam['module'], 'index', 'error', ['type' => 'checkout_success']);
		}
	}

	public function orderAction()
	{
		$cart = Session::get('cart');
		$bookId = $this->_arrParam['book_id'];
		$price = $this->_arrParam['price'];
		$quantity = $this->_arrParam['form']['quantity'];
		echo '<pre>';
		print_r($this->_arrParam);
		echo '</pre>';
		if (empty($cart)) {
			$cart['quantity'][$bookId] = $quantity;
			$cart['price'][$bookId] = $price;
		} else {
			if (key_exists($bookId, $cart['quantity'])) {
				$cart['quantity'][$bookId] += $quantity;
				$cart['price'][$bookId] = $price;
			} else {
				$cart['quantity'][$bookId] = $quantity;
				$cart['price'][$bookId] = $price;
			}
		}
		Session::set('cart', $cart);
		URL::redirectLink($this->_arrParam['module'], 'book', 'detail', ['book_id' => $bookId]);
	}

	public function deleteProductAction()
	{
		$id = $this->_arrParam['book_id'];
		unset($_SESSION['cart']['quantity'][$id]);
		unset($_SESSION['cart']['price'][$id]);
		URL::redirectLink('frontend', 'cart', 'index');
	}

	public function deleteAllAction()
	{
		Session::unset('cart');
		URL::redirectLink('frontend', 'cart', 'index');
	}
}
