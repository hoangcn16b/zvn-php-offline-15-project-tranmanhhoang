<?php
class IndexModel extends Model
{
	public function __construct()
	{
		parent::__construct();
		// $this->setTable('user');
		date_default_timezone_set('Asia/Ho_Chi_Minh');
	}

	public function countTotalToIndex()
	{
		$query[] = "SELECT
		(SELECT COUNT(`id`) FROM `user` WHERE `id` > 0) AS `User`,";
		$query[] = "(SELECT COUNT(`id`) FROM `group` WHERE `id` > 0) AS `Group`,";
		$query[] = "(SELECT COUNT(`id`) FROM `category` WHERE `id` > 0) AS `Category`,";
		$query[] = "(SELECT COUNT(`id`) FROM `book` WHERE `id` > 0) AS `Book`";
		$query = implode(" ", $query);
		$result = $this->singleRecord($query);
		return $result;
	}

	public function inforItem($params, $options = null)
	{
		if ($options == null) {
			$email = $params['email'];
			$password = md5($params['password']);
			// unset($params['submit']);
			$query[] = "SELECT `u`.`id`, `u`.`fullname`, `u`.`username`, `u`.`email`, `u`.`group_id`, `g`.`group_acp` ";
			$query[] = "FROM `user` AS `u` LEFT JOIN `group` as `g` ON `u`.`group_id` = `g`.`id`";
			$query[] = "WHERE `u`.`email` = '$email' AND `u`.`password` = '$password' ";
			$query = implode(" ", $query);
			$result = $this->singleRecord($query);

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

	public function saveProfile($params, $options = null)
	{
		$id = $params['id'];
		$params['modified'] = date("Y-m-d H:i:s");
		$params['modified_by'] = $params['username'];
		unset($params['username']);
		unset($params['email']);
		unset($params['id']);
		$where = [['id', $id]];
		$this->update($params, [['id', $id]]);
		Session::set('messageProfile', ['class' => 'success', 'content' => UPDATE_SUCCESS]);
	}
}
