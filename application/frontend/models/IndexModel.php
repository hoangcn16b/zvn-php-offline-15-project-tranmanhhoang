<?php
class IndexModel extends Model
{
	public function __construct()
	{
		parent::__construct();
		$this->setTable('user');
	}

	public function getGroupId($name = null)
	{
		$query[] = "SELECT `id`, `name` ";
		$query[] = "FROM `group`";
		$query[] = "WHERE `name` = '$name'";
		$query = implode(" ", $query);
		$result = $this->singleRecord($query);

		return $result;
	}
	public function saveItem($params, $options = null)
	{
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		if ($options['task'] == 'add') {
			$params['created'] = date("Y-m-d H:i:s");
			$params['register_date'] = date("Y-m-d H:i:s");
			$params['register_ip'] = $_SERVER['REMOTE_ADDR'];
			$params['password'] = md5($params['password']);
			$params['status'] = 'active';
			$groupId = $this->getGroupId('Customer');
			$params['group_id'] = $groupId['id'];
			$this->insert($params);
			// Session::set('messageForm', ['class' => 'success', 'content' => ADD_SUCCESS]);
		}
	}
}
