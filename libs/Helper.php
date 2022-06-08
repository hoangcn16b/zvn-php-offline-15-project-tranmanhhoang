<?php
class Helper
{
    public static function created($created)
    {
        $created = Helper::formatDate($created);
        $xhtml = '
                <p class="mb-0">
                    <i class="far fa-clock"></i> ' . $created . '
                </p>
                ';
        return $xhtml;
    }

    public static function createdBy($createdBy)
    {
        $xhtml = '
                    <p class="mb-0">
                        <i class="far fa-user"></i> ' . $createdBy . '
                    </p>
                ';
        return $xhtml;
    }

    public static function groupAcp($option, $link = '')
    {
        if ($option == 'active') {
            $xhtml = '
                    <a href="' . $link . '" class=" btn btn-success rounded-circle btn-sm"><i class="fas fa-check"></i></a>
                ';
        } elseif ($option == 'inactive') {
            $xhtml = '
                    <a href="' . $link . '" class=" btn btn-danger rounded-circle btn-sm"><i class="fas fa-check"></i></a>
                ';
        }
        return $xhtml;
    }

    public static function formatDate($value, $format = 'H:i:s d-m-Y ')
    {
        $result = '';
        if (!empty($value) && $value != '0000-00-00 00:00:00') {
            $result = date($format, strtotime($value));
        }
        return $result;
    }

    public static function cmsStatus($statusVal, $link, $id)
    {
        $status = ($statusVal == 'active') ? 'btn btn-success rounded-circle btn-sm' : 'btn btn-danger rounded-circle btn-sm';
        $xhtml = '
                    <a id = "status-' . $id . '" href="javascript:changeStatus(\'' . $link . '\')" class="' . $status . '">
                        <span ><i class="fas fa-check"></i></span>
                    </a>
                ';
        return $xhtml;
    }

    public static function cmsGroupAcp($groupAcpVal, $link, $id)
    {
        $groupAcp = ($groupAcpVal == 1) ? 'btn btn-success rounded-circle btn-sm' : 'btn btn-danger rounded-circle btn-sm';
        $xhtml = '
                    <a id = "groupAcp-' . $id . '" href="javascript:changeGroupAcp(\'' . $link . '\')" class="' . $groupAcp . '">
                        <span ><i class="fas fa-check"></i></span>
                    </a>
                ';
        return $xhtml;
    }

    public static function cmsMessage($message)
    {
        $xhtml = '';
        if (!empty($message)) {
            $xhtml = '
                        <span class="text-' . $message['class'] . '"><h3>' . $message['content'] . '</h3></span>
                    ';
        }
        return $xhtml;
    }

    public static function highLight($searchValue, $value)
    {
        if (!empty(trim($searchValue))) {
            $searchValue = trim($searchValue);
            return str_replace($searchValue, "<mark>{$searchValue}</mark>", $value);
        }
        return $value;
    }

    public static function filterStatus($arrParams, $option = null, $keyword = '')
    {

        $xhtml = '';
        foreach ($arrParams as $key => $value) {
            $class = $option == $key ? 'info' : 'secondary';
            if ($keyword == '') {
                $url =  URL::createLink('backend', 'Group', 'index', ['status' => $key]);
            } else {
                $url =  URL::createLink('backend', 'Group', 'index', ['status' => $key, 'input-keyword' => $keyword]);
            }
            $xhtml .= ' 
                        <a href="' . $url . '" class="btn btn-' . $class . '"> ' . ucfirst($key) . '        <span class="badge badge-pill badge-light">' . $value . '</span>
                        </a> 
                    ';
            $url = '';
        }
        return $xhtml;
    }

    public static function cmsSuccess($value = null)
    {

        if ($value == '') {
            $xhtml = '';
        } else {
            $class = $value['class'];
            $content = $value['content'];
            $xhtml = '
                        <div class="alert alert-' . $class . ' alert-dismissible fade show" role="alert">
                            <strong>' . $content . '</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    ';
        }
        return $xhtml;
    }

    public static function cmsError($value = null)
    {

        if ($value == '') {
            $xhtml = '';
        } else {
            $class = 'warning';
            $content = $value;
            $xhtml = '
                        <div class="alert alert-' . $class . ' alert-dismissible fade show" role="alert">
                            <strong>' . $content . '</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    ';
        }
        return $xhtml;
    }
}
