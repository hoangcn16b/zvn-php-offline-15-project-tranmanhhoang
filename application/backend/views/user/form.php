<?php

$data = $this->outPut;
$arrSelect = [
    'status' => ['default' => 'Select Status', 'inactive' => 'Không kích hoạt', 'active' => 'Kích hoạt'],
    'group' => $this->listGroup
];
if (isset($this->arrParams['id'])) {
    $inputId = HelperForm::input('hidden', 'form[id]', $this->arrParams['id']);
}
$readOnly = isset($this->arrParams['id']) ? 'readonly' : '';
$lblUsername = HelperForm::label('Username', true);
$inputUserName = HelperForm::input('text', 'form[username]', $data['username'] ?? '', 'form-control', $readOnly);

$lblPassWord = HelperForm::label('Password', true);
$inputPassWord = HelperForm::input('password', 'form[password]', $data['password'] ?? '', 'form-control');

$lblEmail = HelperForm::label('Email', true);
$inputEmail = HelperForm::input('text', 'form[email]', $data['email'] ?? '', 'form-control');

$lblFullName = HelperForm::label('Fullname');
$inputFullName = HelperForm::input('text', 'form[fullname]', $data['fullname'] ?? '', 'form-control');

$lblStatus = HelperForm::label('Status', true);
$selectStatus = HelperForm::selectBox($arrSelect['status'], 'form[status]', $data['status'] ?? 'default');

$lblGroup = HelperForm::label('Group', true);
$selectGroup = HelperForm::selectBox($arrSelect['group'], 'form[group]', lcfirst($data['group'] ?? 'default'));


?>

<div class="row">
    <div class="col-12">
        <!-- <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-exclamation-triangle"></i> Lỗi!</h5>
            <ul class="list-unstyled mb-0">
                <li class="text-white"><b>Username:</b> Phải từ 3 đến 50 ký tự</li>
                <li class="text-white"><b>Email:</b> Email không hợp lệ!</li>
                <li class="text-white"><b>Group:</b> Vui lòng chọn giá trị!</li>
                <li class="text-white"><b>Password:</b> Giá trị này không được rỗng!</li>
            </ul>
        </div> -->
        <form action="" method="POST">
            <div class="card card-outline card-info">
                <div class="card-body">
                    <?= Helper::cmsError($this->errors ?? '') ?>
                    <div class="form-group">
                        <?= $lblUsername . '</br>' . $inputUserName ?>
                    </div>
                    <div class="form-group">
                        <?= $lblPassWord . '</br>' . $inputPassWord ?>
                    </div>
                    <div class="form-group">
                        <?= $lblEmail . '</br>' . $inputEmail ?>
                    </div>
                    <div class="form-group">
                        <?= $lblFullName . '</br>' . $inputFullName ?>
                    </div>
                    <div class="form-group">
                        <?= $lblStatus . $selectStatus ?>
                    </div>
                    <div class="form-group">
                        <?= $lblGroup . $selectGroup ?>
                    </div>
                    <div class="form-group">
                        <?= $inputId ?? '' ?>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success">Save</button>
                    <a href="<?= URL::createLink('backend', 'User', 'index') ?>" class="btn btn-danger">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>