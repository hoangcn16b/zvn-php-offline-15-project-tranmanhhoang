<?php

$data = $this->outPut;

$readOnly = isset($this->arrParams['id']) ? 'readonly' : '';

$lblId = HelperForm::label('ID');
$inputId = HelperForm::input('text', 'form[id]', $data['id'] ?? '', 'form-control', $readOnly);

$lblUsername = HelperForm::label('Username');
$inputUserName = HelperForm::input('text', 'form[username]', $data['username'] ?? '', 'form-control', $readOnly);

// $random = HelperForm::input('button', '', 'Generate', 'p-2 mb-2 bg-primary text-white makepassword');
$hrefRandom = '
    <a href="' . URL::createLink($this->arrParams['module'], $this->arrParams['controller'], $this->arrParams['action'], ['id' => $this->arrParams['id']]) . '" class=" form-control btn btn-primary text-white" style ="width: 100px; text-align: center;">Generate</a>
';
$lblPassWord = HelperForm::label('Password');
$inputPassWord = HelperForm::input('text', 'form[password]', $data['password'] ?? '', 'form-control', 'id="random-password"');


$lblEmail = HelperForm::label('Email');
$inputEmail = HelperForm::input('text', 'form[email]', $data['email'] ?? '', 'form-control', $readOnly);

$lblFullName = HelperForm::label('Fullname');
$inputFullName = HelperForm::input('text', 'form[fullname]', $data['fullname'] ?? '', 'form-control', $readOnly);

// if (isset($this->arrParams['id'])) {
//     $inputId = HelperForm::input('hidden', 'form[id]', $this->arrParams['id']);
//     $lblPassWord = '';
//     $inputPassWord = '';
// }
// <i class="bi bi-arrow-clockwise"></i>
?>
<div class="row">
    <div class="col-12">
        <form action="" method="POST">
            <div class="card card-outline card-info">
                <div class="card-body">
                    <?= Helper::cmsError($this->errors ?? '') ?>
                    <div class="form-group">
                        <?= $lblId . $inputId ?>
                    </div>
                    <div class="form-group">
                        <?= $lblUsername . $inputUserName ?>
                    </div>
                    <div class="form-group">
                        <?= $lblEmail . $inputEmail ?>
                    </div>
                    <div class="form-group">
                        <?= $lblFullName . $inputFullName ?>
                    </div>
                    <div class="form-group">
                        <?= $lblPassWord . '</br>' . $hrefRandom ?>
                        <div> <?= $inputPassWord ?>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success">Save</button>
                    <?php
                    echo Helper::cmsButton(URL::createLink('backend', 'user', 'index'), 'Cancel', 'btn btn-danger');
                    ?>
                </div>
            </div>
        </form>
    </div>
</div>