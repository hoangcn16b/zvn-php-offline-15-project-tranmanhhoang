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

    public static function selectBox($arrData, $name, $keySelected = 'default', $class = 'custom-select')
    {
        $xhtml = "";
        if (!empty($arrData)) {
            foreach ($arrData as $key => $value) {
                $selected = $key == $keySelected ? 'selected' : '';
                $xhtml .= '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
            }
        }

        $xhtml = '<select class="' . $class . '" name="' . $name . '">' . $xhtml . '</select>';
        return $xhtml;
    }
}
