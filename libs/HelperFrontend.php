<?php


class HelperFrontend
{
    public static function selectBox($arrData, $name, $keySelected = 'default', $class = '', $attr = '')
    {
        $xhtml = "";
        if (!empty($arrData)) {
            foreach ($arrData as $key => $value) {
                $selected = ((string)$key == $keySelected) ? 'selected' : '';
                $xhtml .= '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
            }
        }
        $xhtml = sprintf('<select name="%s" %s> %s</select>', $name, $attr, $xhtml);
        // $xhtml = '<select class="form-control custom-select ' . $class . '" name="' . $name . '">' . $xhtml . '</select>';
        return $xhtml;
    }

    public static function quickView($arrData = [], $className = 'showMyModal')
    {
        $xhtml = '';
        $i = 1;
        foreach ($arrData as $key => $value) {
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
                $picture = '<img src ="' . $pathImg . '"  class="w-100 img-fluid blur-up lazyload book-picture" >';
            } else {
                $pathImg = UPLOAD_URL . 'book' . DS . 'default.png';
                $picture = '<img src ="' . $pathImg . '" class="w-100 img-fluid blur-up lazyload book-picture" >';
            }
            $price = '';
            $priceSale = number_format(($value['price']), 0, ',', '.');
            $priceReal = $value['price'] - ($value['price'] * $value['sale_off'] / 100);
            if ($value['sale_off'] != 0) {
                $priceSale = number_format($priceReal, 0, ',', '.');
                $price = number_format(($value['price']), 0, ',', '.') . ' đ';
            }
            $linktoSpecialProd = URL::createLink('frontend', 'book', 'detail', ['book_id' => $value['id']]);
            $linkOrder = URL::createLink('frontend', 'cart', 'order', ['book_id' => $value['id'], 'price' => $priceReal]);
            $xhtml .= '
                        <div class=" myModal' . $value['id'] . ' modal fade bd-example-modal-lg theme-modal" id="quick-view" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                <div class="modal-content quick-view-modal">
                                    <div class="modal-body">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
                                        <div class="row">
                                            <div class="col-lg-6 col-xs-12">
                                                <div class="quick-view-img">
                                                ' . $picture . '
                                                </div>
                                            </div>
                                            <div class="col-lg-6 rtl-text">
                                                <div class="product-right">
                                                    <h2 class="book-name">
                                                    ' . $value['name'] . '</h2>
                                                    <h3 class="book-price">' . $priceSale . '<del>' . $price . '</del></h3>
                                                    <div class="border-product">
                                                        <div class="book-description">
                                                        ' . $value['description'] . '</div>
                                                    </div>
                                                    <form action ="' . $linkOrder . '" method = "POST"> 
                                                    <div class="product-description border-product">
                                                        <h6 class="product-title">Số lượng</h6>
                                                        <div class="qty-box">
                                                            <div class="input-group">
                                                                <span class="input-group-prepend">
                                                                    <button type="button" class="btn quantity-left-minus" data-type="minus" data-field="">
                                                                        <i class="ti-angle-left"></i>
                                                                    </button>
                                                                </span>
                                                                <input type="text" name="form[quantity]" class="form-control input-number" value="1">
                                                                <span class="input-group-prepend">
                                                                    <button type="button" class="btn quantity-right-plus" data-type="plus" data-field="">
                                                                        <i class="ti-angle-right"></i>
                                                                    </button>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="product-buttons">
                                                        <button type = "submit" class="btn btn-solid mb-1 btn-add-to-cart">Chọn Mua</button>
                                                        <a href="' . $linktoSpecialProd . '" class="btn btn-solid mb-1 btn-view-book-detail">Xem chi tiết</a>
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                ';
            $i++;
        }
        return $xhtml;
    }

    public static function formatPrice($price)
    {
        $xhtml = number_format(($price), 0, ',', '.');
        return $xhtml;
    }

    public static function loadPicture($value, $folder = 'book', $class = '', $attr = '')
    {
        $class = (!empty($class)) ? $class : '';
        $picturePath = UPLOAD_PATH . $folder . DS . '' . ($value);
        if (file_exists($picturePath) == true) {
            $pathImg = UPLOAD_URL . $folder . DS . '' . ($value);
            $picture = sprintf('<img src ="%s"  class="%s" alt="product" %s>', $pathImg, $class, $attr);
        } else {
            $pathImg = UPLOAD_URL . $folder . DS . 'default.png';
            $picture = sprintf('<img src ="%s" class="%s" alt="product" %s>', $pathImg, $class, $attr);
        }
        return $picture;
    }

    public static function loadHome($value, $picture = null)
    {
        $xhtml = '';
        $iconSaleOff = '';
        $name = Helper::collapseDesc($value['name'], 5);
        $description = Helper::collapseDesc($value['description'], 10);
        $title =  Helper::collapseDesc($value['description'], 30);
        if ($value['sale_off'] > 0) {
            $saleOff = ($value['sale_off'] > 0) ? '-' . $value['sale_off'] . '%' : '';
            $iconSaleOff = '
                                <div class="lable-block">
                                    <span class="lable4 badge badge-danger"> ' . $saleOff . '</span>
                                </div>
                            ';
        }
        $picture = self::loadPicture($value['picture'], 'book', 'img-fluid blur-up lazyload bg-img');
        $price = '';
        $priceSale = self::formatPrice($value['price']);
        $priceReal = $value['price'] - ($value['price'] * ($value['sale_off'] / 100));
        if ($value['sale_off'] != 0) {
            $priceSale = self::formatPrice($priceReal);
            $price = self::formatPrice($value['price']) . ' đ';
        }
        $linktoSpecialProd = URL::createLink('frontend', 'book', 'detail', ['book_id' => $value['id']]);
        $linkOrder = URL::createLink('frontend', 'cart', 'order', ['book_id' => $value['id'], 'price' => $priceReal]);
        $xhtml .= '
                    <div class="product-box" title="' . $title . '">
                            <div class="img-wrapper">
                                ' . $iconSaleOff . '
                                <div class="front">
                                    <a href="' . $linktoSpecialProd . '">
                                        ' . $picture . '
                                    </a>
                                </div>
                                <div class="cart-info cart-wrap">
                                    <a href="' . $linkOrder . '" class="form-cart" title="Add to cart"><i class="ti-shopping-cart"></i></a>
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
                        <a href="' . $linktoSpecialProd . '" title="' . $description . '">
                                <h6> ' . $name . ' </h6>
                            </a>

                        <h4 class="text-lowercase">' . $priceSale . ' đ <del>' . $price . '</del></h4>
                    </div>
                        </div>
                    ';
        return $xhtml;
    }

    public static function loadSlider($value)
    {
        $xhtml = '';
        $linkImg = UPLOAD_URL . 'slider' . DS . $value['picture'];
        $xhtml .= '
                    <div>
                    <a href="" class="home text-center">
                        <img src="' . $linkImg . '" alt="" class="bg-img blur-up lazyload">
                    </a>
                    </div>   
                ';
        return $xhtml;
    }

    public static function loadSideProd($value)
    {
        $xhtml = '';
        $iconSaleOff = '';
        if ($value['sale_off'] > 0) {
            $saleOff = ($value['sale_off'] > 0) ? '-' . $value['sale_off'] . '%' : '';
            $iconSaleOff = '
                            <div class="lable-block">
                                <span class="lable4 badge badge-danger"> ' . $saleOff . '</span>
                            </div>';
        }
        $picture = HelperFrontend::loadPicture($value['picture'], 'book', 'img-fluid blur-up lazyload', 'style = "width:140px; height:210px;"');
        $name = Helper::collapseDesc($value['name'], 5);
        $description = Helper::collapseDesc($value['description'], 30);
        $price = '';
        $priceSale = self::formatPrice($value['price']);
        $priceReal = $value['price'] - ($value['price'] * $value['sale_off'] / 100);
        if ($value['sale_off'] != 0) {
            $priceSale = self::formatPrice($priceReal);
            $price = self::formatPrice($value['price']) . ' đ';
        }
        $linktospecialProd = URL::createLink('frontend', 'book', 'detail', ['book_id' => $value['id']]);
        $xhtml .= '
                    <div class="media">
                        <a href="' . $linktospecialProd . '">
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
                            <a href="' . $linktospecialProd . '" title="' . $description . '">
                                <h6> ' . $name . ' </h6>
                            </a>
                            <p></p>
                            <h4 class="text-lowercase">' . $priceSale . ' đ <del>' . $price . '</del></h4>
                        </div>
                    </div>
                ';
        return $xhtml;
    }

    public static function loadTitle($title = '')
    {
        $xhtml = '
                    <div class="breadcrumb-section">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <div class="page-title">
                                        <h2 class="py-2"> ' . $title . '</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';
        return $xhtml;
    }
}
