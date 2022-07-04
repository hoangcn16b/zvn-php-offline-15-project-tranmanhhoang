<?php

$data = $this->outPut;
// unset($this->listCategory['default']);
$arrSelect = [
    'active' => 'Hiển thị', 'inactive' => 'Không hiển thị'
];

$readOnly = isset($this->arrParams['id']) ? 'readonly' : '';
$labelExistPic = ': None!';
$readOnly = '';
if (isset($this->arrParams['id'])) {
    if (($data['picture_current'] ?? $data['picture_hidden']) == '') {
        $data['picture_current'] = 'default.png';
    }
    $inputId = HelperForm::input('hidden', 'form[id]', $this->arrParams['id']);
    $pathImg = UPLOAD_URL . 'slider' . DS . '' . ($data['picture_current'] ?? $data['picture_hidden']);
    $picture = '<img src ="' . $pathImg . '">';
    $inputPictureHidden = HelperForm::input('hidden', 'form[picture_hidden]', $data['picture_current'] ?? '');
    $labelExistPic = '';
}

$lblName = HelperForm::label('Name', true);
$inputName = HelperForm::input('text', 'form[name]', $data['name'] ?? '', 'form-control');

$lblLink = HelperForm::label('Link');
$inputLink = HelperForm::input('text', 'form[link]', $data['link'] ?? '', 'form-control');

$lblDescription = HelperForm::label('Description');
$inputDescription = '<textarea class = "form-control" name = "form[description]" >' . ($data['description'] ?? '') . '</textarea>';

$lblStatus = HelperForm::label('Status', true);
$selectStatus = HelperForm::selectBox($arrSelect, 'form[status]', $data['status'] ?? 'active');

$lblOrdering = HelperForm::label('Ordering');
$inputOrdering = HelperForm::input('number', 'form[ordering]', $data['ordering'] ?? '10', 'form-control');

$lblPicture = HelperForm::label('Current banner' . ($labelExistPic ?? ''));
$lblPictureNew = HelperForm::label('Add new banner');

$attrImg = 'onchange="document.getElementById(\'blah\').src = window.URL.createObjectURL(this.files[0])"';
$inputPicture = HelperForm::input('file', 'picture', '', '', $attrImg);

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
                <li class="text-white"><b>Username:</b> Phải từ 3 đến 50 ký tự</li>
                <li class="text-white"><b>Email:</b> Email không hợp lệ!</li>
                <li class="text-white"><b>Group:</b> Vui lòng chọn giá trị!</li>
                <li class="text-white"><b>Password:</b> Giá trị này không được rỗng!</li>
            </ul>
        </div> -->
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="card card-outline card-info">
                <div class="card-body">
                    <?= Helper::cmsError($this->errors ?? '') ?>
                    <div class="form-group">
                        <?= $lblName . $inputName ?>
                    </div>
                    <div class="form-group">
                        <?= $lblLink . $inputLink ?>
                    </div>
                    <div class="form-group">
                        <?= $lblPicture . '</br>' . ($picture ?? '') . ($inputPictureHidden ?? '') ?>
                    </div>
                    <div class="form-group">
                        <?= $lblPictureNew . '</br>' . $inputPicture ?>
                        <img id="blah" width="600" height="300" />
                    </div>
                    <div class="form-group">
                        <?= $lblDescription . $inputDescription ?>
                    </div>
                    <div class="form-group">
                        <?= $lblOrdering . $inputOrdering ?>
                    </div>
                    <div class="form-group">
                        <?= $lblStatus . $selectStatus ?>
                    </div>
                    <div class="form-group">
                        <?= $inputId ?? '' . ($inputPictureHidden ?? "") ?>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success">Save</button>
                    <?php
                    echo Helper::cmsButton(URL::createLink('backend', 'slider', 'index'), 'Cancel', 'btn btn-danger');
                    ?>
                </div>
            </div>
        </form>
    </div>
</div>