<?php
$msg = '';
switch ($this->arrParams['type'] ?? '') {
    case 'decline':
        $msg = 'Truy cập bị từ chối!';
        break;
    case 'file_not_exist':
        $msg = 'Đường dẫn không tồn tại!';
        break;
    case 'checkout_success':
        $msg = 'Thông báo!';
        break;
    default:
        $msg = 'Không tìm thấy trang yêu cầu';
        break;
}
$notice = '';
if ((Session::get('messageCheckout') != null)) {
    $notice = Helper::cmsSuccess(Session::get('messageCheckout' ?? ''));
    Session::unset('messageCheckout');
} else {
    $notice = Helper::cmsSuccess(['class' => 'waring', 'content' => 'Bạn chưa đặt hàng, hãy quay lại mua hàng!']);
}
?>
<div class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-title">
                    <!-- <h2 class="py-2">Không tìm thấy trang yêu cầu</h2> -->
                    <h2 class="py-2"><?= $msg ?></h2>
                </div>
            </div>
        </div>
    </div>
</div>
<section class="p-0">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="error-section">
                    <h2>
                        <?= $notice ?>
                    </h2>
                    <!-- <h2>Đường dẫn không hợp lệ</h2> -->
                    <a href="<?= URL::createLink($this->arrParams['module'], $this->arrParams['controller'], 'index') ?>" class="btn btn-solid">Quay lại trang chủ</a>
                </div>
            </div>
        </div>
    </div>
</section>