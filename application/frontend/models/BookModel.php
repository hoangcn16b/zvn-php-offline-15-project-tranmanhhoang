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
		if ($options['task'] == 'get_cate_name') {
			$query[] = "SELECT `name` FROM `" . TABLE_CATEGORY . "`";
			$addWhere = " ";
			if (isset($params['id'])) $addWhere = " `id` = '{$params['id']}' AND ";
			$query[] = "WHERE $addWhere `status` = 'active'";
			$query = implode(" ", $query);
			$result = $this->singleRecord($query);
		} elseif ($options['task'] == 'get_all_cate_name') {
			$query[] = "SELECT `id`, `name` FROM `" . TABLE_CATEGORY . "` WHERE `status` = 'active'";
			$query = implode(" ", $query);
			$result = $this->fetchPairs($query);
		} elseif ($options['task'] == 'get_product_by_cate_id') {
			$query[] = "SELECT * FROM `" . TABLE_BOOK . "`";
			$addWhere = " ";
			if (isset($params['id'])) $addWhere = " `category_id` = '{$params['id']}' AND ";
			$query[] = "WHERE $addWhere `status` = 'active'";

			if (isset($params['sort'])) {
				$sort = $params['sort'];
				if ($sort == 'price_asc') {
					$query[] = " ORDER BY `price` ASC, `ordering` ASC ";
				} elseif ($sort == 'price_desc') {
					$query[] = " ORDER BY `price` DESC, `ordering` ASC ";
				} elseif ($sort == 'latest') {
					$query[] = " ORDER BY `id` DESC, `ordering` ASC ";
				} elseif ($sort == 'default') {
					$query[] = " ORDER BY `ordering` ASC";
				}
			}
			$pagination = $params['pagination'];
			$totalItemsPerPage = $pagination['totalItemsPerPage'];
			if ($totalItemsPerPage > 0) {
				$position = ($pagination['currentPage'] - 1) * $totalItemsPerPage;
				$query[] = "LIMIT $position, $totalItemsPerPage";
			}
			$query = implode(" ", $query);
			$result = $this->listRecord($query);
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
				$result = $this->singleRecord($query);
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
				$queryRalate[] = "SELECT * FROM `" . TABLE_BOOK . "`";
				$queryRalate[] = "WHERE `category_id` = $cateId AND `status` = 'active' AND `id` <> $bookId";
				$queryRalate[] = "ORDER BY `ordering` ASC LIMIT 0,6";
				$queryRalate = implode(" ", $queryRalate);
				$result = $this->listRecord($queryRalate);
			}
		}
		return $result;
	}

	public function bookNew()
	{
		$query[] = "SELECT DISTINCT `id`, `name` ";
		$query[] = "FROM `" . TABLE_CATEGORY . "`";
		$query[] = "WHERE `status` = 'active' ORDER BY `ordering` ASC LIMIT 0,5";
		$query = implode(" ", $query);
		$resultTblCate = $this->fetchPairs($query);
		// $result = [];
		foreach ($resultTblCate as $key => $value) {
			$queryProduct = "SELECT * FROM `book` WHERE `status` = 'active' AND `category_id` = $key ORDER BY `ordering` ASC, `id` DESC LIMIT 0,4 ";
			$result[$key] = $this->fetchAll($queryProduct);
		}
		return $result;
	}

	public function getSpecialProduct($params = null)
	{
		$query[] = "SELECT DISTINCT c.id, c.name ";
		$query[] = "FROM `" . TABLE_CATEGORY . "` as `c`, `" . TABLE_BOOK . "` as `b`";
		$query[] = "WHERE `b`.`category_id` = `c`.`id` AND `c`.`status` = 'active' ORDER BY `c`.`ordering` ASC ";
		$query = implode(" ", $query);
		$resultTblCate = $this->fetchPairs($query);

		$result = [];
		foreach ($resultTblCate as $key => $value) {
			$queryProduct = [];
			$queryProduct[] = "SELECT DISTINCT * ";
			$queryProduct[] = "FROM  `" . TABLE_BOOK . "`";
			$queryProduct[] = "WHERE `status` = 'active' AND `special` = 1 AND `category_id` = $key ";
			$queryProduct[] = "ORDER BY `ordering` ASC LIMIT 0,4";
			$queryProduct = implode(" ", $queryProduct);
			$result[$key] = $this->fetchAll($queryProduct);
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

	public function countItem($params, $total = 3, $options = ['name', 'price', 'description'])
	{
		$result = [];
		$query[] = "SELECT COUNT(`id`) AS `all`";
		$query[] = "FROM `$this->table`";
		$query[] = "WHERE 1 ";
		if (isset($params['id']) && $params['id'] != '') {
			$id = $params['id'];
			$query[] = "AND `category_id` = '$id'";
		}

		$query = implode(" ", $query);
		$result = $this->singleRecord($query);
		if (empty($result)) {
			return $result['all'] = 0;
		} else {
			return $result['all'];
		}
	}
}
