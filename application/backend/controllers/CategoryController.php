<?php
class CategoryController extends Controller
{
    public function __construct($arrParams)
    {
        // $userInfor = Session::get('user');
        // $logged = (($userInfor['login'] ?? false) == true && ((($userInfor['time'] ?? '') + TIME_LOGIN) >= time()));
        // if ($logged == false) {
        //     URL::redirectLink('backend', 'index', 'login');
        // }
        parent::__construct($arrParams);
        $this->_templateObj->setFolderTemplate('backend/');
        $this->_templateObj->setFileTemplate('index.php');
        $this->_templateObj->setFileConfig('template.ini');
        $this->_templateObj->load();
    }

    public function indexAction()
    {

        $configPagination = ['totalItemsPerPage' => 5, 'pageRange' => 3];
        $this->setPagination($configPagination);
        $this->_view->items = $this->_model->listItems($this->_arrParam);
        $this->_view->filterStatus = $this->_model->filterStatusFix($this->_arrParam);

        $this->totalItems = $this->_model->countItem($this->_arrParam, null);
        $this->_view->pagination = new Pagination($this->totalItems, $this->_pagination);
        $this->_view->render($this->_arrParam['controller'] . '/index');
    }

    public function ajaxStatusAction()
    {
        $result = $this->_model->changeStatus($this->_arrParam, ['task' => 'changeStatus']);
        echo $result;
        // echo json_encode($result);
    }

    public function deleteAction()
    {
        if (isset($this->_arrParam['id'])) {
            $this->_model->deleteItem($this->_arrParam['id']);
        }
        URL::redirectLink($this->_arrParam['module'], $this->_arrParam['controller'], 'index');
    }

    public function formAction()
    {

        $this->_view->setTitleForm = 'Add Category Book';
        $data = null;
        $task = 'add';
        if (isset($this->_arrParam['id'])) {
            $this->_view->setTitleForm = 'Edit Category Book';
            $data = $this->_model->checkItem($this->_arrParam);
            if (empty($data)) {
                URL::redirectLink($this->_arrParam['module'], $this->_arrParam['controller'], 'index');
            }
            $task = 'edit';
        }

        if (!empty($this->_arrParam['form'])) {
            $data = $this->_arrParam['form'];
            if ($task == 'edit') {
                $data['modified_by'] = $this->_arrParam['userLogged']['username'];
            } elseif ($task == 'add') {
                $data['created_by'] = $this->_arrParam['userLogged']['username'];
            }
            $validate = new Validate($data);
            $required = $task == 'add' ? true : false;
            // $name    = $data['name'];
            // $query[] = "SELECT `name` FROM `category`";
            // if (isset($this->_arrParam['id'])) {
            //     $query[] = "WHERE `id` <> " . $this->_arrParam['id'] . " AND `name` = '" . $name . "'";
            // } else {
            //     $data['created_by'] = $this->_arrParam['userLogged']['username'];
            //     $query[] = "WHERE `name` = '" . $name . "'";
            
            // }
            // $query = implode(" ", $query);
            // $checkCategory = $this->_model->checkExistCategory($query);
            // if ($checkCategory) {
            //     $validate->setError('category',' is exist');
            // }
            $validate->addRule('name', 'username', ['min' => 5, 'max' => 100])
                ->addRule('status', 'status');
            $validate->run();
            $data = $validate->getResult();
            if ($validate->isValid()) {
                $this->_model->saveItem($data, ['task' => $task]);
                URL::redirectLink($this->_arrParam['module'], $this->_arrParam['controller'], 'index');
            } else {
                $this->_view->errors = $validate->showErrors();
            }
        }
        $this->_view->outPut = $data;
        $this->_view->render($this->_arrParam['controller'] . '/form');
    }
}
