<?php
class BookModel extends Model
{
	public function __construct()
	{
		parent::__construct();
		$this->setTable(TABLE_BOOK);
		date_default_timezone_set('Asia/Ho_Chi_Minh');
	}

	public function createQuery($arrParams, $total = 3, $options = ['name', 'description', 'price'])
	{
		$query = [];
		//search
		$i = 0;
		if (isset($arrParams['input-keyword']) && $arrParams['input-keyword'] != '') {
			$query[] = "AND (";
			foreach ($options as $cols => $value) {
				if ($i == $total) break;
				$likeKeyWord = "LIKE '%" . trim($arrParams['input-keyword']) . "%'";
				$query[] = ($i < 2) ? "`b`.`{$value}` $likeKeyWord OR" : "`b`.`{$value}` $likeKeyWord";
				$i++;
			}
			$query[] = ")";
		}
		if (isset($arrParams['category_id']) && $arrParams['category_id'] != 'default' && $arrParams['category_id'] != '') {
			$query[] = "AND (";
			$groupAcp = trim(($arrParams['category_id']));
			$query[] = "`category_id` = $groupAcp ";
			$query[] = ")";
		}

		if (isset($arrParams['status']) && $arrParams['status'] != '' && $arrParams['status'] != 'all') {
			$query[] = "AND `b`.`status` = '{$arrParams['status']}'";
		}

		if (isset($arrParams['special']) && $arrParams['special'] != '' && $arrParams['special'] != 'default') {
			$query[] = "AND `b`.`special` = '{$arrParams['special']}'";
		}
		return implode(" ", $query);
	}

	public function listItems($arrParams, $option = null)
	{
		// $exceptId = $_SESSION['user']['info']['id'];			//`u`.`id` != $exceptId
		$query[] = "SELECT `b`.`id`, b.name, b.description, b.price, b.special, b.sale_off, b.picture, b.created, b.created_by, b.modified, b.modified_by, b.status, b.category_id, c.name AS `group_name` ";
		$query[] = "FROM `book` AS `b`, `category` AS `c`";
		$query[] = "WHERE `b`.`category_id` = `c`.`id`";
		$query[] = $this->createQuery($arrParams, 3);

		$query[] = "ORDER BY `b`.`id` DESC";
		$pagination = $arrParams['pagination'];
		$totalItemsPerPage = $pagination['totalItemsPerPage'];
		if ($totalItemsPerPage > 0) {
			$position = ($pagination['currentPage'] - 1) * $totalItemsPerPage;
			$query[] = "LIMIT $position, $totalItemsPerPage";
		}
		$query = implode(" ", $query);
		if ($this->query($query)) {
			$result = $this->listRecord($query);
		} else {
			$result = [];
		}
		return $result;
	}

	public function changeStatus($params)
	{
		$id = $params['id'];
		$modified = date("Y-m-d H:i:s");
		$modifiedBy = $params['userLogged']['username'];
		$status = $params['status'] == 'active' ? 'inactive' : 'active';
		$query = "UPDATE `$this->table` SET `status` = '$status', `modified` = '$modified', `modified_by` = '$modifiedBy' where `id` = '$id'";
		$url = URL::createLink($params['module'], $params['controller'], 'ajaxStatus', ['id' => $id, 'status' => $status]);
		$result = Helper::cmsStatus($status, $url, $id);
		$this->query($query);
		return $result;
	}

	public function changeSpecial($params)
	{
		$id = $params['id'];
		$modified = date("Y-m-d H:i:s");
		$modifiedBy = $params['userLogged']['username'];
		$special = $params['special'] == 1 ? 0 : 1;
		$query = "UPDATE `$this->table` SET `special` = '$special', `modified` = '$modified', `modified_by` = '$modifiedBy' where `id` = '$id'";
		$url = URL::createLink($params['module'], $params['controller'], 'ajaxSpecial', ['id' => $id, 'special' => $special]);
		$result = Helper::cmsSpecial($special, $url, $id);
		$this->query($query);
		return $result;
	}

	public function changeCategory($params)
	{
		$id = $params['id'];
		$modified = date("Y-m-d H:i:s");
		$modifiedBy = $params['userLogged']['username'];
		$categoryId = $params['category_id'];
		echo $query = "UPDATE `$this->table` SET `category_id` = '$categoryId', `modified` = '$modified', `modified_by` = '$modifiedBy' WHERE `id` = '$id'";
		$this->query($query);
	}
	public function deleteItem($id = '')
	{
		$query = "DELETE FROM `$this->table` WHERE `id` = " . mysqli_real_escape_string($this->connect, $id);
		$this->query($query);
		Session::set('messageDelete', ['class' => 'success', 'content' => DELETE_SUCCESS]);
	}

	public function filterStatusFix($arrParams, $total = 3, $options = ['name', 'description', 'price'])
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
		if (isset($arrParams['category_id']) && $arrParams['category_id'] != 'default' && $arrParams['category_id'] != '') {
			$keyword = $arrParams['category_id'];
			$query[] = "AND `category_id` = $keyword";
		}
		if (isset($arrParams['special']) && $arrParams['special'] != 'default' && $arrParams['special'] != '') {
			$keyword = $arrParams['special'];
			$query[] = "AND `special` = $keyword";
		}
		$query = implode(" ", $query);
		if ($this->query($query)) {
			$result = $this->singleRecord($query);
		} else {
			$result = [];
		}
		return $result;
	}

	public function getGroupAdmin($hasDefault = false, $params = null)
	{
		$query[] = "SELECT `id`, `name`, `group_acp`";
		$query[] = "FROM `group`";
		$query[] = "WHERE 1";
		// if (!empty($params['idLogged'])) {
		// 	if ($params['idLogged'] == 1) {
		// 		$query[] = "AND `id` <> 1";
		// 	} elseif ($params['idLogged'] !== 1) {
		// 		$query[] = " AND `id` <> 1";
		// 	}
		// }

		$query = implode(" ", $query);
		$list = $this->listRecord($query);
		$result = [];
		if ($hasDefault) $result['default'] = 'Select Category';
		foreach ($list as $key => $value) {
			$result[$value['id']] = $value['name'];
		}
		return $result;
	}

	public function getGroupCategory($params = null, $hasDefault = false)
	{
		$query[] = "SELECT DISTINCT `id`, `name`";
		$query[] = "FROM `category`";
		$query[] = "WHERE 1";
		$query = implode(" ", $query);
		$list = $this->listRecord($query);
		$result = [];
		if ($hasDefault) $result['default'] = 'Select Group';
		foreach ($list as $key => $value) {
			$result[$value['id']] = $value['name'];
		}
		return $result;
	}
	// public function getGroupId($name = null)
	// {
	// 	$query[] = "SELECT DISTINCT g.`name`, u.`group_id`";
	// 	$query[] = "FROM `user` AS `u`, `group` AS `g`";
	// 	$query[] = "WHERE `u`.`group_id` = `g`.`id`";
	// 	$query[] = ($name != null) ? "AND `g`.`name` = '$name'" : '';
	// 	$query = implode(" ", $query);
	// 	$result = $this->singleRecord($query);

	// 	return $result;
	// }

	public function saveItem($params, $options = null)
	{
		require_once LIBRARY_EXT_PATH . "Upload.php";
		$uploadObj = new Upload();
		if ($options['task'] == 'add') {
			$params['picture'] = $uploadObj->uploadFile($params['picture'], 'book', null);
			$params['created'] = date("Y-m-d H:i:s");
			$params['name'] = mysqli_real_escape_string($this->connect, $params['name']);
			$params['description'] = mysqli_real_escape_string($this->connect, ($params['description'] ?? ''));
			$this->insert($params);
			Session::set('messageForm', ['class' => 'success', 'content' => ADD_SUCCESS]);
		} elseif ($options['task'] == 'edit') {
			$params['modified'] = date("Y-m-d H:i:s");
			if ($params['picture']['name'] == null) {
				unset($params['picture']);
				unset($params['picture_hidden']);
			} else {
				$params['picture'] = $uploadObj->uploadFile($params['picture'], 'book', null);
				$uploadObj->removeFile('book', $params['picture_hidden']);
				$uploadObj->removeFile('book', '60x90-' . $params['picture_hidden']);
				unset($params['picture_hidden']);
			}
			$params['name'] = mysqli_real_escape_string($this->connect, $params['name']);
			$params['description'] = mysqli_real_escape_string($this->connect, ($params['description'] ?? ''));
			$id = $params['id'];
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
		$query[] = "SELECT DISTINCT c.`name`, b.`category_id`";
		$query[] = "FROM `book`AS `b`, `category` AS `c`";
		$query[] = "WHERE b.`category_id` = c.`id`";
		$query[] = ($option != null) ? "AND b.`category_id` = '{$option}'" : '';
		$query = implode(" ", $query);
		$result = $this->singleRecord($query);

		return $result;
	}



	public function countItem($arrParams, $total = 3, $options = ['name', 'price', 'description'])
	{
		$result = [];
		$query[] = "SELECT COUNT(`id`) AS `all`";
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
		if (isset($arrParams['category_id']) && $arrParams['category_id'] != 'default' && $arrParams['category_id'] != '') {
			$groupAcp = $arrParams['category_id'];
			$query[] = "AND `category_id` = $groupAcp";
		}

		if (isset($arrParams['status']) && $arrParams['status'] != 'all' && $arrParams['status'] != '') {
			$status = $arrParams['status'];
			$query[] = "AND `status` = '$status'";
		}

		if (isset($arrParams['special']) && $arrParams['special'] != 'default' && $arrParams['special'] != '') {
			$status = $arrParams['special'];
			$query[] = "AND `status` = '$status'";
		}
		$query = implode(" ", $query);
		if ($this->query($query)) {
			$result = $this->singleRecord($query);
			return $result['all'];
		} else {
			// $result[] = [];
			return $result['all'] = 0;
		}
	}
}
