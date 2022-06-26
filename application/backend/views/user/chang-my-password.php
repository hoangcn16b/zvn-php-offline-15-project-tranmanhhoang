<?php

$data = $this->outPut;

$inputId = HelperForm::input('hidden', 'form[id]', $data['id'] ?? '');
$inputEmail = HelperForm::input('hidden', 'form[email]', $data['email'] ?? '');
$inputUserName = HelperForm::input('hidden', 'form[username]', $data['username'] ?? '');

$lblPass = HelperForm::label('Password hiện tại', true);
$inputPass = HelperForm::input('text', 'form[password]', '', 'form-control');

$lblPassNew = HelperForm::label('Password mới', true);
$inputPassNew = HelperForm::input('text', 'form[new password]', '', 'form-control');

$lblRewritePass = HelperForm::label('Nhập lại password mới', true);
$inputRewritePass = HelperForm::input('text', 'form[new password confirm]', '', 'form-control');

?>
<div class="row">
    <div class="col-12">
        <form action="" method="POST">
            <div class="card card-outline card-info">
                <div class="card-body">
                    <?= Helper::cmsError($this->errors ?? '') ?>
                    <?= Helper::cmsError($this->errors1 ?? '') ?>
                    <div class="form-group">
                        <?= $inputId . $inputEmail . $inputUserName ?>
                    </div>
                    <div class="form-group">
                        <?= $lblPass . $inputPass ?>
                    </div>
                    <div class="form-group">
                        <?= $lblPassNew . $inputPassNew ?>
                    </div>
                    <div class="form-group">
                        <?= $lblRewritePass . $inputRewritePass ?>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success">Save</button>
                    <?php
                    echo Helper::cmsButton(URL::createLink('backend', 'index', 'index'), 'Cancel', 'btn btn-danger');
                    ?>
                </div>
            </div>
        </form>
    </div>
</div>