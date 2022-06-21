<header class="my-header sticky">
    <?php
    $userObj = Session::get('user');
    // Session::unset('user');
    $arrMenu = [];
    if ($userObj == true && $userObj['group_acp'] == true) {
        $arrMenu[] = ['class' => 'user-index', 'link' => URL::createLink('backend', 'index', 'index'), 'name' => 'Trang quản lý'];
    }
    if ($userObj == true) {
        $arrMenu[] = ['class' => 'index-profile', 'link' => URL::createLink($this->arrParams['module'], 'user', 'profile'), 'name' => 'Tài khoản của tôi'];
        $arrMenu[] = ['class' => 'index-logout', 'link' => URL::createLink($this->arrParams['module'], 'index', 'logout'), 'name' => 'Đăng xuất'];
    } else {
        $arrMenu[] = ['class' => 'index-login', 'link' => URL::createLink($this->arrParams['module'], $this->arrParams['controller'], 'login'), 'name' => 'Đăng nhập'];
        $arrMenu[] = ['class' => 'index-register', 'link' => URL::createLink($this->arrParams['module'], $this->arrParams['controller'], 'register'), 'name' => 'Đăng ký'];
    }

    $xhtml = '<ul class="onhover-show-div">';
    foreach ($arrMenu as $key => $value) {
        $xhtml .= '
                <li><a href="' . $value['link'] . '" class="' . $value['class'] . '">' . $value['name'] . '</a></li>
            ';
    }
    $xhtml .= '</ul>';

    ?>
    <div class="mobile-fix-option"></div>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="main-menu">
                    <div class="menu-left">
                        <div class="brand-logo">
                            <a href="<?= URL::createLink($this->arrParams['module'], $this->arrParams['controller'], 'index') ?>">
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
                                    <li><a href="<?= URL::createLink($this->arrParams['module'], $this->arrParams['controller'], 'index') ?>" class="my-menu-link index-index">Trang chủ</a></li>
                                    <li><a href="list.html">Sách</a></li>
                                    <li>
                                        <a href="category.html" class="index-category">Danh mục</a>
                                        <ul>
                                            <li><a href="list.html">Bà mẹ - Em bé</a></li>
                                            <li><a href="list.html">Chính Trị - Pháp Lý</a></li>
                                            <li><a href="list.html">Học Ngoại Ngữ</a></li>
                                            <li><a href="list.html">Công Nghệ Thông Tin</a></li>
                                            <li><a href="list.html">Giáo Khoa - Giáo Trình</a>
                                        </ul>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <div class="top-header">
                            <ul class="header-dropdown">
                                <li class="onhover-dropdown mobile-account">
                                    <img src="<?= $this->_pathImg ?>avatar.png" alt="avatar">

                                    <?= $xhtml ?>

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
                                            <a href="cart.html" id="cart" class="position-relative">
                                                <img src="<?= $this->_pathImg ?>cart.png" class="img-fluid blur-up lazyload" alt="cart">
                                                <i class="ti-shopping-cart"></i>
                                                <span class="badge badge-warning">0</span>
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