<?php
$data = $this->outPut;

// $inputRamdomString = HelperForm::input('text', 'form[username]', $random, 'form-control');
$lblUsername = HelperForm::label('Tên tài khoản', 'required');
$inputUserName = HelperForm::input('text', 'form[username]', $data['username'] ?? '', 'form-control');

$lblPassWord = HelperForm::label('Password', 'required');
$inputPassWord = HelperForm::input('password', 'form[password]', $data['password'] ?? '', 'form-control');

$lblEmail = HelperForm::label('Email', 'required');
$inputEmail = HelperForm::input('text', 'form[email]', $data['email'] ?? '', 'form-control');

$lblFullName = HelperForm::label('Fullname', false, 'required');
$inputFullName = HelperForm::input('text', 'form[fullname]', $data['fullname'] ?? '', 'form-control');

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
<section class="register-page section-b-space">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3>Đăng ký tài khoản</h3>
                <div class="theme-card">
                    <form action="" method="post" id="admin-form" class="theme-form">
                        <?= Helper::cmsError($this->errors ?? '') ?>
                        <div class="form-row">
                            <div class="col-md-6">
                                <?= $lblUsername . $inputUserName ?>
                            </div>
                            <div class="col-md-6">
                                <?= $lblFullName . $inputFullName ?>
                            </div>
                            <div class="col-md-6">
                                <?= $lblEmail . $inputEmail ?>
                            </div>
                            <div class="col-md-6">
                                <?= $lblPassWord . $inputPassWord ?>
                            </div>
                        </div>
                        <!-- <input type="hidden" id="form[token]" name="form[token]" value="1599208957"> -->
                        <button type="submit" id="submit" name="submit" value="Tạo tài khoản" class="btn btn-solid">Tạo tài khoản</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>