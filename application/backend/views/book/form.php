<?php

$data = $this->outPut;
$arrSelect = [
    'status' => ['default' => 'Select Status', 'inactive' => 'Không kích hoạt', 'active' => 'Kích hoạt'],
    'special' =>  ['default' => 'Select Special', 1 => 'Nổi bật', 0 => 'Không nổi bật'],
    'category' => $this->listCategory
];
$readOnly = isset($this->arrParams['id']) ? 'readonly' : '';
$readOnly = '';
if (isset($this->arrParams['id'])) {
    $inputId = HelperForm::input('hidden', 'form[id]', $this->arrParams['id']);
    $pathImg = UPLOAD_URL . 'book' . DS . '60x90-' . ($data['picture'] ?? '');
    $picture = '<img src ="' . $pathImg . '">';
    $inputPictureHidden = HelperForm::input('hidden', 'form[picture_hidden]', $data['picture'] ?? '');
}

$lblName = HelperForm::label('Name', true);
$inputName = HelperForm::input('text', 'form[name]', $data['name'] ?? '', 'form-control', $readOnly);

$lblPrice = HelperForm::label('Price', true);
$inputPrice = HelperForm::input('number', 'form[price]', $data['price'] ?? '', 'form-control', $readOnly);

$lblSpecial = HelperForm::label('Special', true);
$inputSpecial = HelperForm::selectBox($arrSelect['special'], 'form[special]', $data['special'] ?? 'default');

$lblSaleOff = HelperForm::label('Sale off');
$inputSaleOff = HelperForm::input('number', 'form[sale_off]', $data['sale_off'] ?? '', 'form-control', $readOnly);

$lblDescription = HelperForm::label('Description');
$inputDescription = '<textarea class = "form-control" name = "form[description]"> ' . ($data['description'] ?? '') . ' </textarea>';

$lblStatus = HelperForm::label('Status', true);
$selectStatus = HelperForm::selectBox($arrSelect['status'], 'form[status]', $data['status'] ?? 'default');

$lblOrdering = HelperForm::label('Ordering');
$inputOrdering = HelperForm::input('number', 'form[ordering]', $data['ordering'] ?? '10', 'form-control');

$lblGroup = HelperForm::label('Group Category', true);
$selectGroup = HelperForm::selectBox($arrSelect['category'], 'form[category_id]', lcfirst($data['category_id'] ?? 'default'));

$lblPicture = HelperForm::label('Picture', true);
$inputPicture = HelperForm::input('file', 'picture', '', '');

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
                        <?= $lblPicture . '</br>' . $inputPicture . ($picture ?? '') . ($inputPictureHidden ?? '') ?>
                    </div>
                    <div class="form-group">
                        <?= $lblSaleOff . $inputSaleOff ?>
                    </div>
                    <div class="form-group">
                        <?= $lblDescription . $inputDescription ?>
                    </div>
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