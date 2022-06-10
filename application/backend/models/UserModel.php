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
			$query[] = "AND `username` $keyword";
		}

		if (isset($arrParams['status']) && $arrParams['status'] != 'all') {
			$query[] = "AND `status` = '{$arrParams['status']}'";
		}

		return implode(' ', $query);
	}

	public function listItems($arrParams, $option = null)
	{
		$query[] = "SELECT * FROM `$this->table` WHERE `id` > 0";

		$query[] = $this->createQuery($arrParams);
		$query = implode(" ", $query);
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
		$result = $this->singleRecord($query);
		return $result;
	}

	public function getGroupAdmin()
	{
		$query = 'SELECT `name` FROM `group`';
		$list = $this->listRecord($query);
		$result = [];
		$result['default'] = 'Select Group';
		foreach ($list as $key => $value) {
			$result[lcfirst($value['name'])] = $value['name'];
		}
		return $result;
	}

	public function getGroupId($option = null)
	{
		$query[] = "SELECT DISTINCT g.`name`, u.`group_id`";
		$query[] = "FROM `user`AS `u`, `group` AS `g`";
		$query[] = "WHERE u.`group_id` = g.`id`";
		$query[] = ($option != null) ? "AND g.`name` = '{$option}'" : '';
		$query = implode(" ", $query);
		$result = $this->singleRecord($query);

		return $result;
	}

	public function saveItem($params, $options = null)
	{
		if ($options['task'] == 'add') {
			$params['created'] = date("Y-m-d H:i:s");
			// $params['password'] = md5($params['password']);
			$params['group_id'] = $this->getGroupId($params['group']) ?? '';
			unset($params['group']);
			$this->insert($params);
			Session::set('messageForm', ['class' => 'success', 'content' => ADD_SUCCESS]);
		} elseif ($options['task'] == 'edit') {
			$params['modified'] = date("Y-m-d H:i:s");
			$id = $params['id'];
			unset($params['id']);
			// $params['password'] = md5($params['password']);
			$params['group_id'] = $this->getGroupId($params['group']);
			unset($params['group']);
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
}
