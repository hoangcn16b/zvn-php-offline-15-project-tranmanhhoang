<?php
class GroupModel extends Model
{
	public function __construct()
	{
		parent::__construct();
		$this->setTable('group');
	}

	public function createQuery($arrParams)
	{
		$query = [];
		//search
		if (!empty($arrParams['input-keyword'])) {
			$keyword = "LIKE '%" . $arrParams['input-keyword'] . "%'";
			$query[] = "AND `name` $keyword";
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
		Session::set('messageDelete', ['class' => 'success', 'content' => 'Xoá thành công!']);
	}

	public function filterStatusFix($arrParams)
	{
		$result = [];
		$query[] = "SELECT COUNT(`status`) as `all`, SUM(`status` = 'active') as `active`, SUM(`status` = 'inactive') as `inactive` FROM `$this->table`";

		if (!empty($arrParams['input-keyword'])) {
			$keyword = "LIKE '%" . $arrParams['input-keyword'] . "%'";
			$query[] = "WHERE `name` $keyword";
		}

		$query = implode(" ", $query);
		$result = $this->singleRecord($query);
		return $result;
	}

	public function saveItem($params, $options = null)
	{
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
}
