<div class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-title">
                    <h2 class="py-2"><?= $this->infoBook . ' sách: ' . $this->bookInfo['name'] ?></h2>
                </div>
            </div>
        </div>
    </div>
</div>
<?php

$bookInfo = $this->bookInfo;
$bookSpecial = $this->getSpecialProduct;
$bookNew = $this->bookNew;
$bookRelate = $this->bookRelate;

//1 bookInfo
$xhtmlBookInfo = '';
$picture = HelperFrontend::loadPicture($bookInfo, 'img-fluid w-100 blur-up lazyload image_zoom_cls-0');
$iconSaleOff = '';
if ($bookInfo['sale_off'] > 0) {
    $saleOff = ($bookInfo['sale_off'] > 0) ? '-' . $bookInfo['sale_off'] . '%' : '';
    $iconSaleOff = '<span> ' . $saleOff . '</span>';
}
$price = '';
$priceSale = HelperFrontend::formatPrice($bookInfo['price']);
$priceReal = $bookInfo['price'] - ($bookInfo['price'] * ($bookInfo['sale_off'] / 100));
if ($bookInfo['sale_off'] != 0) {
    $priceSale = HelperFrontend::formatPrice($priceReal);
    $price = HelperFrontend::formatPrice($bookInfo['price']) . ' đ';
}
$thisDescription = Helper::collapseDesc($bookInfo['description'], 20);
$linkOrder = URL::createLink('frontend', 'cart', 'order', ['book_id' => $bookInfo['id'], 'price' => $priceReal]);
$xhtmlBookInfo = '
                    <div class="col-lg-9 col-sm-12 col-xs-12">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="filter-main-btn mb-2"><span class="filter-btn"><i class="fa fa-filter" aria-hidden="true"></i> filter</span></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-xl-4">
                                    <div class="product-slick">
                                        <div>
                                        ' . $picture . '
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8 col-xl-8 rtl-text">
                                    <div class="product-right">
                                        <h2 class="mb-2">' . $bookInfo['name'] . '</h2>                       
                                        <h4><del>' . $price . '</del>' . $iconSaleOff . '</h4>
                                        <h3>' . $priceSale . ' Đ</h3>
                                        <div class="product-description border-product">
                                            <h6 class="product-title">Số lượng</h6>
                                            <div class="qty-box">
                                                <div class="input-group">
                                                    <span class="input-group-prepend">
                                                        <button type="button" class="btn quantity-left-minus" data-type="minus" data-field="">
                                                            <i class="ti-angle-left"></i>
                                                        </button>
                                                    </span>
                                                    <input type="text" name="this_quantity" class="form-control input-number quantity-number" id ="quantity-number" value="1">
                                                    <span class="input-group-prepend">
                                                        <button type="button" class="btn quantity-right-plus" data-type="plus" data-field="">
                                                            <i class="ti-angle-right"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-buttons">
                                            <a href="' . $linkOrder . '" class="btn btn-solid ml-0 form-cart"><i class="fa fa-cart-plus"></i> Chọn mua</a>
                                        </div>
                                        
                                        <div class="border-product">
                                            ' . $thisDescription . '
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <section class="tab-product m-0">
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-12 col-lg-12">
                                        <ul class="nav nav-tabs nav-material" id="top-tab" role="tablist">
                                            <li class="nav-item"><a class="nav-link active" id="top-home-tab" data-toggle="tab" href="#top-home" role="tab" aria-selected="true">Mô tả sản phẩm</a>
                                                <div class="material-border"></div>
                                            </li>
                                        </ul>
                                        <div class="tab-content nav-material" id="top-tabContent">
                                            <div class="tab-pane fade show active ckeditor-content" id="top-home" role="tabpanel" aria-labelledby="top-home-tab">
                                                <p>' . $bookInfo['content'] . '</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                ';

//2 bookSpecial
$xhtmlBookSpecial = '';

foreach ($bookSpecial as $idCate => $listItems) {
    $xhtmlBookSpecial .= '<div>';
    foreach ($listItems as $key => $value) {
        if ($value['id'] != $this->arrParams['book_id']) {
            $xhtmlBookSpecial .= HelperFrontend::loadSideProd($value);
        }
    }
    $xhtmlBookSpecial .= '</div>';
}

//3 bookNew 
$xhtmlBookNew = '';

foreach ($bookNew as $idNew => $listItemsNew) {
    $xhtmlBookNew .= '<div>';
    foreach ($listItemsNew as $key => $value) {
        if ($value['id'] != $this->arrParams['book_id']) {
            $xhtmlBookNew .= HelperFrontend::loadSideProd($value);
        }
    }
    $xhtmlBookNew .= '</div>';
}

//4 bookRelate
$xhtmlBookRelate = '';
foreach ($bookRelate as $key => $value) {
    if ($value['id'] != $this->arrParams['book_id']) {
        $xhtmlBookRelate .= '<div class="col-xl-2 col-md-4 col-sm-6">';
        $xhtmlBookRelate .= HelperFrontend::loadHome($value);
        $xhtmlBookRelate .= '</div>';
    }
}
?>

<section class="section-b-space">
    <div class="collection-wrapper">
        <div class="container">
            <div class="row">
                <?= $xhtmlBookInfo ?>
                <div class="col-sm-3 collection-filter">
                    <?php require_once SERVICE_LAYOUT . 'service_in_detail.php' ?>
                    <div class="theme-card">
                        <h5 class="title-border">Sách nổi bật</h5>
                        <div class="offer-slider slide-1">
                            <?= $xhtmlBookSpecial ?>
                            <!-- <div>
                                <div class="media">
                                    <a href="item.html">
                                        <img class="img-fluid blur-up lazyload" src="images/product.jpg" alt="Cẩm Nang Cấu Trúc Tiếng Anh"></a>
                                    <div class="media-body align-self-center">
                                        <div class="rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                        <a href="item.html" title="Cẩm Nang Cấu Trúc Tiếng Anh">
                                            <h6>Cẩm Nang Cấu Trúc Tiếng Anh</h6>
                                        </a>
                                        <h4 class="text-lowercase">48,020 đ</h4>
                                    </div>
                                </div>
                                <div class="media">
                                    <a href="item.html">
                                        <img class="img-fluid blur-up lazyload" src="images/product.jpg" alt="Cẩm Nang Cấu Trúc Tiếng Anh"></a>
                                    <div class="media-body align-self-center">
                                        <div class="rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                        <a href="item.html" title="Cẩm Nang Cấu Trúc Tiếng Anh">
                                            <h6>Cẩm Nang Cấu Trúc Tiếng Anh</h6>
                                        </a>
                                        <h4 class="text-lowercase">48,020 đ</h4>
                                    </div>
                                </div>
                                <div class="media">
                                    <a href="item.html">
                                        <img class="img-fluid blur-up lazyload" src="images/product.jpg" alt="Cẩm Nang Cấu Trúc Tiếng Anh"></a>
                                    <div class="media-body align-self-center">
                                        <div class="rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                        <a href="item.html" title="Cẩm Nang Cấu Trúc Tiếng Anh">
                                            <h6>Cẩm Nang Cấu Trúc Tiếng Anh</h6>
                                        </a>
                                        <h4 class="text-lowercase">48,020 đ</h4>
                                    </div>
                                </div>
                                <div class="media">
                                    <a href="item.html">
                                        <img class="img-fluid blur-up lazyload" src="images/product.jpg" alt="Cẩm Nang Cấu Trúc Tiếng Anh"></a>
                                    <div class="media-body align-self-center">
                                        <div class="rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                        <a href="item.html" title="Cẩm Nang Cấu Trúc Tiếng Anh">
                                            <h6>Cẩm Nang Cấu Trúc Tiếng Anh</h6>
                                        </a>
                                        <h4 class="text-lowercase">48,020 đ</h4>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="media">
                                    <a href="item.html">
                                        <img class="img-fluid blur-up lazyload" src="images/product.jpg" alt="Cẩm Nang Cấu Trúc Tiếng Anh"></a>
                                    <div class="media-body align-self-center">
                                        <div class="rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                        <a href="item.html" title="Cẩm Nang Cấu Trúc Tiếng Anh">
                                            <h6>Cẩm Nang Cấu Trúc Tiếng Anh</h6>
                                        </a>
                                        <h4 class="text-lowercase">48,020 đ</h4>
                                    </div>
                                </div>
                                <div class="media">
                                    <a href="item.html">
                                        <img class="img-fluid blur-up lazyload" src="images/product.jpg" alt="Cẩm Nang Cấu Trúc Tiếng Anh"></a>
                                    <div class="media-body align-self-center">
                                        <div class="rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                        <a href="item.html" title="Cẩm Nang Cấu Trúc Tiếng Anh">
                                            <h6>Cẩm Nang Cấu Trúc Tiếng Anh</h6>
                                        </a>
                                        <h4 class="text-lowercase">48,020 đ</h4>
                                    </div>
                                </div>
                                <div class="media">
                                    <a href="item.html">
                                        <img class="img-fluid blur-up lazyload" src="images/product.jpg" alt="Cẩm Nang Cấu Trúc Tiếng Anh"></a>
                                    <div class="media-body align-self-center">
                                        <div class="rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                        <a href="item.html" title="Cẩm Nang Cấu Trúc Tiếng Anh">
                                            <h6>Cẩm Nang Cấu Trúc Tiếng Anh</h6>
                                        </a>
                                        <h4 class="text-lowercase">48,020 đ</h4>
                                    </div>
                                </div>
                                <div class="media">
                                    <a href="item.html">
                                        <img class="img-fluid blur-up lazyload" src="images/product.jpg" alt="Cẩm Nang Cấu Trúc Tiếng Anh"></a>
                                    <div class="media-body align-self-center">
                                        <div class="rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                        <a href="item.html" title="Cẩm Nang Cấu Trúc Tiếng Anh">
                                            <h6>Cẩm Nang Cấu Trúc Tiếng Anh</h6>
                                        </a>
                                        <h4 class="text-lowercase">48,020 đ</h4>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>

                    <div class="theme-card mt-4">
                        <h5 class="title-border">Sách mới</h5>
                        <div class="offer-slider slide-1">
                            <?= $xhtmlBookNew ?>
                            <!-- <div>
                                <div class="media">
                                    <a href="item.html">
                                        <img class="img-fluid blur-up lazyload" src="images/product.jpg" alt="Cẩm Nang Cấu Trúc Tiếng Anh"></a>
                                    <div class="media-body align-self-center">
                                        <div class="rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                        <a href="item.html" title="Cẩm Nang Cấu Trúc Tiếng Anh">
                                            <h6>Cẩm Nang Cấu Trúc Tiếng Anh</h6>
                                        </a>
                                        <h4 class="text-lowercase">48,020 đ</h4>
                                    </div>
                                </div>
                                <div class="media">
                                    <a href="item.html">
                                        <img class="img-fluid blur-up lazyload" src="images/product.jpg" alt="Cẩm Nang Cấu Trúc Tiếng Anh"></a>
                                    <div class="media-body align-self-center">
                                        <div class="rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                        <a href="item.html" title="Cẩm Nang Cấu Trúc Tiếng Anh">
                                            <h6>Cẩm Nang Cấu Trúc Tiếng Anh</h6>
                                        </a>
                                        <h4 class="text-lowercase">48,020 đ</h4>
                                    </div>
                                </div>
                                <div class="media">
                                    <a href="item.html">
                                        <img class="img-fluid blur-up lazyload" src="images/product.jpg" alt="Cẩm Nang Cấu Trúc Tiếng Anh"></a>
                                    <div class="media-body align-self-center">
                                        <div class="rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                        <a href="item.html" title="Cẩm Nang Cấu Trúc Tiếng Anh">
                                            <h6>Cẩm Nang Cấu Trúc Tiếng Anh</h6>
                                        </a>
                                        <h4 class="text-lowercase">48,020 đ</h4>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="media">
                                    <a href="item.html">
                                        <img class="img-fluid blur-up lazyload" src="images/product.jpg" alt="Cẩm Nang Cấu Trúc Tiếng Anh"></a>
                                    <div class="media-body align-self-center">
                                        <div class="rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                        <a href="item.html" title="Cẩm Nang Cấu Trúc Tiếng Anh">
                                            <h6>Cẩm Nang Cấu Trúc Tiếng Anh</h6>
                                        </a>
                                        <h4 class="text-lowercase">48,020 đ</h4>
                                    </div>
                                </div>
                                <div class="media">
                                    <a href="item.html">
                                        <img class="img-fluid blur-up lazyload" src="images/product.jpg" alt="Cẩm Nang Cấu Trúc Tiếng Anh"></a>
                                    <div class="media-body align-self-center">
                                        <div class="rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                        <a href="item.html" title="Cẩm Nang Cấu Trúc Tiếng Anh">
                                            <h6>Cẩm Nang Cấu Trúc Tiếng Anh</h6>
                                        </a>
                                        <h4 class="text-lowercase">48,020 đ</h4>
                                    </div>
                                </div>
                                <div class="media">
                                    <a href="item.html">
                                        <img class="img-fluid blur-up lazyload" src="images/product.jpg" alt="Cẩm Nang Cấu Trúc Tiếng Anh"></a>
                                    <div class="media-body align-self-center">
                                        <div class="rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                        <a href="item.html" title="Cẩm Nang Cấu Trúc Tiếng Anh">
                                            <h6>Cẩm Nang Cấu Trúc Tiếng Anh</h6>
                                        </a>
                                        <h4 class="text-lowercase">48,020 đ</h4>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <section class="section-b-space j-box ratio_asos pb-0">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 product-related">
                                <h2>Sản phẩm liên quan</h2>
                            </div>
                        </div>
                        <div class="row search-product">
                            <?= $xhtmlBookRelate ?>
                            <!-- <div class="col-xl-2 col-md-4 col-sm-6">
                                <div class="product-box">
                                    <div class="img-wrapper">
                                        <div class="lable-block">
                                            <span class="lable4 badge badge-danger"> -34%</span>
                                        </div>
                                        <div class="front">
                                            <a href="item.html">
                                                <img src="images/product.jpg" class="img-fluid blur-up lazyload bg-img" alt="">
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
                                        <a href="item.html" title="Nuôi Con Không Phải Là Cuộc Chiến 2 (Trọn Bộ 3 Tập)">
                                            <h6>Nuôi Con Không Phải Là Cuộc Chiến 2 (Trọn Bộ ...</h6>
                                        </a>
                                        <h4 class="text-lowercase">210,540 đ <del>319,000 đ</del></h4>
                                    </div>
                                </div>

                            </div>
                            <div class="col-xl-2 col-md-4 col-sm-6">
                                <div class="product-box">
                                    <div class="img-wrapper">
                                        <div class="lable-block">
                                            <span class="lable4 badge badge-danger"> -34%</span>
                                        </div>
                                        <div class="front">
                                            <a href="item.html">
                                                <img src="images/product.jpg" class="img-fluid blur-up lazyload bg-img" alt="">
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
                                        <a href="item.html" title="Nuôi Con Không Phải Là Cuộc Chiến 2 (Trọn Bộ 3 Tập)">
                                            <h6>Nuôi Con Không Phải Là Cuộc Chiến 2 (Trọn Bộ ...</h6>
                                        </a>
                                        <h4 class="text-lowercase">210,540 đ <del>319,000 đ</del></h4>
                                    </div>
                                </div>

                            </div> -->
                        </div>
                    </div>
                </section>
                <div class="modal fade bd-example-modal-lg theme-modal cart-modal" id="addtocart" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-body modal1">
                                <div class="container-fluid p-0">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="modal-bg addtocart">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                <div class="media">
                                                    <a href="#">
                                                        <img class="img-fluid blur-up lazyload pro-img" src="/public/files/book/5rf49ech.jpg" alt="">
                                                    </a>
                                                    <div class="media-body align-self-center text-center">
                                                        <a href="#">
                                                            <h6>
                                                                <i class="fa fa-check"></i>Sản phẩm
                                                                <span class="font-weight-bold">Chờ Đến Mẫu Giáo Thì
                                                                    Đã Muộn</span>
                                                                <span> đã được thêm vào giỏ hàng!</span>
                                                            </h6>
                                                        </a>
                                                        <div class="buttons">
                                                            <a href="../gio-hang.html" class="view-cart btn btn-solid">Xem giỏ hàng</a>
                                                            <a href="#" class="continue btn btn-solid" data-dismiss="modal">Tiếp tục mua sắm</a>
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
        </div>
    </div>
</section>

<?php
echo HelperFrontend::quickView($bookRelate, $idName = 'quick-view-relate');

?>