<?php
class GroupController extends Controller
{
    public function __construct($arrParams)
    {
        $userInfor = Session::get('user');
        $logged = (($userInfor['login'] ?? false) == true && ((($userInfor['time'] ?? '') + TIME_LOGIN) >= time()));
        if ($logged == false) {
            URL::redirectLink('backend', 'index', 'login');
        }
        parent::__construct($arrParams);
        $this->_templateObj->setFolderTemplate('backend/');
        $this->_templateObj->setFileTemplate('index.php');
        $this->_templateObj->setFileConfig('template.ini');
        $this->_templateObj->load();
    }

    public function indexAction()
    {
        $userInfor = Session::get('user');
        // $requestURL = "backend-group-form";
        // $this->_view->showButtonAddGroup = (in_array($requestURL, $userInfor['info']['privilege']) == true) ? true : false;

        $configPagination = ['totalItemsPerPage' => 5, 'pageRange' => 3];
        $this->setPagination($configPagination);
        $this->_view->items = $this->_model->listItems($this->_arrParam);
        $this->_view->filterStatus = $this->_model->filterStatusFix($this->_arrParam);
        $this->_view->getGroupAcp = $this->_model->getGroupAcp(true);

        $this->totalItems = $this->_model->countItem($this->_arrParam, null);
        $this->_view->pagination = new Pagination($this->totalItems, $this->_pagination);
        $this->_view->render($this->_arrParam['controller'] . '/index');
    }

    public function ajaxStatusAction()
    {
        $result = $this->_model->changeStatusAndAcp($this->_arrParam, ['task' => 'changeStatus']);
        echo $result;
        // echo json_encode($result);
    }

    public function ajaxGroupAcpAction()
    {
        $result = $this->_model->changeStatusAndAcp($this->_arrParam, ['task' => 'changeGroupAcp']);
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
        if ($this->_arrParam['idLogged'] != 1) {
            Session::set('messageFormGroup', ['class' => 'warning', 'content' => 'Bạn không đủ quyền để thực hiện']);
            URL::redirectLink($this->_arrParam['module'], 'index', 'index');
        }
        $this->_view->setTitleForm = 'Add Group Admin';
        $data = null;
        $task = 'add';
        if (isset($this->_arrParam['id'])) {
            $this->_view->setTitleForm = 'Edit Group Admin';
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
            }
            $validate = new Validate($data);
            $required = $task == 'add' ? true : false;
            $name    = $data['name'];
            $query[] = "SELECT * FROM `group`";
            if (isset($this->_arrParam['id'])) {
                $query[] = "WHERE `id` <> " . $this->_arrParam['id'] . " AND `name` = '" . $name . "'";
            } else {
                $query[] = "WHERE `name` = '" . $name . "'";
            }
            $query = implode(" ", $query);
            $validate->addRule('name', 'string-notExistRecord', ['min' => 3, 'max' => 20, 'database' => $this->_model, 'query' => $query, 'required' => true])
                ->addRule('group_acp', 'groupAcp')
                ->addRule('status', 'status');
            $validate->run();
            $data = $validate->getResult();
            // $data['name'] = ($flag == true) ? '' : ($data['name'] ?? '');
            if ($validate->isValid()) {
                $this->_model->saveItem($data, ['task' => $task], $this->_userLogged);
                URL::redirectLink($this->_arrParam['module'], $this->_arrParam['controller'], 'index');
            } else {
                $this->_view->errors = $validate->showErrors();
            }
        }
        $this->_view->outPut = $data;
        $this->_view->render($this->_arrParam['controller'] . '/form');
    }


    // public function clearAction()
    // {
    // 	// Session::unset('keyword');
    // 	URL::redirectLink('backend', 'Group', 'index');
    // }
}
