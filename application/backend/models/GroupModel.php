<?php
class GroupModel extends Model
{
	public function __construct()
	{
		parent::__construct();
		$this->setTable('group');
	}

	public function getGroupAcp($hasDefault = false)
	{
		$query = 'SELECT `group_acp` FROM `group`';
		$list = $this->listRecord($query);
		$result = [];
		if ($hasDefault) $result['default'] = 'Select Group';
		foreach ($list as $key => $value) {
			if ($value['group_acp'] == 1) {
				$result[$value['group_acp']] = 'Active';
			} else {
				$result[$value['group_acp']] = 'Inative';
			}

			// $result[$value['group_acp']] = $value['group_acp'];
		}
		return $result;
	}

	public function createQuery($arrParams)
	{
		$query = [];
		//search
		if (isset($arrParams['input-keyword']) && $arrParams['input-keyword'] != '') {
			$keyword = "LIKE '%" . $arrParams['input-keyword'] . "%'";
			$query[] = "AND `name` $keyword";
		}

		if (isset($arrParams['status']) && $arrParams['status'] != 'all' && $arrParams['status'] != '') {
			$query[] = "AND `status` = '{$arrParams['status']}'";
		}
		if (isset($arrParams['group_acp']) && $arrParams['group_acp'] != 'default' && $arrParams['group_acp'] != '') {
			$groupAcp = trim(($arrParams['group_acp']));
			$query[] = "AND `group_acp` = $groupAcp ";
		}
		$result = implode(' ', $query);
		return  $result;
	}

	public function listItems($arrParams, $option = null)
	{
		$query[] = "SELECT * FROM `$this->table` WHERE `id` > 0";
		$query[] = $this->createQuery($arrParams);
		$query[] = "ORDER BY `id` DESC";
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

	// public function changeStatusAndAcp($Params, $option = null)
	// {
	// 	$id = mysqli_real_escape_string($this->connect, $Params['id']);
	// 	if ($option['task'] == 'change-status') {
	// 		$status = $Params['status'] == 'active' ? 'inactive' : 'active';
	// 		$query = "UPDATE `$this->table` SET `status` = '$status' where `id` = '$id'";
	// 		$result = [$id, $status, URL::createLink('backend', 'Group', 'ajaxStatus', ['id' => $id, 'status' => $status])];
	// 	} else if ($option['task'] == 'change-group-acp') {
	// 		$groupAcp = $Params['group_acp'] == 1 ? 0 : 1;
	// 		$query = "UPDATE `$this->table` SET `group_acp` = '$groupAcp' where `id` = '$id'";
	// 		$result = [$id, $groupAcp, URL::createLink('backend', 'Group', 'ajaxGroupAcp', ['id' => $id, 'group_acp' => $groupAcp])];
	// 	}
	// 	$this->query($query);
	// 	return $result;
	// }

	public function changeStatusAndAcp($params, $option = null)
	{
		$id = $params['id'];
		if ($option['task'] == 'changeStatus') {
			$status = $params['status'] == 'active' ? 'inactive' : 'active';
			$query = "UPDATE `$this->table` SET `status` = '$status' where `id` = '$id'";
			$url = URL::createLink($params['module'], $params['controller'], 'ajaxStatus', ['id' => $id, 'status' => $status]);
			$result = Helper::cmsStatus($status, $url, $id);
		} else if ($option['task'] == 'changeGroupAcp') {
			$groupAcp = $params['group_acp'] == 1 ? 0 : 1;
			$query = "UPDATE `$this->table` SET `group_acp` = '$groupAcp' where `id` = '$id'";
			$url = URL::createLink($params['module'], $params['controller'], 'ajaxGroupAcp', ['id' => $id, 'group_acp' => $groupAcp]);
			$result = Helper::cmsGroupAcp($groupAcp, $url, $id);
		}
		$this->query($query);
		return $result;
	}

	public function deleteItem($id = '')
	{
		$query = "DELETE FROM `$this->table` WHERE `id` = " . mysqli_real_escape_string($this->connect, $id);
		$this->query($query);
		Session::set('messageDelete', ['class' => 'success', 'content' => 'Xoá thành công!']);
	}

	public function filterStatusFix($arrParams)
	{
		$result = [];
		$query[] = "SELECT COUNT(`status`) as `all`, SUM(`status` = 'active') as `active`, SUM(`status` = 'inactive') as `inactive` FROM `$this->table`";
		$query[] = "WHERE 1";
		if (isset($arrParams['input-keyword']) && $arrParams['input-keyword'] != '') {
			$keyword = "LIKE '%" . $arrParams['input-keyword'] . "%'";
			$query[] = "AND `name` $keyword";
		}

		if (isset($arrParams['group_acp']) && $arrParams['group_acp'] != 'default' && $arrParams['group_acp'] != '') {
			$groupAcp = $arrParams['group_acp'];
			$query[] = "AND `group_acp` = $groupAcp";
		}
		$query = implode(" ", $query);
		$result = $this->singleRecord($query);
		return $result;
	}

	public function saveItem($params, $options = null)
	{
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		if ($options['task'] == 'add') {
			$params['created'] = date("Y-m-d H:i:s");
			$this->insert($params);
			Session::set('messageForm', ['class' => 'success', 'content' => 'Thêm mới thành công!']);
		} elseif ($options['task'] == 'edit') {
			$params['modified'] = date("Y-m-d H:i:s");
			$id = $params['id'];
			unset($params['id']);
			$this->update($params, [['id', $id]]);
			Session::set('messageForm', ['class' => 'success', 'content' => 'Cập nhật thành công!']);
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

	public function checkNameGroup($params)
	{
		$query[] = "SELECT * FROM `$this->table`";
		if (isset($params['id'])) {
			$query[] = "WHERE `id` != " . $params['id'] . " AND `name` = '" . $params['name'] . "'";
		} else {
			$query[] = "WHERE `name` = '" . $params['name'] . "'";
		}
		$query = implode(" ", $query);
		// $result = $this->singleRecord($query);
		$result = $this->isExist($query);
		return $result;
	}

	public function countItem($arrParams, $options = null)
	{
		$result = [];
		$query[] = "SELECT COUNT(`id`) AS `all`";
		$query[] = "FROM `$this->table`";
		$query[] = "WHERE 1";
		if (isset($arrParams['input-keyword']) && $arrParams['input-keyword'] != '') {
			$keyword = "LIKE '%" . $arrParams['input-keyword'] . "%'";
			$query[] = "AND `name` $keyword";
		}
		if (isset($arrParams['group_id']) && $arrParams['group_id'] != 'default' && $arrParams['group_id'] != '') {
			$groupAcp = $arrParams['group_acp'];
			$query[] = "AND `group_acp` = $groupAcp";
		}

		if (isset($arrParams['status']) && $arrParams['status'] !== 'all' && $arrParams['status'] != '') {
			$status = $arrParams['status'];
			$query[] = "AND `status` = '$status'";
		}
		echo $query = implode(" ", $query);
		// $result = $this->singleRecord($query);
		return $result['all'];
	}
}
