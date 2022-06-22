<?php

$data = $this->outPut;
$arrSelect = [
    'status' => ['default' => 'Select Status', 'inactive' => 'Không kích hoạt', 'active' => 'Kích hoạt'],
    'group' => $this->listGroup
];
$readOnly = isset($this->arrParams['id']) ? 'readonly' : '';

$lblUsername = HelperForm::label('Username', true);
$inputUserName = HelperForm::input('text', 'form[username]', $data['username'] ?? '', 'form-control', $readOnly);

$lblPassWord = HelperForm::label('Password', true);
$inputPassWord = HelperForm::input('password', 'form[password]', $data['password'] ?? '', 'form-control', $readOnly);

$lblEmail = HelperForm::label('Email', true);
$inputEmail = HelperForm::input('text', 'form[email]', $data['email'] ?? '', 'form-control', $readOnly);

$lblFullName = HelperForm::label('Fullname');
$inputFullName = HelperForm::input('text', 'form[fullname]', $data['fullname'] ?? '', 'form-control');

$lblStatus = HelperForm::label('Status', true);
$selectStatus = HelperForm::selectBox($arrSelect['status'], 'form[status]', $data['status'] ?? 'default');

$lblGroup = HelperForm::label('Group', true);
$selectGroup = HelperForm::selectBox($arrSelect['group'], 'form[group_id]', lcfirst($data['group_id'] ?? 'default'));

if (isset($this->arrParams['id'])) {
    $inputId = HelperForm::input('hidden', 'form[id]', $this->arrParams['id']);
    $lblPassWord = '';
    $inputPassWord = '';
}

$idUserLogged = $_SESSION['user']['info']['id'] ?? '';
if (isset($this->arrParams['id']) && $idUserLogged == $this->arrParams['id'] ?? '') {
    $selectStatus = HelperForm::input('text', 'form[status]', $data['status'] ?? '', 'form-control', $readOnly);
    foreach ($this->listGroup as $key => $value) {
        if ($idUserLogged == $key) {
            $getNameGroup = $value;
            break;
        }
    }
    $selectGroupHidden = HelperForm::input('hidden', 'form[group_id]', $data['group_id'] ?? '', 'form-control', $readOnly);
    $selectGroup = HelperForm::input('text', '', $getNameGroup, 'form-control', $readOnly);
}

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
                        <?= $lblUsername . $inputUserName ?>
                    </div>
                    <div class="form-group">
                        <?= $lblPassWord . $inputPassWord ?>
                    </div>
                    <div class="form-group">
                        <?= $lblEmail . $inputEmail ?>
                    </div>
                    <div class="form-group">
                        <?= $lblFullName . $inputFullName ?>
                    </div>
                    <div class="form-group">
                        <?= $lblStatus . $selectStatus ?>
                    </div>
                    <div class="form-group">
                        <?= $lblGroup . $selectGroup . ($selectGroupHidden ?? '') ?>
                    </div>
                    <div class="form-group">
                        <?= $inputId ?? '' ?>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success">Save</button>
                    <a href="<?= URL::createLink('backend', 'user', 'index') ?>" class="btn btn-danger">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>