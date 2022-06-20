<?php
class IndexModel extends Model
{
	public function __construct()
	{
		parent::__construct();
		// $this->setTable('user');
	}

	public function countTotalToIndex()
	{
		$query[] = "SELECT
		(SELECT COUNT(`id`) FROM `user` WHERE `id` > 0) AS `User`,";
		$query[] = "(SELECT COUNT(`id`) FROM `group` WHERE `id` > 0) AS `Group`";
		$query = implode(" ", $query);
		$result = $this->singleRecord($query);
		return $result;
	}

	public function inforItem($params, $options = null)
	{
		if ($options == null) {
			$email = $params['email'];
			$password = md5($params['password']);
			// unset($params['submit']);
			$query[] = "SELECT `u`.`id`, `u`.`fullname`, `u`.`email`, `u`.`group_id`, `g`.`group_acp` ";
			$query[] = "FROM `user` AS `u` LEFT JOIN `group` as `g` ON `u`.`group_id` = `g`.`id`";
			$query[] = "WHERE `u`.`email` = '$email' AND `u`.`password` = '$password' ";
			$query = implode(" ", $query);
			$result = $this->singleRecord($query);
			return $result;
		}
	}
}
