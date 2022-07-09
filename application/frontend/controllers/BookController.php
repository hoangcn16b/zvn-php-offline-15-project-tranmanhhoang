<?php
class BookController extends Controller
{
    public function __construct($arrParams)
    {

        parent::__construct($arrParams);
        $this->_templateObj->setFolderTemplate('frontend/');
        $this->_templateObj->setFileTemplate('index.php');
        $this->_templateObj->setFileConfig('template.ini');
        $this->_templateObj->load();
    }

    // public function indexAction()
    // {
    //     $this->_view->title = 'List books';
    //     $this->_view->categoryName = $this->_model->infoItems($this->_arrParam, ['task' => 'get_cate_name']);
    //     $this->_view->render('book/list');
    // }

    public function listAction()
    {
        $this->_view->thisTitle = 'Tất cả sách';
        if (isset($this->_arrParam['id'])) {
            if ($this->_model->checkId($this->_arrParam, ['task' => 'check_id_category']) == false) {
                URL::redirectLink($this->_arrParam['module'], 'index', 'error', ['type' => 'file_not_exist']);
            }
        }
        $configPagination = ['totalItemsPerPage' => 20, 'pageRange' => 5];
        $this->setPagination($configPagination);
        // $this->_view->categoryName = $this->_model->infoItems($this->_arrParam, ['task' => 'get_cate_name']);
        $this->_view->categoryAllName = $this->_model->infoItems($this->_arrParam, ['task' => 'get_all_cate_name']);
        $this->_view->productAll = $this->_model->infoItems($this->_arrParam, ['task' => 'get_product_by_cate_id']);
        $this->_view->getSpecialProduct = $this->_model->getSpecialProduct(['task' => 'special_book'], 21);

        $this->totalItems = $this->_model->countItem($this->_arrParam);
        $this->_view->pagination = new Pagination_frontend($this->totalItems, $this->_pagination);
        $this->_view->render('book/list');
    }

    public function detailAction()
    {
        if (isset($this->_arrParam['book_id'])) {
            if ($this->_model->checkId($this->_arrParam, ['task' => 'check_id_book']) == false) {
                URL::redirectLink($this->_arrParam['module'], 'index', 'error', ['type' => 'file_not_exist']);
            }
        }
        $this->_view->infoBook = 'Thông tin chi tiết';
        $this->_view->bookInfo = $this->_model->bookDetail($this->_arrParam, ['task' => 'book_info']);
        $this->_view->bookRelate = $this->_model->bookDetail($this->_arrParam, ['task' => 'book_relate']);
        $this->_view->bookNew = $this->_model->getSpecialProduct(['task' => 'new_book']);
        $this->_view->getSpecialProduct = $this->_model->getSpecialProduct(['task' => 'special_book']);
        $this->_view->render('book/detail');
    }
}
