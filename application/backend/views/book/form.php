<?php

$data = $this->outPut;
// unset($this->listCategory['default']);
$arrSelect = [
    'status' => ['active' => 'Kích hoạt', 'inactive' => 'Không kích hoạt'],
    'special' =>  [1 => 'Nổi bật', 0 => 'Không nổi bật'],
    'category' => $this->listCategory
];

$readOnly = isset($this->arrParams['id']) ? 'readonly' : '';
$labelExistPic = ': None!';
$readOnly = '';
if (isset($this->arrParams['id'])) {
    if (($data['picture_current'] ?? $data['picture_hidden']) == '') {
        $data['picture_current'] = 'default.png';
    }
    $inputId = HelperForm::input('hidden', 'form[id]', $this->arrParams['id']);
    $pathImg = UPLOAD_URL . 'book' . DS . '60x90-' . ($data['picture_current'] ?? $data['picture_hidden']);
    $picture = '<img src ="' . $pathImg . '">';
    $inputPictureHidden = HelperForm::input('hidden', 'form[picture_hidden]', $data['picture_current'] ?? '');
    $labelExistPic = '';
}

$lblName = HelperForm::label('Name', true);
$inputName = HelperForm::input('text', 'form[name]', $data['name'] ?? '', 'form-control', $readOnly);

$lblPrice = HelperForm::label('Price', true);
$inputPrice = HelperForm::input('number', 'form[price]', $data['price'] ?? '', 'form-control', $readOnly);

$lblSpecial = HelperForm::label('Special', true);
$inputSpecial = HelperForm::selectBox($arrSelect['special'], 'form[special]', $data['special'] ?? 0);

$lblSaleOff = HelperForm::label('Sale off');
$inputSaleOff = HelperForm::input('number', 'form[sale_off]', $data['sale_off'] ?? '', 'form-control', $readOnly);

$lblDescription = HelperForm::label('Description');
$inputDescription = '<textarea class = "form-control" name = "form[description]" >' . ($data['description'] ?? '') . '</textarea>';
$lblContent = HelperForm::label('Content');
$inputContent = '<textarea class = "form-control" name = "form[content]" id="editorDesc">' . ($data['content'] ?? '') . '</textarea>';

$lblStatus = HelperForm::label('Status', true);
$selectStatus = HelperForm::selectBox($arrSelect['status'], 'form[status]', $data['status'] ?? 'active');

$lblOrdering = HelperForm::label('Ordering');
$inputOrdering = HelperForm::input('number', 'form[ordering]', $data['ordering'] ?? '10', 'form-control');

$lblGroup = HelperForm::label('Group Category', true);
$selectGroup = HelperForm::selectBox($arrSelect['category'], 'form[category_id]', lcfirst($data['category_id'] ?? ''));

$lblPicture = HelperForm::label('Current picture' . ($labelExistPic ?? ''));
$lblPictureNew = HelperForm::label('Add new picture');

$attrImg = 'onchange="document.getElementById(\'blah\').src = window.URL.createObjectURL(this.files[0])"';
$inputPicture = HelperForm::input('file', 'picture', '', '', $attrImg);

if (isset($this->arrParams['id'])) {
    $inputId = HelperForm::input('hidden', 'form[id]', $this->arrParams['id']);
}

?>
<script type="text/javascript" src="<?= CKEDITOR_PATH ?>ckeditor.js"></script>
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
                        <?= $lblPicture . '</br>' . ($picture ?? '') . ($inputPictureHidden ?? '') ?>
                    </div>
                    <div class="form-group">
                        <?= $lblPictureNew . '</br>' . $inputPicture ?>
                        <img id="blah" width="240" height="300" />
                    </div>
                    <div class="form-group">
                        <?= $lblSaleOff . $inputSaleOff ?>
                    </div>
                    <div class="form-group">
                        <?= $lblDescription . $inputDescription ?>
                    </div>
                    <div class="form-group">
                        <?= $lblContent . $inputContent ?>
                    </div>
                    <script>
                        CKEDITOR.replace('editorDesc');
                    </script>
                    <div class="form-group">
                        <?= $lblOrdering . $inputOrdering ?>
                    </div>
                    <div class="form-group">
                        <?= $lblPrice . $inputPrice ?>
                    </div>
                    <div class="form-group">
                        <?= $lblSpecial . $inputSpecial ?>
                    </div>
                    <div class="form-group">
                        <?= $lblStatus . $selectStatus ?>
                    </div>
                    <div class="form-group">
                        <?= $lblGroup . $selectGroup  ?>
                    </div>
                    <div class="form-group">
                        <?= $inputId ?? '' . ($inputPictureHidden ?? "") ?>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success">Save</button>
                    <?php
                    echo Helper::cmsButton(URL::createLink('backend', 'book', 'index'), 'Cancel', 'btn btn-danger');
                    ?>
                </div>
            </div>
        </form>
    </div>
</div>