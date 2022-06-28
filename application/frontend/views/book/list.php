<div class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-title">
                    <h2 class="py-2">Tất cả sách</h2>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

$xhtmlAllCategory = '';
$activeCategory = $this->arrParams['id'] ?? '';
foreach ($this->categoryAllName as $key => $value) {
    $link = URL::createLink($this->arrParams['module'], 'book', 'list', ['id' => $key]);
    $aClass = '';
    if ($activeCategory == $key) {
        $aClass = 'my-text-primary';
    } else {
        $aClass = 'text-dark more-item';
    }
    $xhtmlAllCategory .= '
                        <div class="custom-control custom-checkbox collection-filter-checkbox pl-0 category-item">
                            <a class="' . $aClass . '" href="' . $link . '">' . $value . '</a>
                        </div>
                        ';
}

$xhtmlProduct = '';
foreach ($this->productAll as $key => $value) {
    $iconSaleOff = '';
    if ($value['sale_off'] > 0) {
        $saleOff = ($value['sale_off'] > 0) ? '-' . $value['sale_off'] . '%' : '';
        $iconSaleOff = '
                            <div class="lable-block">
                                <span class="lable4 badge badge-danger"> ' . $saleOff . '</span>
                            </div>
                        ';
    }
    $picturePath = UPLOAD_PATH . 'book' . DS . '' . ($value['picture']);
    if (file_exists($picturePath) == true) {
        $pathImg = UPLOAD_URL . 'book' . DS . '' . ($value['picture']);
        $picture = '<img src ="' . $pathImg . '"  class="img-fluid blur-up lazyload bg-img" alt="" >';
    } else {
        $pathImg = UPLOAD_URL . 'book' . DS . 'default.png';
        $picture = '<img src ="' . $pathImg . '" class="img-fluid blur-up lazyload bg-img" alt="" >';
    }
    $price = '';
    $priceSale = number_format(($value['price']), 0, ',', '.');
    if ($value['sale_off'] != 0) {
        $priceSale = number_format(($value['price'] - ($value['price'] * $value['sale_off'] / 100)), 0, ',', '.');
        $price = number_format(($value['price']), 0, ',', '.') . ' đ';
    }
    $xhtmlProduct .= '
                    <div class="col-xl-3 col-6 col-grid-box" >
                        <div class="product-box" title="' . substr($value['description'], 0, 100) . '">
                            <div class="img-wrapper">
                                ' . $iconSaleOff . '
                                <div class="front">
                                    <a href="">
                                        ' . $picture . '
                                    </a>
                                </div>
                                <div class="cart-info cart-wrap">
                                    <a href="#" title="Add to cart"><i class="ti-shopping-cart"></i></a>
                                    <a href="#" title="Quick View"><i class="ti-search" data-toggle="modal" data-target="#quick-view"></i></a>
                                </div>
                            </div>
                            <div class="product-detail">
                                <div class="rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                                <a href="item.html" title="' . substr($value['description'], 0, 100) . '">
                                    <h6> ' . $value['name'] . ' </h6>
                                </a>
                                <p></p>
                                <h4 class="text-lowercase">' . $priceSale . ' đ <del>' . $price . '</del></h4>
                            </div>
                        </div>
                    </div>
                ';
}
//sach noi bat
echo '<pre>';
print_r($this->getSpecialProduct['90']);
echo '</pre>';

$xhtmlSpecialProduct = '';
$i = 1;
foreach ($this->getSpecialProduct as $idCate => $listItems) {
    $xhtmlSpecialProduct .= '<div>';

    foreach ($listItems as $key => $value) {
        $iconSaleOff = '';
        if ($value['sale_off'] > 0) {
            $saleOff = ($value['sale_off'] > 0) ? '-' . $value['sale_off'] . '%' : '';
            $iconSaleOff = '
                                <div class="lable-block">
                                    <span class="lable4 badge badge-danger"> ' . $saleOff . '</span>
                                </div>
                            ';
        }
        $picturePath = UPLOAD_PATH . 'book' . DS . '' . ($value['picture']);
        if (file_exists($picturePath) == true) {
            $pathImg = UPLOAD_URL . 'book' . DS . '' . ($value['picture']);
            $picture = '<img src ="' . $pathImg . '"  class="img-fluid blur-up lazyload" alt="' . $value['name'] . '" >';
        } else {
            $pathImg = UPLOAD_URL . 'book' . DS . 'default.png';
            $picture = '<img src ="' . $pathImg . '" class="img-fluid blur-up lazyload" alt="' . $value['name'] . '" >';
        }
        $price = '';
        $priceSale = number_format(($value['price']), 0, ',', '.');
        if ($value['sale_off'] != 0) {
            $priceSale = number_format(($value['price'] - ($value['price'] * $value['sale_off'] / 100)), 0, ',', '.');
            $price = number_format(($value['price']), 0, ',', '.') . ' đ';
        }
        $xhtmlSpecialProduct .= '
                                <div class="media">
                                    <a href="item.html">
                                        ' . $picture . '
                                    </a>
                                    <div class="media-body align-self-center">
                                        <div class="rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                        <a href="item.html" title="' . substr($value['description'], 0, 100) . '">
                                    <h6> ' . $value['name'] . ' </h6>
                                </a>
                                <p></p>
                                <h4 class="text-lowercase">' . $priceSale . ' đ <del>' . $price . '</del></h4>
                                    </div>
                                </div>
                            ';
    }
    $xhtmlSpecialProduct .= '</div>';
    $i++;
}

?>

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
                                                            <select id="sort" name="sort">
                                                                <option value="default" selected> - Sắp xếp - </option>
                                                                <option value="price_asc">Giá tăng dần</option>
                                                                <option value="price_desc">Giá giảm dần</option>
                                                                <option value="latest">Mới nhất</option>
                                                            </select>
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
                                    <!-- <div class="product-pagination">
                                        <div class="theme-paggination-block">
                                            <div class="container-fluid p-0">
                                                <div class="row">
                                                    <div class="col-xl-6 col-md-6 col-sm-12">
                                                        <nav aria-label="Page navigation">
                                                            <nav>
                                                                <ul class="pagination">
                                                                    <li class="page-item disabled">
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
                                                                    </li>
                                                                </ul>
                                                            </nav>
                                                        </nav>
                                                    </div>
                                                    <div class="col-xl-6 col-md-6 col-sm-12">
                                                        <div class="product-search-count-bottom">
                                                            <h5>Showing Items 1-12 of 55 Result</h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>