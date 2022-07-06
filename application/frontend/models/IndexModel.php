<?php
class IndexModel extends Model
{
	public function __construct()
	{
		parent::__construct();
		$this->setTable('user');
		date_default_timezone_set('Asia/Ho_Chi_Minh');
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
		if ($options['task'] == 'add') {
			$params['created'] = date("Y-m-d H:i:s");
			$params['register_date'] = date("Y-m-d H:i:s");
			$params['register_ip'] = $_SERVER['REMOTE_ADDR'];
			$params['password'] = md5($params['password']);
			$params['status'] = 'inactive';
			$params['active_code'] = Helper::randomString();
			$groupId = $this->getGroupId('Customer');
			$params['group_id'] = $groupId['id'];
			$this->insert($params);
			HelperSendMail::sendEmailToActiveAccount($params);

			// Session::set('messageForm', ['class' => 'success', 'content' => ADD_SUCCESS]);
		}
	}

	public function inforItem($params, $options = null)
	{
		if ($options == null) {
			$email = $params['email'];
			$password = md5($params['password']);
			// unset($params['submit']);
			$query[] = "SELECT `u`.`id`, `u`.`fullname`, `u`.`username`, `u`.`email`, `u`.`group_id`, `g`.`group_acp`  ";
			$query[] = "FROM `user` AS `u` LEFT JOIN `group` as `g` ON `u`.`group_id` = `g`.`id`";
			$query[] = "WHERE `u`.`email` = '$email' AND `u`.`password` = '$password' AND `u`.`status` = 'active' ";
			$query = implode(" ", $query);
			// $result = $this->singleRecord($query);
			if ($this->query($query)) {
				$result = $this->singleRecord($query);
			} else {
				$result = false;
			}
			// if ($result['group_acp'] == 1) {
			// 	$arrPrivilege = explode(',', $result['privilege_id']);
			// 	$strPrivilegeId = '';
			// 	foreach ($arrPrivilege as $privilegeId) {
			// 		$strPrivilegeId .= "'$privilegeId',";
			// 	}

			// 	$queryP[] = "SELECT `id`, CONCAT(`module`, '-',`controller`,'-', `action`) AS `name`";
			// 	$queryP[] = "FROM `" . TABLE_PRIVILEGE . "` AS `p`";
			// 	$queryP[] = "WHERE id IN ($strPrivilegeId'0') ";
			// 	$queryP = implode(" ", $queryP);
			// 	$result['privilege'] = $this->fetchPairs($queryP);
			// }

			return $result;
		}
	}
	public function activate($params)
	{
		$query[] = "SELECT * FROM `user`";
		$query[] = "WHERE `username` = '{$params['username']}' AND `active_code` = '{$params['active_code']}' AND `status` = 'inactive'";
		$query = implode(" ", $query);
		// $result = $this->query($query);
		$result = $this->singleRecord($query);
		if (!empty($result)) {
			$modified = date("Y-m-d H:i:s");
			$randomCode = Helper::randomString() . '_active';
			$queryUpdate = "UPDATE `" . TABLE_USER . "` SET `status` = 'active', `modified` = '$modified', `modified_by` = '{$params['username']}', `active_code` = '$randomCode' WHERE `username` = '{$params['username']}'";
			$this->query($queryUpdate);
			return true;
		} else {
			return false;
		}
	}

	public function listProductSpecial($options = null)
	{
		$check = true;
		if ($check) {
			if ($options['task'] == 'get_product_special') {
				$query[] = "SELECT * FROM `" . TABLE_BOOK . "`";
				$query[] = "WHERE `status` = 'active' AND `special` = 1 LIMIT 0,10";
				$query = implode(" ", $query);

				$result = $this->listRecord($query);
			} elseif ($options['task'] == 'get_category_special') {
				$query[] = "SELECT DISTINCT c.id, c.name ";
				$query[] = "FROM `" . TABLE_CATEGORY . "` as `c`, `" . TABLE_BOOK . "` as `b`";
				$query[] = "WHERE `b`.`category_id` = `c`.`id` AND `c`.`status` = 'active' AND `c`.`special` = 1 ORDER BY `c`.`ordering` ASC LIMIT 0,4";
				$query = implode(" ", $query);
				$result = $this->fetchAll($query);
			}
		}
		return $result;
	}

	public function getSpecialProctduct($arrParams = null)
	{
		$arrParams = $this->listProductSpecial(['task' => 'get_category_special']);
		$result = [];
		foreach ($arrParams as $key => $value) {
			$queryProduct = [];
			$queryProduct[] = "SELECT DISTINCT * ";
			$queryProduct[] = "FROM  `" . TABLE_BOOK . "`";
			$queryProduct[] = "WHERE `status` = 'active' AND `special` = 0 AND `category_id` = {$value['id']} ";
			$queryProduct[] = "ORDER BY `ordering` ASC LIMIT 0,8";
			$queryProduct = implode(" ", $queryProduct);
			$arrParams[$key]['books'] = $this->fetchAll($queryProduct);
		}
		return $arrParams;
	}
	public function slider()
	{
		$query = "SELECT `picture`, `link` FROM `slider` LIMIT 0,4";
		$result = $this->fetchAll($query);
		return $result;
	}
}
