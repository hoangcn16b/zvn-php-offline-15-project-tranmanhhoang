<?php
class DashboardController extends Controller{
	
	public function __construct($arrParams){
		parent::__construct($arrParams);
		$this->_templateObj->setFolderTemplate('backend/');
		$this->_templateObj->setFileTemplate('index.php');
		$this->_templateObj->setFileConfig('template.ini');
		$this->_templateObj->load();
	}
	
	public function indexAction(){
		
		$this->_view->render('index/index');
	}
	
	public function logoutAction(){
		echo '<h3>' . __METHOD__ . '</h3>';
		$this->_view->setTitle('Logout');
		$this->_view->appendJS(array('user/js/test.js'));
		$this->_view->render('user/logout', true);
	}
}