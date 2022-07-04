<div class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-title">
                    <h2 class="py-2">
                        <?= $this->titlePage ?></h2>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

$inputId = HelperForm::input('hidden', 'form[id]', $this->arrParams['idLogged'] ?? '', 'form-control');
$inputUserName = HelperForm::input('hidden', 'form[username]', $this->arrParams['userLogged']['username'] ?? '', 'form-control');
$inputEmail = HelperForm::input('hidden', 'form[email]', $this->arrParams['userLogged']['email'] ?? '', 'form-control');

$lblPass = HelperForm::label('Password hiện tại', true);
$inputPass = HelperForm::input('text', 'form[password]', '', 'form-control');

$lblPassNew = HelperForm::label('Password mới', true);
$inputPassNew = HelperForm::input('text', 'form[new password]', '', 'form-control');

$lblConfirmPass = HelperForm::label('Nhập lại password mới', true);
$inputConfirmPass = HelperForm::input('text', 'form[new password confirm]', '', 'form-control');

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
                            <li class="active"><a href="<?= URL::createLink($this->arrParams['module'], 'user', 'profile') ?>">Thông tin tài khoản</a></li>
                            <li class=""><a href="<?= URL::createLink($this->arrParams['module'], 'user', 'password') ?>">Thay đổi mật khẩu</a></li>
                            <li class=""><a href="order-history.html">Lịch sử mua hàng</a></li>
                            <li class=""><a href="<?= URL::createLink($this->arrParams['module'], 'index', 'logout') ?>">Đăng xuất</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="dashboard-right">
                    <div class="dashboard">
                        <form action="" method="post" id="admin-form" class="theme-form">
                            <?php
                            echo Helper::cmsError($this->errors ?? '');
                            ?>
                            <?= $inputId . $inputUserName . $inputEmail ?>
                            <div class="form-group">
                                <?= $lblPass . $inputPass ?>
                            </div>
                            <div class="form-group">
                                <?= $lblPassNew . $inputPassNew ?>
                            </div>
                            <div class="form-group">
                                <?= $lblConfirmPass . $inputConfirmPass ?>
                            </div>
                            <!-- <input type="hidden" id="form[token]" name="form[token]" value="1599258345"> -->
                            <button type="submit" id="submit" class="btn btn-solid btn-sm">Cập nhật mật khẩu </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>