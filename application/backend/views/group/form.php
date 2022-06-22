<?php
$data = $this->outPut;

$arrSelect = [
    'group_acp' => [2 => 'Select Group ACP', 0 => 'Không kích hoạt', 1 => 'Kích hoạt'],
    'status' => ['default' => 'Select Status', 'inactive' => 'Không kích hoạt', 'active' => 'Kích hoạt']
];

$lblName = HelperForm::label('Name',true);
$inputName = HelperForm::input('text', 'form[name]', $data['name'] ?? '', 'form-control');

$lblGroupAcp = HelperForm::label('Group ACP',true);

$selectGroupAcp = HelperForm::selectBox($arrSelect['group_acp'], 'form[group_acp]', $data['group_acp'] ?? 2);

$lblStatus = HelperForm::label('Status',true);
$selectStatus = HelperForm::selectBox($arrSelect['status'], 'form[status]', $data['status'] ?? 'default');

if (isset($this->arrParams['id'])) {
    $inputId = HelperForm::input('hidden', 'form[id]', $this->arrParams['id']);
}
?>

<div class="row">
    <div class="col-12">
        <!-- <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-exclamation-triangle"></i> Lỗi!</h5>
            <ul class="list-unstyled mb-0">
                <li class="text-white"><b>Name:</b> Giá trị này không được rỗng!</li>
                <li class="text-white"><b>Group ACP:</b> Vui lòng chọn giá trị</li>
                <li class="text-white"><b>Status:</b> Vui lòng chọn giá trị!</li>
            </ul>
        </div> -->
        <form action="" method="POST">
            <div class="card card-outline card-info">
                <div class="card-body">
                    <?= Helper::cmsError($this->errors ?? '') ?>
                    <div class="form-group">
                        <?= $lblName . '</br>' . $inputName ?>
                    </div>
                    <div class="form-group">
                        <?= $lblGroupAcp . '</br>' . $selectGroupAcp ?>
                    </div>
                    <div class="form-group">
                        <?= $lblStatus . '</br>' . $selectStatus ?>
                    </div>
                    <?= $inputId ?? '' ?>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success">Save</button>
                    <a href="<?= URL::createLink('backend', 'group', 'index') ?>" class="btn btn-danger">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>