<?php
$slider = $this->slider;
$xhtmlSlider = '';
if (!empty($slider)) {
    foreach ($slider as $key => $value) {
        $linkImg = UPLOAD_URL . 'slider' . DS . $value['picture'];
        $xhtmlSlider .= '
                    <div>
                    <a href="" class="home text-center">
                        <img src="' . $linkImg . '" alt="" class="bg-img blur-up lazyload">
                    </a>
                    </div>   
                ';
    }
}
$xhtmlSpecialBook = '';
$i = 1;
foreach ($this->specialBook as $key => $value) {
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
        $picture = '<img src ="' . $pathImg . '"  class="img-fluid blur-up lazyload bg-img" alt="product" >';
    } else {
        $pathImg = UPLOAD_URL . 'book' . DS . 'default.png';
        $picture = '<img src ="' . $pathImg . '" class="img-fluid blur-up lazyload" alt="product" >';
    }
    $price = '';
    $priceSale = number_format(($value['price']), 0, ',', '.');
    $priceReal = $value['price'] - ($value['price'] * ($value['sale_off'] / 100));
    if ($value['sale_off'] != 0) {
        $priceSale = number_format(($value['price'] - ($value['price'] * $value['sale_off'] / 100)), 0, ',', '.');
        $price = number_format(($value['price']), 0, ',', '.') . ' đ';
    }
    $linktoSpecialProd = URL::createLink($this->arrParams['module'], 'book', 'detail', ['book_id' => $value['id']]);
    $linkOrder = URL::createLink('frontend', 'cart', 'order', ['book_id' => $value['id'], 'price' => $priceReal]);
    $xhtmlSpecialBook .= '
                            <div class="product-box" title="' . substr($value['description'], 0, 100) . '">
                                <div class="img-wrapper">
                                    ' . $iconSaleOff . '
                                    <div class="front">
                                        <a href="' . $linktoSpecialProd . '">
                                            ' . $picture . '
                                        </a>
                                    </div>
                                    <div class="cart-info cart-wrap">
                                        <a href="' . $linkOrder . '" title="Add to cart"><i class="ti-shopping-cart"></i></a>
                                        <a href="#" id = "clickModal" class="' . $value['id'] . '" title="Quick View"><i class="ti-search" data-toggle="modal" data-target="#quick-view"></i></a>
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
                            <a href="' . $linktoSpecialProd . '" title="' . substr($value['description'], 0, 100) . '">
                                    <h6> ' . $value['name'] . ' </h6>
                                </a>

                            <h4 class="text-lowercase">' . $priceSale . ' đ <del>' . $price . '</del></h4>
                        </div>
                            </div>
                        ';
    $i++;
}

$xhtmlCateSpecial = '';
if ($this->specialCategory) {
    $xhtmlCateSpecial .= '<ul class="tabs tab-title">';
    foreach ($this->specialCategory as $keyC => $valueC) {
        $categoryId = $valueC['id'];
        $categoryName = $valueC['name'];
        $xhtmlCateSpecial .= sprintf('<li><a href="tab-category-%s" class="my-product-tab" data-category="%s">%s</a></li>', $categoryId, $categoryId, $categoryName);

        $linkPreview = URL::createLink($this->arrParams['module'], 'book', 'list', ['id' => $categoryId]);

        $attr = '';
        if ($key == 0) $attr = 'active default';

        $xhtmldetailCate .= '
                    <div id="tab-category-' . $categoryId . '" class="tab-content ' . $attr . '">
                        <div class="no-slider row tab-content-inside">';
        foreach ($valueC['books'] as $keyB => $value) {
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
                $picture = '<img src ="' . $pathImg . '"  class="img-fluid blur-up lazyload bg-img" alt="product" >';
            } else {
                $pathImg = UPLOAD_URL . 'book' . DS . 'default.png';
                $picture = '<img src ="' . $pathImg . '" class="img-fluid blur-up lazyload" alt="product" >';
            }
            $price = '';
            $priceSale = number_format(($value['price']), 0, ',', '.');
            $priceReal = $value['price'] - ($value['price'] * ($value['sale_off'] / 100));

            if ($value['sale_off'] != 0) {
                $priceSale = number_format($priceReal, 0, ',', '.');
                $price = number_format(($value['price']), 0, ',', '.') . ' đ';
            }
            $linktoProdCate = URL::createLink($this->arrParams['module'], 'book', 'detail', ['book_id' => $value['id']]);
            $linkOrder = URL::createLink('frontend', 'cart', 'order', ['book_id' => $value['id'], 'price' => $priceReal]);

            $xhtmldetailCate .= '
                        <div class="product-box" title="' . substr($value['description'], 0, 100) . '">
                            <div class="img-wrapper">
                                <div class="lable-block">
                                    ' . $iconSaleOff . '
                                </div>
                                <div class="front">
                                    <a href="' . $linktoProdCate . '">
                                        ' . $picture . '
                                    </a>
                                </div>
                                <div class="cart-info cart-wrap">
                                    <a href="' . $linkOrder . '" title="Add to cart"><i class="ti-shopping-cart"></i></a>
                                    <a href="#" id = "clickModal" class="' . $value['id'] . '" title="Quick View"><i class="ti-search" data-toggle="modal" data-target="#quick-view"></i></a>
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
                                <a href="' . $linktoProdCate . '" title="' . substr($value['description'], 0, 100) . '">
                                    <h6> ' . $value['name'] . ' </h6>
                                </a>
                            <h4 class="text-lowercase">' . $priceSale . ' đ <del>' . $price . '</del></h4>
                            </div>
                        </div>
                    ';
        }

        $xhtmldetailCate .= '
                        </div>
                        <div class="text-center"><a href="' . $linkPreview . '" class="btn btn-solid">Xem tất cả</a></div>
                    </div> 
                ';
    }
}

?>

<!-- Home slider -->
<section class="p-0 my-home-slider">
    <div class="slide-1 home-slider">
        <?= $xhtmlSlider ?>
        <!-- <div>
            <a href="" class="home text-center">
                <img src="<= $this->_pathImg ?>slider.jpg" alt="" class="bg-img blur-up lazyload">
            </a>
        </div> -->
    </div>
</section>
<!-- Home slider end -->

<!-- Top Collection -->

<div class="title1 section-t-space title5">
    <h2 class="title-inner1">Sản phẩm nổi bật</h2>
    <hr role="tournament6">
</div>
<!-- Product slider -->
<section class="section-b-space p-t-0 j-box ratio_asos">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="product-4 product-m no-arrow">
                    <?= $xhtmlSpecialBook ?>
                    <!-- <div class="product-box">
                        <div class="img-wrapper">
                            <div class="lable-block">
                                <span class="lable4 badge badge-danger"> -35%</span>
                            </div>
                            <div class="front">
                                <a href="item.html">
                                    <img src="< $this->_pathImg ?>product.jpg" class="img-fluid blur-up lazyload bg-img" alt="product">
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
                            <a href="item.html" title="Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores reprehenderit incidunt vero aperiam, ipsum natus.">
                                <h6>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eius, quasi ...</h6>
                            </a>
                            <h4 class="text-lowercase">48,020 đ <del>98,000 đ</del></h4>
                        </div>
                    </div>
                    <div class="product-box">
                        <div class="img-wrapper">
                            <div class="lable-block">
                                <span class="lable4 badge badge-danger"> -35%</span>
                            </div>
                            <div class="front">
                                <a href="item.html">
                                    <img src="<?= $this->_pathImg ?>product.jpg" class="img-fluid blur-up lazyload bg-img" alt="product">
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
                            <a href="item.html" title="Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores reprehenderit incidunt vero aperiam, ipsum natus.">
                                <h6>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eius, quasi ...</h6>
                            </a>
                            <h4 class="text-lowercase">48,020 đ <del>98,000 đ</del></h4>
                        </div>
                    </div>
                    <div class="product-box">
                        <div class="img-wrapper">
                            <div class="lable-block">
                                <span class="lable4 badge badge-danger"> -35%</span>
                            </div>
                            <div class="front">
                                <a href="item.html">
                                    <img src="<?= $this->_pathImg ?>product.jpg" class="img-fluid blur-up lazyload bg-img" alt="product">
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
                            <a href="item.html" title="Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores reprehenderit incidunt vero aperiam, ipsum natus.">
                                <h6>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eius, quasi ...</h6>
                            </a>
                            <h4 class="text-lowercase">48,020 đ <del>98,000 đ</del></h4>
                        </div>
                    </div>
                    <div class="product-box">
                        <div class="img-wrapper">
                            <div class="lable-block">
                                <span class="lable4 badge badge-danger"> -35%</span>
                            </div>
                            <div class="front">
                                <a href="item.html">
                                    <img src="<?= $this->_pathImg ?>product.jpg" class="img-fluid blur-up lazyload bg-img" alt="product">
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
                            <a href="item.html" title="Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores reprehenderit incidunt vero aperiam, ipsum natus.">
                                <h6>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eius, quasi ...</h6>
                            </a>
                            <h4 class="text-lowercase">48,020 đ <del>98,000 đ</del></h4>
                        </div>
                    </div>
                    <div class="product-box">
                        <div class="img-wrapper">
                            <div class="lable-block">
                                <span class="lable4 badge badge-danger"> -35%</span>
                            </div>
                            <div class="front">
                                <a href="item.html">
                                    <img src="<?= $this->_pathImg ?>product.jpg" class="img-fluid blur-up lazyload bg-img" alt="product">
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
                            <a href="item.html" title="Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores reprehenderit incidunt vero aperiam, ipsum natus.">
                                <h6>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eius, quasi ...</h6>
                            </a>
                            <h4 class="text-lowercase">48,020 đ <del>98,000 đ</del></h4>
                        </div>
                    </div>
                    <div class="product-box">
                        <div class="img-wrapper">
                            <div class="lable-block">
                                <span class="lable4 badge badge-danger"> -35%</span>
                            </div>
                            <div class="front">
                                <a href="item.html">
                                    <img src="<?= $this->_pathImg ?>product.jpg" class="img-fluid blur-up lazyload bg-img" alt="product">
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
                            <a href="item.html" title="Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores reprehenderit incidunt vero aperiam, ipsum natus.">
                                <h6>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eius, quasi ...</h6>
                            </a>
                            <h4 class="text-lowercase">48,020 đ <del>98,000 đ</del></h4>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Product slider end -->
<!-- Top Collection end-->

<!-- service layout -->
<?php require_once SERVICE_LAYOUT . 'service_layout.php' ?>
<!-- service layout  end -->

<!-- Tab product -->

<div class="title1 section-t-space title5">
    <h2 class="title-inner1">Danh mục nổi bật</h2>
    <hr role="tournament6">
</div>
<section class="p-t-0 j-box ratio_asos">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="theme-tab">
                    <?= $xhtmlCateSpecial ?>
                    <!-- <ul class="tabs tab-title">
                        <li class="current"><a href="tab-category-1" class="my-product-tab" data-category="1">Bà mẹ - Em bé</a></li>
                        <li><a href="tab-category-5" class="my-product-tab" data-category="5">Học Ngoại Ngữ</a></li>
                        <li><a href="tab-category-3" class="my-product-tab" data-category="3">Công Nghệ Thông
                                Tin</a></li>
                    </ul> -->
                    <?= $xhtmldetailCate ?>
                    <!-- <div class="tab-content-cls">
                        <div id="tab-category-1" class="tab-content active default">
                            <div class="no-slider row tab-content-inside">
                                <div class="product-box">
                                    <div class="img-wrapper">
                                        <div class="lable-block">
                                            <span class="lable4 badge badge-danger"> -35%</span>
                                        </div>
                                        <div class="front">
                                            <a href="item.html">
                                                <img src="<?= $this->_pathImg ?>product.jpg" class="img-fluid blur-up lazyload bg-img" alt="product">
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
                                        <a href="item.html" title="Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores reprehenderit incidunt vero aperiam, ipsum natus.">
                                            <h6>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eius,
                                                quasi ...</h6>
                                        </a>
                                        <h4 class="text-lowercase">48,020 đ <del>98,000 đ</del></h4>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center"><a href="list.html" class="btn btn-solid">Xem tất cả</a></div>
                        </div>
                        <div id="tab-category-2" class="tab-content ">
                            <div class="no-slider row tab-content-inside">
                                <div class="product-box">
                                    <div class="img-wrapper">
                                        <div class="lable-block">
                                            <span class="lable4 badge badge-danger"> -35%</span>
                                        </div>
                                        <div class="front">
                                            <a href="item.html">
                                                <img src="<?= $this->_pathImg ?>product.jpg" class="img-fluid blur-up lazyload bg-img" alt="product">
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
                                        <a href="item.html" title="Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores reprehenderit incidunt vero aperiam, ipsum natus.">
                                            <h6>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eius,
                                                quasi ...</h6>
                                        </a>
                                        <h4 class="text-lowercase">48,020 đ <del>98,000 đ</del></h4>
                                    </div>
                                </div>
                                <div class="product-box">
                                    <div class="img-wrapper">
                                        <div class="lable-block">
                                            <span class="lable4 badge badge-danger"> -35%</span>
                                        </div>
                                        <div class="front">
                                            <a href="item.html">
                                                <img src="<?= $this->_pathImg ?>product.jpg" class="img-fluid blur-up lazyload bg-img" alt="product">
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
                                        <a href="item.html" title="Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores reprehenderit incidunt vero aperiam, ipsum natus.">
                                            <h6>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eius,
                                                quasi ...</h6>
                                        </a>
                                        <h4 class="text-lowercase">48,020 đ <del>98,000 đ</del></h4>
                                    </div>
                                </div>
                                <div class="product-box">
                                    <div class="img-wrapper">
                                        <div class="lable-block">
                                            <span class="lable4 badge badge-danger"> -35%</span>
                                        </div>
                                        <div class="front">
                                            <a href="item.html">
                                                <img src="<?= $this->_pathImg ?>product.jpg" class="img-fluid blur-up lazyload bg-img" alt="product">
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
                                        <a href="item.html" title="Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores reprehenderit incidunt vero aperiam, ipsum natus.">
                                            <h6>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eius,
                                                quasi ...</h6>
                                        </a>
                                        <h4 class="text-lowercase">48,020 đ <del>98,000 đ</del></h4>
                                    </div>
                                </div>
                                <div class="product-box">
                                    <div class="img-wrapper">
                                        <div class="lable-block">
                                            <span class="lable4 badge badge-danger"> -35%</span>
                                        </div>
                                        <div class="front">
                                            <a href="item.html">
                                                <img src="<?= $this->_pathImg ?>product.jpg" class="img-fluid blur-up lazyload bg-img" alt="product">
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
                                        <a href="item.html" title="Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores reprehenderit incidunt vero aperiam, ipsum natus.">
                                            <h6>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eius,
                                                quasi ...</h6>
                                        </a>
                                        <h4 class="text-lowercase">48,020 đ <del>98,000 đ</del></h4>
                                    </div>
                                </div>
                                <div class="product-box">
                                    <div class="img-wrapper">
                                        <div class="lable-block">
                                            <span class="lable4 badge badge-danger"> -35%</span>
                                        </div>
                                        <div class="front">
                                            <a href="item.html">
                                                <img src="<?= $this->_pathImg ?>product.jpg" class="img-fluid blur-up lazyload bg-img" alt="product">
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
                                        <a href="item.html" title="Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores reprehenderit incidunt vero aperiam, ipsum natus.">
                                            <h6>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eius,
                                                quasi ...</h6>
                                        </a>
                                        <h4 class="text-lowercase">48,020 đ <del>98,000 đ</del></h4>
                                    </div>
                                </div>
                                <div class="product-box">
                                    <div class="img-wrapper">
                                        <div class="lable-block">
                                            <span class="lable4 badge badge-danger"> -35%</span>
                                        </div>
                                        <div class="front">
                                            <a href="item.html">
                                                <img src="<?= $this->_pathImg ?>product.jpg" class="img-fluid blur-up lazyload bg-img" alt="product">
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
                                        <a href="item.html" title="Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores reprehenderit incidunt vero aperiam, ipsum natus.">
                                            <h6>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eius,
                                                quasi ...</h6>
                                        </a>
                                        <h4 class="text-lowercase">48,020 đ <del>98,000 đ</del></h4>
                                    </div>
                                </div>
                                <div class="product-box">
                                    <div class="img-wrapper">
                                        <div class="lable-block">
                                            <span class="lable4 badge badge-danger"> -35%</span>
                                        </div>
                                        <div class="front">
                                            <a href="item.html">
                                                <img src="<?= $this->_pathImg ?>product.jpg" class="img-fluid blur-up lazyload bg-img" alt="product">
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
                                        <a href="item.html" title="Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores reprehenderit incidunt vero aperiam, ipsum natus.">
                                            <h6>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eius,
                                                quasi ...</h6>
                                        </a>
                                        <h4 class="text-lowercase">48,020 đ <del>98,000 đ</del></h4>
                                    </div>
                                </div>
                                <div class="product-box">
                                    <div class="img-wrapper">
                                        <div class="lable-block">
                                            <span class="lable4 badge badge-danger"> -35%</span>
                                        </div>
                                        <div class="front">
                                            <a href="item.html">
                                                <img src="<?= $this->_pathImg ?>product.jpg" class="img-fluid blur-up lazyload bg-img" alt="product">
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
                                        <a href="item.html" title="Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores reprehenderit incidunt vero aperiam, ipsum natus.">
                                            <h6>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eius,
                                                quasi ...</h6>
                                        </a>
                                        <h4 class="text-lowercase">48,020 đ <del>98,000 đ</del></h4>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center"><a href="list.html" class="btn btn-solid">Xem tất cả</a></div>
                        </div>
                        <div id="tab-category-3" class="tab-content ">
                            <div class="no-slider row tab-content-inside">
                                <div class="product-box">
                                    <div class="img-wrapper">
                                        <div class="lable-block">
                                            <span class="lable4 badge badge-danger"> -35%</span>
                                        </div>
                                        <div class="front">
                                            <a href="item.html">
                                                <img src="<?= $this->_pathImg ?>product.jpg" class="img-fluid blur-up lazyload bg-img" alt="product">
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
                                        <a href="item.html" title="Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores reprehenderit incidunt vero aperiam, ipsum natus.">
                                            <h6>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eius,
                                                quasi ...</h6>
                                        </a>
                                        <h4 class="text-lowercase">48,020 đ <del>98,000 đ</del></h4>
                                    </div>
                                </div>
                                <div class="product-box">
                                    <div class="img-wrapper">
                                        <div class="lable-block">
                                            <span class="lable4 badge badge-danger"> -35%</span>
                                        </div>
                                        <div class="front">
                                            <a href="item.html">
                                                <img src="<?= $this->_pathImg ?>product.jpg" class="img-fluid blur-up lazyload bg-img" alt="product">
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
                                        <a href="item.html" title="Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores reprehenderit incidunt vero aperiam, ipsum natus.">
                                            <h6>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eius,
                                                quasi ...</h6>
                                        </a>
                                        <h4 class="text-lowercase">48,020 đ <del>98,000 đ</del></h4>
                                    </div>
                                </div>
                                <div class="product-box">
                                    <div class="img-wrapper">
                                        <div class="lable-block">
                                            <span class="lable4 badge badge-danger"> -35%</span>
                                        </div>
                                        <div class="front">
                                            <a href="item.html">
                                                <img src="<?= $this->_pathImg ?>product.jpg" class="img-fluid blur-up lazyload bg-img" alt="product">
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
                                        <a href="item.html" title="Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores reprehenderit incidunt vero aperiam, ipsum natus.">
                                            <h6>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eius,
                                                quasi ...</h6>
                                        </a>
                                        <h4 class="text-lowercase">48,020 đ <del>98,000 đ</del></h4>
                                    </div>
                                </div>
                                <div class="product-box">
                                    <div class="img-wrapper">
                                        <div class="lable-block">
                                            <span class="lable4 badge badge-danger"> -35%</span>
                                        </div>
                                        <div class="front">
                                            <a href="item.html">
                                                <img src="<?= $this->_pathImg ?>product.jpg" class="img-fluid blur-up lazyload bg-img" alt="product">
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
                                        <a href="item.html" title="Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores reprehenderit incidunt vero aperiam, ipsum natus.">
                                            <h6>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eius,
                                                quasi ...</h6>
                                        </a>
                                        <h4 class="text-lowercase">48,020 đ <del>98,000 đ</del></h4>
                                    </div>
                                </div>
                                <div class="product-box">
                                    <div class="img-wrapper">
                                        <div class="lable-block">
                                            <span class="lable4 badge badge-danger"> -35%</span>
                                        </div>
                                        <div class="front">
                                            <a href="item.html">
                                                <img src="<?= $this->_pathImg ?>product.jpg" class="img-fluid blur-up lazyload bg-img" alt="product">
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
                                        <a href="item.html" title="Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores reprehenderit incidunt vero aperiam, ipsum natus.">
                                            <h6>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eius,
                                                quasi ...</h6>
                                        </a>
                                        <h4 class="text-lowercase">48,020 đ <del>98,000 đ</del></h4>
                                    </div>
                                </div>
                                <div class="product-box">
                                    <div class="img-wrapper">
                                        <div class="lable-block">
                                            <span class="lable4 badge badge-danger"> -35%</span>
                                        </div>
                                        <div class="front">
                                            <a href="item.html">
                                                <img src="<?= $this->_pathImg ?>product.jpg" class="img-fluid blur-up lazyload bg-img" alt="product">
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
                                        <a href="item.html" title="Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores reprehenderit incidunt vero aperiam, ipsum natus.">
                                            <h6>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eius,
                                                quasi ...</h6>
                                        </a>
                                        <h4 class="text-lowercase">48,020 đ <del>98,000 đ</del></h4>
                                    </div>
                                </div>
                                <div class="product-box">
                                    <div class="img-wrapper">
                                        <div class="lable-block">
                                            <span class="lable4 badge badge-danger"> -35%</span>
                                        </div>
                                        <div class="front">
                                            <a href="item.html">
                                                <img src="<?= $this->_pathImg ?>product.jpg" class="img-fluid blur-up lazyload bg-img" alt="product">
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
                                        <a href="item.html" title="Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores reprehenderit incidunt vero aperiam, ipsum natus.">
                                            <h6>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eius,
                                                quasi ...</h6>
                                        </a>
                                        <h4 class="text-lowercase">48,020 đ <del>98,000 đ</del></h4>
                                    </div>
                                </div>
                                <div class="product-box">
                                    <div class="img-wrapper">
                                        <div class="lable-block">
                                            <span class="lable4 badge badge-danger"> -35%</span>
                                        </div>
                                        <div class="front">
                                            <a href="item.html">
                                                <img src="<?= $this->_pathImg ?>product.jpg" class="img-fluid blur-up lazyload bg-img" alt="product">
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
                                        <a href="item.html" title="Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores reprehenderit incidunt vero aperiam, ipsum natus.">
                                            <h6>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eius,
                                                quasi ...</h6>
                                        </a>
                                        <h4 class="text-lowercase">48,020 đ <del>98,000 đ</del></h4>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center"><a href="list.html" class="btn btn-solid">Xem tất cả</a></div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</section> <!-- Tab product end -->

<!-- Quick-view modal popup start-->

<!-- <div class="myModal modal fade bd-example-modal-lg theme-modal" id="quick-view" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content quick-view-modal">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
                <div class="row">
                    <div class="col-lg-6 col-xs-12">
                        <div class="quick-view-img"><img src="images/quick-view-bg.jpg" alt="" class="w-100 img-fluid blur-up lazyload book-picture"></div>
                    </div>
                    <div class="col-lg-6 rtl-text">
                        <div class="product-right">
                            <h2 class="book-name">Lorem ipsum dolor sit amet consectetur adipisicing elit. Maiores,
                                distinctio.</h2>
                            <h3 class="book-price">26.910 ₫ <del>39.000 ₫</del></h3>
                            <div class="border-product">
                                <div class="book-description">Lorem ipsum dolor sit amet consectetur, adipisicing
                                    elit. Unde quae cupiditate delectus laudantium odio molestiae deleniti facilis
                                    itaque ut vero architecto nulla officiis in nam qui, doloremque iste. Incidunt,
                                    in?</div>
                            </div>
                            <div class="product-description border-product">
                                <h6 class="product-title">Số lượng</h6>
                                <div class="qty-box">
                                    <div class="input-group">
                                        <span class="input-group-prepend">
                                            <button type="button" class="btn quantity-left-minus" data-type="minus" data-field="">
                                                <i class="ti-angle-left"></i>
                                            </button>
                                        </span>
                                        <input type="text" name="quantity" class="form-control input-number" value="1">
                                        <span class="input-group-prepend">
                                            <button type="button" class="btn quantity-right-plus" data-type="plus" data-field="">
                                                <i class="ti-angle-right"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="product-buttons">
                                <a href="#" class="btn btn-solid mb-1 btn-add-to-cart">Chọn Mua</a>
                                <a href="item.html" class="btn btn-solid mb-1 btn-view-book-detail">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->

<?php
// echo HelperFrontend::quickView($this->specialBook);
// foreach ($this->getSpecialProctduct as $idCategory => $listItems) {
//     echo HelperFrontend::quickView($listItems);
// }
?>
<!-- Quick-view modal popup end -->