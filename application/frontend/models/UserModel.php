<?php

class UserModel extends Model
{
	public function __construct()
	{
		parent::__construct();
		$this->setTable('user');
		date_default_timezone_set('Asia/Ho_Chi_Minh');
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

	public function changeMyPassword($params, $options = null)
	{
		$newPassword = $params['new password'];
		$params['modified'] = date("Y-m-d H:i:s");
		$params['password'] = md5($params['new password']);
		$modifiedBy = $params['username'];
		$id = $params['id'];
		unset($params['id']);
		unset($params['new password']);
		$query = "UPDATE `" . TABLE_USER . "` SET `password` = '{$params['password']}', `modified` = '{$params['modified']}', `modified_by` = '$modifiedBy' WHERE `id` = '$id'";
		$result = $this->query($query);
		if ($result) {
			HelperSendMail::sendEmailPassword($newPassword, $params['email'], $modifiedBy);
			return true;
		} else {
			return false;
		}
	}
}
