<div class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-title">
                    <h2 class="py-2">Giỏ hàng</h2>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$cart = Session::get('cart');
// Session::unset('cart');

$totalItems = 0;
$totalPrice = 0;
if (!empty($cart)) {
    $totalItems = array_sum($cart['quantity']);
    $totalPrice = array_sum($cart['price']);
}

$xhtml = '';
$linkDeleteAll = URL::createLink('frontend', 'cart', 'deleteAll');
if (!empty($this->items)) {
    $xhtml .= '
            <table class="table cart-table table-responsive-xs">
                <thead>
                    <tr class="table-head">
                        <th scope="col">Hình ảnh</th>
                        <th scope="col">Tên sách</th>
                        <th scope="col">Giá</th>
                        <th scope="col">Số Lượng</th>
                        <th scope="col">Delete All 
                            <a href="' . $linkDeleteAll . '" class="icon"><i class="ti-close"></i></a>
                        </th>
                        <th scope="col">Thành tiền</th>
                    </tr>
                </thead>
            ';
    $countPrice = 0;
    foreach ($this->items as $key => $value) {
        $link = URL::createLink($this->arrParams['module'], 'book', 'detail', ['book_id' => $value['id']]);
        $picturePath = UPLOAD_PATH . 'book' . DS . '' . ($value['picture']);
        if (file_exists($picturePath) == true) {
            $pathImg = UPLOAD_URL . 'book' . DS . '' . ($value['picture']);
            $picture = '<img src ="' . $pathImg . '"  alt="" >';
        } else {
            $pathImg = UPLOAD_URL . 'book' . DS . 'default.png';
            $picture = '<img src ="' . $pathImg . '"  alt="" >';
        }
        $price = number_format(($value['price']), 0, ',', '.');
        $totalPrice = number_format(($value['totalprice']), 0, ',', '.');
        $countPrice += $value['totalprice'];
        $linkDeleteProd = URL::createLink('frontend', 'cart', 'deleteProduct', ['book_id' => $value['id']]);
        $xhtml .= '
                <tbody>
                    <tr>
                        <td>
                            <a href="' . $link . '">
                            ' . $picture . '
                            </a>
                        </td>
                        <td><a href="' . $link . '">' . $value['name'] . '</a>
                            <div class="mobile-cart-content row">
                                <div class="col-xs-3">
                                    <div class="qty-box">
                                        <div class="input-group">
                                            <input type="number" name="" value="' . $value['quantity'] . '" class="form-control input-number" id="quantity-10" min="1">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <h2 class="td-color text-lowercase">' . $price . ' đ</h2>
                                </div>
                                <div class="col-xs-3">
                                    <h2 class="td-color text-lowercase">
                                        <a href="#" class="icon"><i class="ti-close"></i></a>
                                    </h2>
                                </div>
                            </div>
                        </td>
                        <td>
                            <h2 class="text-lowercase">' . $price . ' đ</h2>
                        </td>
                        <td>
                            <div class="qty-box">
                                <div class="input-group">
                                    <input type="number" name="form[quantity][]" value="' . $value['quantity'] . '" class="form-control input-number" id="quantity-10" min="1" readonly>
                                </div>
                            </div>
                        </td>
                        <td><a href="' . $linkDeleteProd . '" class="icon"><i class="ti-close"></i></a></td>
                        <td>
                            <h2 class="td-color text-lowercase">' . $totalPrice . ' đ</h2>
                        </td>
                    </tr>
                    <input type="hidden" name="form[book_id][]" value="' . $value['id'] . '" id="input_book_id_10">
                    <input type="hidden" name="form[price][]" value="' . $value['price'] . '" id="input_price_10">
                    <input type="hidden" name="" value="' . $value['quantity'] . '" id="input_quantity_10">
                    <input type="hidden" name="form[name][]" value="' . $value['name'] . '" id="input_name_10">
                    <input type="hidden" name="form[picture][]" value="' . $value['picture'] . '" id="input_picture_10">
                </tbody>
            ';
    }
    $countPrice = number_format($countPrice, 0, ',', '.');
    $xhtml .= '
                </table>
                    <table class="table cart-table table-responsive-md">
                        <tfoot>
                            <tr>
                                <td>Tổng :</td>
                                <td>
                                    <h2 class="text-lowercase">' . $countPrice . ' đ</h2>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    

                ';
} else {
    $xhtml = 'Chưa có sẳn phẩm được thêm vào, hãy mua thêm sản phẩm!';
}
$linkContinue = URL::createLink('frontend', 'book', 'list');
$linkSubmit = URL::createLink('frontend', 'cart', 'buy');
?>

<form action="<?= $linkSubmit ?>" method="POST" name="admin-form" id="admin-form">
    <section class="cart-section section-b-space">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <?= $xhtml ?>
                    <!-- <table class="table cart-table table-responsive-xs">
                        <thead>
                            <tr class="table-head">
                                <th scope="col">Hình ảnh</th>
                                <th scope="col">Tên sách</th>
                                <th scope="col">Giá</th>
                                <th scope="col">Số Lượng</th>
                                <th scope="col"></th>
                                <th scope="col">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <a href="item.html"><img src="images/product.jpg" alt="Chờ Đến Mẫu Giáo Thì Đã Muộn"></a>
                                </td>
                                <td><a href="item.html">Chờ Đến Mẫu Giáo Thì Đã Muộn</a>
                                    <div class="mobile-cart-content row">
                                        <div class="col-xs-3">
                                            <div class="qty-box">
                                                <div class="input-group">
                                                    <input type="number" name="quantity" value="1" class="form-control input-number" id="quantity-10" min="1">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-3">
                                            <h2 class="td-color text-lowercase">48,300 đ</h2>
                                        </div>
                                        <div class="col-xs-3">
                                            <h2 class="td-color text-lowercase">
                                                <a href="#" class="icon"><i class="ti-close"></i></a>
                                            </h2>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <h2 class="text-lowercase">48,300 đ</h2>
                                </td>
                                <td>
                                    <div class="qty-box">
                                        <div class="input-group">
                                            <input type="number" name="quantity" value="1" class="form-control input-number" id="quantity-10" min="1">
                                        </div>
                                    </div>
                                </td>
                                <td><a href="#" class="icon"><i class="ti-close"></i></a></td>
                                <td>
                                    <h2 class="td-color text-lowercase">48,300 đ</h2>
                                </td>
                            </tr>
                            <input type="hidden" name="form[book_id][]" value="10" id="input_book_id_10">
                            <input type="hidden" name="form[price][]" value="48300" id="input_price_10">
                            <input type="hidden" name="form[quantity][]" value="1" id="input_quantity_10">
                            <input type="hidden" name="form[name][]" value="Chờ Đến Mẫu Giáo Thì Đã Muộn" id="input_name_10"><input type="hidden" name="form[picture][]" value="product.jpg" id="input_picture_10">
                            <tr>
                                <td>
                                    <a href="item.html"><img src="images/product.jpg" alt="Cẩm Nang Cấu Trúc Tiếng Anh"></a>
                                </td>
                                <td>
                                    <a href="item.html">Cẩm Nang Cấu Trúc Tiếng Anh</a>
                                    <div class="mobile-cart-content row">
                                        <div class="col-xs-3">
                                            <div class="qty-box">
                                                <div class="input-group">
                                                    <input type="number" name="quantity" value="1" class="form-control input-number" id="quantity-47" min="1">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-3">
                                            <h2 class="td-color text-lowercase">48,020 đ</h2>
                                        </div>
                                        <div class="col-xs-3">
                                            <h2 class="td-color text-lowercase">
                                                <a href="#" class="icon"><i class="ti-close"></i></a>
                                            </h2>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <h2 class="text-lowercase">48,020 đ</h2>
                                </td>
                                <td>
                                    <div class="qty-box">
                                        <div class="input-group">
                                            <input type="number" name="quantity" value="1" class="form-control input-number" id="quantity-47" min="1">
                                        </div>
                                    </div>
                                </td>
                                <td><a href="#" class="icon"><i class="ti-close"></i></a></td>
                                <td>
                                    <h2 class="td-color text-lowercase">48,020 đ</h2>
                                </td>
                            </tr>
                            <input type="hidden" name="form[book_id][]" value="47" id="input_book_id_47">
                            <input type="hidden" name="form[price][]" value="48020" id="input_price_47">
                            <input type="hidden" name="form[quantity][]" value="1" id="input_quantity_47">
                            <input type="hidden" name="form[name][]" value="Cẩm Nang Cấu Trúc Tiếng Anh" id="input_name_47"><input type="hidden" name="form[picture][]" value="product.jpg" id="input_picture_47">
                        </tbody>
                    </table>
                    <table class="table cart-table table-responsive-md">
                        <tfoot>
                            <tr>
                                <td>Tổng :</td>
                                <td>
                                    <h2 class="text-lowercase">96,320 đ</h2>
                                </td>
                            </tr>
                        </tfoot>
                    </table> -->
                </div>
            </div>
            <div class="row cart-buttons">
                <div class="col-6"><a href="<?= $linkContinue ?>" class="btn btn-solid">Tiếp tục mua sắm</a></div>
                <?php if (!empty($this->items)) {
                    echo '<div class="col-6"><button type="submit" class="btn btn-solid">Đặt hàng</button></div>';
                } ?>
            </div>
        </div>
    </section>
</form>