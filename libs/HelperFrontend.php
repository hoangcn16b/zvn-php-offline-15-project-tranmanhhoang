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
            if ($value['sale_off'] != 0) {
                $priceSale = number_format(($value['price'] - ($value['price'] * $value['sale_off'] / 100)), 0, ',', '.');
                $price = number_format(($value['price']), 0, ',', '.') . ' đ';
            }
            $linktoSpecialProd = URL::createLink('frontend', 'book', 'detail', ['book_id' => $value['id']]);
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
                                                        <a href="' . $linktoSpecialProd . '" class="btn btn-solid mb-1 btn-view-book-detail">Xem chi tiết</a>
                                                    </div>
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
}
