<?php
class CartModel extends Model
{
	public function __construct()
	{
		parent::__construct();
		$this->setTable('cart');
		date_default_timezone_set('Asia/Ho_Chi_Minh');
	}

	public function listItems($params = null, $option = null)
	{
		if ($option['task'] == 'books-in-cart') {
			$cart = Session::get('cart');
			$result = [];
			if (!empty($cart)) {
				$ids = '(';
				foreach ($cart['quantity'] as $key => $value) {
					$ids .= "'$key', ";
				}
				$ids .= "'0')";
			} else {
				$ids = "('0')";
			}
			$query[] = "SELECT `id`, `name`, `picture` FROM `" . TABLE_BOOK . "`";
			$query[] = "WHERE `id` IN $ids AND `status` = 'active'";
			$query = implode(" ", $query);
			$result = $this->fetchAll($query);
			foreach ($result as $key => $value) {
				$result[$key]['quantity'] = $cart['quantity'][$value['id']];
				$result[$key]['totalprice'] = $cart['price'][$value['id']];
				$result[$key]['price'] = $result[$key]['totalprice'] / $result[$key]['quantity'];
			}
		}
		return $result;
	}
}
