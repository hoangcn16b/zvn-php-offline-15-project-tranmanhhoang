<?php

$data = $this->outPut;
$readOnly = 'readonly';

$lblId = HelperForm::label('ID');
$inputId = HelperForm::input('text', 'form[id]', $data['id'] ?? '', 'form-control', $readOnly);

$lblUsername = HelperForm::label('Username');
$inputUserName = HelperForm::input('text', 'form[username]', $data['username'] ?? '', 'form-control', $readOnly);

$lblEmail = HelperForm::label('Email');
$inputEmail = HelperForm::input('text', 'form[email]', $data['email'] ?? '', 'form-control', $readOnly);

$lblFullName = HelperForm::label('Fullname');
$inputFullName = HelperForm::input('text', 'form[fullname]', $data['fullname'] ?? '', 'form-control');

$lblDate = HelperForm::label('Your Birthday(Month/Day/Year)');;
$inputDate = HelperForm::input('date', 'form[birthday]', $data['birthday'] ?? '', 'form-control');

$lblPhone = HelperForm::label('Phone number');
$inputPhone = HelperForm::input('number', 'form[phone]', $data['phone'] ?? '', 'form-control');

$lblAddress = HelperForm::label('Address');
$inputAddress = HelperForm::input('text', 'form[address]', $data['address'] ?? '', 'form-control');

?>

<div class="row">
    <div class="col-12">
        <form action="" method="POST">
            <div class="card card-outline card-info">
                <div class="card-body">
                    <?php
                    echo Helper::cmsError($this->errors ?? '');
                    echo Helper::cmsSuccess($_SESSION['messageProfile'] ?? '');
                    Session::unset('messageProfile');
                    ?>
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
                        <?= $lblDate . $inputDate ?>
                    </div>
                    <div class="form-group">
                        <?= $lblPhone . $inputPhone ?>
                    </div>
                    <div class="form-group">
                        <?= $lblAddress . $inputAddress ?>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success">Save</button>
                        <?php
                        echo Helper::cmsButton(URL::createLink('backend', 'index', 'index'), 'Cancel', 'btn btn-danger');
                        ?>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>