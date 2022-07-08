<?php

$module = $this->arrParams['module'];
$controller = $this->arrParams['controller'];
$action = $this->arrParams['action'];
$xhtml = '';
$listStatus = [
    'selectStatus' => ['new' => 'New', 'waiting' => 'Waiting', 'process' => 'Process', 'completed' => 'Completed'],
    'filterStatus' => ['all' => '--Select Status--', 'new' => 'New', 'waiting' => 'Waiting', 'process' => 'Process', 'completed' => 'Completed'],
    'search_by' => ['all' => '--Search by all--', 'id' => 'ID', 'fullname' => 'Fullname', 'username' => 'Username', 'email' => 'Email', 'phone' => 'Phone', 'address' => 'Address']
];
$items = $this->items;
if (!empty($items)) {
    foreach ($this->items as $key => $item) {
        $id = $item['id'];
        $date = date("H:i d/m/Y", strtotime($item['date']));
        $ajaxStatus = URL::createLink($module, $controller, 'ajaxStatus', ['id' => $id, 'status' => 'value_new']);
        $attrStatus = 'data-geturl = "' . $ajaxStatus . '"';
        $selectStatus = HelperForm::selectBoxOnCart($listStatus['selectStatus'], '', $item['status'], ' select-ordering-book', $attrStatus);
        $linkView = URL::createLink($module, $controller, 'view', ['id' => $id]);
        $cmsButtonView = Helper::cmsButton($linkView, '<i class="fas fa-eye "></i>', 'btn btn-info btn-sm rounded-circle');

        $id = Helper::highLight($this->arrParams['input-keyword'] ?? '', $item['id']);
        $userName = Helper::highLight($this->arrParams['input-keyword'] ?? '', $item['username']);
        $fullName = Helper::highLight($this->arrParams['input-keyword'] ?? '',  $item['fullname']);
        $email = Helper::highLight($this->arrParams['input-keyword'] ?? '', $item['email']);
        $phone = Helper::highLight($this->arrParams['input-keyword'] ?? '', $item['phone']);
        $address = Helper::highLight($this->arrParams['input-keyword'] ?? '', $item['address']);

        $tableContent = '';
        $date = date("H:i d/m/Y", strtotime($item['date']));
        $arrBook = json_decode($item['books']);
        $arrPrice = json_decode($item['prices']);
        $arrName = json_decode($item['names']);
        $arrQuantity = json_decode($item['quantities']);
        // $arrPicture = json_decode($item['pictures']);
        $totalPrice = 0;
        foreach ($arrBook as $keyB => $valueB) {
            $name = $arrName[$keyB];
            $price = $arrPrice[$keyB];
            $formatPrice = number_format($price);
            $quantity = $arrQuantity[$keyB];
            $totalperProd = number_format($price * $quantity);
            $name = $arrName[$keyB];
            $totalPrice += $price * $quantity;
            $tableContent .= '
                            <p class="mb-0"><b>+</b> <i>' . $name . '</i> x <span class="badge badge-info badge-pill">' . $quantity . '</span> = ' . $totalperProd . '
                            </p>--------------------------------------------<br>
                            ';
        }
        $formatTotalPrice = number_format($totalPrice) . 'đ';
        $xhtml .= '
            <tr>
                <td>' . $id . '</td>
                <td class="text-left" style="width:25%;">
                <p class="mb-0"><b>Fullname:</b> ' . $fullName . '</p>
                    <p class="mb-0"><b>Username:</b> ' . $userName . '</p>
                    <p class="mb-0"><b>Email:</b> ' . $email . '</p>
                    <p class="mb-0"><b>Phone:</b> ' . $phone . '</p>
                    <p class="mb-0"><b>Address:</b> ' . $address . '</p>
                </td>
                <td class="text-left" style="width:40%;">
                    ' . $tableContent . '
                </td>
                <td> ' . $formatTotalPrice . ' </td>
                <td class ="position-relative"> ' . $selectStatus . ' </td>
                <td> ' . $date . ' </td>
                <td>' . $cmsButtonView . '</td>
            </tr>
        ';
    }
}
$valueApplication = HelperForm::input('hidden', 'module', $module) .
    HelperForm::input('hidden', 'controller', $controller) .
    HelperForm::input('hidden', 'action', $action);

$filterAll = '
            <a class="btn btn-primary"> Total Deals
                <span class="badge badge-pill badge-light">' . $this->totalDeals . '</span>
            </a>';
$select = HelperForm::selectBox($listStatus['filterStatus'], 'status', $this->arrParams['status'] ?? 'all', ' filter-element');
$filterStatus = $valueApplication . $select;

$selectSearchBy = HelperForm::selectBox($listStatus['search_by'], 'search_by', $this->arrParams['search_by'] ?? 'all', 'filter-search-by');

$filterSearch = HelperForm::input('text', 'input-keyword', ($this->arrParams['input-keyword'] ?? ''), 'input-keyword', 'form-control');

$xhtmlPagination = $this->pagination->showPagination();
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
                            <?= $filterAll ?? '' ?>
                        </div>
                        <form action="" method="get" id="form-search" class="flex-grow-1 row align-items-center justify-content-end">
                            <div class="area-filter-attribute mb-2 mr-2 mb-2">
                                <?= $filterStatus ?? '' ?>
                            </div>
                            <div class="area-filter-attribute mb-2 mr-2 mb-2">
                                <?= $selectSearchBy ?? '' ?>
                            </div>
                            <div class="area-search mb-2">
                                <div class="input-group" id="form-input">
                                    <?= $filterSearch ?? '' ?>
                                    <span class="input-group-append">
                                        <button type="submit" id="submit-keyword" class="btn btn-info">Search</button>
                                        <a href="<?= URL::createLink($module, 'cart', 'index') ?>" name="clear-keyword" class="btn btn-danger">Clear</a>
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
                        <!-- <div>
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
                        </div> -->
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
                                <th>ID</th>
                                <th>Info customer</th>
                                <th class="text-left">Info Deals</th>
                                <th>Total Prices</th>
                                <th style="width:20%">Status</th>
                                <th>Date Order</th>
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