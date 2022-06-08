<?php
class HelperForm
{
    public static function input($type, $name, $value = null, $class = null)
    {
        $xhtml = sprintf('
                    <input type="%s" name="%s" value="%s" class="%s">
                ', $type, $name, $value, $class);
        return $xhtml;
    }

    public static function label($name)
    {
        return ('<label>' . $name . ' <span class="text-danger">*</span></label>');
    }

    public static function SelectBox($arrData, $name, $keySelected = 'default', $class = 'custom-select')
    {
        $xhtml = "";
        if (!empty($arrData)) {

            $xhtml = '  
                        <select class="' . $class . '" name="' . $name . '">
                    ';
            foreach ($arrData as $key => $value) {
                if ($key == $keySelected) {
                    $xhtml .= '<option value="' . $key . '" selected >' . $value . '</option>';
                } else {
                    $xhtml .= '<option value="' . $key . '">' . $value . '</option>';
                }
            }
            $xhtml .= ' 
                        </select>
                    ';
        }
        return $xhtml;
    }
}
