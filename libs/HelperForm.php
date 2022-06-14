<?php
class HelperForm
{
    public static function input($type, $name, $value = null, $class = null, $attributes = null)
    {

        $xhtml = sprintf('
                    <input type="%s" name="%s" value="%s" class="%s" %s>
                ', $type, $name, $value, $class, $attributes);
        return $xhtml;
    }

    public static function label($name, $option = false)
    {
        $option = ($option == true) ? '<span class="text-danger">*</span>' : '';
        return ('<label>' . $name . $option . ' </label>');
    }

    public static function selectBox($arrData, $name, $keySelected = 'default', $class = '')
    {
        $xhtml = "";
        if (!empty($arrData)) {
            foreach ($arrData as $key => $value) {
                $selected = ((string)$key == $keySelected) ? 'selected' : '';
                $xhtml .= '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
            }
        }

        $xhtml = '<select class="form-control custom-select ' . $class . '" name="' . $name . '">' . $xhtml . '</select>';
        return $xhtml;
    }

    public static function selectBoxKeyInt($arrData, $name, $keySelected = 'default', $class = '')
    {
        $xhtml = "";
        if (!empty($arrData)) {
            foreach ($arrData as $key => $value) {
                $selected = ((string)$key === $keySelected) ? 'selected' : '';
                $xhtml .= '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
            }
        }

        $xhtml = '<select class="form-control custom-select ' . $class . '" name="' . $name . '">' . $xhtml . '</select>';
        return $xhtml;
    }
}
