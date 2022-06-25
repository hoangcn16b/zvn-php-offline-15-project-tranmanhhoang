<?php
echo Helper::cmsSuccess($_SESSION['messageRegister'] ?? '');
Session::unset('messageRegister');

$lblEmail = HelperForm::label('Email', false, 'required');
$inputEmail = HelperForm::input('email', 'form[email]', $data['name'] ?? '', 'form-control', 'id="form[email]"');

$lblPassword = HelperForm::label('Password', false, 'required');
$inputPassword = HelperForm::input('password', 'form[password]', $data['name'] ?? '', 'form-control', 'id="form[password]"');

$linkAction = URL::createLink($this->arrParams['module'], $this->arrParams['controller'], $this->arrParams['action'])

?>
<div class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-title">
                    <h2 class="py-2"><?= $this->titlePage ?? '' ?></h2>
                </div>
            </div>
        </div>
    </div>
</div>
<section class="login-page section-b-space">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h3>Đăng nhập</h3>
                <div class="theme-card">
                    <?php echo Helper::cmsError($this->errors ?? '');
                    echo Helper::cmsSuccess($_SESSION['messageChangePass'] ?? '');
                    echo Helper::cmsSuccess($_SESSION['messageLogin'] ?? '');
                    Session::unset('messageChangePass');
                    Session::unset('messageLogin');
                    ?>
                    <form action="<?= $linkAction ?>" method="post" id="admin-form" class="theme-form">
                        <div class="form-group">
                            <?= $lblEmail . $inputEmail ?>
                        </div>
                        <div class="form-group">
                            <?= $lblPassword . $inputPassword ?>
                        </div>
                        <!-- <input type="hidden" id="form[token]" name="form[token]" value="1599208737"> -->
                        <button type="submit" id="submit" name="form[submit]" value="Đăng nhập" class="btn btn-solid">Đăng nhập</button>
                    </form>
                </div>
            </div>
            <div class="col-lg-6 right-login">
                <h3>Khách hàng mới</h3>
                <div class="theme-card authentication-right">
                    <h6 class="title-font">Đăng ký tài khoản</h6>
                    <p>Sign up for a free account at our store. Registration is quick and easy. It allows you to be
                        able to order from our shop. To start shopping click register.</p>
                    <a href="<?= URL::createLink($this->arrParams['module'], $this->arrParams['controller'], 'register') ?>" class="btn btn-solid">Đăng ký</a>
                </div>
            </div>
        </div>
    </div>
</section>