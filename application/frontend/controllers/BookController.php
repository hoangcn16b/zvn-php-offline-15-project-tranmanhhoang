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
        $this->_view->categoryName = $this->_model->infoItems($this->_arrParam, ['task' => 'get_cate_name']);
        $this->_view->categoryAllName = $this->_model->infoItems($this->_arrParam, ['task' => 'get_all_cate_name']);
        $this->_view->productAll = $this->_model->infoItems($this->_arrParam, ['task' => 'get_product_by_cate_id']);
        $this->_view->getSpecialProduct = $this->_model->getSpecialProduct();
        $this->_view->render('book/list');
    }
}
