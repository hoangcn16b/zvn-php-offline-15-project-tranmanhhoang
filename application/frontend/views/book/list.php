
<?php
//cate Name
$xhtmlAllCategory = '';
$activeCategory = $this->arrParams['id'] ?? '';
foreach ($this->categoryAllName as $key => $value) {
    $link = URL::createLink($this->arrParams['module'], 'book', 'list', ['id' => $key]);
    if (isset($this->arrParams['sort'])) {
        $link = URL::createLink($this->arrParams['module'], 'book', 'list', ['id' => $key, 'sort' => $this->arrParams['sort'] ?? '']);
    }
    $aClass = '';
    if ($activeCategory == $key) {
        $aClass = 'my-text-primary';
    } else {
        $aClass = 'text-dark more-item';
    }
    $xhtmlAllCategory .= '
                        <div class="custom-control custom-checkbox collection-filter-checkbox pl-0 category-item">
                            <a class="' . $aClass . '" href="' . $link . '">' . $value . '</a>
                        </div>';
}
//add Prod
$xhtmlProduct = '';
foreach ($this->productAll as $key => $value) {
    $xhtmlProduct .= '<div class="col-xl-3 col-6 col-grid-box" >';
    $xhtmlProduct .= HelperFrontend::loadHome($value);
    $xhtmlProduct .= '</div>';
}

//sach noi bat
$xhtmlSpecialProduct = '';
foreach ($this->getSpecialProduct as $idCate => $listItems) {
    $xhtmlSpecialProduct .= '<div>';
    foreach ($listItems as $key => $value) {
        $xhtmlSpecialProduct .= HelperFrontend::loadSideProd($value);
    }
    $xhtmlSpecialProduct .= '</div>';
}


$paramsId = '';
if (isset($this->arrParams['id'])) {
    $paramsId = HelperForm::input('hidden', 'id', $this->arrParams['id']);
}
$paramsToURL = HelperForm::input('hidden', 'module', 'frontend') . HelperForm::input('hidden', 'controller', 'book') . HelperForm::input('hidden', 'action', 'list') . $paramsId;

$arrData = ['default' => ' - Sắp xếp(mặc định) - ', 'price_asc' => 'Giá tăng dần', 'price_desc' => 'Giá giảm dần', 'latest' => 'Mới nhất'];
$selectSearch = HelperFrontend::selectBox($arrData, 'sort', $this->arrParams['sort'] ?? 'default', '', 'id="sort"');
$xhtmlPagination = $this->pagination->showPagination();

?>
<?= HelperFrontend::loadTitle($this->thisTitle); ?>
<section class="section-b-space j-box ratio_asos">
    <div class="collection-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-sm-3 collection-filter">
                    <!-- side-bar colleps block stat -->
                    <div class="collection-filter-block">
                        <!-- brand filter start -->
                        <div class="collection-mobile-back"><span class="filter-back"><i class="fa fa-angle-left" aria-hidden="true"></i> back</span></div>
                        <div class="collection-collapse-block open">
                            <h3 class="collapse-block-title">Danh mục</h3>
                            <div class="collection-collapse-block-content">
                                <div class="collection-brand-filter">
                                    <?= $xhtmlAllCategory ?>
                                    <div class="custom-control custom-checkbox collection-filter-checkbox pl-0 text-center">
                                        <span class="text-dark font-weight-bold" id="btn-view-more">Xem thêm</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="theme-card">
                        <h5 class="title-border">Sách nổi bật</h5>
                        <div class="offer-slider slide-1">
                            <?= $xhtmlSpecialProduct ?>
                        </div>
                    </div>
                    <!-- silde-bar colleps block end here -->
                </div>
                <div class="collection-content col">
                    <div class="page-main-content">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="collection-product-wrapper">
                                    <div class="product-top-filter">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="filter-main-btn">
                                                    <span class="filter-btn btn btn-theme"><i class="fa fa-filter" aria-hidden="true"></i> Filter</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="product-filter-content">
                                                    <div class="collection-view">
                                                        <ul>
                                                            <li><i class="fa fa-th grid-layout-view"></i></li>
                                                            <li><i class="fa fa-list-ul list-layout-view"></i></li>
                                                        </ul>
                                                    </div>
                                                    <div class="collection-grid-view">
                                                        <ul>
                                                            <li class="my-layout-view" data-number="2">
                                                                <img src="<?= $this->_pathImg ?>icon/2.png" alt="" class="product-2-layout-view">
                                                            </li>
                                                            <li class="my-layout-view" data-number="3">
                                                                <img src="<?= $this->_pathImg ?>icon/3.png" alt="" class="product-3-layout-view">
                                                            </li>
                                                            <li class="my-layout-view active" data-number="4">
                                                                <img src="<?= $this->_pathImg ?>icon/4.png" alt="" class="product-4-layout-view">
                                                            </li>
                                                            <li class="my-layout-view" data-number="6">
                                                                <img src="<?= $this->_pathImg ?>icon/6.png" alt="" class="product-6-layout-view">
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="product-page-filter">
                                                        <form action="" id="sort-form" method="GET">
                                                            <?= $paramsToURL . $selectSearch ?>

                                                            <!-- <select id="sort" name="sort">
                                                                <option value="default"> - Sắp xếp - </option>
                                                                <option value="price_asc">Giá tăng dần</option>
                                                                <option value="price_desc">Giá giảm dần</option>
                                                                <option value="latest">Mới nhất</option>
                                                            </select> -->
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-wrapper-grid" id="my-product-list">
                                        <div class="row margin-res">
                                            <?= $xhtmlProduct ?>
                                        </div>
                                    </div>
                                    <!-- <div class="card-footer clearfix">
                                        <ul class="pagination m-0 float-right">
                                            <?= $xhtmlPagination ?>
                                        </ul>
                                    </div> -->
                                    <div class="product-pagination">
                                        <div class="theme-paggination-block">
                                            <div class="container-fluid p-0">
                                                <div class="row">
                                                    <div class="col-xl-6 col-md-6 col-sm-12">
                                                        <nav aria-label="Page navigation">
                                                            <nav>
                                                                <!-- <ul class="pagination"> -->
                                                                <?= $xhtmlPagination ?>

                                                                <!-- <li class="page-item disabled">
                                                                        <a href="" class="page-link"><i class="fa fa-angle-double-left"></i></a>
                                                                    </li>
                                                                    <li class="page-item disabled">
                                                                        <a href="" class="page-link"><i class="fa fa-angle-left"></i></a>
                                                                    </li>
                                                                    <li class="page-item active">
                                                                        <a class="page-link">1</a>
                                                                    </li>
                                                                    <li class="page-item">
                                                                        <a class="page-link" href="#">2</a>
                                                                    </li>
                                                                    <li class="page-item">
                                                                        <a class="page-link" href="#">3</a>
                                                                    </li>
                                                                    <li class="page-item">
                                                                        <a class="page-link" href="#"><i class="fa fa-angle-right"></i></a>
                                                                    </li>
                                                                    <li class="page-item">
                                                                        <a class="page-link" href="#"><i class="fa fa-angle-double-right"></i></a>
                                                                    </li> -->
                                                                <!-- </ul> -->
                                                            </nav>
                                                        </nav>
                                                    </div>
                                                    <?= $this->pagination->showNumPage(); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>