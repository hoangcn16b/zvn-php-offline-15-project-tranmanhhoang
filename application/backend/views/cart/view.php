<?php

$listStatus =
    [
        'new' => 'New', 'waiting' => 'Waiting', 'process' => 'Process', 'completed' => 'Completed'
    ];
$item = $this->getItem;
$xhtml = '';
$titleContent = '';
$tableContent = '';
if (!empty($item)) {
    $id = $item['id'];
    $date = date("H:i d/m/Y", strtotime($item['date']));
    foreach ($listStatus as $key => $value) {
        if ($item['status'] == $key) {
            $status = $value;
            break;
        }
    }
    $titleContent = '
                    <h4 class="card-title">
                        <span><b>Mã đơn hàng: </b> ' . $id . '</span> ||
                        <span><b>Ngày đặt:</b> ' . $date . '</span> ||
                        <span><b>Khách hàng:</b> ' . $item['username'] . '</span> ||
                        <span><b>Trạng thái:</b> ' . $status . '</span>
                    </h4>';

    $date = date("H:i d/m/Y", strtotime($item['date']));
    $arrBook = json_decode($item['books']);
    $arrPrice = json_decode($item['prices']);
    $arrName = json_decode($item['names']);
    $arrQuantity = json_decode($item['quantities']);
    $arrPicture = json_decode($item['pictures']);
    $totalPrice = 0;
    $totalQty = 0;
    foreach ($arrBook as $keyB => $valueB) {
        $idBook = $valueB;
        $linkBook = URL::createLink('backend', 'book', 'form', ['id' => $idBook]);
        $name = $arrName[$keyB];
        $price = $arrPrice[$keyB];
        $formatPrice = number_format($price);
        $quantity = $arrQuantity[$keyB];
        $totalperProd = number_format($price * $quantity);
        $name = $arrName[$keyB];
        $totalQty += $quantity;
        $totalPrice += $price * $quantity;
        $picturePath = UPLOAD_PATH . 'book' . DS . '' . ($arrPicture[$keyB]);
        if (file_exists($picturePath) == true) {
            $pathImg = UPLOAD_URL . 'book' . DS . '' . ($arrPicture[$keyB]);
            $picture = '<img src ="' . $pathImg . '" class="item-image w-100" >';
        } else {
            $pathImg = UPLOAD_URL . 'book' . DS . 'default.png';
            $picture = '<img src ="' . $pathImg . '" class="item-image w-100" >';
        }
        $tableContent .= '
                            <tr>
                                <td style="width: 120px; padding: 5px"><a href = "' . $linkBook . '">' . $picture . '</a></td>
                                <td class="text-wrap" style="min-width: 180px">' . $name . '</td>
                                <td class="text-center">' . $formatPrice . 'đ</td>
                                <td class="text-center">' . $quantity . '</td>
                                <td class="text-center">' . $totalperProd . 'đ</td>
                            </tr>';
    }
    $formatTotalPrice = number_format($totalPrice);
    $tableContent .= '
                        <tr>
                            <td></td>
                            <td></td>
                            <td class="text-center"><b>Tổng</b></td>
                            <td class="text-center"><b>' . $totalQty . '</b></td>
                            <td class="text-center"><b>' . $formatTotalPrice . 'đ</b></td>
                        </tr>';
}

?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h1 class="m-0 text-dark">Deal Detail</h1>
                <a href="<?= URL::createLink('backend', 'cart', 'index') ?>" class="btn btn-info"><i class="fas fa-arrow-circle-left"></i> Quay về</a>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</div> <!-- /.content-header -->


<!-- Main content -->
<section class="content">
    <div class="container-fluid">

        <div class="card card-info card-outline">
            <div class="card-header">
                <?= $titleContent ?>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fas fa-minus"></i></button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">

                    <table class="table table-bordered table-hover text-nowrap btn-table mb-0">
                        <thead>
                            <tr>
                                <th class="text-center">Hình ảnh</th>
                                <th>Tên sách</th>
                                <th class="text-center">Giá</th>
                                <th class="text-center">Số lượng</th>
                                <th class="text-center">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?= $tableContent ?>
                            <!-- <tr>
                                <td style="width: 120px; padding: 5px"><img class="item-image w-100" src="/public/files/book/zq148n3m.jpg"></td>
                                <td class="text-wrap" style="min-width: 180px">Cẩm Nang Cấu Trúc Tiếng Anh</td>
                                <td class="text-center">48.020 đ</td>
                                <td class="text-center">1</td>
                                <td class="text-center">48.020 đ</td>
                            </tr> -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer clearfix">
            </div>
        </div>
    </div>
</section>