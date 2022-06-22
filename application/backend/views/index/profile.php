<?php

$data = $this->profileUser;
$readOnly = 'readonly';

$lblId = HelperForm::label('ID');
$inputId = HelperForm::input('text', 'form[id]', $data['id'] ?? '', 'form-control', $readOnly);

$lblFullName = HelperForm::label('Fullname');
$inputFullName = HelperForm::input('text', 'form[fullname]', $data['fullname'] ?? '', 'form-control', $readOnly);

$lblUsername = HelperForm::label('Username');
$inputUserName = HelperForm::input('text', 'form[username]', $data['username'] ?? '', 'form-control', $readOnly);

$lblEmail = HelperForm::label('Email');
$inputEmail = HelperForm::input('text', 'form[email]', $data['email'] ?? '', 'form-control', $readOnly);

?>

<div class="row">
    <div class="col-12">
        <form action="" method="POST">
            <div class="card card-outline card-info">
                <div class="card-body">
                    <div class="form-group">
                        <?= $lblId . $inputId ?>
                    </div>
                    <div class="form-group">
                        <?= $lblFullName . $inputFullName ?>
                    </div>
                    <div class="form-group">
                        <?= $lblUsername . $inputUserName ?>
                    </div>
                    <div class="form-group">
                        <?= $lblEmail . $inputEmail ?>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>