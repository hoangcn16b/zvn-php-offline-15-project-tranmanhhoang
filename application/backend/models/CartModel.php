<?php
class CartModel extends Model
{
	public function __construct()
	{
		parent::__construct();
		$this->setTable('cart');
		date_default_timezone_set('Asia/Ho_Chi_Minh');
	}

	public function createQuery($arrParams, $total = 5, $options = ['username', 'email', 'phone', 'fullname', 'address'])
	{
		$query = [];
		//search
		$i = 0;
		if (isset($arrParams['input-keyword']) && $arrParams['input-keyword'] != '') {
			$query[] = "AND (";

			foreach ($options as $cols => $value) {
				$checkSearchBy = false;
				if (isset($arrParams['search_by']) && $arrParams['search_by'] != '' && $arrParams['search_by'] != 'all') {
					$value = $arrParams['search_by'];
					$checkSearchBy = true;
				}
				if ($i == $total) {
					break;
				}
				$likeKeyWord = "LIKE '%" . trim($arrParams['input-keyword']) . "%'";
				$query[] = ($i < 4) ? "`u`.`{$value}` $likeKeyWord OR" : "`u`.`{$value}` $likeKeyWord";
				if ($checkSearchBy) {
					$query[] = "`u`.`{$value}` $likeKeyWord";
					break;
				}
				$i++;
			}
			$query[] = ")";
		}

		if (isset($arrParams['status']) && $arrParams['status'] != '' && $arrParams['status'] != 'all') {
			$query[] = "AND `c`.`status` = '{$arrParams['status']}'";
		}

		return implode(" ", $query);
	}

	public function listItems($arrParams, $option = null)
	{
		$query[] = "SELECT `c`.`id`, c.books, c.pictures, c.prices, c.quantities, c.names, c.status, c.date, u.username, u.fullname, u.address, u.phone, u.email ";
		$query[] = "FROM `user` AS `u`, `cart` AS `c`";
		$query[] = "WHERE `u`.`username` = `c`.`username`";

		$query[] = $this->createQuery($arrParams, 5);
		$query[] = "ORDER BY `c`.`date` DESC";
		$pagination = $arrParams['pagination'];
		$totalItemsPerPage = $pagination['totalItemsPerPage'];
		if ($totalItemsPerPage > 0) {
			$position = ($pagination['currentPage'] - 1) * $totalItemsPerPage;
			$query[] = "LIMIT $position, $totalItemsPerPage";
		}
		$query = implode(" ", $query);

		$result = $this->listRecord($query);
		return $result;
	}

	public function countItem($arrParams, $total = 5, $options = ['username', 'email', 'phone', 'fullname', 'address'])
	{
		$result = [];
		$query[] = "SELECT DISTINCT COUNT(`c`.`id`) AS `all`";
		$query[] = "FROM `cart` as `c`, `user` as `u`";
		$query[] = "WHERE `c`.`username` = `u`.`username` ";
		// $i = 0;
		$query[] = $this->createQuery($arrParams, 5);

		if (isset($arrParams['status']) && $arrParams['status'] != 'all' && $arrParams['status'] != '') {
			$status = $arrParams['status'];
			$query[] = "AND `c`.`status` = '$status'";
		}
		$query = implode(" ", $query);
		if ($this->query($query)) {
			$result = $this->singleRecord($query);
			return $result['all'];
		} else {
			// $result[] = [];
			return $result['all'] = 0;
		}
	}
	public function changeStatus($params)
	{
		$id = $params['id'];
		$confirmed_at = date("Y-m-d H:i:s");
		$confirmed_by = $params['userLogged']['username'];
		$status = $params['status'];
		$query = "UPDATE `cart` SET `confirmed_at` = '$confirmed_at', `confirmed_by` = '$confirmed_by', `status` = '$status' WHERE `id` = '$id'";
		$this->query($query);
	}

	// public function totalDeals()
	// {
	// 	$query = "SELECT count(`id`) AS `total` FROM `cart`";
	// 	$result = [];
	// 	$result = $this->singleRecord($query);
	// 	if (empty($result)) {
	// 		$result['total'] = 0;
	// 	}
	// 	return $result;
	// }
	
	// if (isset($arrParams['input-keyword']) && $arrParams['input-keyword'] != '') {
		// 	$query[] = "AND (";
		// 	foreach ($options as $cols => $value) {
		// 		$checkSearchBy = false;
		// 		if (isset($arrParams['search_by']) && $arrParams['search_by'] != '' && $arrParams['search_by'] != 'all') {
		// 			$value = $arrParams['search_by'];
		// 			$checkSearchBy = true;
		// 		}
		// 		if ($i == $total) {
		// 			break;
		// 		}
		// 		$likeKeyWord = "LIKE '%" . trim($arrParams['input-keyword']) . "%'";
		// 		$query[] = ($i < 4) ? "`u`.`{$value}` $likeKeyWord OR" : "`u`.`{$value}` $likeKeyWord";
		// 		if ($checkSearchBy) {
		// 			$query[] = "`u`.`{$value}` $likeKeyWord";
		// 			break;
		// 		}
		// 		$i++;
		// 	}
		// 	$query[] = ")";
		// }
}
