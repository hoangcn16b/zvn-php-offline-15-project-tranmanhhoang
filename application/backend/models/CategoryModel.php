<?php
class CategoryModel extends Model
{
	public function __construct()
	{
		parent::__construct();
		$this->setTable(TABLE_CATEGORY);
		date_default_timezone_set('Asia/Ho_Chi_Minh');
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

	public function changeStatus($params, $option = null)
	{
		$id = $params['id'];
		$modified = date("Y-m-d H:i:s");
		// $modifiedBy = $params['idLogged'];
		$userName = $params['userLogged']['username'];
		if ($option['task'] == 'changeStatus') {
			$status = $params['status'] == 'active' ? 'inactive' : 'active';
			$query = "UPDATE `$this->table` SET `status` = '$status', `modified` = '$modified', `modified_by` = '$userName' where `id` = '$id'";
			$url = URL::createLink($params['module'], $params['controller'], 'ajaxStatus', ['id' => $id, 'status' => $status]);
			$result = Helper::cmsStatus($status, $url, $id);
		}
		$this->query($query);
		return $result;
	}

	public function deleteItem($id = '')
	{
		require_once LIBRARY_EXT_PATH . "Upload.php";
		$uploadObj = new Upload();
		$queryPic = "SELECT `id`, `picture` as `name` FROM `category` WHERE `id` = $id";
		$result = $this->fetchPairs($queryPic);
		foreach ($result as $value) {
			$uploadObj->removeFile('category', $value);
			$uploadObj->removeFile('category', '60x90-' . $value);
		}
		$query = "DELETE FROM `$this->table` WHERE `id` = " . mysqli_real_escape_string($this->connect, $id);
		$this->query($query);
		//remove picture


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

		$query = implode(" ", $query);
		$result = $this->singleRecord($query);
		return $result;
	}

	public function saveItem($params, $options = null)
	{
		require_once LIBRARY_EXT_PATH . "Upload.php";
		$uploadObj = new Upload();
		if ($options['task'] == 'add') {
			$params['picture'] = $uploadObj->uploadFile($params['picture'], 'category', null);
			$params['created'] = date("Y-m-d H:i:s");
			$this->insert($params);
			Session::set('messageForm', ['class' => 'success', 'content' => 'Thêm mới thành công!']);
		} elseif ($options['task'] == 'edit') {
			$params['modified'] = date("Y-m-d H:i:s");
			if ($params['picture']['name'] == null) {
				unset($params['picture']);
			} else {
				$params['picture'] = $uploadObj->uploadFile($params['picture'], 'category', null);
				$uploadObj->removeFile('category', $params['picture_hidden']);
				$uploadObj->removeFile('category', '60x90' . $params['picture_hidden']);
			}
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

	public function countItem($arrParams, $options = null)
	{
		$result = [];
		$query[] = "SELECT COUNT(`id`) AS `all`";
		$query[] = "FROM `$this->table`";
		$query[] = "WHERE 1";
		$query[] = $this->createQuery($arrParams);

		$query = implode(" ", $query);
		$result = $this->singleRecord($query);
		return $result['all'];
	}

	public function checkExistCategory($query)
	{
		$result = $this->singleRecord($query);
		if (empty($result)) {
			return true;
		} else {
			return false;
		}
	}
}
