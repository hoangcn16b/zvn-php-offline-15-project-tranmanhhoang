<?php


class HelperFrontend
{
    public static function selectBox($arrData, $name, $keySelected = 'default', $class = '', $attr = '')
    {
        $xhtml = "";
        if (!empty($arrData)) {
            foreach ($arrData as $key => $value) {
                $selected = ((string)$key == $keySelected) ? 'selected' : '';
                $xhtml .= '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
            }
        }
        $xhtml = sprintf('<select name="%s" %s> %s</select>', $name, $attr, $xhtml);
        // $xhtml = '<select class="form-control custom-select ' . $class . '" name="' . $name . '">' . $xhtml . '</select>';
        return $xhtml;
    }
}
