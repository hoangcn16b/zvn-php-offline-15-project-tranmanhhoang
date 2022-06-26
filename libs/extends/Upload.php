<?php
require_once SCRIPT_PATH . 'PhpThumb' . DS . 'ThumbLib.inc.php';
class Upload
{
    public function uploadFile($fileObj, $folderUpload, $options = null)
    {
        if ($options == null) {
            if ($fileObj['tmp_name'] != null) {
                $uploadDir = UPLOAD_PATH . $folderUpload . DS;
                $randomName = Helper::randomString(7);
                $ext = '.' . pathinfo($fileObj['name'], PATHINFO_EXTENSION);
                $nameFile = $randomName . $ext;
                copy($fileObj['tmp_name'], $uploadDir . $nameFile);
                $thumb = PhpThumbFactory::create($uploadDir . $nameFile);
                $thumb->adaptiveResize(60, 90);
                $thumb->save($uploadDir . '60x90-' . $nameFile);
            }
            return $nameFile;
        }
    }

    public function removeFile($folderUpload, $fileName)
    {
        $fileName = UPLOAD_PATH . $folderUpload . DS . $fileName;
        @unlink($fileName);
    }
}
