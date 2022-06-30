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
    public static function createdBy($createdBy, $created = '')
    {
        $created = Helper::formatDate($created);
        $xhtml = '
                    <p class="mb-0">
                        <i class="far fa-user"></i> ' . $createdBy . '
                    </p>
                    <p class="mb-0">
                        <i class="far fa-clock"></i> ' . $created . '
                    </p>
                ';
        return $xhtml;
    }
    public static function formatDate($value, $format = 'H:i:s d-m-Y ')
    {
        $result = '';
        if (isset($value) && $value != '0000-00-00 00:00:00') {
            $result = date($format, strtotime($value));
        }
        return $result;
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

    // public static function cmsStatus($statusVal, $link, $id)
    // {
    //     $status = ($statusVal == 'active') ? 'btn btn-success rounded-circle btn-sm' : 'btn btn-danger rounded-circle btn-sm';
    //     $xhtml = '
    //                 <a id = "status-' . $id . '" href="javascript:changeStatus(\'' . $link . '\')" class="' . $status . ' ajax-status">
    //                     <span ><i class="fas fa-check"></i></span>
    //                 </a>
    //             ';
    //     return $xhtml;
    // }

    // public static function cmsGroupAcp($groupAcpVal, $link, $id)
    // {
    //     $groupAcp = ($groupAcpVal == 1) ? 'btn btn-success rounded-circle btn-sm' : 'btn btn-danger rounded-circle btn-sm';
    //     $xhtml = '
    //                 <a id = "groupAcp-' . $id . '" href="javascript:changeGroupAcp(\'' . $link . '\')" class="' . $groupAcp . '">
    //                     <span ><i class="fas fa-check"></i></span>
    //                 </a>
    //             ';
    //     return $xhtml;
    // }
    public static function cmsStatus($statusVal, $link, $id, $jsClass = 'ajax-status')
    {
        $status = ($statusVal == 'active') ? 'btn btn-success rounded-circle btn-sm' : 'btn btn-danger rounded-circle btn-sm';

        $iconStatus = ($statusVal == 'active') ? 'check' : 'check';
        $xhtml = '
                    <a id = "status-' . $id . '" href="' . $link . '" class="' . $status . ' ' . $jsClass . '">
                        <span ><i class="fas fa-' . $iconStatus . '"></i></span>
                    </a>
                ';
        return $xhtml;
    }

    public static function cmsSpecial($statusVal, $link, $id, $jsClass = 'ajax-special')
    {
        $status = ($statusVal == '1') ? 'btn btn-success rounded-circle btn-sm' : 'btn btn-danger rounded-circle btn-sm';

        $iconStatus = ($statusVal == '1') ? 'check' : 'check';
        $xhtml = '
                    <a id = "status-' . $id . '" href="' . $link . '" class="' . $status . ' ' . $jsClass . '">
                        <span ><i class="fas fa-' . $iconStatus . '"></i></span>
                    </a>
                ';
        return $xhtml;
    }

    public static function cmsRedirectStatus($statusVal)
    {
        $status = ($statusVal == 'active') ? 'btn btn-success rounded-circle btn-sm' : 'btn btn-danger rounded-circle btn-sm';
        $xhtml = '
                    <span class="' . $status . '><i class="fas fa-check"></i></span>
                ';
        return $xhtml;
    }

    public static function cmsGroupAcp($groupAcpVal, $link, $id, $jsClass = 'ajax-group-acp')
    {
        $groupAcp = ($groupAcpVal == 1) ? 'btn btn-success rounded-circle btn-sm' : 'btn btn-danger rounded-circle btn-sm';
        $xhtml = '
                    <a id = "groupAcp-' . $id . '" href="' . $link . '" class="' . $groupAcp . ' ' . $jsClass . '">
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
            $searchValue = preg_quote($searchValue);
            // return str_replace("$searchValue", "<mark>$searchValue</mark>", $value);
            return preg_replace("#$searchValue#i", "<mark>\\0</mark>", $value);
        } else {
            return $value;
        }
    }

    public static function filterStatusGroup($arrParams, $toUrl)
    {
        $xhtml = '';
        $option = $toUrl['status'] ?? 'all';
        $keySearch = $toUrl['input-keyword'] ?? '';
        foreach ($arrParams as $key => $value) {
            $optionsLink = [];
            $class = $option == $key ? 'info' : 'secondary';
            if (isset($toUrl['group_acp'])) {
                $optionsLink['group_acp'] = $toUrl['group_acp'];
            }
            if ($keySearch == '') {
                $optionsLink['status'] = $key;
            } else {
                $optionsLink['status'] = $key;
                $optionsLink['input-keyword'] = $keySearch;
            }
            $url =  URL::createLink($toUrl['module'], $toUrl['controller'], $toUrl['action'], $optionsLink);
            $xhtml .= ' 
                        <a href="' . $url . '" class="btn btn-' . $class . '"> ' . ucfirst($key) . '        <span class="badge badge-pill badge-light">' . $value . '</span>
                        </a> 
                    ';
        }
        return $xhtml;
    }

    public static function filterStatusUser($arrParams, $toUrl)
    {
        $xhtml = '';
        $option = $toUrl['status'] ?? 'all';
        $keySearch = $toUrl['input-keyword'] ?? '';
        foreach ($arrParams as $key => $value) {
            $optionsLink = [];
            $class = $option == $key ? 'info' : 'secondary';
            if (isset($toUrl['group_id'])) {
                $optionsLink['group_id'] = $toUrl['group_id'];
            }
            if ($keySearch == '') {
                $optionsLink['status'] = $key;
            } else {
                $optionsLink['status'] = $key;
                $optionsLink['input-keyword'] = $keySearch;
            }
            $url =  URL::createLink($toUrl['module'], $toUrl['controller'], $toUrl['action'], $optionsLink);
            $xhtml .= ' 
                        <a href="' . $url . '" class="btn btn-' . $class . '"> ' . ucfirst($key) . '        <span class="badge badge-pill badge-light">' . $value . '</span>
                        </a> 
                    ';
        }
        return $xhtml;
    }

    public static function filterStatusBook($arrParams, $toUrl)
    {
        $xhtml = '';
        $option = $toUrl['status'] ?? 'all';
        $keySearch = $toUrl['input-keyword'] ?? '';
        foreach ($arrParams as $key => $value) {
            $optionsLink = [];
            $class = $option == $key ? 'info' : 'secondary';
            if (isset($toUrl['special'])) {
                $optionsLink['special'] = $toUrl['special'];
            }
            if (isset($toUrl['category_id'])) {
                $optionsLink['category_id'] = $toUrl['category_id'];
            }
            if ($keySearch == '') {
                $optionsLink['status'] = $key;
            } else {
                $optionsLink['status'] = $key;
                $optionsLink['input-keyword'] = $keySearch;
            }
            $url =  URL::createLink($toUrl['module'], $toUrl['controller'], $toUrl['action'], $optionsLink);
            $xhtml .= ' 
                        <a href="' . $url . '" class="btn btn-' . $class . '"> ' . ucfirst($key) . '
                        <span class="badge badge-pill badge-light">' . $value . '</span>
                        </a> 
                    ';
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

    public static function cmsButton($link, $value, $class)
    {
        $xhtml = '';
        $xhtml .= '
                    <a href="' . $link . '" class="' . $class . '">' . $value . '</a>
                ';
        return $xhtml;
    }

    public static function randomString($length = 5)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function collapseDesc($string, $length = 10)
    {
        $str = explode(" ", $string);
        $xhtml = '';
        foreach ($str as $key => $value) {
            if ($key + 1 > $length) {
                $xhtml .= '...';
                break;
            } else {
                $xhtml .= $value . ' ';
            }
        }
        return $xhtml;
    }
}
