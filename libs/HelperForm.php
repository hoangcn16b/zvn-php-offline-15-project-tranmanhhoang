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

    public static function label($name, $option = false, $class = 'text-danger')
    {
        $option = ($option == true) ? '<span class="' . $class . '">*</span>' : '';
        return ('<label>' . $name . $option . ' </label>');
    }

    public static function selectBox($arrData, $name, $keySelected = 'default', $class = '', $attr = '')
    {
        $xhtml = "";
        if (!empty($arrData)) {
            foreach ($arrData as $key => $value) {
                $selected = ((string)$key == $keySelected) ? 'selected' : '';
                $xhtml .= '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
            }
        }
        $xhtml = sprintf('<select class="form-control custom-select %s" name="%s" %s> %s</select>', $class, $name, $attr, $xhtml);
        // $xhtml = '<select class="form-control custom-select ' . $class . '" name="' . $name . '">' . $xhtml . '</select>';
        return $xhtml;
    }

    public static function selectBoxKeyInt($arrData, $name, $keySelected = 'default', $class = '', $attr = '')
    {
        $xhtml = "";
        if (!empty($arrData)) {
            foreach ($arrData as $key => $value) {
                $selected = ((string)$value === $keySelected) ? 'selected' : '';
                $xhtml .= '<option value="' . $value . '" ' . $selected . '>' . $value . '</option>';
            }
        }

        $xhtml = '<select class="form-control custom-select ' . $class . '" name="' . $name . '" ' . $attr . '>' . $xhtml . '</select>';
        return $xhtml;
    }

    public static function iconFormLogin($class = '')
    {
        $xhtml = '';
        $xhtml .= '
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas ' . $class . '"></span>
                        </div>
                    </div>
                ';
        return $xhtml;
    }
}
