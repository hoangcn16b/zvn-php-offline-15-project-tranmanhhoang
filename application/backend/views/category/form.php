<?php
$data = $this->outPut;

$arrSelect = [
    'status' => ['default' => 'Select Status', 'inactive' => 'Không kích hoạt', 'active' => 'Kích hoạt']
];

$lblName = HelperForm::label('Name', true);
$inputName = HelperForm::input('text', 'form[name]', $data['name'] ?? '', 'form-control');

$lblStatus = HelperForm::label('Status', true);
$selectStatus = HelperForm::selectBox($arrSelect['status'], 'form[status]', $data['status'] ?? 'default');

if (isset($this->arrParams['id'])) {
    $inputId = HelperForm::input('hidden', 'form[id]', $this->arrParams['id']);
}
?>

<div class="row">
    <div class="col-12">
        <form action="" method="POST">
            <div class="card card-outline card-info">
                <div class="card-body">
                    <?php echo Helper::cmsError($this->errors ?? '');
                    
                    ?>
                    <div class="form-group">
                        <?= $lblName . '</br>' . $inputName ?>
                    </div>
                    <div class="form-group">
                        <?= $lblStatus . '</br>' . $selectStatus ?>
                    </div>
                    <?= $inputId ?? '' ?>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success">Save</button>
                    <?php
                    echo Helper::cmsButton(URL::createLink('backend', 'category', 'index'), 'Cancel', 'btn btn-danger');
                    ?>
                </div>
            </div>
        </form>
    </div>
</div>