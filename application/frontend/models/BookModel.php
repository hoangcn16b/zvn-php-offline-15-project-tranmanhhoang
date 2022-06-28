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
}
