<?php
$data = $this->outPut;

$arrSelect = [
    'status' => ['active' => 'Kích hoạt', 'inactive' => 'Không kích hoạt'],
    'special' => [1 => 'Kích hoạt', 0 => 'Không kích hoạt',]
];
$labelExistPic = ': None!';
if (isset($this->arrParams['id'])) {
    if (($data['picture_current'] ?? $data['picture_hidden']) == '') {
        $data['picture_current'] = 'default.png';
    }
    $inputId = HelperForm::input('hidden', 'form[id]', $this->arrParams['id']);
    $pathImg = UPLOAD_URL . 'category' . DS . '60x90-' . ($data['picture_current'] ?? $data['picture_hidden']);
    $picture = '<img src="' . $pathImg . '" alt="Ảnh hiện tại">';
    $inputPictureHidden = HelperForm::input('hidden', 'form[picture_hidden]', $data['picture_current'] ?? '');
    $labelExistPic = '';
}
$lblName = HelperForm::label('Name', true);
$inputName = HelperForm::input('text', 'form[name]', $data['name'] ?? '', 'form-control');

$lblStatus = HelperForm::label('Status', true);
$selectStatus = HelperForm::selectBox($arrSelect['status'], 'form[status]', $data['status'] ?? 'Kích hoạt');

$lblSpecial = HelperForm::label('Special', true);
$selectSpecial = HelperForm::selectBox($arrSelect['special'], 'form[special]', $data['special'] ?? 0);

$lblOrdering = HelperForm::label('Số thứ tự');
$inputOrdering = HelperForm::input('number', 'form[ordering]', $data['ordering'] ?? '10', 'form-control');

$lblPicture = HelperForm::label('Current picture' . ($labelExistPic ?? ''));
$lblPictureNew = HelperForm::label('Add new picture');
$attrImg = 'onchange="document.getElementById(\'blah\').src = window.URL.createObjectURL(this.files[0])"';
// $inputPicPrev = HelperForm::input('file', '', '', '', $attrImg);
$inputPicture = HelperForm::input('file', 'picture', '', '', $attrImg);

?>

<div class="row">
    <div class="col-12">
        <form action="" method="POST" enctype="multipart/form-data" runat="server">
            <div class="card card-outline card-info">
                <div class="card-body">
                    <?php echo Helper::cmsError($this->errors ?? '');
                    ?>
                    <div class="form-group">
                        <?= $lblName . '</br>' . $inputName ?>
                    </div>
                    <div class="form-group">
                        <?= $lblPicture . ($picture ?? '') . ($inputPictureHidden ?? '')  ?>
                    </div>
                    <div class="form-group">
                        <?= $lblPictureNew . '</br>' . $inputPicture; ?>
                        <img id="blah" width="200" height="300" />
                    </div>
                    <div class="form-group">
                        <?= $lblOrdering . '</br>' . $inputOrdering ?>
                    </div>
                    <div class="form-group">
                        <?= $lblStatus . '</br>' . $selectStatus ?>
                    </div>
                    <div class="form-group">
                        <?= $lblSpecial . '</br>' . $selectSpecial ?>
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