<?php
class BookModel extends Model
{
	public function __construct()
	{
		parent::__construct();
		$this->setTable(TABLE_BOOK);
		date_default_timezone_set('Asia/Ho_Chi_Minh');
	}

	public function infoItems($params = null, $options = null)
	{
		if (isset($params['id'])) {
			if ($options['task'] == 'get_cate_name') {
				$query[] = "SELECT `name` FROM `" . TABLE_CATEGORY . "`";
				$query[] = "WHERE `id` = '{$params['id']}' AND `status` = 'active'";
				$query = implode(" ", $query);
				if ($this->query($query)) {
					$result = $this->singleRecord($query);
				} else {
					$result = [];
				}
			} elseif ($options['task'] == 'get_all_cate_name') {
				$query[] = "SELECT `id`, `name` FROM `" . TABLE_CATEGORY . "` WHERE `status` = 'active'";
				$query = implode(" ", $query);
				if ($this->query($query)) {
					$result = $this->fetchPairs($query);
				} else {
					$result = [];
				}
			} elseif ($options['task'] == 'get_product_by_cate_id') {

				$query[] = "SELECT * FROM `" . TABLE_BOOK . "`";
				$query[] = "WHERE `category_id` = '{$params['id']}' AND `status` = 'active'";
				if (isset($params['sort'])) {
					$sort = $params['sort'];
					if ($sort == 'price_asc') {
						$query[] = " ORDER BY `price` ASC ";
					} elseif ($sort == 'price_desc') {
						$query[] = " ORDER BY `price` DESC ";
					} elseif ($sort == 'latest') {
						$query[] = " ORDER BY `id` DESC ";
					} elseif ($sort == 'default') {
						$query[] = " ORDER BY `ordering` DESC ";
					}
				}
				$query = implode(" ", $query);
				if ($this->query($query)) {
					$result = $this->listRecord($query);
				} else {
					$result = [];
				}
			}
		} else {
			if ($options['task'] == 'get_cate_name') {
				$query[] = "SELECT `name` FROM `" . TABLE_CATEGORY . "`";
				$query[] = "WHERE `status` = 'active'";
				$query = implode(" ", $query);
				if ($this->query($query)) {
					$result = $this->singleRecord($query);
				} else {
					$result = [];
				}
			} elseif ($options['task'] == 'get_all_cate_name') {
				$queryCate[] = "SELECT `id`, `name` FROM `" . TABLE_CATEGORY . "` WHERE `status` = 'active'";
				$queryCate = implode(" ", $queryCate);
				if ($this->query($queryCate)) {
					$result = $this->fetchPairs($queryCate);
				} else {
					$result = [];
				}
			} elseif ($options['task'] == 'get_product_by_cate_id') {
				$query[] = "SELECT * FROM `" . TABLE_BOOK . "`";
				$query[] = "WHERE `status` = 'active'";
				if (isset($params['sort'])) {
					$sort = $params['sort'];
					// $priceSale = 
					if ($sort == 'price_asc') {
						$query[] = " ORDER BY `price` ASC ";
					} elseif ($sort == 'price_desc') {
						$query[] = " ORDER BY `price` DESC ";
					} elseif ($sort == 'latest') {
						$query[] = " ORDER BY `id` DESC ";
					} elseif ($sort == 'default') {
						$query[] = " ORDER BY `ordering` DESC ";
					}
				}
				$query = implode(" ", $query);
				if ($this->query($query)) {
					$result = $this->listRecord($query);
				} else {
					$result = [];
				}
			}
		}
		return $result;
	}

	public function bookDetail($params, $options = null)
	{
		if (isset($params['book_id'])) {
			if ($options['task'] == 'book_info') {
				$query[] = "SELECT * FROM `" . TABLE_BOOK . "`";
				$query[] = "WHERE `id` = '{$params['book_id']}' AND `status` = 'active'";
				$query = implode(" ", $query);
				if ($this->query($query)) {
					$result = $this->singleRecord($query);
				} else {
					$result = [];
				}
			}
			if ($options['task'] == 'book_relate') {
				$bookId = $params['book_id'];
				$queryCate = "SELECT `category_id` FROM `book` WHERE `id` = $bookId";
				if ($this->query($queryCate)) {
					$resultCate = $this->fetchRow($queryCate);
					$cateId = $resultCate['category_id'];
				} else {
					$cateId = '';
				}
				$queryRalte[] = "SELECT * FROM `" . TABLE_BOOK . "`";
				$queryRalte[] = "WHERE `category_id` = $cateId AND `status` = 'active' AND `id` <> $bookId";
				$queryRalte[] = "ORDER BY `ordering` DESC LIMIT 0,6";
				$queryRalte = implode(" ", $queryRalte);
				if ($this->query($queryRalte)) {
					$result = $this->listRecord($queryRalte);
				} else {
					$result = [];
				}
			}
		}
		return $result;
	}

	public function bookNew()
	{
		$query[] = "SELECT DISTINCT `id`, `name` ";
		$query[] = "FROM `" . TABLE_CATEGORY . "`";
		$query[] = "WHERE `status` = 'active' ORDER BY `ordering` ASC LIMIT 0,4";
		$query = implode(" ", $query);
		if ($this->query($query)) {
			$resultTblCate = $this->fetchPairs($query);
		} else {
			$resultTblCate = [];
		}
		// $result = [];
		foreach ($resultTblCate as $key => $value) {
			$queryProduct = "SELECT * FROM `book` WHERE `status` = 'active' AND `category_id` = $key ORDER BY `ordering` ASC LIMIT 0,4 ";
			if ($this->query($queryProduct)) {
				$result[$key] = $this->fetchAll($queryProduct);
			} else {
				$result = [];
			}
		}
		return $result;
	}

	public function getSpecialProduct($params = null)
	{
		$query[] = "SELECT DISTINCT c.id, c.name ";
		$query[] = "FROM `" . TABLE_CATEGORY . "` as `c`, `" . TABLE_BOOK . "` as `b`";
		$query[] = "WHERE `b`.`category_id` = `c`.`id` AND `c`.`status` = 'active' ORDER BY `c`.`ordering` ASC ";
		$query = implode(" ", $query);
		if ($this->query($query)) {
			$resultTblCate = $this->fetchPairs($query);
		} else {
			$resultTblCate = [];
		}
		$result = [];
		foreach ($resultTblCate as $key => $value) {
			$queryProduct = [];
			$queryProduct[] = "SELECT DISTINCT * ";
			$queryProduct[] = "FROM  `" . TABLE_BOOK . "`";
			$queryProduct[] = "WHERE `status` = 'active' AND `special` = 1 AND `category_id` = $key ";
			$queryProduct[] = "ORDER BY `ordering` ASC LIMIT 0,4";
			$queryProduct = implode(" ", $queryProduct);
			if ($this->query($queryProduct)) {
				$result[$key] = $this->fetchAll($queryProduct);
			} else {
				$result = [];
			}
		}
		return $result;
	}

	public function checkId($params, $options = null)
	{
		if ($options['task'] == 'check_id_book') {
			$query = "SELECT `id` FROM `book` WHERE `id` = '{$params['book_id']}'";
			$result = $this->singleRecord($query);
			if (empty($result)) {
				return false;
			} else {
				return true;
			}
		} elseif ($options['task'] == 'check_id_category') {
			$query = "SELECT `id` FROM `category` WHERE `id` = '{$params['id']}'";
			$result = $this->singleRecord($query);
			if (empty($result)) {
				return false;
			} else {
				return true;
			}
		}
	}
}
