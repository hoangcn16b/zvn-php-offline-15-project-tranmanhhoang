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
		$check = true;
		if ($check) {
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

	public function getSpecialProduct($arrParams = null)
	{
		
		$query[] = "SELECT DISTINCT c.id, c.name ";
		$query[] = "FROM `" . TABLE_CATEGORY . "` as `c`, `" . TABLE_BOOK . "` as `b`";
		$query[] = "WHERE `b`.`category_id` = `c`.`id` AND `c`.`status` = 'active' AND `b`.`special` = 1 ORDER BY `c`.`ordering` ASC LIMIT 0,4";
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
}
