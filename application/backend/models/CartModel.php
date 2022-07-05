<?php
class CartModel extends Model
{
	public function __construct()
	{
		parent::__construct();
		$this->setTable('cart');
		date_default_timezone_set('Asia/Ho_Chi_Minh');
	}

	
}
