<?php
class CategoryModel extends Model
{
	public function __construct()
	{
		parent::__construct();
		$this->setTable(TABLE_CATEGORY);
		date_default_timezone_set('Asia/Ho_Chi_Minh');
	}

	public function listItems($arrParams = null, $option = null)
	{
		$query[] = "SELECT `id`, `name`, `picture` FROM `$this->table` WHERE `status` = 'active'";
		$query[] = "ORDER BY `ordering`";
		$query = implode(" ", $query);
		$result = $this->listRecord($query);
		return $result;
	}
}
