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
$data = $this->outPut;

$inputId = HelperForm::input('hidden', 'form[id]', $data['id']);

$lblUserName = HelperForm::label('Username', false, '');
$inputUserName = HelperForm::input('text', 'form[username]', $data['username'] ?? '', 'form-control', 'readonly ="1"');

$lblEmail = HelperForm::label('Email', false,);
$inputEmail = HelperForm::input('text', 'form[email]', $data['email'] ?? '', 'form-control', 'readonly');

$lblFullName = HelperForm::label('Họ và tên', false, '');
$inputFullName = HelperForm::input('text', 'form[fullname]', $data['fullname'] ?? '', 'form-control');

$lblDate = HelperForm::label('Your Birthday(Month/Day/Year)');;
$inputDate = HelperForm::input('date', 'form[birthday]', $data['birthday'] ?? '', 'form-control');

$lblPhone = HelperForm::label('Số điện thoại', false, '');
$inputPhone = HelperForm::input('number', 'form[phone]', $data['phone'] ?? '', 'form-control');

$lblAddress = HelperForm::label('Địa chỉ', false, '');
$inputAddress = HelperForm::input('text', 'form[address]', $data['address'] ?? '', 'form-control');

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
                            <li class="user-history"><a href="order-history.html">Lịch sử mua hàng</a></li>
                            <li class="user-logout"><a href="<?= URL::createLink($this->arrParams['module'], 'index', 'logout') ?>">Đăng xuất</a>
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
                            echo Helper::cmsSuccess($_SESSION['messageProfile'] ?? '');
                            Session::unset('messageProfile');
                            ?>
                            <?= $inputId ?>
                            <div class="form-group">
                                <?= $lblUserName . $inputUserName ?>
                            </div>
                            <div class="form-group">
                                <?= $lblEmail . $inputEmail ?>
                            </div>
                            <div class="form-group">
                                <?= $lblFullName . $inputFullName ?>
                            </div>
                            <div class="form-group">
                                <?= $lblDate . $inputDate ?>
                            </div>
                            <div class="form-group">
                                <?= $lblPhone . $inputPhone ?>
                            </div>
                            <div class="form-group">
                                <?= $lblAddress . $inputAddress ?>
                            </div>
                            <!-- <input type="hidden" id="form[token]" name="form[token]" value="1599258345"> -->
                            <button type="submit" id="submit" value="Cập nhật thông tin" class="btn btn-solid btn-sm">Cập nhật thông tin</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>