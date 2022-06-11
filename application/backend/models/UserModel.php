<?php
class UserModel extends Model
{
	public function __construct()
	{
		parent::__construct();
		$this->setTable('user');
	}

	public function createQuery($arrParams)
	{
		$query = [];
		//search
		if (!empty($arrParams['input-keyword'])) {
			$keyword = "LIKE '%" . $arrParams['input-keyword'] . "%'";
			$query[] = "AND `u`.`username` $keyword";
		}

		if (isset($arrParams['status']) && $arrParams['status'] != 'all') {
			$query[] = "AND `u`.`status` = '{$arrParams['status']}'";
		}

		return implode(" ", $query);
	}

	public function listItems($arrParams, $option = null)
	{
		$query[] = "SELECT u.id, u.username, u.email, u.fullname, u.created, u.created_by, u.modified, u.modified_by, u.status, u.group_id, g.name AS `group_name`";
		$query[] = "FROM `user` AS `u`, `group` AS `g`";
		$query[] = "WHERE u.`id` > 0 AND `u`.`group_id` = `g`.`id` ORDER BY u.id ";
		$query[] = $this->createQuery($arrParams);
		$query = implode(" ", $query);
		$query;
		$result = $this->listRecord($query);
		return $result;
	}

	public function changeStatusAndAcp($Params, $option = null)
	{
		$id = mysqli_real_escape_string($this->connect, $Params['id']);
		if ($option['task'] == 'change-status') {
			$status = $Params['status'] == 'active' ? 'inactive' : 'active';
			$query = "UPDATE `$this->table` SET `status` = '$status' where `id` = '$id'";
			$result = [$id, $status, URL::createLink('backend', 'Group', 'ajaxStatus', ['id' => $id, 'status' => $status])];
		} else if ($option['task'] == 'change-group-acp') {
			$groupAcp = $Params['group_acp'] == 1 ? 0 : 1;
			$query = "UPDATE `$this->table` SET `group_acp` = '$groupAcp' where `id` = '$id'";
			$result = [$id, $groupAcp, URL::createLink('backend', 'Group', 'ajaxGroupAcp', ['id' => $id, 'group_acp' => $groupAcp])];
		}
		$this->query($query);
		return $result;
	}

	public function deleteItem($id = '')
	{
		$query = "DELETE FROM `$this->table` WHERE `id` = " . mysqli_real_escape_string($this->connect, $id);
		$this->query($query);
		Session::set('messageDelete', ['class' => 'success', 'content' => DELETE_SUCCESS]);
	}

	public function filterStatusFix($arrParams)
	{
		$result = [];
		$query[] = "SELECT COUNT(`status`) as `all`, SUM(`status` = 'active') as `active`, SUM(`status` = 'inactive') as `inactive` FROM `$this->table`";

		if (!empty($arrParams['input-keyword'])) {
			$keyword = "LIKE '%" . $arrParams['input-keyword'] . "%'";
			$query[] = "WHERE `username` $keyword";
		}

		$query = implode(" ", $query);
		$query;
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
			echo '<pre>';
			print_r($params);
			echo '</pre>';
			$group = ucfirst($params['group'] ?? '');
			$groupId =  $this->getGroupId($group);
			$params['group_id'] = $groupId['group_id'];
			unset($params['group']);
			$this->insert($params);
			Session::set('messageForm', ['class' => 'success', 'content' => ADD_SUCCESS]);
		} elseif ($options['task'] == 'edit') {
			$params['modified'] = date("Y-m-d H:i:s");
			$id = $params['id'];
			unset($params['id']);
			$params['password'] = md5($params['password']);
			unset($params['username']);
			unset($params['password']);

			$group = ucfirst($params['group'] ?? '');
			$groupId = $this->getGroupId($group);

			$groupId = $groupId['group_id'];
			$params['group_id'] = $groupId['group_id'];

			unset($params['group']);
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

	public function checkUserName($params)
	{
		$query = "SELECT `username` from `user` where `username` = '{$params['username']}'";
		$result = $this->isExist($query);
		return $result;
	}
}
