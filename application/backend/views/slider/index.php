<?php

$module = $this->arrParams['module'];
$controller = $this->arrParams['controller'];
$action = $this->arrParams['action'];
$xhtml = '';
$listOrdering = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

if (!empty($this->items)) {
    foreach ($this->items as $key => $item) {
        $id = $item['id'];
        $picturePath = UPLOAD_PATH . 'slider' . DS . '400x200-' . ($item['picture']);
        if (file_exists($picturePath) == true) {
            $pathImg = UPLOAD_URL . 'slider' . DS . '400x200-' . ($item['picture']);
            $picture = '<img src ="' . $pathImg . '">';
        } else {
            $pathImg = UPLOAD_URL . 'slider' . DS . '60x90-default.png';
            $picture = '<img src ="' . $pathImg . '">';
        }
        $name = Helper::highLight($this->arrParams['input-keyword'] ?? '', $item['name']);

        $description = Helper::highLight($this->arrParams['input-keyword'] ?? '', Helper::collapseDesc($item['description'], 20));

        $linkStatus = URL::createLink($module, $controller, 'ajaxStatus', ['id' => $id, 'status' => $item['status']]);
        $status = Helper::cmsStatus($item['status'], $linkStatus, $id);

        $ajaxOrdering = URL::createLink($module, $controller, 'ajaxOrdering', ['id' => $id, 'ordering' => 'value_new']);
        $attrOrder = 'data-geturl = "' . $ajaxOrdering . '"';
        $selectOrdering = HelperForm::selectBoxKeyInt($listOrdering, '', $item['ordering'], 'w-auto select-ordering-book', $attrOrder);
        // $createdBy = Helper::createdBy($item['created_by'], $item['created']);
        // $modifiedBy = Helper::createdBy($item['modified_by'], $item['modified']);

        $linkEdit = URL::createLink($module, $controller, 'form', ['id' => $id]);
        $cmsButtonEdit = Helper::cmsButton($linkEdit, '<i class="fas fa-pen "></i>', 'btn btn-info btn-sm rounded-circle');

        $linkDelete = URL::createLink($module, $controller, 'delete', ['id' => $id]);
        $cmsButtonDelete = Helper::cmsButton($linkDelete, '<i class="fas fa-trash"></i>', 'btn btn-danger btn-sm rounded-circle  btn-acpt-delete');

        $ckb = '<input type="checkbox" name = "cid[]" value="' . $id . '" >';

        $xhtml .= '
            <tr>
                <td>' . $ckb . '</td>
                <td>' . $id . '</td>
                <td >' . $picture . '</td>
                <td class="text-left" style="width:25%;">
                    <p class="mb-0">Name: ' . $name . '</p>
                    <p class="mb-0">Link: ' . $item['link'] . '</p>
                </td>
                <td style="width:30%;"> ' . $description . '</td>
                <td class ="position-relative"> ' . $status . ' </td>
                <td class ="position-relative"> ' . $selectOrdering . ' </td>
                <td>
                    ' . $cmsButtonEdit . '
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

$filterStatus = Helper::filterStatusBook($this->filterStatus, $this->arrParams);

$filterSearch = $valueApplication . HelperForm::input('text', 'input-keyword', ($this->arrParams['input-keyword'] ?? ''), 'input-keyword', 'form-control');

$xhtmlPagination = $this->pagination->showPagination(URL::createLink($module, $controller, $action));
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
                            <div class="area-search mb-2">
                                <div class="input-group" id="form-input">
                                    <?= $filterSearch ?>
                                    <span class="input-group-append">
                                        <button type="submit" id="submit-keyword" class="btn btn-info">Search</button>
                                        <a href="<?= URL::createLink($module, 'slider', 'index') ?>" name="clear-keyword" class="btn btn-danger">Clear</a>
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
                                <th>Picture</th>
                                <th class="text-left">Info</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Ordering</th>
                                <!-- <th>Created</th> -->
                                <!-- <th>Modified</th> -->
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?= $xhtml ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer clearfix">
                <ul class="pagination m-0 float-right">
                    <?= $xhtmlPagination ?>
                </ul>
            </div>
        </div>
    </div>
</div>