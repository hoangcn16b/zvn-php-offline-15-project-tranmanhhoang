<header class="my-header sticky">
    <?php
    $userObj = $this->arrParams['userLogged'] ?? '';
    // Session::unset('user');
    $arrMenu = [];
    if ($userObj['group_acp'] ?? '' == 1) {
        $arrMenu[] = ['class' => '', 'link' => URL::createLink('backend', 'index', 'index'), 'name' => 'Trang quản lý'];
    }
    if ($userObj == true) {
        $arrMenu[] = ['class' => '', 'link' => URL::createLink($this->arrParams['module'], 'user', 'profile'), 'name' => 'Tài khoản của tôi'];
        $arrMenu[] = ['class' => '', 'link' => URL::createLink($this->arrParams['module'], 'index', 'logout'), 'name' => 'Đăng xuất'];
    } else {
        $arrMenu[] = ['class' => '', 'link' => URL::createLink($this->arrParams['module'], 'index', 'login'), 'name' => 'Đăng nhập'];
        $arrMenu[] = ['class' => '', 'link' => URL::createLink($this->arrParams['module'], 'index', 'register'), 'name' => 'Đăng ký'];
    }

    $xhtml = '<ul class="onhover-show-div">';
    foreach ($arrMenu as $key => $value) {
        $xhtml .= sprintf('<li><a href="%s" class="%s">%s</a></li>', $value['link'], $value['class'], $value['name']);
    }
    $xhtml .= '</ul>';
    if (!empty($userObj)) {
        $iconAvt = sprintf('<img src=" %sprofile-user.png" alt="avatar">', $this->_pathImg);
    } else {
        $iconAvt = sprintf('<img src=" %savatar.png" alt="avatar">', $this->_pathImg);
    }
    //Category
    $model = new Model();
    $query = "SELECT `id`, `name` FROM `category` WHERE `status` = 'active' ORDER BY `ordering`";
    $resultCategory = $model->listRecord($query);
    $xhtmlCategory = '';
    if ($resultCategory != null) {
        $xhtmlCategory .= '<ul>';
        $activeCategory = $this->arrParams['id'] ?? '';
        foreach ($resultCategory as $key => $item) {
            $link = URL::createLink($this->arrParams['module'], 'book', 'list', ['id' => $item['id']]);
            $style = '';
            if (($activeCategory) === $item['id']) $style = 'style = "color: #5fcbc4;"';
            $xhtmlCategory .= sprintf('<li ><a %s href="%s"> %s</a></li>', $style, $link, $item['name']);
        }
        $xhtmlCategory .= '</ul>';
    }
    if (!empty(Session::get('cart'))) {
        $cart = Session::get('cart');
        $totalItems = array_sum($cart['quantity']);
        Session::set('quantity', $totalItems);
    } else {
        $totalItems = 0;
    }
    $linkHome  = URL::createLink($this->arrParams['module'], 'index', 'index');
    $linkBook = URL::createLink($this->arrParams['module'], 'book', 'list');
    $linkCate = URL::createLink('frontend', 'category', 'index');
    $linkCart = URL::createLink('frontend', 'cart', 'index');
    ?>
    <div class="mobile-fix-option"></div>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="main-menu">
                    <div class="menu-left">
                        <div class="brand-logo">
                            <a href="<?= URL::createLink($this->arrParams['module'], 'index', 'index') ?>">
                                <h2 class="mb-0" style="color: #5fcbc4">BookStore</h2>
                            </a>
                        </div>
                    </div>
                    <div class="menu-right pull-right">
                        <div>
                            <nav id="main-nav">
                                <div class="toggle-nav"><i class="fa fa-bars sidebar-bar"></i></div>
                                <ul id="main-menu" class="sm pixelstrap sm-horizontal">
                                    <li>
                                        <div class="mobile-back text-right">Back<i class="fa fa-angle-right pl-2" aria-hidden="true"></i></div>
                                    </li>
                                    <li><a href="<?= $linkHome ?>" class="my-menu-link index-index">Trang chủ</a></li>
                                    <li><a href="<?= $linkBook ?>" class="my-menu-link book-list">Sách</a></li>
                                    <li>
                                        <a href="<?= $linkCate ?>" class="my-menu-link category-index">Danh mục</a>
                                        <?= $xhtmlCategory ?>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <div class="top-header">
                            <ul class="header-dropdown">
                                <li class="onhover-dropdown mobile-account">

                                    <?= $iconAvt . $xhtml ?>

                                </li>
                            </ul>
                        </div>
                        <div>
                            <div class="icon-nav">
                                <ul>
                                    <li class="onhover-div mobile-search">
                                        <div>
                                            <img src="<?= $this->_pathImg ?>search.png" onclick="openSearch()" class="img-fluid blur-up lazyload" alt="">
                                            <i class="ti-search" onclick="openSearch()"></i>
                                        </div>
                                        <div id="search-overlay" class="search-overlay">
                                            <div>
                                                <span class="closebtn" onclick="closeSearch()" title="Close Overlay">×</span>
                                                <div class="overlay-content">
                                                    <div class="container">
                                                        <div class="row">
                                                            <div class="col-xl-12">
                                                                <form action="" method="GET">
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control" name="search" id="search-input" placeholder="Tìm kiếm sách...">
                                                                    </div>
                                                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="onhover-div mobile-cart">
                                        <div>
                                            <a href="<?= $linkCart ?>" id="cart" class="position-relative cart-index">
                                                <img src="<?= $this->_pathImg ?>cart.png" class="img-fluid blur-up lazyload" alt="cart">
                                                <i class="ti-shopping-cart"></i>
                                                <span class="badge badge-warning quantity-cart" id="quantity-cart"><?= $totalItems ?? '0' ?></span>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</header>