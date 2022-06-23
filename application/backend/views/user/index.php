<?php

$module = $this->arrParams['module'];
$controller = $this->arrParams['controller'];
$action = $this->arrParams['action'];
$xhtml = '';
$idUserLogged = $_SESSION['user']['info']['id'];

if (!empty($this->items)) {
    foreach ($this->items as $key => $item) {
        $id = $item['id'];
        $userName = Helper::highLight($this->arrParams['input-keyword'] ?? '', $item['username']);
        $fullName = Helper::highLight($this->arrParams['input-keyword'] ?? '', $item['fullname']);
        $email = Helper::highLight($this->arrParams['input-keyword'] ?? '', $item['email']);
        $linkStatus = URL::createLink($module, $controller, 'ajaxStatus', ['id' => $id, 'status' => $item['status']]);
        $status = Helper::cmsStatus($item['status'], $linkStatus, $id);
        $ajaxLinkGroup = URL::createLink($module, $controller, 'ajaxGroup', ['id' => $id, 'group_id' => 'value_new']);
        $attr = 'data-geturl = "' . $ajaxLinkGroup . '"';
        $group = HelperForm::selectBox($this->listGroup, '', $item['group_id'], 'w-auto select-group', $attr);

        $createdBy = Helper::createdBy($item['created_by'], $item['created']);
        $modifiedBy = Helper::createdBy($item['modified_by'], $item['modified']);

        $linkEdit = URL::createLink($module, $controller, 'form', ['id' => $id]);

        $linkDelete = URL::createLink($module, $controller, 'delete', ['id' => $id]);
        $cmsButtonDelete = Helper::cmsButton($linkDelete, '<i class="fas fa-trash "></i>', 'btn btn-danger btn-sm rounded-circle btn-acpt-delete');
        // $cmsButtonDelete = ($idUserLogged == $id) ? '' : $cmsButtonDelete;
        $linkPassword = URL::createLink($module, $controller, 'changePassword', ['id' => $id]);
        $groupName = lcfirst($item['group_name']);
        $ckb = '<input type="checkbox" name = "cid[]" value="' . $id . '" >';
        $xhtml .= '
            <tr>
                <td>' . $ckb . '</td>
                <td>' . $id . '</td>
                <td class="text-left">
                    <p class="mb-0">Username: ' . $userName . '</p>
                    <p class="mb-0">FullName: ' . $fullName . '</p>
                    <p class="mb-0">Email: ' . $email . '</p>
                </td>
                <td class ="position-relative"> ' . $group . ' </td>
                <td class ="position-relative"> ' . $status . ' </td>
                <td>' . $createdBy . '</td>
                <td> ' . $modifiedBy . '</td>
                <td>
                    <a href="' . $linkPassword . '" class="btn btn-secondary btn-sm rounded-circle"><i class="fas fa-key"></i></a>
                    <a href="' . $linkEdit . '" class="btn btn-info btn-sm rounded-circle"><i class="fas fa-pen"></i></a>
                    ' . $cmsButtonDelete . '
                </td>
            </tr>
        ';
    }
}
$valueApplication = HelperForm::input('hidden', 'module', $module) .
    HelperForm::input('hidden', 'controller', $controller) .
    HelperForm::input('hidden', 'action', $action) .
    HelperForm::input('hidden', 'status', $this->arrParams['status'] ?? 'all');;

$filterStatus = Helper::filterStatusUser($this->filterStatus, $this->arrParams);

$select = HelperForm::selectBox($this->filterGroupUser, 'group_id', $this->arrParams['group_id'] ?? 'default', ' filter-element');
// $select = HelperForm::selectBox($this->listGroup, 'group_acp', $this->arrParams['group_acp'] ?? 'default', ' form-control custom-select filter-element');
$filterGroupUser = $valueApplication . $select;
$filterSearch = HelperForm::input('text', 'input-keyword', ($this->arrParams['input-keyword'] ?? ''), 'input-keyword', 'form-control');

//pagination
$extraParamUrl = [
    'group_id' => $this->arrParams['group_id'] ?? 'default',
    'status' => $this->arrParams['status'] ?? 'all',
    'input-keyword' => $this->arrParams['input-keyword'] ?? '',
];
$xhtmlPagination = $this->pagination->showPagination(URL::createLink($module, $controller, $action, $extraParamUrl));
?>

<div class="row">
    <div class="col-12">
        <!-- Search & Filter -->
        <div class="card card-outline card-info">
            <div class="card-header">
                <h3 class="card-title">Search & Filter</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="container-fluid">
                    <div class="row justify-content-between align-items-center">
                        <div class="area-filter-status mb-2">
                            <?= $filterStatus ?>
                        </div>

                        <form action="" method="get" id="form-search" class="flex-grow-1 row align-items-center justify-content-end">
                            <div class="area-filter-attribute mb-2 mr-2 mb-2">
                                <?= $filterGroupUser ?>
                            </div>
                            <div class="area-search mb-2">
                                <div class="input-group" id="form-input">
                                    <?= $filterSearch ?>


                                    <span class="input-group-append">
                                        <button type="submit" id="submit-keyword" class="btn btn-info">Search</button>
                                        <a href="<?= URL::createLink('backend', 'user', 'index') ?>" name="clear-keyword" class="btn btn-danger">Clear</a>
                                    </span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- List -->
        <div class="card card-outline card-info">
            <div class="card-header">
                <h3 class="card-title">List</h3>

                <div class="card-tools">
                    <a href="<?= URL::createLink($module, $controller, $action) ?>" class="btn btn-tool" data-card-widget="refresh">
                        <i class="fas fa-sync-alt"></i>
                    </a>
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="container-fluid">
                    <div class="row align-items-center justify-content-between mb-2">
                        <div>
                            <div class="input-group">
                                <select class="form-control custom-select">
                                    <option>Bulk Action</option>
                                    <option>Delete</option>
                                    <option>Active</option>
                                    <option>Inactive</option>
                                </select>
                                <span class="input-group-append">
                                    <button type="button" class="btn btn-info">Apply</button>
                                </span>
                            </div>
                        </div>
                        <div>
                            <?php
                            echo Helper::cmsButton(URL::createLink($module, $controller, 'form'), '<i class="fas fa-plus"></i> Add New', 'btn btn-info');
                            ?>
                            
                        </div>
                    </div>
                </div>
                <span><?php
                        echo Helper::cmsSuccess($_SESSION['messageDelete'] ?? '');
                        echo Helper::cmsSuccess($_SESSION['messageForm'] ?? '');
                        Session::unset('messageDelete');
                        Session::unset('messageForm');
                        ?>
                </span>
                <div class="table-responsive">
                    <table class="table align-middle text-center table-bordered" id="mainOutput" name="mainOutput">
                        <thead>
                            <tr>
                                <th><input type="checkbox" name="checkall"></th>
                                <th>ID</th>
                                <th class="text-left">Info</th>
                                <th>Group</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Modified</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?= $xhtml ?>
                            <!-- <tr>
                                <td><input type="checkbox"></td>
                                <td>1</td>
                                <td class="text-left">
                                    <p class="mb-0">Username: admin01</p>
                                    <p class="mb-0">FullName: Nguyễn Văn A</p>
                                    <p class="mb-0">Email: admin01@example.com</p>
                                </td>
                                <td>
                                    <select class="form-control custom-select w-auto">
                                        <option> - Select Group - </option>
                                        <option selected>Admin</option>
                                        <option>Manager</option>
                                        <option>Member</option>
                                        <option>Register</option>
                                    </select>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-success rounded-circle btn-sm"><i class="fas fa-check"></i></a>
                                </td>
                                <td>
                                    <p class="mb-0"><i class="far fa-user"></i> admin</p>
                                    <p class="mb-0"><i class="far fa-clock"></i> 09/01/2021</p>
                                </td>
                                <td>
                                    <p class="mb-0"><i class="far fa-user"></i> admin</p>
                                    <p class="mb-0"><i class="far fa-clock"></i> 09/01/2021</p>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-secondary btn-sm rounded-circle"><i class="fas fa-key"></i></a>
                                    <a href="#" class="btn btn-info btn-sm rounded-circle"><i class="fas fa-pen"></i></a>
                                    <a href="#" class="btn btn-danger btn-sm rounded-circle"><i class="fas fa-trash "></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox"></td>
                                <td>2</td>
                                <td class="text-left">
                                    <p class="mb-0">Username: manager01</p>
                                    <p class="mb-0">FullName: Nguyễn Văn M</p>
                                    <p class="mb-0">Email: manager01@example.com</p>
                                </td>
                                <td>
                                    <select class="form-control custom-select w-auto">
                                        <option> - Select Group - </option>
                                        <option>Admin</option>
                                        <option selected>Manager</option>
                                        <option>Member</option>
                                        <option>Register</option>
                                    </select>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-success rounded-circle btn-sm"><i class="fas fa-check"></i></a>
                                </td>
                                <td>
                                    <p class="mb-0"><i class="far fa-user"></i> admin</p>
                                    <p class="mb-0"><i class="far fa-clock"></i> 09/01/2021</p>
                                </td>
                                <td>
                                    <p class="mb-0"><i class="far fa-user"></i> admin</p>
                                    <p class="mb-0"><i class="far fa-clock"></i> 09/01/2021</p>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-secondary btn-sm rounded-circle"><i class="fas fa-key"></i></a>
                                    <a href="#" class="btn btn-info btn-sm rounded-circle"><i class="fas fa-pen"></i></a>
                                    <a href="#" class="btn btn-danger btn-sm rounded-circle"><i class="fas fa-trash "></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox"></td>
                                <td>3</td>
                                <td class="text-left">
                                    <p class="mb-0">Username: member01</p>
                                    <p class="mb-0">FullName: Nguyễn Thị M</p>
                                    <p class="mb-0">Email: member01@example.com</p>
                                </td>
                                <td>
                                    <select class="form-control custom-select w-auto">
                                        <option> - Select Group - </option>
                                        <option>Admin</option>
                                        <option>Manager</option>
                                        <option selected>Member</option>
                                        <option>Register</option>
                                    </select>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-success rounded-circle btn-sm"><i class="fas fa-check"></i></a>
                                </td>
                                <td>
                                    <p class="mb-0"><i class="far fa-user"></i> admin</p>
                                    <p class="mb-0"><i class="far fa-clock"></i> 09/01/2021</p>
                                </td>
                                <td>
                                    <p class="mb-0"><i class="far fa-user"></i> admin</p>
                                    <p class="mb-0"><i class="far fa-clock"></i> 09/01/2021</p>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-secondary btn-sm rounded-circle"><i class="fas fa-key"></i></a>
                                    <a href="#" class="btn btn-info btn-sm rounded-circle"><i class="fas fa-pen"></i></a>
                                    <a href="#" class="btn btn-danger btn-sm rounded-circle"><i class="fas fa-trash "></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox"></td>
                                <td>4</td>
                                <td class="text-left">
                                    <p class="mb-0">Username: register01</p>
                                    <p class="mb-0">FullName: Trần Cao R</p>
                                    <p class="mb-0">Email: register01@example.com</p>
                                </td>
                                <td>
                                    <select class="form-control custom-select w-auto">
                                        <option> - Select Group - </option>
                                        <option>Admin</option>
                                        <option>Manager</option>
                                        <option>Member</option>
                                        <option selected>Register</option>
                                    </select>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-danger rounded-circle btn-sm"><i class="fas fa-check"></i></a>
                                </td>
                                <td>
                                    <p class="mb-0"><i class="far fa-user"></i> admin</p>
                                    <p class="mb-0"><i class="far fa-clock"></i> 09/01/2021</p>
                                </td>
                                <td>
                                    <p class="mb-0"><i class="far fa-user"></i> admin</p>
                                    <p class="mb-0"><i class="far fa-clock"></i> 09/01/2021</p>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-secondary btn-sm rounded-circle"><i class="fas fa-key"></i></a>
                                    <a href="#" class="btn btn-info btn-sm rounded-circle"><i class="fas fa-pen"></i></a>
                                    <a href="#" class="btn btn-danger btn-sm rounded-circle"><i class="fas fa-trash "></i></a>
                                </td>
                            </tr> -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer clearfix">
                <ul class="pagination m-0 float-right">
                    <?= $xhtmlPagination ?>
                    <!-- <li class="page-item disabled"><a class="page-link" href="#"><i class="fas fa-angle-double-left"></i></a></li>
                    <li class="page-item disabled"><a class="page-link" href="#"><i class="fas fa-angle-left"></i></a></li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#"><i class="fas fa-angle-right"></i></a></li>
                    <li class="page-item"><a class="page-link" href="#"><i class="fas fa-angle-double-right"></i></a></li> -->
                </ul>
            </div>
        </div>
    </div>
</div>