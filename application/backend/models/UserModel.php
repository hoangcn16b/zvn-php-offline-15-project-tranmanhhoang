<?php
class UserModel extends Model
{
	public function __construct()
	{
		parent::__construct();
		$this->setTable('user');
		date_default_timezone_set('Asia/Ho_Chi_Minh');
	}

	public function createQuery($arrParams, $total = 3, $options = ['username', 'fullname', 'email'])
	{
		$query = [];
		//search
		$i = 0;
		if (isset($arrParams['input-keyword']) && $arrParams['input-keyword'] != '') {
			$query[] = "AND (";
			foreach ($options as $cols => $value) {
				if ($i == $total) break;
				$likeKeyWord = "LIKE '%" . trim($arrParams['input-keyword']) . "%'";
				$query[] = ($i < 2) ? "`u`.`{$value}` $likeKeyWord OR" : "`u`.`{$value}` $likeKeyWord";
				$i++;
			}
			$query[] = ")";
		}
		if (isset($arrParams['group_id']) && $arrParams['group_id'] != 'default' && $arrParams['group_id'] != '') {
			$query[] = "AND (";
			$groupAcp = trim(($arrParams['group_id']));
			$query[] = "`group_id` = $groupAcp ";
			$query[] = ")";
		}

		if (isset($arrParams['status']) && $arrParams['status'] != '' && $arrParams['status'] != 'all') {
			$query[] = "AND `u`.`status` = '{$arrParams['status']}'";
		}
		return implode(" ", $query);
	}

	public function listItems($arrParams, $option = null)
	{
		// $exceptId = $_SESSION['user']['info']['id'];			//`u`.`id` != $exceptId
		$query[] = "SELECT u.id, u.username, u.email, u.fullname, u.created, u.created_by, u.modified, u.modified_by, u.status, u.group_id, g.name AS `group_name`";
		$query[] = "FROM `user` AS `u`, `group` AS `g`";
		$query[] = "WHERE 1 AND `u`.`group_id` = `g`.`id`";
		$query[] = $this->createQuery($arrParams, 3);

		$query[] = "ORDER BY `u`.`id` DESC";
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

	public function changeStatus($params)
	{
		$id = $params['id'];
		$modified = date("Y-m-d H:i:s");
		$status = $params['status'] == 'active' ? 'inactive' : 'active';
		$query = "UPDATE `$this->table` SET `status` = '$status', `modified` = '$modified' where `id` = '$id'";
		$url = URL::createLink($params['module'], $params['controller'], 'ajaxStatus', ['id' => $id, 'status' => $status]);
		$result = Helper::cmsStatus($status, $url, $id);
		$this->query($query);
		return $result;
	}

	public function deleteItem($id = '')
	{
		$query = "DELETE FROM `$this->table` WHERE `id` = " . mysqli_real_escape_string($this->connect, $id);
		$this->query($query);
		Session::set('messageDelete', ['class' => 'success', 'content' => DELETE_SUCCESS]);
	}

	public function filterStatusFix($arrParams, $total = 3, $options = ['username', 'fullname', 'email'])
	{
		$result = [];
		$query[] = "SELECT COUNT(`status`) as `all`, SUM(`status` = 'active') as `active`, SUM(`status` = 'inactive') as `inactive`";
		$query[] = "FROM `$this->table`";
		$query[] = "WHERE 1 ";
		$i = 0;
		if (isset($arrParams['input-keyword']) && $arrParams['input-keyword'] != '') {
			$query[] = "AND (";
			foreach ($options as $cols => $value) {
				if ($i == $total) break;
				$likeKeyWord = "LIKE '%" . trim($arrParams['input-keyword']) . "%'";
				$query[] = ($i < 2) ? "`{$value}` $likeKeyWord OR" : "`{$value}` $likeKeyWord";
				$i++;
			}
			$query[] = ")";
		}
		if (isset($arrParams['group_id']) && $arrParams['group_id'] != 'default' && $arrParams['group_id'] != '') {
			$keyword = $arrParams['group_id'];
			$query[] = "AND `group_id` = $keyword";
		}
		$query = implode(" ", $query);
		$result = $this->singleRecord($query);
		return $result;
	}

	public function getGroupAdmin($hasDefault = false)
	{
		$query = 'SELECT `id`, `name` FROM `group`';
		$list = $this->listRecord($query);
		$result = [];
		if ($hasDefault) $result['default'] = 'Select Group';
		foreach ($list as $key => $value) {
			$result[$value['id']] = $value['name'];
		}
		return $result;
	}

	public function getGroupId($name = null)
	{
		$query[] = "SELECT DISTINCT g.`name`, u.`group_id`";
		$query[] = "FROM `user` AS `u`, `group` AS `g`";
		$query[] = "WHERE `u`.`group_id` = `g`.`id`";
		$query[] = ($name != null) ? "AND `g`.`name` = '$name'" : '';
		$query = implode(" ", $query);
		$result = $this->singleRecord($query);

		return $result;
	}

	public function saveItem($params, $options = null)
	{
		if ($options['task'] == 'add') {
			$params['created'] = date("Y-m-d H:i:s");
			$params['password'] = md5($params['password']);
			$this->insert($params);
			Session::set('messageForm', ['class' => 'success', 'content' => ADD_SUCCESS]);
		} elseif ($options['task'] == 'edit') {
			$params['modified'] = date("Y-m-d H:i:s");
			$id = $params['id'];
			unset($params['username']);
			unset($params['email']);
			unset($params['id']);
			$where = [['id', $id]];
			$this->update($params, [['id', $id]]);
			Session::set('messageForm', ['class' => 'success', 'content' => UPDATE_SUCCESS]);
		}
	}

	public function checkItem($params)
	{
		$query[] = "SELECT * FROM `$this->table`";
		$query[] = "WHERE `id` = '{$params['id']}'";
		$query = implode(" ", $query);

		$result = $this->singleRecord($query);
		return $result;
	}

	public function getNameByGroupId($option = null)
	{
		$query[] = "SELECT DISTINCT g.`name`, u.`group_id`";
		$query[] = "FROM `user`AS `u`, `group` AS `g`";
		$query[] = "WHERE u.`group_id` = g.`id`";
		$query[] = ($option != null) ? "AND u.`group_id` = '{$option}'" : '';
		$query = implode(" ", $query);
		$result = $this->singleRecord($query);

		return $result;
	}

	public function checkUserNameEmail($params)
	{
		$query[] = "SELECT `username`, `email` from `$this->table` ";
		$query[] = "WHERE `username` = '{$params['username']}' OR `email` = '{$params['email']}'";
		$query = implode(" ", $query);
		$result = $this->isExist($query);
		return $result;
	}

	public function changeGroupUser($params)
	{
		$id = $params['id'];
		$modified = date("Y-m-d H:i:s");
		$groupId = $params['group_id'];
		$query = "UPDATE `$this->table` SET `group_id` = '$groupId', `modified` = '$modified' WHERE `id` = '$id'";
		$this->query($query);
	}

	public function countItem($arrParams, $total = 3, $options = ['username', 'fullname', 'email'])
	{
		$result = [];
		$query[] = "SELECT COUNT(`id`) AS `all`";
		$query[] = "FROM `$this->table`";
		$query[] = "WHERE 1";
		$i = 0;
		if (isset($arrParams['input-keyword']) && $arrParams['input-keyword'] != '') {
			$query[] = "AND (";
			foreach ($options as $cols => $value) {
				if ($i == $total) break;
				$likeKeyWord = "LIKE '%" . trim($arrParams['input-keyword']) . "%'";
				$query[] = ($i < 2) ? "`{$value}` $likeKeyWord OR" : "`{$value}` $likeKeyWord";
				$i++;
			}
			$query[] = ")";
		}
		if (isset($arrParams['group_id']) && $arrParams['group_id'] != 'default' && $arrParams['group_id'] != '') {
			$groupAcp = $arrParams['group_id'];
			$query[] = "AND `group_id` = $groupAcp";
		}

		if (isset($arrParams['status']) && $arrParams['status'] !== 'all' && $arrParams['status'] != '') {
			$status = $arrParams['status'];
			$query[] = "AND `status` = '$status'";
		}
		$query = implode(" ", $query);
		$result = $this->singleRecord($query);
		return $result['all'];
	}

	public function savePassword($params, $options = null)
	{

		$params['modified'] = date("Y-m-d H:i:s");
		$params['password'] = md5($params['password']);
		$id = $params['id'];
		unset($params['fullname']);
		unset($params['username']);
		unset($params['email']);
		unset($params['id']);
		$where = [['id', $id]];
		$this->update($params, [['id', $id]]);
		Session::set('messageForm', ['class' => 'success', 'content' => UPDATE_SUCCESS]);
	}

	public function changeMyPassword($params, $options = null)
	{
		$params['modified'] = date("Y-m-d H:i:s");
		$params['password'] = md5($params['new password']);
		$id = $params['id'];
		unset($params['id']);
		unset($params['new password']);
		$query = "UPDATE `" . TABLE_USER . "` SET `password` = '{$params['password']}', `modified` = '{$params['modified']}', `modified_by` = '$id' WHERE `id` = '$id'";
		$result = $this->query($query);
		if ($result) {
			return true;
		} else {
			return false;
		}
		// $where = [['id', $id]];
		// $this->update($params, [['id', $id]]);
	}
}
