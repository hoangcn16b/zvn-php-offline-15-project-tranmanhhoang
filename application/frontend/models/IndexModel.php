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

	public function inforItem($params, $options = null)
	{
		if ($options == null) {
			$email = $params['email'];
			$password = md5($params['password']);
			// unset($params['submit']);
			$query[] = "SELECT `u`.`id`, `u`.`fullname`, `u`.`username`, `u`.`email`, `u`.`group_id`, `g`.`group_acp`, `g`.`privilege_id`  ";
			$query[] = "FROM `user` AS `u` LEFT JOIN `group` as `g` ON `u`.`group_id` = `g`.`id`";
			$query[] = "WHERE `u`.`email` = '$email' AND `u`.`password` = '$password' ";
			$query = implode(" ", $query);
			$result = $this->singleRecord($query);

			if ($result['group_acp'] == 1) {
				$arrPrivilege = explode(',', $result['privilege_id']);
				$strPrivilegeId = '';
				foreach ($arrPrivilege as $privilegeId) {
					$strPrivilegeId .= "'$privilegeId',";
				}

				$queryP[] = "SELECT `id`, CONCAT(`module`, '-',`controller`,'-', `action`) AS `name`";
				$queryP[] = "FROM `" . TABLE_PRIVILEGE . "` AS `p`";
				$queryP[] = "WHERE id IN ($strPrivilegeId'0') ";
				$queryP = implode(" ", $queryP);
				$result['privilege'] = $this->fetchPairs($queryP);
			}

			return $result;
		}
	}
}
