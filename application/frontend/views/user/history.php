<div class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-title">
                    <h2 class="py-2">Lịch sử mua hàng</h2>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$listStatus =
    [
        'new' => 'New', 'waiting' => 'Waiting', 'process' => 'Process', 'completed' => 'Completed'
    ];
$xhtml = '';
if (!empty($this->items)) {
    foreach ($this->items as $key => $item) {
        $tableContent = '';
        $cartId = $item['id'];
        $tableHeader = '<thead>
                            <tr>
                                <td>Hình ảnh</td>
                                <td>Tên sách</td>
                                <td>Giá</td>
                                <td>Số lượng</td>
                                <td>Thành tiền</td>
                            </tr>
                        </thead>';


        $date = date("H:i d/m/Y", strtotime($item['date']));
        $arrBook = json_decode($item['books']);
        $arrPrice = json_decode($item['prices']);
        $arrName = json_decode($item['names']);
        $arrQuantity = json_decode($item['quantities']);
        $arrPicture = json_decode($item['pictures']);
        $totalPrice = 0;
        foreach ($arrBook as $keyB => $valueB) {
            $linkDetail = URL::createLink('frontend', 'book', 'detail', ['book_id' => $valueB]);
            $name = $arrName[$keyB];
            $price = $arrPrice[$keyB];
            $formatPrice = number_format($price);
            $quantity = $arrQuantity[$keyB];
            $totalperProd = number_format($price * $quantity);
            $name = $arrName[$keyB];
            $picturePath = UPLOAD_PATH . 'book' . DS . '' . ($arrPicture[$keyB]);
            if (file_exists($picturePath) == true) {
                $pathImg = UPLOAD_URL . 'book' . DS . '' . ($arrPicture[$keyB]);
                $picture = '<img src ="' . $pathImg . '" style="width: 80px" alt="' . $name . '" >';
            } else {
                $pathImg = UPLOAD_URL . 'book' . DS . 'default.png';
                $picture = '<img src ="' . $pathImg . '" style="width: 80px" alt="default" >';
            }
            $totalPrice += $price * $quantity;
            $tableContent .= '
                        <tr>
                            <td><a href="' . $linkDetail . '"> ' . $picture . '</a>
                            </td>
                            <td style="min-width: 200px"> ' . $name . '</td>
                            <td style="min-width: 100px">' . $formatPrice . ' đ</td>
                            <td>' . $quantity . '</td>
                            <td style="min-width: 150px">' . $totalperProd . ' đ</td>
                        </tr>';
        }
        $formatTotalPrice = number_format($totalPrice);
        foreach ($listStatus as $key => $value) {
            if ($item['status'] == $key) {
                $status = $value;
                break;
            }
        }
        $xhtml .= '
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><button style="text-transform: none;" class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#' . $cartId . '">Mã đơn hàng:
                                    ' . $cartId . '</button>&nbsp;&nbsp;Thời gian: ' . $date . '&nbsp;&nbsp; Trạng thái: <b>' . $status . '</b></h5>
                        </div>
                        <div id="' . $cartId . '" class="collapse" data-parent="#accordionExample">
                            <div class="card-body table-responsive">
                                <table class="table btn-table">
                                    ' . $tableHeader . '
                                    <tbody>
                                        ' . $tableContent . '
                                    </tbody>
                                    <tfoot>
                                        <tr class="my-text-primary font-weight-bold">
                                            <td colspan="4" class="text-right">Tổng: </td>
                                            <td>' . $formatTotalPrice . ' đ</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                ';
    }
} else {
    $xhtml .= '<h2>Chưa có đơn hàng nào!</h2>';
}

?>


<section class="faq-section section-b-space">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="account-sidebar">
                    <a class="popup-btn">Menu</a>
                </div>
                <h3 class="d-lg-none">Tài khoản</h3>
                <div class="dashboard-left">
                    <div class="collection-mobile-back"><span class="filter-back"><i class="fa fa-angle-left" aria-hidden="true"></i> Ẩn</span></div>
                    <div class="block-content">
                        <ul>
                            <li class="user-profile"><a href="<?= URL::createLink($this->arrParams['module'], 'user', 'profile') ?>">Thông tin tài khoản</a></li>
                            <li class="user-password"><a href="<?= URL::createLink($this->arrParams['module'], 'user', 'password') ?>">Thay đổi mật khẩu</a></li>
                            <li class="user-history"><a href="<?= URL::createLink($this->arrParams['module'], 'user', 'history') ?>">Lịch sử mua hàng</a></li>
                            <li class="user-logout"><a href="<?= URL::createLink($this->arrParams['module'], 'index', 'logout') ?>">Đăng xuất</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="accordion theme-accordion" id="accordionExample">
                    <div class="accordion theme-accordion" id="accordionExample">
                        <!-- <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <button style="text-transform: none;" class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#rIgdYJf">Mã đơn hàng:
                                        rIgdYJf</button>&nbsp;&nbsp;Thời gian: 03/09/2020 10:07:21
                                </h5>
                            </div>
                            <div id="rIgdYJf" class="collapse" data-parent="#accordionExample">
                                <div class="card-body table-responsive">
                                    <table class="table btn-table">

                                        <thead>
                                            <tr>
                                                <td>Hình ảnh</td>
                                                <td>Tên sách</td>
                                                <td>Giá</td>
                                                <td>Số lượng</td>
                                                <td>Thành tiền</td>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            <tr>
                                                <td><a href="#"><img src="images/product.jpg" alt="Kiến Trúc Hướng Dòng Thông Gió Tự Nhiên (Tái Bản)" style="width: 80px"></a></td>
                                                <td style="min-width: 200px">Kiến Trúc Hướng Dòng Thông Gió Tự Nhiên
                                                    (Tái Bản)</td>
                                                <td style="min-width: 100px">70,550 đ</td>
                                                <td>1</td>
                                                <td style="min-width: 150px">70,550 đ</td>
                                            </tr>
                                            <tr></tr>
                                        </tbody>
                                        <tfoot>
                                            <tr class="my-text-primary font-weight-bold">
                                                <td colspan="4" class="text-right">Tổng: </td>
                                                <td>70,550 đ</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div> -->
                        <?= $xhtml ?>


                        <!-- <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0"><button style="text-transform: none;" class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#kqxfDul">Mã đơn hàng:
                                        kqxfDul</button>&nbsp;&nbsp;Thời gian: 30/08/2020 21:20:14</h5>
                            </div>
                            <div id="kqxfDul" class="collapse" data-parent="#accordionExample">
                                <div class="card-body table-responsive">
                                    <table class="table btn-table">

                                        <thead>
                                            <tr>
                                                <td>Hình ảnh</td>
                                                <td>Tên sách</td>
                                                <td>Giá</td>
                                                <td>Số lượng</td>
                                                <td>Thành tiền</td>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            <tr>
                                                <td><a href="#"><img src="images/product.jpg" alt="Giáo Trình Kỹ Thuật Lập Trình C Căn Bản Và Nâng Cao" style="width: 80px"></a></td>
                                                <td style="min-width: 200px">Giáo Trình Kỹ Thuật Lập Trình C Căn Bản Và
                                                    Nâng Cao</td>
                                                <td style="min-width: 100px">101,250 đ</td>
                                                <td>1</td>
                                                <td style="min-width: 150px">101,250 đ</td>
                                            </tr>

                                            <tr>
                                                <td><a href="#"><img src="images/product.jpg" alt="Kiến Trúc Hướng Dòng Thông Gió Tự Nhiên (Tái Bản)" style="width: 80px"></a></td>
                                                <td style="min-width: 200px">Kiến Trúc Hướng Dòng Thông Gió Tự Nhiên
                                                    (Tái Bản)</td>
                                                <td style="min-width: 100px">70,550 đ</td>
                                                <td>1</td>
                                                <td style="min-width: 150px">70,550 đ</td>
                                            </tr>

                                            <tr>
                                                <td><a href="#"><img src="images/product.jpg" alt="Cẩm Nang Cấu Trúc Tiếng Anh" style="width: 80px"></a>
                                                </td>
                                                <td style="min-width: 200px">Cẩm Nang Cấu Trúc Tiếng Anh</td>
                                                <td style="min-width: 100px">48,020 đ</td>
                                                <td>1</td>
                                                <td style="min-width: 150px">48,020 đ</td>
                                            </tr>
                                            <tr></tr>
                                        </tbody>
                                        <tfoot>
                                            <tr class="my-text-primary font-weight-bold">
                                                <td colspan="4" class="text-right">Tổng: </td>
                                                <td>219,820 đ</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>